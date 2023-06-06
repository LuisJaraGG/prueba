<?php
require '../../includes/app.php';

use App\Propiedad;
use App\Vendedor;

use Intervention\Image\ImageManagerStatic as Image;

estaAutenticado();

//Importar la conexion

$propiedad = new Propiedad();

// Consultar para obtener los vendedores
$vendedores = Vendedor::all();

// Errores
$errores = Propiedad::getErrores();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // **Crea nueva instancia**
    // POST es un array
    $propiedad = new Propiedad($_POST['propiedad']);

    //Generar un nombre unico
    $nombreImagen = md5(uniqid(rand(), true)) . ".jpg";

    // Setear la imagen
    // Realiza un resize a la imagen
    if ($_FILES['propiedad']['tmp_name']['imagen']) {
        $img = Image::make($_FILES['propiedad']['tmp_name']['imagen'])->fit(800, 600);
        $propiedad->setImagen($nombreImagen);
    }

    //Validar
    $errores = $propiedad->validar();

    //Revisar el arreglo de errores
    if (empty($errores)) {

        //Crear la caperta para subir imagenes
        if (!is_dir(CARPETA_IMAGENES)) {
            mkdir(CARPETA_IMAGENES);
        }

        //Guardar la imagen en el servidor
        $img->save(CARPETA_IMAGENES . $nombreImagen);

        //Guarda en la DB
        $propiedad->guardar();
    }
}

incluirTemplate('header');

?>

<main class="contenedor seccion">
    <h1>Crear</h1>
    <a href="/bienesraices_POO/admin" class="boton boton-verde">Volver</a>


    <?php foreach ($errores as $error) : ?>
        <p class="alerta error">
            <?php echo $error; ?>
        </p>
    <?php endforeach; ?>

    <form action="/bienesraices_POO/admin/propiedades/crear.php" class="formulario" method="POST" enctype="multipart/form-data">

        <?php include '../../includes/templates/formulario_propiedades.php' ?>

        <input type="submit" value="Crear propiedad" class="boton boton-verde">
    </form>

</main>

<?php
incluirTemplate('footer');


?>