<?php
class File
{

    public static function guardarfoto($foto)
    {
        $tmp_name=$foto['tmp_name'];
        $name=$foto['name'];
        $folder="imagenes/";
        $nombre=$folder.$name;

        move_uploaded_file($tmp_name,$folder.$name);
        return $nombre;
    }

}
?>