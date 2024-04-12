<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use Exception;

class Login extends BaseController
{
    
    public function __construct()
    {
        helper(['url']);
    }

    public function index():string{
       
        return view('login_view', ['data' => []]);
      
    }

    public function login():string{
       try{
        $input = $this->getRequestInput($this->request);
        helper('recaptcha');
        if(!validar_recaptcha($input['token'],$input['action'])){
            throw new Exception('error en el reCAPTCHA.');
       }
        $endpoint=$_ENV['DOMAIN_ADM_API_LOGIN'];
        //$endpoint='auth/login';
       
        helper('cliente');
        $response=callApi($endpoint,['usuario'=>$input["usuario"], 'password'=>$input["password"],'grand_type'=>'USER_CREDENTIAL' ],'application/json','','POST',$_ENV['CANAL_WEB']);
        $response=extractResponse($response,[200]);
        session()->set('usuario',  $response['body']->user);
        session()->set('token',  $response['body']->access_token);
        session()->set('type',$_ENV['SESSION_CANAL']);
        return view('dashboard_view', ['usuario' => $response['body']->user,'title'=>"Inicio"]);
       }catch(\Exception $e){
        log_message('info', 'Error busqueda rut: ' . $e->getMessage());
            return view('login_view', ['error' =>$e->getMessage()]);
       }

    }
    
    public function loginProfileIndex():string{
        try {
            $rules = [
                'rutID' => 'required|min_length[1]|max_length[36]',
            ];
    
            $input = $this->getRequestInput($this->request);
    
            if (!$this->validateRequest($input, $rules)) {
                throw new Exception('rutID es necesario');
            }
            if(session()->has('user_id')) {
                $canal=session()->get('canal');
                $token=session()->get('token');
                $usuario=session()->get('usuario');
                $getRut=$this->buscarRut($input['rutID'],$canal,$token);
                session()->set('RUT',$getRut);
                return view('profile/registro_incidente', ['usuario' => $usuario,'RUT' => $getRut]);
                //return redirect()->to('profile/registro_incidente');
            }
            $input = $this->getRequestInput($this->request);
           // return view('profile/registro_incidente', ['usuario' => $response['body']->user,'title'=>"Inicio",'RUT' => $getRut]);
            return view('profile/login_view', ['rutID' => $input['rutID']]);
        } catch (\Exception $e) {
            log_message('error', 'Error login registro externo: ' . $e->getMessage());
            return view('rutificador/rutificar_view',['rutificado'=> ['error' =>$e->getMessage()]]);
        }
        
      
    }
    public function loginProfile():string{
        try{
         $input = $this->getRequestInput($this->request);
         
        
         helper('recaptcha');
         if(!validar_recaptcha($input['token'],$input['action'])){
             throw new Exception('error en el reCAPTCHA.');
        }
        $rules = [
            'rutID' => 'required|min_length[1]|max_length[36]',
        ];

        $input = $this->getRequestInput($this->request);

        if (!$this->validateRequest($input, $rules)) {
            throw new Exception('');
        }

        $canal=$_ENV['CANAL_PROFILE'];
        $dataLogin=['usuario'=>$input["usuario"], 'password'=>$input["password"] ,'grand_type'=>'USER_CREDENTIAL'];
        $autResponse=$this->authApi( $dataLogin,$canal);
         session()->set('usuario',  $autResponse['body']->user);
         session()->set('token',  $autResponse['body']->access_token);
         session()->set('canal',  $canal);
         session()->set('type',$_ENV['SESSION_CANAL']);
         helper('cookie');

         session()->set('user_id', $autResponse['body']->user->id); 
         $cookie = cookie('sesion_abierta', 'true',  ['expires' => 1200]);
      
       
        $responseService = service('response');
        // Agregar la cookie a la respuesta
        $responseService->setCookie($cookie);
         $getRut=$this->buscarRut($input['rutID'],$canal,$autResponse['body']->access_token);
         session()->set('RUT',$getRut);
         return view('profile/registro_incidente', ['usuario' => $autResponse['body']->user,'RUT' => $getRut]);
        }catch(\Exception $e){
          log_message('info', 'Error busqueda rut: ' . $e->getMessage());
             return view('profile/login_view', ['error' =>$e->getMessage(),'rutID' => $input['rutID']]);
        }
 
     }



     private function buscarRut($rutID,$canal,$token){
        helper('cliente');
        $endpoint = $_ENV['ADM_API_GET_RUTIFICAR_ID'];
        $url = str_replace("{rutID}",$rutID, $endpoint);
        return getResponseForEnpoint($url,[],$token,'application/json','GET',$canal);
     }

     private function authApi($dataLogin,$canal){
        helper('cliente');
        $endpoint=$_ENV['DOMAIN_ADM_API_LOGIN'];
         $response=callApi($endpoint,$dataLogin,'application/json','','POST',$canal);
         return extractResponse($response,[200]);
         
     }



    public function salir(){
         session()->destroy();
         return redirect()->to(site_url('/adm/login'));

     }

     public function profileSalir(){
        session()->destroy();
        return redirect()->to(site_url('/api'));

    }

   
}