<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\HeaderRequestModel;
use App\Models\RolesModel;
use App\Models\UserModel;
use App\Models\UsuRolRelModel;
use CodeIgniter\HTTP\ResponseInterface;
use Config\Services;
use DateTime;
use Exception;

class Auth extends BaseController
{
    public function register()
    {
       //$this->load->library('input');
       //$canal = $this->input->get_request_header('Channel', TRUE);
       $headers = $this->request->headers();
        $canal =$headers['Channel'];
        $rules = [
            'nombre' => 'required|min_length[3]|max_length[50]',
            'apellido' => 'required|min_length[3]|max_length[50]',
            'email' => 'required|valid_email|is_unique[usuario.email]',
            'username' => 'required|min_length[8]|max_length[255]|is_unique[usuario.username]',
            'password' => 'required|min_length[8]|max_length[255]'
        ];

        $input = $this->getRequestInput($this->request);
        
        if (!$this->validateRequest($input, $rules)) {
            return $this->getResponse($this->validator->getErrors(), ResponseInterface::HTTP_BAD_REQUEST);
        }
        $userModel = new UserModel();
        $input['id']=$userModel->generaId();
        $result=$userModel->insert($input);
        if($result==0){
            $modelRol = new RolesModel();
            $rolesData=$modelRol->findByNombre("mobile");
            $relModel=new UsuRolRelModel();
            $relModel->insert(['rol_id'=> $rolesData['id'],
                                'usuario_id'=>$input['id']]);
            helper("casilla");
             $message='';
            
            if($canal->getValue()=='MOVIL'){
                $message=preareConfirmacionCode($input['email'],$input['username'],"Bien venido, estamos muy contentos que formes parte de nuesta comunidad anti-fraudes, ahora para continuar");
            }else{
                $message=preareConfirmacionHash($input['email'],$input['username'],"Bien venido, estamos muy contentos que formes parte de nuesta comunidad anti-fraudes, ahora para continuar");
            }
            $subject="Creacion de cuenta";
            $this->sendMail($input['email'], $subject, $message);
        return $this->getJWTForUser($input['username'],0, ResponseInterface::HTTP_CREATED);
        }else{
            throw new Exception("Error al crear el usuario.");
        }
        
    }

    public function cambioPass()
    {
        
        try{
        $rules = [
    
            'username' => 'required|min_length[8]|max_length[255]',
            'newPassword' => 'required|min_length[8]|max_length[36]',
            'confirmNewPass' => 'required|min_length[8]|max_length[36]|matches[newPassword]',
            'password' => 'required|min_length[8]|max_length[36]|validateUser[username, password]'
        ];

        $errors = [
    
            'username' => 'el nombre de usuario debe ser informado',
            'newPassword' => 'debe ingresar la nueva password',
            'confirmNewPass' => 'la confirmacion del password no coinciden',
            'password' => 'La clave ingresada no corresponde a su clave actual'
        ];

        $input = $this->getRequestInput($this->request);

        if (!$this->validateRequest($input, $rules,$errors)) {
            return $this->getResponse($this->validator->getErrors(), ResponseInterface::HTTP_BAD_REQUEST);
        }
        $userModel = new UserModel();
        $user=$userModel->findUserByName($input['username']);
        if($userModel->update($user['id'],['password'=>$input['newPassword']])){
            $this->sendMail($user['email'],"Cambio de contraseña","Estimado ".$user['username'].".\n    su contraseña a sido cambiada con exito.");
            return $this->getResponse(['message'=>'clave cambiada'], ResponseInterface::HTTP_OK);
        }else{
            return $this->getResponse(['error'=>'clave no fue cambiada'], ResponseInterface::HTTP_BAD_REQUEST);
        }
    }catch(\Exception $e){
        return Services::response()
        ->setJSON([
            'error'=> $e->getMessage()
        ])->setStatusCode(ResponseInterface::HTTP_BAD_REQUEST);
    }
       
    }

