<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use Config\Services;

class Ruts extends BaseController
{
    const title_registra='Registrar RUT';
    const title_modifica='Modifica RUT';
    public function __construct()
    {
        helper(['url']);
       
    }

    public function index():string{
        try{

            return view('profile/add_rut', ['usuario' => session()->get('usuario'),'title'=>self::title_registra]);
         
        }catch(\Exception $e){
           
             return view('profile/add_rut', ['usuario' => session()->get('usuario'),'title'=>self::title_registra,'error' =>$e->getMessage()]);
        }
    }

    public function indexModificar():string{
        try{

            return view('profile/mod_rut', ['usuario' => session()->get('usuario'),'title'=>self::title_modifica]);
         
        }catch(\Exception $e){
           
             return view('profile/mod_rut', ['usuario' => session()->get('usuario'),'title'=>self::title_modifica,'error' =>$e->getMessage()]);
        }
    }

    public function indexFraude():string{
        try{

            return view('profile/add_fraude', ['usuario' => session()->get('usuario'),'title'=>self::title_registra]);
         
        }catch(\Exception $e){
           
             return view('profile/add_fraude', ['usuario' => session()->get('usuario'),'title'=>self::title_registra,'error' =>$e->getMessage()]);
        }
    }

    public function buscar(){
        try{
            $rules = [
                'rut' => 'required|min_length[6]|max_length[50]|valid_rut',
            ];
    
            $input = $this->getRequestInput($this->request);
    
            if (!$this->validateRequest($input, $rules)) {
                return $this->getResponse($this->validator->getErrors(), ResponseInterface::HTTP_BAD_REQUEST);
            }

            $url=$_ENV['ADM_API_GET_RUTIFICAR'];
            $rut = $input['rut']; 
            $endpoint = str_replace('{rut}', $rut, $url);

        helper('cliente');
       
        $response=callApi($endpoint,[],'application/json', session()->get('token'),'GET',$_ENV['CANAL_WEB']);
        $response=extractResponse($response,[ResponseInterface::HTTP_OK],[ResponseInterface::HTTP_NOT_FOUND]);
        return  $this->getResponse(['isRUT'=>  true,'RUT'=>  $response['body']],ResponseInterface::HTTP_OK);
        }catch(\Exception $e){
                return $this->getResponse(['error'=> $e->getMessage()],ResponseInterface::HTTP_NOT_FOUND);
        }
    }
    
}