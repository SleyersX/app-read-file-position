<?php
    namespace getToken;
    use Firebase\JWT\JWT;
    include 'vendor/firebase/php-jwt/src/JWT.php';
    //$key = hash('sha256',uniqid("",true));
    $key = md5(uniqid(""));
    $payload = array(
        "iss" => "http://example.org",
        "aud" => "http://example.com",
        "iat" => strtotime("now"),
        "nbf" => strtotime("+60 minute")
    );

    $jwt = JWT::encode($payload, $key);

    $response=array(
        "token"=>$jwt
    );
    header('Content-Type: application/json; charset=utf-8');
    echo json_encode($response);