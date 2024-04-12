<?php 

function findRulesIdBusqueda($idBusqueda){
    $retorno=[];
    switch ($idBusqueda) {
        case 'usuario':
            $retorno= ['inputVal' => 'required|min_length[2]|max_length[8]',
                        'seleccion' => 'required|trim|not_equals[ ]|is_not[0]'];
            break;
        case 'id':
            $retorno=  ['inputVal' => 'required|min_length[1]|max_length[36]' ];
            break;
        case 'email':
            $retorno=  ['inputVal' => 'required|valid_email|is_unique[user.email]'];
            break;
        
        
    }
    return  $retorno;

}

function mensajeriaValidaciones(){
    return  [
        'names' => [
            'required' => 'El campo nombres es obligatorio.',
            'min_length' => 'El campo nombres acepta un minimo de 3 y maximo 50.',
            'max_length' => 'El campo nombres acepta un minimo de 3 y maximo 50.'
        ],
        'apellidos' => [
            'required' => 'El campo apellidos es obligatorio',
            'min_length' => 'El campo apellidos acepta un minimo de 3 y maximo 50.',
            'max_length' => 'El campo apellidos acepta un minimo de 3 y maximo 50.'
        ],
        'email' => [
            'required' => 'El campo email es obligatorio.',
            'valid_email' => 'El campo email no es un email valido.',
            'is_unique' => 'email registrado con otra cuenta.',
        ],
        'usuario' => [
            'is_unique' => 'El campo usuario no valido para registrar.',
            'min_length' => 'El campo usuario acepta un minimo de 8 y maximo 36.',
            'max_length' => 'El campo usuario acepta un minimo de 8 y maximo 36.'
        ],
        'password' => [
            'required' => 'El campo contraseña es obligatorio',
            'min_length' => 'El campo contraseña acepta un minimo de 8 y maximo 36',
            'max_length' => 'El campo contraseña acepta un minimo de 8 y maximo 36'
        ],
        'password2' => [
            'required' => 'El campo repassword es obligatorio',
            'matches' =>'Las contraseñas no coinciden',
            'min_length' => 'El campo repassword acepta un minimo de 8 y maximo 36',
            'max_length' => 'El campo repassword acepta un minimo de 8 y maximo 36'
        ],
    ];
}


