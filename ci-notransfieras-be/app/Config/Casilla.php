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
    private $email;
    public function __construct()
    {
        $this->email = Services::email();
    }


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
            $modelUser = new UserModel();
            $user = $modelUser->findUserByEmailAddressNameUser($input['email'], $input['username']);
            if ($user['email_confirmado']) {
                throw new \Exception('Email ya confirmado');
            }
            $model = new ConfirmacionCorreoModel();
            $subject = "Verificacion de correo";
            $currentDate = new DateTime();
            $hash = hash('sha256', $currentDate->format('Y-m-d H:i:s'));
            $fechaExpiracion = $currentDate->modify('+5 days');

            $model->save(
                [
                    'hash' => $hash,
                    'usuario_id' => $user['id'],
                    'fecha_expiracion' => $fechaExpiracion->format('Y-m-d H:i:s')
                ]
            );

            $modelUser->update(['id' => $user['id']], ['email_confirmado' => 0]);
            $message = "Estimado " . $input['username'] . "\n Verifica tu correo " . $input['emial'] . " haciendo click en el siguieten link:\n       " . site_url("mail/confirmar/") . $hash;
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

                'username' => 'required|min_length[6]|max_length[20]',
                'email' => 'required|valid_email'
            ];

            $input = $this->getRequestInput($this->request);

            if (!$this->validateRequest($input, $rules)) {
                return $this->getResponse($this->validator->getErrors(), ResponseInterface::HTTP_BAD_REQUEST);
            }
            $modelUser = new UserModel();
            $user = $modelUser->findUserByEmailAddressNameUser($input['email'], $input['username']);
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
            return $this->sendMail($input['email'], $subject, $message);
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

    function sendMail(string $email, string $subject, string $message)
    {

        $this->email->setTo($email);
        $this->email->setFrom("no-reply@notransfieras.com");
        $this->email->setSubject($subject);
        $this->email->setMessage($message);

        /**
            <b><?php echo $subject; ?>
            <br><br>
            Hola: <a href="https://netveloper.com">netveloper.com</a>
            <br><br>
            Saludos
            $email->setMessage( $data['message']);
            $echo_page = view('emails/templates_one.php', $data);
            $email->setMessage($echo_page);
         */

        if ($this->email->send()) {
            return $this->getResponse(['message' => 'correo enviado'], ResponseInterface::HTTP_OK);
        } else {
            return $this->getResponse(['error' => $this->email->printDebugger(['headers'])], ResponseInterface::HTTP_FORBIDDEN);
        }
    }
}