    public function delete()
    {
        try
        {
            if (!isset($userID)) {
                return $this->getResponse(['error'=>'id usuario no informado'], ResponseInterface::HTTP_BAD_REQUEST);
            }
            $userModel = new UserModel();
            $userModel->delete($userID);
            return $this->getResponse(['menssage'=>'OK']);
        }catch(\Exception $e){
            return Services::response()
            ->setJSON([
                'error'=> $e->getMessage()
            ])->setStatusCode(ResponseInterface::HTTP_BAD_REQUEST);
        }
    }

    public function findId($userID)
    {
        
        try
        {
           
            $rules = [
                'id' => 'required'
            ];
            if (!$this->validateRequest(['id' => $userID], $rules)) {
                return $this->getResponse($this->validator->getErrors(), ResponseInterface::HTTP_BAD_REQUEST);
            }
            $userModel = new UserModel();
            $usario=$userModel->find($userID);
            if (!isset($usario)) {
                return $this->getResponse(['error'=>'id usuario no encontrado'], ResponseInterface::HTTP_BAD_REQUEST);
            }
            $modelRol = new RolesModel();
            $usario['roles']=$modelRol->findAllByIdUsuario($usario['id']);
            return $this->getResponse($usario);
        }catch(\Exception $e){
            return Services::response()
            ->setJSON([
                'error'=> $e->getMessage()
            ])->setStatusCode(ResponseInterface::HTTP_BAD_REQUEST);
        }
        
    }

    public function findEmail($email)
    {
        
        try
        {
           
            $rules = [
                'email' => 'required|valid_email'
            ];

            if (!$this->validateRequest(['email' => $email], $rules)) {
                return $this->getResponse($this->validator->getErrors(), ResponseInterface::HTTP_BAD_REQUEST);
            }
            $userModel = new UserModel();
            $usario=$userModel->where('email', $email)->first();
            if (!isset($usario)) {
                return $this->getResponse(['error'=>'email no encontrado'], ResponseInterface::HTTP_BAD_REQUEST);
            }
            $modelRol = new RolesModel();
            $usario['roles']=$modelRol->findAllByIdUsuario($usario['id']);
            return $this->getResponse($usario);
        }catch(\Exception $e){
            return Services::response()
            ->setJSON([
                'error'=> $e->getMessage()
            ])->setStatusCode(ResponseInterface::HTTP_BAD_REQUEST);
        }
        
    }

    public function findUserName($username)
    {
        
        try
        {
           
            $rules = [
                'username' => 'required|min_length[8]|max_length[255]'
            ];

            if (!$this->validateRequest(['username' => $username], $rules)) {
                return $this->getResponse($this->validator->getErrors(), ResponseInterface::HTTP_BAD_REQUEST);
            }
            $userModel = new UserModel();
            $usario=$userModel->where('username', $username)->first();
            if (!isset($usario)) {
                return $this->getResponse(['error'=>'usuario no encontrado'], ResponseInterface::HTTP_BAD_REQUEST);
            }
            $modelRol = new RolesModel();
            $usario['roles']=$modelRol->findAllByIdUsuario($usario['id']);
            return $this->getResponse($usario);
        }catch(\Exception $e){
            return Services::response()
            ->setJSON([
                'error'=> $e->getMessage()
            ])->setStatusCode(ResponseInterface::HTTP_BAD_REQUEST);
        }
        
    }

    public function editar($userID)
    {
        try
        {
            $rules = [
                'name' => 'required|min_length[3]|max_length[50]',
                'apellido' => 'required|min_length[3]|max_length[50]',
                'email' => 'required|valid_email|is_unique[user.email]',
                'username' => 'required|min_length[8]|max_length[255]|is_unique[user.username]',
                'password' => 'required|min_length[8]|max_length[255]'
            ];
    
            $input = $this->getRequestInput($this->request);
    
            if (!$this->validateRequest($input, $rules)) {
                return $this->getResponse($this->validator->getErrors(), ResponseInterface::HTTP_BAD_REQUEST);
            }
            $userModel = new UserModel();
            $input['id']=$userModel->generaId();
            $userModel->insert($input);
    
            return $this->getJWTForUser($input['usuario'],1, ResponseInterface::HTTP_CREATED);
        }catch(\Exception $e){
            return Services::response()
            ->setJSON([
                'error'=> $e->getMessage()
            ])->setStatusCode(ResponseInterface::HTTP_BAD_REQUEST);
        }
        
    }

