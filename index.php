<?php
require_once './usuario.php';
require_once './producto.php';
require_once './file.php';
require_once './ventas.php';
require_once './datos.php';
$path= $_SERVER['PATH_INFO'] ?? "";
$metodo= $_SERVER['REQUEST_METHOD'] ?? "";


switch($path)
{
    case "/usuario":
        if($metodo=='POST'){
            
           $nombre =$_POST['nombre'] ?? "";
           $dni=$_POST['dni'] ?? "";
           $obrasocial= $_POST['obra_social'] ?? "";
           $clave= $_POST['clave'] ?? "";
           $tipo=$_POST['tipo'] ?? "";

           if($nombre!="" && $dni!="" && $obrasocial!="" && $clave!="" && $tipo!=""){
            if($tipo=="user" || $tipo=="admin")
            {  
                
                $usuario= new Usuario($nombre,$dni,$obrasocial,$clave,$tipo);
                $rta=$usuario->save();

                echo $rta;
            }
            else{
                echo"El tipo debe ser ADMIN o USER";
            }
          
            }else{
                echo "faltan datos";
            }
        }
        else{
            echo"Debe ingresar por POST";
        }

    break;

    case "/login":
        if($metodo=="POST")
        {
            $nombre=$_POST['nombre'] ?? "";
            $clave=$_POST['clave'] ?? "";
          
            if($nombre!="" && $clave!="")
            {
    
              if(Usuario :: validar($nombre,$clave))
              {
                echo " <br>Se encontro";
              }else{
                    echo "Nombre o Clave erroneos";
              }
    
            }else{
                echo "Faltan datos";
            }
    
    
        }else{
            echo"Debe usar metodo POST";
        }
    
    break;

    case"/stock":
        if($metodo=="POST")
        {
            $header = getallheaders();
            $mitoken=$header["token"] ?? " ";
            $toko=Token::decodeToken($mitoken);
            if(Usuario::validaradmin($toko))
            {
                $id=time();
                $producto =$_POST['producto'] ?? "";
                $marca=$_POST['marca'] ?? "";
                $precio= $_POST['precio'] ?? "";
                $stock= $_POST['stock'] ?? "";
                $imag=$_FILES['foto']['tmp_name'] ?? "";
                if($imag!="")
                {
                    $imagen=File :: guardarfoto($_FILES['foto']);
                }
                else
                {
                    echo "Debe ingresar una imagen";
                }
                

                if($producto!="" && $marca!="" && $precio!="" && $stock!="" && $imagen!=""){
                    if($producto=="medicamento" || $producto=="vacuna")
                    {  
                        
                        $producto= new Stock($id,$producto,$marca,$precio,$stock,$imagen);
                        $rta=$producto->saveproducto($producto);
        
                        echo $rta;
                    }
                    else{
                        echo"El Producto debe ser medicamento o vacuna";
                    }
                  
                    }else{
                        echo "faltan datos";
                    }
                

            }else
            {
                echo "debe de ser admin para entrar";
            }
    
    
        }else{
            echo"Debe usar metodo POST";
        }
    
    break;

    case "/detalle":
        if($metodo=="GET")
        {
            
            $header = getallheaders();
            $mitoken=$header["token"] ?? " ";
            if(Token::decodeToken($mitoken))
            {
                $rta =Stock::mostrarlista();
                echo json_encode($rta);
            }else{
                echo "Token erroneo";
            }

        }else{
            echo "Debe ingresar por GET";

        }

    break;

    case "/ventas":
        if($metodo=="POST")
        {
            $header = getallheaders();
            $mitoken=$header["token"] ?? " ";
            if(Token::decodeToken($mitoken))
            {
                
                $toko=Token::decodeToken($mitoken);
                if(Usuario::validarusuario($toko))
                {
                    $id =$_POST['id_producto'] ?? "";
                    $cant=$_POST['cantidad'] ?? "";
                    $usuario= $_POST['usuario'] ?? "";
                   // var_dump($_POST)
                    
                   if($id != "" && $cant !="" && $usuario != "" )
                   {
                    $rta = Venta:: ventas($id,$cant,$usuario);
                    if($rta != 0)
                    {   
                        echo "La venta se pudo realizar el costo es: $rta";
                        Venta :: guardarventa($id,$cant,$usuario);
                    }else{
                        echo "nose se pudo realizar la ventas";}
                   }else{
                       echo "faltan datos";
                   }
                   
                }else{
                    echo "Solo pueden ingresar Usuarios";
                }
            }else{
                echo "Token incorrecto";
            }
        }else{
            echo "Debe ingresar por POST";
        }

    break;

    case "/venta":
        if($metodo == "GET")
        {
            $header = getallheaders();
            $mitoken=$header["token"] ?? " ";
            if(Token::decodeToken($mitoken))
            {
                $toko=Token::decodeToken($mitoken);
                if(Usuario::validaradmin($toko))
                {
                    $lista = Datos::leerTodo("ventas.txt");
                    echo json_encode($lista);
                   
                }
                if(Usuario::validarusuario($toko))
                {
                  $lista = Datos :: leeruser("ventas.txt",$toko);
                  echo json_encode($lista);
                   
                }

            }else{
                echo "Token incorrecto";
            }

        }else{
            echo "debe ingresar por GET";
        }


}

?>