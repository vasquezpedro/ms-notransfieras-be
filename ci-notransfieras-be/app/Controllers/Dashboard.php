<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use Exception;

class Dashboard extends BaseController
{
    
    public function __construct()
    {
        helper(['url']);
       
    }

    public function usuario($accion):string{
       try{
       
             $usuario=session()->get('usuario');
           return view($accion.'_usuario_view', ['usuario' => $usuario,'title'=>'Crear usuario']);
        
       }catch(\Exception $e){
            return view('login_view', ['error' =>$e]);
       }

    }

    

   
}