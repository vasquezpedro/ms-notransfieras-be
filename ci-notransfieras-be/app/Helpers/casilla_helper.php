<?php

use App\Models\ConfirmacionCorreoModel;
use App\Models\UserModel;

function preareConfirmacionHash(string $email,string $username,string $mensaje=""){
    $modelUser = new UserModel();
    $user = $modelUser->findUserByEmailAddressNameUser($email, $username);
    if ($user['email_confirmado']) {
        throw new \Exception('Email ya confirmado');
    }
    $model = new ConfirmacionCorreoModel();
    $currentDate = new DateTime();
    $hash = hash('sha256', $currentDate->format('Y-m-d H:i:s'));
    $fechaExpiracion = $currentDate->modify('+5 days');
    $model->save(
        [
            'hash' => $hash,
            'usuario_id' => $user['id'],
            'fecha_expiracion' => $fechaExpiracion->format('Y-m-d H:i:s')
        ]
    );
    $modelUser->update(['id' => $user['id']], ['email_confirmado' => 0]);
return $message = "Estimado " 
                . $username 
                .$mensaje
                ."\n Verifica tu correo " 
                . $email 
                . " haciendo click en el siguieten link:\n       " 
                . site_url("mail/confirmar/") 
                . $hash
                ."\n          este link estara disponible hasta la fehca "
                .$fechaExpiracion->format('Y-m-d H:i:s');
}

function preareConfirmacionCode(string $email,string $username,string $mensaje=""){
    $modelUser = new UserModel();
    $user = $modelUser->findUserByEmailAddressNameUser($email, $username);
    if ($user['email_confirmado']) {
        throw new \Exception('Email ya confirmado');
    }
    $model = new ConfirmacionCorreoModel();
    $currentDate = new DateTime();
    $numeroAleatorio = mt_rand(100000, 999999);
    $fechaExpiracion = $currentDate->modify('+5 minutes');
    $model->save(
        [
            'code' => $numeroAleatorio,
            'usuario_id' => $user['id'],
            'fecha_expiracion' => $fechaExpiracion->format('Y-m-d H:i:s')
        ]
    );
    $modelUser->update(['id' => $user['id']], ['email_confirmado' => 0]);
return $message = "Estimado " 
                . $username 
                .$mensaje
                ."\n Verifica tu correo " 
                . $email 
                . " ingresando el siguiente codigo en tu aplicacion:\n       " 
      
                . '<h1>'.$numeroAleatorio.'</h1>'
                ."\n este codigo estara disponible duante 2 minutos, en caso de perderlo puedes volver a solicitar otro\n fecha de expiracion:"
                .$fechaExpiracion->format('Y-m-d H:i:s');
}