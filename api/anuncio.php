<?php

require __DIR__ . '/includes/app.php';

$id = $_GET['id'];
$id = filter_var($id, FILTER_VALIDATE_INT);


if (!$id) {
    header('Location:/bienesraices_POO/index.php');
}

// Importar base de datos
$db = conectarDB();

// query a la db
$query = "SELECT * FROM propiedades WHERE id = {$id}";

// obtener resultados
$resultado =  mysqli_query($db, $query);

if ($resultado->num_rows === 0) {
    header('Location:/bienesraices_POO/index.php');
}

$resultado = mysqli_fetch_assoc($resultado);

incluirTemplate('header');

?>

<main class="contenedor seccion contenido-centrado">
    <h1><?php echo $resultado['titulo']; ?></h1>

    <img loading="lazy" src="/bienesraices_POO/imagenes/<?php echo $resultado['imagen']; ?>" alt="imagen de la propiedad">

    <div class="resumen-propiedad">
        <p class="precio">$<?php echo $resultado['precio']; ?></p>
        <ul class="iconos-caracteristicas">
            <li>
                <img class="icono" loading="lazy" src="build/img/icono_wc.svg" alt="icono wc">
                <p><?php echo $resultado['wc']; ?></p>
            </li>
            <li>
                <img class="icono" loading="lazy" src="build/img/icono_estacionamiento.svg" alt="icono estacionamiento">
                <p><?php echo $resultado['estacionamiento']; ?></p>
            </li>
            <li>
                <img class="icono" loading="lazy" src="build/img/icono_dormitorio.svg" alt="icono habitaciones">
                <p><?php echo $resultado['habitaciones']; ?></p>
            </li>
        </ul>

        <p><?php echo $resultado['descripcion']; ?></p>
    </div>
</main>

<!-- Cerrar conexion -->

<?php

mysqli_close($db);

incluirTemplate('footer');


?>