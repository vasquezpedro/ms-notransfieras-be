<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\AdjuntosModel;
use CodeIgniter\Config\Services;
use CodeIgniter\HTTP\ResponseInterface;
use Exception;

class Incidentes extends BaseController
{
    
    public function registrar()
    {
        try {

            $rules = [
                'detalle' => 'required|min_length[1]|max_length[1000]',
                'fechaRegistro' => 'required|valid_date',
                'usuarioID' =>'required|numeric|min_length[1]|max_length[50]'
            ];
    
            $input = $this->getRequestInput($this->request);

                helper('cliente');

                $usuario=session()->get('usuario');
                $token=session()->get('token');
                $canal=session()->get('canal');
                $input['fechaRegistro'] = date('Y-m-d', strtotime(str_replace('/', '-', $input['fechaRegistro'])));
                $fraudePostUrl=$_ENV['ADM_API_POST_FRAUDE'];
                $fraudePostResponse=getResponseForEnpoint($fraudePostUrl,$input,$token,'application/json','POST',$canal,[201]);
                $fraudeID=$fraudePostResponse['body']->id;
            if(isset($_FILES['imagenes'])){
                $this->registrar_adjuntos($_FILES['imagenes'],$fraudeID,$token,$canal);
                }
               

    /*
            if (!$this->validateRequest($input, $rules)) {
                return $this->getResponse($this->validator->getErrors(), ResponseInterface::HTTP_BAD_REQUEST);
            }
            
            */
            return $this->getResponse(['message'=>'OK'], ResponseInterface::HTTP_OK);
        } catch (\Exception $e) {
            log_message('info', 'Error : ' . $e->getMessage());
            return Services::response()
                ->setJSON([
                    'error' => $e->getMessage()
                ])->setStatusCode(ResponseInterface::HTTP_BAD_REQUEST);
        }
    }

    private function registrar_adjuntos($files,$fraudeID,$token,$canal){
        if (isset( $files)) {
                   
           
            foreach ($files['tmp_name'] as $key => $tmp_name) {
               
               try {
                $input=['file'=>base64_encode(file_get_contents($files['tmp_name'][$key])),
                'fraudeID'=>$fraudeID,
                'nombre' =>  $files['name'][$key],
                'ext'=>$files['type'][$key]
            ];
                    $uploadPostUrl = $_ENV['ADM_API_UPLOAD_ADJUNTO'];
                $fraudePostResponse=getResponseForEnpoint($uploadPostUrl,$input,$token,'application/json','POST',$canal,[201]);
               } catch (\Exception $e) {
                log_message('info', 'Error : ' . $e->getMessage());
               }
            
               
                
               
            }
        }
    }
}
    