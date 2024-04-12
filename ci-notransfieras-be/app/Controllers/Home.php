<?php

namespace App\Controllers;

use App\Models\FraudeModel;
use CodeIgniter\HTTP\ResponseInterface;
use Config\Services;
use Exception;

class Home extends BaseController
{
    public function __construct()
{
    helper(['url']);
}
    
    public function index(): string
    {
       
        return view('rutificador/rutificar_view', ['rutificado' => []]);
      
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
        return view('rutificador/rutificar_view',['rutificado'=>$rutificado]);
    }catch(\Exception $e){
            log_message('info', 'Error busqueda rut: ' . $e->getMessage());
            return view('rutificador/rutificar_view',['rutificado'=>['error'=>$e->getMessage()]]); 
        }
    }


    public function facebookOaut(){
        
    }

    public function detalleFraude($id)
    {
        try {
            $endpoint = $_ENV['ADM_API_GET_DETALLE_FRAUDE'];
            $url = str_replace("{fraudeID}", $id, $endpoint);
            helper('cliente');
            $dataLogin=['grand_type'=>'CLI_ACCES'];
            $data_response = getApiSecure($url, [],$dataLogin, 'application/json', 'GET',$_ENV['CANAL_WEB']);
            $data_response =extractResponse( $data_response,[200]);
            return $this->getResponse($data_response, ResponseInterface::HTTP_OK);
        } catch (\Exception $e) {
            return Services::response()
                ->setJSON([
                    'error' => $e->getMessage()
                ])->setStatusCode(ResponseInterface::HTTP_BAD_REQUEST);
        }
    }
   
}