    public function login()
    {
        $namUser="";
        $input = $this->getRequestInput($this->request);
        $rules = [
            'grand_type' => 'required|validaGrandType[grand_type]'
        ];

        $errors = [
            'error' => [
                'validaGrandType' => 'Grand_type no valido.'
            ]
        ];

        if (!$this->validateRequest($input, $rules, $errors)) {
            return $this->getResponse($this->validator->getErrors(), ResponseInterface::HTTP_BAD_REQUEST);
        }
        if($input['grand_type']==$_ENV['GRAND_CLI_ACCES']){
            $namUser=$_ENV['SISTEM_USER'];
        }else{
            $rules = [
                'username' => 'required|min_length[6]|max_length[36]',
                'password'=> 'required|min_length[8]|max_length[36]|validateUser[username, password]'
            ];
    
            $errors = [
                'error' => [
                    'validateUser' => 'Credenciales no validas'
                ]
            ];
    
            $input = $this->getRequestInput($this->request);
    
            if (!$this->validateRequest($input, $rules, $errors)) {
                return $this->getResponse($this->validator->getErrors(), ResponseInterface::HTTP_BAD_REQUEST);
            }
            $namUser=$input['username'];
        }

        return $this->getJWTForUser($namUser,1);
    }

    private function registroHead(string $userID,string $bitacora)
    {

        $ipRequest = $this->request->getHeaderLine('ip');
        $soDevice = $this->request->getHeaderLine('os');
        $deviceId = $this->request->getHeaderLine('Device-Id');
        $canal = $this->request->getHeaderLine('Channel');
        $headModel= new HeaderRequestModel();
        $idHeader = $headModel->generaId();
        $data=[
                'id'=>$headModel->generaId(),
                'ip'=>$ipRequest,
                'os'=>$soDevice,
                'device_id'=>$deviceId,
                'id_usuario'=>$userID,
                'canal'=> $canal,
                'bitacora'=>$bitacora
        ];
        $headModel->insert($data);
        return $idHeader;
    }

    private function getJWTForUser(string $namUser,int $nuevo, int $responseCode = ResponseInterface::HTTP_UNAUTHORIZED)
    {
        try {
            $model = new UserModel();
            $user = $model->findUserByName($namUser);
            if($nuevo==1 && !$user['email_confirmado']){
                throw new Exception("Debe validar el email.");
            }
            $modelRol = new RolesModel();
            $rolesData=$modelRol->findAllByIdUsuario($user['id']);
            $idHeader= $this->registroHead($user['id'],'bitacora');
            $rolesAux = array_column($rolesData, 'nombre');
            $rolesAux = array_values($rolesAux);
            unset($user['password']);
            $user['roles']=$rolesAux;
            $user['head_session']=$idHeader;
            helper('jwt');
            $issuedAtTime = time();
            $tokenTimeToLive = $_ENV['JWT_TIME_TO_LIVE'];
            $tokenExpiration = $issuedAtTime + $tokenTimeToLive;
            date_default_timezone_set('America/Santiago');
            $expirationDateTime = new DateTime('@' . $tokenExpiration);
       
            return $this->getResponse([
                'message' => 'User authenticated successfully',
                'user' => $user,
                'access_token' => getSignedJWTForUser($user,$issuedAtTime,$tokenExpiration),
                'token_expirer' => $expirationDateTime
              
            ]);
        } catch (\Exception $e) {
            return $this->getResponse([
                'error' => $e->getMessage()
            ], $responseCode);
        }
    }

   
}