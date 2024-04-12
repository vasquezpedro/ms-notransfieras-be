<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\RrSsModel;
use CodeIgniter\Config\Services;
use CodeIgniter\Database\Exceptions\DatabaseException;
use CodeIgniter\HTTP\ResponseInterface;


class RRSS extends BaseController
{
    
   
    public function registrar()
    {
        try{
            
            $rules = [
                'tipo' => 'required|min_length[1]|max_length[20]',
                'rutID' => 'required|min_length[36]|max_length[36]',
                'fraudeID' => 'required|min_length[36]|max_length[36]',
                'nombre' =>'required|min_length[36]|max_length[36]'
            ];
    
            $input = $this->getRequestInput($this->request);
    
            if (!$this->validateRequest($input, $rules)) {
                return $this->getResponse($this->validator->getErrors(), ResponseInterface::HTTP_BAD_REQUEST);
            }
            $rrSsModel = new RrSsModel();
            $idUUID =$rrSsModel->generaId();

            $data = [
                'usu_rrss_id'=>$idUUID,
                'usu_rrss_tipo' => $input['tipo'],
                'usu_rrss_nombre' => $input['nombre'],
                'usuario_id' => $input['rutID'],
                'usu_fraude_id' => $input['fraudeID']
            ];
  
            $rrSsModel->insert($data);
           
            return  $this->getResponse([
                'rrSSID'=> $idUUID
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