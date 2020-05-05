<?php
class Datos
{


public static function guardar($archivo,$datos)
  {
    $file=fopen($archivo,'r');
    $string=fread($file,filesize($archivo));
    $json=json_decode($string);
    fclose($file);

    array_push($json,$datos);

    $file=fopen($archivo,'w');
    $rta=fwrite($file,json_encode($json));
    fclose($file);

    return $rta;

   }


   public static function leerJson($archivo)
  {
    $file=fopen($archivo,'r');
    $string=fread($file,filesize($archivo));
    $json=json_decode($string);
    fclose($file);

    return $json;

  }

  public static function guardaventa($archivo,$datos)
{
    $file=fopen($archivo,"a");

    $rta=fwrite($file,$datos);

    fclose($file);

    return $rta;
}

public static function leerTodo($archivo)
{

    $file=fopen($archivo,"r");

    $lista=array();

    while(!feof($file))
    {

        $linea=fgets($file);

        $explode = explode('@',$linea);

        if(count($explode)>0)
        {
            array_push($lista, $explode);
        }
        
    }

    fclose($file);

    return $lista;

}

public static function leeruser($archivo,$toko)
{
    $file=fopen($archivo,'a+');
    $array=array();
    $var="";
    
    while(!feof($file))
    {
        $linea=fgets($file);
        $var=explode("@",$linea)[2] ?? '';
        
        if($toko->nombre==$var)
        {
          
           array_push($array,$linea);
          
        }  
    }
    fclose($file);
    return $array;
}


  
 
   
  
}
?>