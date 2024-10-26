<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Administrador</title>
	<link rel="stylesheet" href="../Css/admin_buscador.css">
	<header>
    <a href="../View/Administrador.php">
        <div class="logo">
            <img src="../Img/logo.png" alt="Logo Health and Services Management">
        </div>
        </a>
        <div class="menu-toggle">
            <span></span>
            <span></span>
            <span></span>
        </div>
        <nav>
            <ul>
                <li><a href="../View/Administrador.php">Inicio</a></li>
                <li><a href="../Controller/buscador.php">Buscar usuarios</a></li>
                <li><a href="../Controller/crearUsuarios.php">Crear Usuarios</a></li>
                <li><a href="../Controller/cerrar.php">Cerrar sesión</a></li>
            </ul>
        </nav>
    </header>

    <script>
        document.querySelector('.menu-toggle').addEventListener('click', function() {
            document.querySelector('nav').classList.toggle('active');
        });
    </script>
    </header>
</head>
