<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\RolesModel;
use App\Models\TelefonoModel;
use CodeIgniter\Commands\Help;
use CodeIgniter\Config\Services;
use CodeIgniter\Database\Exceptions\DatabaseException;
use CodeIgniter\HTTP\ResponseInterface;
use Exception;

class Usuario extends BaseController
{
    
   
     const titleRegistro="Registrar Usuario";
     const titleEditar='Editar Usuario';

    public function indexRegistrar():string{
        try{
        
              $usuario=session()->get('usuario');
            return view('registro_usuario_view', ['usuario' => $usuario,'title'=>self::titleRegistro]);
         
        }catch(\Exception $e){
             return view('login_view', ['error' =>$e]);
        }
 
     }

     public function indexUpdate():string{
      
        try{
        
          
            return view('editar_usuario_view', ['usuario' => session()->get('usuario'),'title'=>self::titleEditar]);
        }catch(\Exception $e){
             return view('editar_usuario_view', ['usuario' => session()->get('usuario'),'error' =>$e,'title'=>self::titleEditar]);
        }

         

 }

 public function indexRol():string{
      
    try{
        return view('rol_usuario_view', ['usuario' => session()->get('usuario'),'title'=>"Rol Usuario"]);
    }catch(\Exception $e){
         return view('rol_usuario_view', ['usuario' => session()->get('usuario'),'error' =>$e,'title'=>"Rol Usuario"]);
    }

     

}

    public function registrar()
    {
        try{
            
        $rules = [
                'names' => 'required|min_length[3]|max_length[50]',
                'apellidos' => 'required|min_length[3]|max_length[50]',
                'email' => 'required|valid_email|is_unique[user.email]',
                'usuario' => 'required|min_length[8]|max_length[36]|is_unique[user.usuario]',
                'password' => 'required|min_length[8]|max_length[255]',
                'password2' => 'required|min_length[8]|max_length[255]|matches[password]'
            ];
            helper('usuario');
            $input = $this->getRequestInput($this->request);
    
            if (!$this->validateRequest($input, $rules,mensajeriaValidaciones())) {
            
                return view('registro_usuario_view', ['usuario'=>session()->get('usuario'),'error' =>implode('<br> ', $this->validator->getErrors())]);
            }

            $data = [
            'name' => $input['names'],
            'apellido' =>  $input['apellidos'],
            'email' =>  $input['email'],
            'usuario' => $input['usuario'],
            'password' => $input['password']
        ];
        $endpoint=$_ENV['ADM_API_POST_USER'];
        helper('cliente');
        $token=session()->get('token');
        $response=callPostApi($endpoint,$data,'application/json',$token);
        $response=extractResponse($response,[200]);
        return view('registro_usuario_view', ['usuario'=>session()->get('usuario'),'usuarioID'=>$response['body']->user->id,'title'=>"Crear Usuario"]);

        }catch(\Exception $e){
            return view('registro_usuario_view', ['usuario'=>session()->get('usuario'),'error' => $e->getMessage(),'title'=>"Crear Usuario"]);
        }
        
    }


    public function editar():string{
        try{
            $roles=new RolesModel();
            $listRoles=$roles->findAll();
          
            return view('editar_usuario_view', ['usuario' => session()->get('usuario'),'listadoRoles'=> $listRoles,'title'=>self::titleEditar]);
        }catch(\Exception $e){
             return view('editar_usuario_view', ['usuario' => session()->get('usuario'),'error' =>$e,'title'=>self::titleEditar]);
        }
 
     }

