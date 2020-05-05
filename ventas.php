<?php
include_once './producto.php';
include_once './datos.php';
class Venta
{
   
    public static function ventas($id_producto,$cant,$usuario)
    {
        $lista= Stock :: mostrarlista();
        $producto="";
        $resta="";
        
        foreach($lista as $value)
        {
            if($value->id==$id_producto)
            {
               $producto=$value; //aca encontre el producto

               if($producto->stock >= $cant && $value->stock != 0)
               {
                   $file= fopen("productos.json",'w');
                   $rta=$producto->precio * $cant;
                   $resta=$producto->stock - $cant;
                   $value->stock=$resta;
                   $right=fwrite($file,json_encode($lista));
                   fclose($file);
                   break; 
               }else{ $rta = 0;}
            }           
        }     
        return $rta;
    }

    
    public function guardarventa($id,$cant,$usuario)
{

return Datos::guardaventa("ventas.txt", Venta :: toFile($id,$cant,$usuario));

}

public static function toFile($id,$cant,$usuario)
{
  return "Producto: $id ".'@'."Cantidad: $cant ".'@'.$usuario. '@'. PHP_EOL;
}









}
?>



