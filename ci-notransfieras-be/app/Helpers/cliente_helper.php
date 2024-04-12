<?php




function callPostApi($url, $data,$content_type,$token)
{
    $baseEndpoint=$_ENV['DOMAIN_ADM_API'];
    //$baseEndpoint="https://rutsfakechile.000webhostapp.com/api";
    $enpoint=$baseEndpoint.'/'.$url;
    $curl = curl_init();
    log_message('info',  "comienza solicitud post para:". $enpoint);
    // Configurar la solicitud POST
    curl_setopt_array($curl, array(
        CURLOPT_URL => $enpoint,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 100,
         
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "POST",
        CURLOPT_POSTFIELDS => json_encode($data), // Convertir los datos a formato de consulta
        CURLOPT_HTTPHEADER =>  generarHeader($content_type,$token),
    ));
    log_message('info',  "request de la solicitud:". json_encode($data));
    // Ejecutar la solicitud y obtener la respuesta
    $response = curl_exec($curl);
    
    $http_status = curl_getinfo($curl, CURLINFO_HTTP_CODE);
    log_message('info',  "http_status de la solicitud:". $http_status);
    log_message('info',  "body de la solicitud:". json_encode($response));
    
    $err = curl_error($curl);

    // Cerrar la sesión cURL
    curl_close($curl);

    // Verificar errores y devolver la respuesta
    if ($err ||  $http_status!=200) {
        log_message('info',  "Error al hacer la solicitud:" . $err);
        log_message('info',  "fin solicitud post con errores.");
       
    } else {
        log_message('info',  "fin solicitud post.");
    }
    return ["code"=>$http_status,"body"=>json_decode($response)];
}



function generarHeader($content_type='application/json',$token,$canal='WEB'){
    $params= array(
        'Content-Type: '.$content_type,
        'Channel: '.$canal,
        'ip: '.$_SERVER['REMOTE_ADDR'] ,
        'os: '.$_SERVER['HTTP_USER_AGENT'] ,
        'Device-Id: 0');
        if(isset($token) && !empty($token)){
            $params[count($params)]='Authorization: Bearer '.$token;
        }
        return $params;
    }

function callApi($url, $data,$content_type,$token,$peticion,$canal)
{
    $HTTPHEADER=generarHeader($content_type,$token,$canal);
    $baseEndpoint=$_ENV['DOMAIN_ADM_API'];

    $enpoint=$baseEndpoint.'/'.$url;
    $curl = curl_init();
    log_message('info',  "comienza solicitud ".$peticion." para:". $enpoint);
    // Configurar la solicitud
    $paramsCurl=array(
        CURLOPT_URL => $enpoint,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 100,
         
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => $peticion,
        CURLOPT_HTTPHEADER => $HTTPHEADER,
    );
    if(strcasecmp($peticion, 'post')==0){
        $paramsCurl[CURLOPT_POSTFIELDS] = json_encode($data);
    }
    curl_setopt_array($curl,$paramsCurl);
    log_message('info',  "request de la solicitud:". json_encode($data));
    // Ejecutar la solicitud y obtener la respuesta
    $response = curl_exec($curl);
    
    $http_status = curl_getinfo($curl, CURLINFO_HTTP_CODE);
    log_message('info',  "http_status de la solicitud:". $http_status);
    log_message('info',  "response de la solicitud:". json_encode($response));
    
    $err = curl_error($curl);

    // Cerrar la sesión cURL
    curl_close($curl);

    // Verificar errores y devolver la respuesta
    if ($err ||  $http_status!=200) {
        log_message('info',  "Error al hacer la solicitud:" . $err);
        log_message('info',  "fin solicitud ".$peticion." con errores.");
       
    } else {
        log_message('info',  "fin solicitud ".$peticion.".");
    }
    return ["code"=>$http_status,"body"=>json_decode($response)];
}


function extractResponse($response,$expectCode=[200],$exceptionCode=[])
{
    if(isset($response)){
        if(in_array($response['code'], $expectCode)){

            return $response;

        }else{

            if($response['body'] && !empty($exceptionCode) && in_array($response['code'],$exceptionCode)){
                $error="message - ";
                foreach ($response['body'] as $value) {
                    
                    if( $error!="message - "){
                        $error=$error.' '.$value;
                    }else{
                        $error=$error.$value;
                    }
                }
            throw new Exception($error);
            }else{
                log_message('info',  'cant find:'.$response['code'].',in excepted code:'.implode(', ', $exceptionCode));
                throw new Exception('Error al consultar el servicio.');
            }
            
           
        }
   
    }else{
        throw new Exception('se ha producido un error inesperado.');
    }

    
}

function getApiSecure($url, $data,$dataLogin,$content_type,$peticion,$canal){
    $endpoint=$_ENV['DOMAIN_ADM_API_LOGIN'];
    $response=callApi($endpoint,$dataLogin,'application/json','','POST',$canal);
    $response=extractResponse($response,[200]);
    if (isset($response['body']->access_token) && !is_null($response['body']->access_token) && $response['body']->access_token !== '') {
        return callApi($url, $data,$content_type,$response['body']->access_token,$peticion,$canal);
    } else {
       throw new Exception('Error al obtener el token');
    }
    
}

function getResponseForEnpoint($endpoint, $data,$token,$content_type,$peticion,$canal,$expectCode=[200],$exceptionCode=[]){
    $response=callApi($endpoint,$data,$content_type,$token,$peticion,$canal);
    return extractResponse($response,$expectCode,$exceptionCode);
    
    
}

