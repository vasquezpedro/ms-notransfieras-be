<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\AdjuntosModel;
use CodeIgniter\Config\Services;
use CodeIgniter\HTTP\ResponseInterface;
use Exception;

class Adjuntos extends BaseController
{
    
    
    public function getById($idUser)
    {
       
        try{
            $adjuntoModel = new AdjuntosModel();
            $responseData=$adjuntoModel->findAdjuntoById($idUser);
            if($responseData === null || empty($responseData)){
                throw new Exception("ID no valido.");    
            }
        
            header('Content-Type: application/octet-stream');
            header('Content-Disposition: attachment; filename="'.$responseData['nombre'].$responseData['ext'].'"');
            // Devolver el BLOB como respuesta
            echo $responseData['usu_fraudes_adjunto_file'];
        }catch(\Exception $e){
            return Services::response()
                ->setJSON([
                    'error'=> $e->getMessage()
                ])->setStatusCode(ResponseInterface::HTTP_NOT_FOUND);
        }
        
    }

    public function deleteById($id)
    {
       
        try{
            $adjuntoModel = new AdjuntosModel();
            $adjuntoModel->delete($id);
            return $this->getResponse(['message'=>'OK'],ResponseInterface::HTTP_OK);
        }catch(\Exception $e){
            return Services::response()
                ->setJSON([
                    'error'=> $e->getMessage()
                ])->setStatusCode(ResponseInterface::HTTP_NOT_FOUND);
        }
        
    }

    public function upload()
    {
        try{
            helper("fraude");
            $rules = [
                'file' => 'required',
                'fraudeID' => 'required|numeric|min_length[1]|max_length[50]',
                'nombre' =>'required|min_length[1]|max_length[50]',
                'ext' =>'required|min_length[1]|max_length[10]'
            ];
    
            $input = $this->getRequestInput($this->request);
    
            if (!$this->validateRequest($input, $rules)) {
                return $this->getResponse($this->validator->getErrors(), ResponseInterface::HTTP_BAD_REQUEST);
            }
    
            $data = [
                'usu_fraudes_adjunto_file' => base64_decode($input['file']),
                'usu_fraude_id' => $input['fraudeID'],
                'nombre' => $input['nombre'],
                'ext' => $input['ext']
            ];
            $adjuntoModel = new AdjuntosModel();
            $result=$adjuntoModel->insert($data);
            if($result!=0){
                $lastInsertedId = $adjuntoModel->insertID();
                return  Services::response()
                    ->setJSON([
                        'adjuntoID'=> $lastInsertedId
                    ])->setStatusCode(ResponseInterface::HTTP_CREATED);
            }else{
                  return  Services::response()
                ->setJSON([
                        'error'=> 'no se pudo realizar el upload'
                    ])->setStatusCode(ResponseInterface::HTTP_NOT_ACCEPTABLE);
            }
    
        }catch(\Exception $e){
            return Services::response()
                ->setJSON([
                    'error'=> $e->getMessage()
                ])->setStatusCode(ResponseInterface::HTTP_NOT_FOUND);
        }
        
    }

    

   
    
   
}