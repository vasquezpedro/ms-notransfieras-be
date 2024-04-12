<?php


use Firebase\JWT\JWT;
use App\Models\UserModel;
use CodeIgniter\Config\Services;
use Firebase\JWT\Key;

function getJWTFromRequest($authenticationHeader): string
{
    if (is_null($authenticationHeader)) {
         throw new Exception('Credenciales no validas.');
    }

    return explode(' ', $authenticationHeader)[1];
}

function decodeToken($encodedToken):stdClass{
    $alg=$_ENV['JWT_ALG'];

    $key = Services::getSecretKey();
    $decodedToken = JWT::decode($encodedToken,  new Key($key , $alg));
    return $decodedToken;
}
function validateJWTFromRequest(string $encodedToken)
{
   
    $decodedToken = decodeToken($encodedToken);
    $userModel = new UserModel();
    $userModel->findUserByName($decodedToken->username);
}

function getSignedJWTForUser(array $user,$issuedAtTime,$tokenExpiration): string
{
    /*
    $issuedAtTime = time();
    $tokenTimeToLive = $_ENV['JWT_TIME_TO_LIVE'];
    $tokenExpiration = $issuedAtTime + $tokenTimeToLive;
    */
    $alg=$_ENV['JWT_ALG'];
    $key = Services::getSecretKey();
    
    $payload = [
        'email' => $user['email'],
        'username' => $user['username'],
        'role'=> $user['roles'],
        'iat' => $issuedAtTime,
        'exp' => $tokenExpiration
    ];
 
    $jwt = JWT::encode($payload, $key,$alg);

    return $jwt;
}

function valPermisoUsuario( $metohdName,$roles ){
    if (isset($roles) && !empty($roles)) {
        $sinPermisos=true;
        foreach ($roles as $rol) {
            $arrayValores = explode(',', env('PERFILACION_'.$rol));
            foreach ($arrayValores as $methds) {
                if ($methds === $metohdName) {
                    $sinPermisos=false;
                    break;
                 }
            }
           
        }
       
        if ($sinPermisos) {
            throw new Exception('Sin permisos suficientes para realizar esta acci¨®n');
        }
    }else{
        throw new Exception('Usuario sin perfilacion.');
    }
   

}

