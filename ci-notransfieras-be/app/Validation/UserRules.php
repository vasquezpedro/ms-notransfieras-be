<?php

namespace App\Validation;

use App\Models\UserModel;

class UserRules
{
    public function validateUser(string $str, string $fields, array $data): bool
    {
        try {
            $model = new UserModel();
            $user = $model->findUserByName($data['username']);
            return password_verify($data['password'], $user['password']);
        } catch (\Exception $e) {
            return false;
        }
    }

    public function isNotZero(string $str = null): bool{
        return $str !== '0';
    }

    public function isNotWhitespace(string $str = null): bool
    {
        return trim($str) !== '';
    }


    function valid_rut($rut) {
        if($rut===null && isset($rut)){
            return false;
        }
        // Eliminar puntos y guión del RUT y convertir todo a mayúsculas
        $rut = strtoupper(str_replace(['.', '-'], '', $rut));
    
        // Separar el RUT del dígito verificador
        $rutSinVerificador = substr($rut, 0, -1);
        $verificador = substr($rut, -1);
    
        // Validar el formato del RUT
        if (!preg_match('/^[0-9]{1,8}$/', $rutSinVerificador)) {
            return false; // El RUT no tiene el formato correcto
        }
    
        // Calcular el dígito verificador esperado
        $factor = 2;
        $suma = 0;
        for ($i = strlen($rutSinVerificador) - 1; $i >= 0; $i--) {
            $suma += $rutSinVerificador[$i] * $factor;
            $factor = $factor == 7 ? 2 : $factor + 1;
        }
        $resto = $suma % 11;
        $digitoEsperado = ($resto == 0) ? '0' : (($resto == 1) ? 'K' : (11 - $resto));
    
    
        // Comparar el dígito verificador calculado con el proporcionado
        return $digitoEsperado == $verificador;
    }
    
     function validaGrandType($grand_type){
        $continua=false;
        if (isset($grand_type) && !empty($grand_type)) {
                $arrayCanales = explode(',', env('GRAND_TYPES'));
                foreach ($arrayCanales as $grand_type_OK) {
                    if ($grand_type === $grand_type_OK) {
                        $continua=true;
                        break;
                     }
                }
            }
        return $continua;
    }
}