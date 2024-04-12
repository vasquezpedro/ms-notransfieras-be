<?php

function valCanalesEntrada( $canal ){
    if (isset($canal) && !empty($canal)) {
        $sinPermisos=true;
      
            $arrayCanales = explode(',', env('PERFILACION_CANALES'));
            foreach ($arrayCanales as $canalValido) {
                if ($canal === $canalValido) {
                    $sinPermisos=false;
                    break;
                 }
            }
        if ($sinPermisos) {
            throw new Exception('El canal ingresado no es valido');
        }
    }else{
        throw new Exception('Se debe informar el canal de origen.');
    }
   

}