<?php

if (!isset($_SESSION)) {
    session_start();
}

$auth = $_SESSION['login'] ?? null;


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bienes Raices</title>
    <link rel="stylesheet" href="/bienesraices_POO/build/css/app.css">
</head>

<body>

    <header class="header <?php echo $inicio  ? 'inicio' : '';   ?> ">
        <div class="contenedor contenido-header">
            <div class="barra">
                <a href="/bienesraices_POO/index.php">
                    <img src="/bienesraices_POO/build/img/logo.svg" alt="Logotipo de Bienes Raices">
                </a>

                <div class="mobile-menu">
                    <img src="/bienesraices_POO/build/img/barras.svg" alt="icono menu responsive">
                </div>

                <div class="derecha">
                    <img class="dark-mode-boton" src="/bienesraices_POO/build/img/dark-mode.svg">
                    <nav class="navegacion">
                        <a href="/bienesraices_POO/nosotros.php">Nosotros</a>
                        <a href="/bienesraices_POO/anuncios.php">Anuncios</a>
                        <a href="/bienesraices_POO/blog.php">Blog</a>
                        <a href="/bienesraices_POO/contacto.php">Contacto</a>
                        <a href="/bienesraices_POO/contacto.php">
                            <?php if ($auth) : ?>
                                <a href="/bienesraices_POO/cerrar_session.php">Cerrar session</a>
                            <?php else : ?>
                                <a href="/bienesraices_POO/login.php">Iniciar session</a>
                            <?php endif; ?>
                        </a>

                    </nav>
                </div>


            </div> <!--.barra-->
            <?php if ($inicio) { ?>
                <h1>Venta de Casas y Departamentos Exclusivos de Lujo</h1>
            <?php }  ?>

        </div>
    </header>