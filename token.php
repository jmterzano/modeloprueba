<?php
include 'vendor/autoload.php';
use \Firebase\JWT\JWT;
class Token{

    public static function encodeToken($nombre,$clave)
    {
        $key = "llave";
        $payload = array(
        "iss" => "http://example.org",
        "aud" => "http://example.com",
        "iat" => 1356999524,
        "nbf" => 1357000000,
        "nombre"=>$nombre,
        "clave"=>$clave
          );

        try {   
             
            return JWT :: encode($payload,$key);
            
        } catch (\Throwable $th) {
            return "Error";
        }
    }

    public static function decodeToken($token)
    {
        $key = "llave";
        try {
            
            $decode = JWT::decode($token, $key, array('HS256'));
            return $decode;

        } catch (\Throwable $th) {
           echo "error";
        }

       

    }

}