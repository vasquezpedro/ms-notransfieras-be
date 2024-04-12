<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\TelefonoModel;
use CodeIgniter\Config\Services;
use CodeIgniter\Database\Exceptions\DatabaseException;
use CodeIgniter\HTTP\ResponseInterface;


class Telefono extends BaseController
{
    
   
    public function registrar()
    {
        try{
            
            $rules = [
                'telefono' => 'required|min_length[11]|max_length[11]',
                'usuarioID' =>'required|min_length[36]|max_length[36]'
            ];
    
            $input = $this->getRequestInput($this->request);
    
            if (!$this->validateRequest($input, $rules)) {
                return $this->getResponse($this->validator->getErrors(), ResponseInterface::HTTP_BAD_REQUEST);
            }
            $telModel = new TelefonoModel();
            $idUUID =$telModel->generaId();
            
            $data = [
                'usu_tel_id'=>$idUUID,
                'usu_tel' => $input['telefono'],
                'usuario_id' => $input['usuarioID']
            ];
  
            $telModel->insert($data);
           
            return  $this->getResponse([
                'telefonoID'=> $idUUID
            ],ResponseInterface::HTTP_CREATED);
    
    
        }catch (DatabaseException $e) {
            return $this->response->setStatusCode(ResponseInterface::HTTP_NOT_FOUND)->setJSON(['error' => $e->getMessage()]);
        }catch(\Exception $e){
            return Services::response()
                ->setJSON([
                    'error'=> $e->getMessage()
                ])->setStatusCode(ResponseInterface::HTTP_NOT_FOUND);
        }
        
    }
}