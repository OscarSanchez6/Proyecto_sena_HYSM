<?php
$nombreservidor="localhost";
$usuario="root";
$password="";
$basedatos="hysmanagement";
$conexion=mysqli_connect($nombreservidor,$usuario,$password,$basedatos);
    if($conexion)
        {
            echo"<p style='color:green;font-size:30px;text-align:center;'> </p>";
        }else{
            echo"<p style='color:red;font-size:30px;text-align:center;'> Conexion Fallida¡</p>";
        }
?>