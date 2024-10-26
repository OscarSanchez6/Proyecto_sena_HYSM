<?php
/*
include_once '../Model/conexionPDO.php';
session_start();
if(isset($_POST['cerrar_sesion']))
	{
		//include_once '../Controller/cerrar.php';
		session_unset();
		session_destroy();
	}

if(isset($_SESSION['idRol']))
	{
		switch ($_SESSION['idRol']) 
		{
			case 1:
				header ('Location: doctor.php');
				break;
			case 2:
				header('Location: administrador.php');
				break;	
			default:
				echo "Este rol no existe dentro de las opciones";
				break;
		}
	}

if (isset($_POST['numdocumento']) && isset($_POST['clave']) && isset($_POST['idRol']))
	{
		$numdocumento=$_POST['numdocumento'];
		$password=$_POST['clave'];
		

		$db=new Database();
		$query=$db->connectar()->prepare('SELECT * FROM crear_usuario WHERE numero_documento=:numdocumento AND contrasena=:clave ');
		$query->execute(['numdocumento'=>$numdocumento,'clave'=>$password]);
		$arreglofila=$query->fetch(PDO::FETCH_NUM);

		if ($arreglofila == true ) 
			{
				$rol=$arreglofila[4];
				$_SESSION['rol']=$rol;
				switch ($rol) 
					{
						case 1:
							header ('Location: doctor.php');
							break;
						case 2:
							header('Location: administrador.php');
							break;	
						default:
							echo "Este rol no existe dentro de las opciones";
							break;
					}
				$usuario=$arreglofila[1];
				$_SESSION['nombre']=$usuario;
				
				$fotosesion=$arreglofila[5];
				$_SESSION['foto']=$fotosesion;
			}
			else
			{
				//echo '<p style="text-align:center; font-size:20;" color:grey;>Número de documento o contraseña incorrecto</p>';
				//echo '<script>alert("Rol , Número de documento o contraseña incorrectos.")</script>';}
				echo("Rol , Número de documento o contraseña incorrectos.");
			}
	}

*/

	
	

include_once '../Model/conexionPDO.php';
session_start();

if(isset($_POST['cerrar_sesion'])) {
    session_unset();
    session_destroy();
	header('Location: inicio_Sesion_Usuario.php');
exit;
	exit;
}

if (isset($_POST['numdocumento']) && isset($_POST['password']) && isset($_POST['idRol']) && isset($_POST['tipoDocumento'])) {
    $numdocumento = $_POST['numdocumento'];
    $password = $_POST['password'];
    $rol = $_POST['idRol'];
    $documento = $_POST['tipoDocumento'];


	// Validación básica
    if (empty($numdocumento) || empty($password) || empty($rol) || empty($documento)) {
        echo "Todos los campos son obligatorios.";
        exit;
    }

    $db = new Database();
    //$query = $db->connectar()->prepare('SELECT * FROM crear_usuario WHERE numero_documento = :numdocumento AND contrasena = :clave AND tipo_documento_id = :tipoDocumento AND rol = :idRol');
	/*Hago el cambio en esta consulta para obtener el ID del usuario que inicio sesion en cualquier rol*/
	$query = $db->connectar()->prepare('SELECT id_usuario, nombre, rol, numero_documento FROM crear_usuario WHERE numero_documento = :numdocumento AND contrasena = :password AND tipo_documento_id = :tipoDocumento AND rol = :idRol');
    $query->execute([
        'numdocumento' => $numdocumento,
        'password' => $password,
        'idRol' => $rol,
        'tipoDocumento' => $documento
    ]);
    $usuario = $query->fetch(PDO::FETCH_ASSOC);

    if ($usuario) {
		$_SESSION['id_usuario'] = $usuario['id_usuario'];//ESTA VARIABLE ES PARA OBTENER EL ID DEL USUARIO QUE ACTUALMENTE TENGA LA SESION INICIADA
        $_SESSION['rol'] = $usuario['rol'];
		$_SESSION['nombre'] = $usuario['nombre'];
		$_SESSION['numero_documento'] = $usuario['numero_documento'];
		
        switch ($_SESSION['rol']) {
			case 1:
                header('Location: doctor.php');
                exit;
            case 2:
                header('Location: administrador.php');
                exit;
			case 3:
				header('Location: recepcion.php');
				exit;
			case 4:
				header('Location: prescriptormedico.php');
				exit;
			case 5:
				header('Location: usuario.php');
				exit;
            default:
                echo "Este rol no existe dentro de las opciones";
                break;
        }
    } else {
        echo '<p class="mensaje_ingreso">Credenciales Incorrectas</p>';
    }
}
?>
