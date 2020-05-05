<?php
include_once './datos.php';
include_once './token.php';
Class Usuario

{   
    public $nombre;
    public $dni;
    public $obrasocial;
    public $clave;
    public $tipo;
    
    public function __construct($nombre,$dni,$obrasocial,$clave,$tipo)
    {
        $this->nombre=$nombre;
        $this->dni=$dni;
        $this->obrasocial=$obrasocial;
        $this->clave=$clave;
        $this->tipo=$tipo;
    }

    public function save()
   {

    return Datos::guardar("datos.json", $this);

   }

   public static function validar($nombre,$clave)
   {
     $lista= Datos::leerjson("datos.json");

     foreach($lista as $value)
     {
         if($value->nombre==$nombre && $value->clave==$clave)
         {

             $token= new Token;
             
             echo json_encode($token->encodetoken($nombre,$clave));
             return true;
             break;
         }
             
     }
     return false;

   }

   public static function validaradmin($toko)
   {
    $lista= Datos::leerjson("datos.json");
    $nombre=$toko->nombre;

    foreach($lista as $value)
    {
        if($value->nombre==$nombre)
        {
            if($value->tipo=="admin")
            {
                return true;
                break;
            }      
        }    
    }
    return false;
   }

   public static function validarusuario($toko)
   {
    $lista= Datos::leerjson("datos.json");
    $nombre=$toko->nombre;

    foreach($lista as $value)
    {
        if($value->nombre==$nombre)
        {
            if($value->tipo=="user")
            {
                return true;
                break;
            }      
        }    
    }
    return false;
   }
   
  
}

    ?>