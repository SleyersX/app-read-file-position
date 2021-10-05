<?php
    namespace getToken;
    use Firebase\JWT\JWT;
    include 'vendor/firebase/php-jwt/src/JWT.php';

    $headers=getallheaders();
    //echo $headers["token"];

    $jwt = $headers["token"];
    $key = "6e8c091a1c3b2a51abe6c04d7928142a74dacb3bf69f917a9762f561b5257464c9dd5973cb532da9c374e2ff9c3118052965a9f605ca0588cada8182f4e056f4";

    JWT::$leeway = 60; // $leeway in seconds
    $decoded = JWT::decode($jwt, $key, array('HS512'));

    print_r($decoded);
