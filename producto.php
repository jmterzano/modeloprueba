<?php
include_once './datos.php';
class Stock
{
    
   public $id;
   public $producto;
   public $marca;
   public $precio;
   public $stock;
   public $imagen;

   public function __construct($id,$producto,$marca,$precio,$stock,$imagen)
   {
       $this->id=$id;
       $this->producto=$producto;
       $this->marca=$marca;
       $this->precio=$precio;
       $this->stock=$stock;
       $this->imagen=$imagen;
   }

   public static function saveproducto($producto)
   {

    return Datos::guardar("productos.json", $producto);

   }

   public static function mostrarlista()
   {

    $lista= Datos::leerjson("productos.json");
    return $lista;
       
   }

   





}
?>