<?php



 function validar_recaptcha($token,$action){
     
        // Hacer una solicitud POST al servidor de reCAPTCHA v3 para validar el token
        $url = $_ENV['recaptchav3_endpoint'];
        $data = array(
            'secret' => $_ENV['recaptchav3_key_private'],
            'response' => $token
        );

        $options = array(
            'http' => array(
                'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
                'method'  => 'POST',
                'content' => http_build_query($data)
            )
        );

        $context  = stream_context_create($options);
        $result = file_get_contents($url, false, $context);
        $response = json_decode($result);

        // Verificar la respuesta del servidor de reCAPTCHA v3
        if ($response->success) {
             log_message('info', 'reCAPTCHA validado correctamente');
            return true;
        } else {
             log_message('info', 'Error al validar reCAPTCHA');
           return false;
        }
    }