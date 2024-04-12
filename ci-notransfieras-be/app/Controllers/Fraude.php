<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\AdjuntosModel;
use App\Models\FraudeModel;
use App\Models\FunaModel;
use App\Models\RrSsModel;
use App\Models\TelefonoModel;
use App\Models\UserRutificadoModel;
use CodeIgniter\Config\Services;
use CodeIgniter\HTTP\ResponseInterface;
use Exception;

class Fraude extends BaseController
{
    
    
    public function findListFunas($idUser)
    {
        $model = new FraudeModel();
        try{
            helper("fraude");
            $responseData=$model->findFunasByIdUser($idUser);
            if($responseData === null || empty($responseData)){
                throw new Exception("No existen registros para el usuario seleccionado.");    
            }
            $listCamelCase=listToCamelCase($responseData);
            return $this->getResponse($listCamelCase);
        }catch(\Exception $e){
            return Services::response()
                ->setJSON([
                    'error'=> $e->getMessage()
                ])->setStatusCode(ResponseInterface::HTTP_BAD_REQUEST);
        }
        
    }

    public function registrar()
    {
        try{
        helper("fraude");
        $rules = [
            'detalle' => 'required|min_length[1]|max_length[2000]',
            'fechaRegistro' => 'required|valid_date',
             'rutID' =>'required|numeric|min_length[1]|max_length[50]',
            'usuarioID' =>'required|min_length[1]|max_length[36]'
        ];

        $input = $this->getRequestInput($this->request);

        if (!$this->validateRequest($input, $rules)) {
            return $this->getResponse($this->validator->getErrors(), ResponseInterface::HTTP_BAD_REQUEST);
        }
         $rutificadorModel = new UserRutificadoModel();
         $rutID=$input['rutID'];
        $dataUpdate['fake']=true;
        $resultUpdate=$rutificadorModel->update($rutID,$dataUpdate);
        if($resultUpdate!=0){
            
            $model = new FraudeModel();
            $data = [
                'usu_fraude_detalle' => $input['detalle'],
                'usu_fraude_fecha_registro' => $input['fechaRegistro'],
                'rut_id' => $input['rutID'],
                'id_user_registra' => $input['usuarioID']
            ];
            $result=$model->insert($data);
            if($result!=0){
                $lastInsertedId = $model->insertID();
                $lastInsertedRecord = $model->findUsuFraudeId($lastInsertedId);
                $listCamelCase=snakeTocamel($lastInsertedRecord);
                return $this->getResponse($listCamelCase, ResponseInterface::HTTP_CREATED);
            }else{
                return $this->getResponse(['error'=>'No se creo el comentario'], ResponseInterface::HTTP_NOT_ACCEPTABLE);
            }
            
        }else{
           return $this->getResponse(['error'=>'No se pudo actualizar estado fake'], ResponseInterface::HTTP_NOT_MODIFIED);
        }
            
        
        
    }catch(\Exception $e){
        return Services::response()
            ->setJSON([
                'error'=> $e->getMessage()
            ])->setStatusCode(ResponseInterface::HTTP_BAD_REQUEST);
    }
    }

    public function getDetalle($idFraude)
    {
        try{
        helper("fraude");
      

        $fraudeModel = new FraudeModel();
        
        $dataFraude=$fraudeModel->findUsuFraudeId($idFraude);
        if($dataFraude===null || empty($dataFraude)){
            throw new Exception('no existen registros con el id ingresado');
        }

        $adjuntoModel= new AdjuntosModel();
        $dataAdjunto=$adjuntoModel->findAdjuntoByIdFraude($idFraude);
        $rrssModel= new RrSsModel();
        $dataRRSS=$rrssModel->findRRSSByIdFraude($idFraude);
        $telefonoModel= new TelefonoModel();
        $dataTelefono=$telefonoModel->findTelefonoByIdUser($dataFraude['rut_id']);
        helper('mapper');
        helper('fraude');
        $dataFraude=snakeTocamel($dataFraude);
        $dataFraude['adjuntos']=adjuntolistToCamelCase($dataAdjunto);
        $dataFraude['rrss']=rrsslistToCamelCase($dataRRSS);
        $dataFraude['telefonos']=telefonoListToCamelCase($dataTelefono);

        return $this->getResponse($dataFraude, ResponseInterface::HTTP_OK);
    }catch(\Exception $e){
        return Services::response()
            ->setJSON([
                'error'=> $e->getMessage()
            ])->setStatusCode(ResponseInterface::HTTP_BAD_REQUEST);
    }
    }
    
   
}