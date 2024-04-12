<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\RolesModel;
use App\Models\UsuRolRelModel;
use CodeIgniter\Config\Services;
use CodeIgniter\Database\Exceptions\DatabaseException;
use CodeIgniter\HTTP\ResponseInterface;


class Roles extends BaseController
{
    
   
    public function registrar()
    {
        try{
            
            $rules = [

                'nombre' => 'required|min_length[1]|max_length[10]',
                'descripcion' =>'required|min_length[1]|max_length[20]'
            ];
    
            $input = $this->getRequestInput($this->request);
    
            if (!$this->validateRequest($input, $rules)) {
                return $this->getResponse($this->validator->getErrors(), ResponseInterface::HTTP_BAD_REQUEST);
            }
            $rolModel = new RolesModel();
            $idUUID =$rolModel->generaId();
            
            $data = [
                'id'=>$idUUID,
                'nombre' => $input['nombre'],
                'descripcion' => $input['descripcion']
            ];
  
            $rolModel->insert($data);
           
            return  Services::response()
                ->setJSON([
                    'rolID'=> $idUUID
                ])->setStatusCode(ResponseInterface::HTTP_CREATED);
    
        }catch (DatabaseException $e) {
            return $this->response->setStatusCode(ResponseInterface::HTTP_NOT_FOUND)->setJSON(['error' => $e->getMessage()]);
        }catch(\Exception $e){
            return Services::response()
                ->setJSON([
                    'error'=> $e->getMessage()
                ])->setStatusCode(ResponseInterface::HTTP_NOT_FOUND);
        }
        
    }

    public function listar()
    {
        try{
        
            $rolModel = new RolesModel();
            $listRoles=$rolModel->findAll();
            return  Services::response()
                ->setJSON($listRoles)->setStatusCode(ResponseInterface::HTTP_CREATED);
    
        }catch (DatabaseException $e) {
            return $this->response->setStatusCode(ResponseInterface::HTTP_NOT_FOUND)->setJSON(['error' => $e->getMessage()]);
        }catch(\Exception $e){
            return Services::response()
                ->setJSON([
                    'error'=> $e->getMessage()
                ])->setStatusCode(ResponseInterface::HTTP_NOT_FOUND);
        }
        
    }

    public function asignarRol()
    {
        try{
        
            $rules = [

                'usuarioID' => 'required|min_length[36]|max_length[36]',
                'rolID' =>'required|min_length[36]|max_length[36]'
            ];
    
            $input = $this->getRequestInput($this->request);
    
            if (!$this->validateRequest($input, $rules)) {
                return $this->getResponse($this->validator->getErrors(), ResponseInterface::HTTP_BAD_REQUEST);
            }
            $data = [

                'usuario_id' => $input['usuarioID'],
                'rol_id' => $input['rolID']
            ];
            $relUsuRolModel = new UsuRolRelModel();
            $relUsuRolModel->insert($data);
            return $this->getResponse(['message'=>'OK'],ResponseInterface::HTTP_CREATED);
    
        }catch (DatabaseException $e) {
            return $this->response->setStatusCode(ResponseInterface::HTTP_NOT_FOUND)->setJSON(['error' => $e->getMessage()]);
        }catch(\Exception $e){
            return Services::response()
                ->setJSON([
                    'error'=> $e->getMessage()
                ])->setStatusCode(ResponseInterface::HTTP_NOT_FOUND);
        }
        
    }

    public function eliminar($usuarioID,$rolID)
    {
        try{
        
            $rules = [

                'usuarioID' => 'required|min_length[36]|max_length[36]',
                'rolID' =>'required|min_length[36]|max_length[36]'
            ];
    
            $input = $this->getRequestInput($this->request);
    
            if (!$this->validateRequest($input, $rules)) {
                return $this->getResponse($this->validator->getErrors(), ResponseInterface::HTTP_BAD_REQUEST);
            }
            $data = [

                'usuario_id' => $usuarioID,
                'rol_id' => $rolID
            ];
            $relUsuRolModel = new UsuRolRelModel();
            $result = $relUsuRolModel->where('rol_id', $rolID)
                                 ->where('usuario_id', $usuarioID)
                                 ->findAll();

            if ($result && count($result)-1 > $_ENV['rol_umbral']) {
                throw new \RuntimeException('El ubral de roles es de minimo:'.$_ENV['rol_umbral']);
            } 
            $relUsuRolModel->where('rol_id', $rolID)
            ->where('usuario_id', $usuarioID)
            ->delete();
            return $this->getResponse(['message'=>'OK'],ResponseInterface::HTTP_CREATED);
    
        }catch (DatabaseException $e) {
            return $this->response->setStatusCode(ResponseInterface::HTTP_NOT_FOUND)->setJSON(['error' => $e->getMessage()]);
        }catch(\Exception $e){
            return Services::response()
                ->setJSON([
                    'error'=> $e->getMessage()
                ])->setStatusCode(ResponseInterface::HTTP_NOT_FOUND);
        }
        
    }

    
    public function index($userID):string{
        try{
            $usuario=session()->get('usuario');
            $rolModel = new RolesModel();
            $listRoles=$rolModel->findAll();
            return view('rol_usuario_view', ['usuario' => session()->get('usuario'),'userID'=>$userID,'listadoRoles'=> $listRoles,'title'=>"Roles"]);
        }catch(\Exception $e){
             return view('rol_usuario_view', ['usuario' => session()->get('usuario'),'error' =>$e,'title'=>"Roles"]);
        }
 
     }

     public function indexd($userID):string{
        try{
            $usuario=session()->get('usuario');
            $rolModel = new RolesModel();
            $listRoles=$rolModel->findAll();
            return view('rol_usuario_view', ['usuario' => session()->get('usuario'),'userID'=>$userID,'listadoRoles'=> $listRoles,'title'=>"Roles"]);
        }catch(\Exception $e){
             return view('rol_usuario_view', ['usuario' => session()->get('usuario'),'error' =>$e,'title'=>"Roles"]);
        }
 
     }

    
    
   
}