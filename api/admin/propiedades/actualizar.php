<?php

use App\Propiedad;
use App\Vendedor;

use Intervention\Image\ImageManagerStatic as Image;

require '../../includes/app.php';


// Autenticacion
estaAutenticado();

$id = $_GET['id'];

// Validar id 
$id = filter_var($id, FILTER_VALIDATE_INT);

if (!$id) {
    header('Location:/bienesraices_POO/admin');
}

// Obtenemos conexion
$db = conectarDB();

// Obtener datos de la propiedad
$propiedad = Propiedad::find($id);
$vendedores = Vendedor::all();

$errores = Propiedad::getErrores();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // Asignar los atributos
    $args = [];

    $args = $_POST['propiedad'];

    $propiedad->sincronizar($args);

    //Validacion
    $errores = $propiedad->validar();

    //Generar un nombre unico
    $nombreImagen = md5(uniqid(rand(), true)) . ".jpg";

    // Setear la imagen
    // Realiza un resize a la imagen

    if ($_FILES['propiedad']['tmp_name']['imagen']) {
        $img = Image::make($_FILES['propiedad']['tmp_name']['imagen'])->fit(800, 600);
        $propiedad->setImagen($nombreImagen);
    }

    //Revisar el arreglo de errores
    if (empty($errores)) {

        //almacenar imagen
        if ($_FILES['propiedad']['tmp_name']['imagen']) {
            $img->save(CARPETA_IMAGENES . $nombreImagen);
        }

        $propiedad->guardar();
    }
}

incluirTemplate('header');

?>

<main class="contenedor seccion">
    <h1>Actualizar Propiedad</h1>
    <a href="/bienesraices_POO/admin" class="boton boton-verde">Volver</a>


    <?php foreach ($errores as $error) : ?>
        <p class="alerta error">
            <?php echo $error; ?>
        </p>
    <?php endforeach; ?>

    <form class="formulario" method="POST" enctype="multipart/form-data">

        <?php require '../../includes/templates/formulario_propiedades.php' ?>

        <input type="submit" value="Actualizar propiedad" class="boton boton-verde">
    </form>


</main>

<?php
incluirTemplate('footer');


?>