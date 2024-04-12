<?php

namespace App\Controllers;

use App\Models\FraudeModel;
use Exception;

class Autenticacion extends BaseController
{
    public function __construct()
{
    helper(['url']);
}
    
    public function index(): string
    {
       
        return view('login_view', ['login' => []]);
      
    }

    public function ruts(): string
    {
         try{
         $rut=$this->request->getPost("rut");
         $token=$this->request->getPost("token");
         $action=$this->request->getPost("action");
        helper('recaptcha');
         
        if(!validar_recaptcha($token,$action)){
             throw new Exception('error en el reCAPTCHA.');
        }
        $userRutificados=new UserRutificados();
        $rutificado=$userRutificados->find1($rut);
        if(isset($rutificado) && array_key_exists('isFake', $rutificado)){
           if(filter_var($rutificado['isFake'], FILTER_VALIDATE_BOOLEAN)){
            $fraudeModel= new FraudeModel();
                $fraudesList=$fraudeModel->findFunasByIdUser($rutificado['id']);
                $rutificado['message']='el rut ingresado registra ('.count($fraudesList).') fraudes o quejas';
                $rutificado['fraudes']=$fraudesList;
           }else{
                $rutificado['message']='el rut ingresado no registra fraudes en nuestras bases de datos';
           }
        }
        return view('rutificar_view',['rutificado'=>$rutificado]);
    }catch(\Exception $e){
            log_message('info', 'Error busqueda rut: ' . $e->getMessage());
            return view('rutificar_view',['rutificado'=>['error'=>$e->getMessage()]]); 
        }
    }


   
}
