<?php

//verificar instancia
/* $curl = curl_init();

curl_setopt_array($curl, array(
    CURLOPT_URL => 'https://api-whats.com/api/v1/instance/verify/F10DC67D74',
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_ENCODING => '',
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_TIMEOUT => 0,
    CURLOPT_FOLLOWLOCATION => true,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => 'GET',
    CURLOPT_HTTPHEADER => array(
        'Access-token: APP-USER-5876655-A797D00B18061C96A196C1B52ADABF9774E8552E'
    ),
));

$response = curl_exec($curl);

curl_close($curl);
echo $response; */




//qrcode

$curl = curl_init();

curl_setopt_array($curl, array(
    CURLOPT_URL => 'https://api-whats.com/api/v1/instance/qrcode/F10DC67D74',
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_ENCODING => '',
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_TIMEOUT => 0,
    CURLOPT_FOLLOWLOCATION => true,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => 'POST',
    CURLOPT_HTTPHEADER => array(
        'Access-token: APP-USER-5876655-A797D00B18061C96A196C1B52ADABF9774E8552E'
    ),
));

$response = curl_exec($curl);

curl_close($curl);
echo $response;



//gerar token
/* $curl = curl_init();

curl_setopt_array($curl, array(
    CURLOPT_URL => 'https://api-whats.com/api/v1/oauth/token/',
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_ENCODING => '',
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_TIMEOUT => 0,
    CURLOPT_FOLLOWLOCATION => true,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => 'POST',
    CURLOPT_HTTPHEADER => array(
        'X-Client-id: 5876655',
        'X-Client-secret: bcca2fb7798c1c5dec4d06364f5f6046'
    ),
));

$response = curl_exec($curl);

curl_close($curl);
echo $response;
 */
