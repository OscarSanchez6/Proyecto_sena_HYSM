<?php
class Database
{
  private $servidorlocal;
  private $basededatos;
  private $usuario;
  private $password;
  private $caracteres;
    function connectar()
      {
      $servidorlocal = 'localhost';
      $basededatos   = 'hysmanagement';
      $usuario       = 'root';
      $password      = '';
      $caracteres    = 'utf8';
        try
          {
            $conexion = "mysql:host=".$servidorlocal.";dbname=".$basededatos.";charset=".$caracteres;
            $opciones = [
                          PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                          PDO::ATTR_EMULATE_PREPARES  => false
                        ];
            $pdo = new PDO($conexion, $usuario, $password, $opciones);
            return $pdo;
          }
        catch(PDOException $error)
          {
            echo 'Error en la conexion:  '.$error->getMessage();
          }
      }
}
//conexion::connect();

?>
