<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\AdjuntosModel;
use App\Models\ConfirmacionCorreoModel;
use App\Models\UserModel;
use CodeIgniter\Config\Services;
use CodeIgniter\HTTP\ResponseInterface;
use DateTime;
use Exception;

class Casilla extends BaseController
{
    
   


    function verifica($hash)
    {
        try {
            $model = new ConfirmacionCorreoModel();
            $hashData = $model->findHash($hash);

            $modelUser = new UserModel();
            $usuarioID = $hashData['usuario_id'];
            $confirmID = $hashData['id_confirmacion'];

            $modelUser->update(['id' => $usuarioID], ['email_confirmado' => 1]);
            $model->update(['id_confirmacion' => $confirmID], ['estado' => 0]);

            return view('email_confirm');
        } catch (\Exception $e) {
            log_message('info', 'Error busqueda rut: ' . $e->getMessage());
            return view('email_error');
        }
    }


    function hashConfirm()
    {
        try {
            $rules = [

                'username' => 'required|min_length[6]|max_length[20]',
                'email' => 'required|valid_email'
            ];

            $input = $this->getRequestInput($this->request);

            if (!$this->validateRequest($input, $rules)) {
                return $this->getResponse($this->validator->getErrors(), ResponseInterface::HTTP_BAD_REQUEST);
            }
            helper("casilla");
            $message=preareConfirmacionHash($input['email'],$input['username']);
            $subject="confirmacion de cuenta.";
            return $this->sendMail($input['email'], $subject, $message);
        } catch (\Exception $e) {
            return Services::response()
                ->setJSON([
                    'error' => $e->getMessage()
                ])->setStatusCode(ResponseInterface::HTTP_NOT_FOUND);
        }
    }


    function codeConfirm()
    {
        try {
            $rules = [

                'username' => 'required|min_length[6]|max_length[20]'
                //,'email' => 'required|valid_email'
            ];

            $input = $this->getRequestInput($this->request);

            if (!$this->validateRequest($input, $rules)) {
                return $this->getResponse($this->validator->getErrors(), ResponseInterface::HTTP_BAD_REQUEST);
            }
            $modelUser = new UserModel();
           // $user = $modelUser->findUserByEmailAddressNameUser($input['email'], $input['username']);
            $user = $modelUser->findUserByName($input['username']);
            if ($user['email_confirmado']) {
                throw new \Exception('Email ya confirmado');
            }
            $model = new ConfirmacionCorreoModel();
            $subject = "Verificacion de correo";
            $currentDate = new DateTime();
            $numeroAleatorio = mt_rand(100000, 999999);
            $fechaExpiracion = $currentDate->modify('+5 days');

            $model->save(
                [
                    'code' => $numeroAleatorio,
                    'usuario_id' => $user['id'],
                    'fecha_expiracion' => $fechaExpiracion->format('Y-m-d H:i:s')
                ]
            );

            $modelUser->update(['id' => $user['id']], ['email_confirmado' => 0]);
            $message = "Estimado " . $input['username'] . "\n Verifica tu correo  ingresando el siguiente codigo en tu aplicacion:\n       " .  $numeroAleatorio;
            return $this->sendMail($user['email'], $subject, $message);
        } catch (\Exception $e) {
            return Services::response()
                ->setJSON([
                    'error' => $e->getMessage()
                ])->setStatusCode(ResponseInterface::HTTP_NOT_FOUND);
        }
    }


    function codeValidate($code)
    {
        try {
        
            $modelUser = new UserModel();
            $model = new ConfirmacionCorreoModel();
            $valMail=$model->findCode($code);

            $modelUser = new UserModel();
            $usuarioID = $valMail['usuario_id'];
            $confirmID = $valMail['id_confirmacion'];

            $modelUser->update(['id' => $usuarioID], ['email_confirmado' => 1]);
            $model->update(['id_confirmacion' => $confirmID], ['estado' => 0]);
            return $this->getResponse(['message' => 'successful'], ResponseInterface::HTTP_OK);
        } catch (\Exception $e) {
            return Services::response()
                ->setJSON([
                    'error' => $e->getMessage()
                ])->setStatusCode(ResponseInterface::HTTP_NOT_FOUND);
        }
    }

    
}