     public function buscar():string{
        try{
            helper("usuario");
            
            $rules =  ['criterio' => 'required|not_equals[ ]',
            'seleccion' => 'required|trim|not_equals[ ]|isNotZero[0]'];
    
            $input = $this->getRequestInput($this->request); 
            $errors = [
                'error' => [
                    'isNotZero' => 'debe seleccionar un filtro de busqueda',
                    'criterio' => 'el criterio ingresado no es valido.'
                ]
            ];
            if (!$this->validateRequest($input, $rules,$errors)) {
            
                throw new Exception(implode(', ', $this->validator->getErrors()));
            }
    
            $idBusqueda=$input['seleccion'];
            $endpoint=$_ENV['ADM_API_GET_USER'].'/'.$idBusqueda;
       
            helper('cliente');
            $token=session()->get('token');
            $response=callApi($endpoint.'/'.$input['criterio'],[],'application/json',$token,'GET',$_ENV['CANAL_WEB']);
            $response=extractResponse($response,[200]);
            $roles=new RolesModel();
            $listRoles=$roles->findAll();
            return view('editar_usuario_view', ['usuario'=>session()->get('usuario'),'usuarioID'=>$response['body'],'listadoRoles'=> $listRoles,'title'=>self::titleEditar]);
        }catch(\Exception $e){
             return view('editar_usuario_view', ['usuario' => session()->get('usuario'),'error' =>$e->getMessage(),'title'=>self::titleEditar]);
        }
 
     }

     public function buscarRolUser():string{
        try{
            helper("usuario");
            
            $rules =  ['criterio' => 'required|not_equals[ ]',
            'seleccion' => 'required|trim|not_equals[ ]|isNotZero[0]'];
    
            $input = $this->getRequestInput($this->request); 
            $errors = [
                'error' => [
                    'isNotZero' => 'debe seleccionar un filtro de busqueda',
                    'criterio' => 'el criterio ingresado no es valido.'
                ]
            ];
            if (!$this->validateRequest($input, $rules,$errors)) {
            
                throw new Exception(implode(', ', $this->validator->getErrors()));
            }
    
            $idBusqueda=$input['seleccion'];
            $endpoint=$_ENV['ADM_API_GET_USER'].'/'.$idBusqueda;
       
            helper('cliente');
            $token=session()->get('token');
            $response=callApi($endpoint.'/'.$input['criterio'],[],'application/json',$token,'GET',$_ENV['CANAL_WEB']);
            $response=extractResponse($response,[200]);
            $roles=new RolesModel();
            $listRoles=$roles->findAll();
            return view('rol_usuario_view', ['usuario'=>session()->get('usuario'),'usuarioID'=>$response['body'],'listadoRoles'=> $listRoles,'title'=>"Rol Usuario"]);
        }catch(\Exception $e){
             return view('rol_usuario_view', ['usuario' => session()->get('usuario'),'error' =>$e->getMessage(),'title'=>"Rol Usuario"]);
        }
 
     }

     public function eliminarRol($usuarioID,$rolID):string{
        try{
            helper("usuario");
            
            $rules =  ['usuarioID' => 'required|trim|not_equals[ ]|min_length[1]|max_length[36]',
                        'rolID' => 'required|trim|not_equals[ ]|isNotZero[0]|min_length[1]|max_length[36]'];
    
           
            $errors = [
                'error' => [
                    'isNotZero' => 'debe seleccionar un rol'
                 
                ]
            ];
            if (!$this->validateRequest([$usuarioID,$rolID], $rules,$errors)) {
            
                throw new Exception(implode(', ', $this->validator->getErrors()));
            }
    
          
            $endpoint=$_ENV['ADM_API_GET_ROL'];
       
            helper('cliente');
            $token=session()->get('token');
            $response=callApi($endpoint.'/'.$usuarioID.'/'.$rolID,[],'application/json',$token,'DELETE',$_ENV['CANAL_WEB']);
            $response=extractResponse($response,[200]);
            $roles=new RolesModel();
            $listRoles=$roles->findAll();
            return view('rol_usuario_view', ['usuario'=>session()->get('usuario'),'usuarioID'=>$response['body'],'listadoRoles'=> $listRoles,'title'=>"Rol Usuario"]);
        }catch(\Exception $e){
             return view('rol_usuario_view', ['usuario' => session()->get('usuario'),'error' =>$e->getMessage(),'title'=>"Rol Usuario"]);
        }
 
     }
}