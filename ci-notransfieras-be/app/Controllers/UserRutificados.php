<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\UserRutificadoModel;
use CodeIgniter\Config\Services;
use CodeIgniter\HTTP\ResponseInterface;
use Exception;
use PDOException;

class UserRutificados extends BaseController
{
    
   
    
    public function find1($rut)
    {
        $model = new UserRutificadoModel();
       
        try{
            log_message('info',  "voy al UserRutificados::find1 ");
            helper('rutificador');
            if(!validarRut($rut)){
                throw new Exception($rut.'->El formato del rut no es valido.');
            }
            $rutAux=cleanRut($rut);
            $userRut=$model->findClientByRut($rutAux);
            $responseData =null;
            if($userRut === null || !isset($userRut)){
                $response = getRutificador($rut);
                
                foreach ($response as $key => $value) {
                    log_message('info', 'response del rutificador - ' . $key . ': ' . $value);
                }
                
                if(!isset($response) ||  array_key_exists('error', $response)){
                    throw new Exception('rut no encontrado');
                }
                $response['rut']=$rutAux;
                $model->save($response);
                $userRut = $model->findClientByRut($rutAux);
                $responseData =domainToResponse( $userRut);
                
            }else{
                $responseData =domainToResponse( $userRut);  
            }
            
            return $responseData;
        }catch(\Exception $e){
          return[
                    'error'=> $e->getMessage()
                ];
        }
        
    }


    public function findNombre($nombre)
    {
        $model = new UserRutificadoModel();
       log_message('info',  "voy al UserRutificados::findNombre ");
        try{
            helper('rutificador');
                $response = getRutificadorNombre($nombre);
               
             if($response !== null ){
                foreach ($response as $dataInsert) {
                    try{
                        if(isset($dataInsert['rut']) && !empty($dataInsert['rut'])){
                            $userRut=$model->findClientByRut($dataInsert['rut']);
                         if($userRut === null || !isset($userRut)){
          
                            $model->save($dataInsert);
                           
                         }
                            
                        }
                         
                        
                    }catch(PDOException  $e){
                        log_message('error', 'error al registrar - '. implode(', ', $dataInsert));
                    }catch(\Exception $e){
                        log_message('error', 'error al registrar - '. implode(', ', $dataInsert));
                    }
                    
                }
        }else{
             return $this->getResponse(['menssage'=>'no se encontraron resultados para el nombre '.$nombre]);
        }
                 $lastInsertedId = $model->insertID();
                return $this->getResponse(['menssage'=>$lastInsertedId]);
        }catch(\Exception $e){
            log_message('error', $e->getMessage());
          return[
                    'error'=> $e->getMessage()
                ];
        }
        
    }


   
    public function find($rut)
    {
       log_message('info',  "voy al UserRutificados::find ");
        $model = new UserRutificadoModel();
       
        try{
            helper('rutificador');
            
            if(!validarRut($rut)){
                throw new Exception('El formato del rut no es valido.');
            }
            $rutAux=cleanRut($rut);
            $userRut=$model->findClientByRut($rutAux);
            $responseData =null;
            if($userRut === null || !isset($userRut)){
                $response = getRutificador($rut);
                foreach ($response as $key => $value) {
                    log_message('info', 'response del rutificador - ' . $key . ': ' . $value);
                }
                if(!isset($response) ||  array_key_exists('error', $response)){
                   // throw new Exception('rut no encontrado');
                     log_message('error', 'rut no encontrado:' . $rut);
                    return $this->getResponse(['error'=>'rut no encontrado'])->setStatusCode(ResponseInterface::HTTP_FORBIDDEN);
                }
                $response['rut']=$rutAux;
                $model->save($response);
                $userRut = $model->findClientByRut($rutAux);
                $responseData =domainToResponse( $userRut);
                
            }else{
                $responseData =domainToResponse( $userRut);  
            }
            
            return $this->getResponse($responseData);
        }catch(\Exception $e){
            log_message('error', 'find:' . $e);
            return Services::response()
                ->setJSON([
                    'error'=> $e->getMessage()
                ])->setStatusCode(ResponseInterface::HTTP_BAD_REQUEST);
                
   
   
        }
        
    }

    public function findById($id)
    {
        $model = new UserRutificadoModel();
       
        try{
            helper('rutificador');
         
            $userRut=$model->findClientById($id);
            $responseData =null;
            if($userRut === null){
                throw new Exception("Id no encontrado."); 
            }else{    
                $responseData =domainToResponse($userRut);
                return $this->getResponse($responseData);
            }
            
            
        }catch(\Exception $e){
            return Services::response()
                ->setJSON([
                    'error'=> $e->getMessage()
                ])->setStatusCode(ResponseInterface::HTTP_BAD_REQUEST);
        }
        
    }

    public function patchAdmin()
    {
        $model = new UserRutificadoModel();
       
        try{
            helper('rutificador');
            $rules = [
                'fake' => 'required|in_list[0,1]',
                'usuarioID' =>'required|numeric|min_length[1]|max_length[50]'
            ];
           
            $input = $this->getRequestInput($this->request);
    
            if (!$this->validateRequest($input, $rules)) {
                return $this->getResponse($this->validator->getErrors(), ResponseInterface::HTTP_BAD_REQUEST);
            }
            
            $userRut['fake']=$input['fake'];
             $result=$model->where('usuario_id', $input['usuarioID'])->set($userRut)->update();
            if($result!=0){
                return  Services::response()->setJSON([
                    'message'=> "OK"
                ])->setStatusCode(ResponseInterface::HTTP_ACCEPTED);
            }else{
                return  Services::response()->setJSON([
                    'error'=> "no se pudo actualizar el estado fake"
                ])->setStatusCode(ResponseInterface::HTTP_NOT_MODIFIED);
            }
        }catch(\Exception $e){
            return Services::response()
                ->setJSON([
                    'error'=> $e->getMessage()
                ])->setStatusCode(ResponseInterface::HTTP_BAD_REQUEST);
        }
        
    }

   
}