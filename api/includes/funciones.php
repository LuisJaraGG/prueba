<?php

define('templatesURL',  __DIR__ . '/templates');
define('funcionesURL', __DIR__ . '/funciones.php');
define('CARPETA_IMAGENES', __DIR__ . '/../imagenes/');

function incluirTemplate(string $nombre, bool $inicio = false)
{
    include  templatesURL . "/{$nombre}.php";
}


function estaAutenticado()
{
    session_start();
    if (!$_SESSION['login']) {
        header('Location: /bienesraices_POO/');
    }
}

function debuguear($variable)
{
    echo "<pre>";
    var_dump($variable);
    echo "</pre>";
    exit;
}


// escapa /sanitizar del HTML
function sanitizarHTML($html): string
{
    $s = htmlspecialchars($html);
    return $s;
}

// validar tipo de contenido
function validarTipoContenido($tipo)
{
    $tipos = ['propiedad', 'vendedor'];
    // in_array() busca un valor en un array
    return in_array($tipo, $tipos);
}
