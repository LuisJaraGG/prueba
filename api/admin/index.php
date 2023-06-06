<?php
require '../includes/app.php';

use App\Propiedad;
use App\Vendedor;


// Autenticacion
estaAutenticado();

//Implementar metodo para obtener todas las propiedades
$propiedades = Propiedad::all();
$vendedores = Vendedor::all();

//Mostrar mensaje condicional
$resultado = $_GET['resultado'] ?? null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $id = $_POST['id'];
    $id = filter_var($id, FILTER_VALIDATE_INT);

    if ($id) {

        $tipo = $_POST['tipo'];

        if (validarTipoContenido($tipo)) {

            if ($tipo === 'vendedor') {
                $vendedor = Vendedor::find($id);
                $vendedor->eliminar();
            } else if ($tipo === 'propiedad') {
                $propiedad->eliminar();
                $propiedad = Propiedad::find($id);
            }
        }
    }
}


//Incluye un template
incluirTemplate('header');

?>

<main class="contenedor seccion">
    <h1>Administrador de bienes raices</h1>
    <?php if ($resultado == 1) : ?>
        <p class="alerta exito">
            Anuncio Creado Correctamente
        </p>
    <?php elseif ($resultado == 2) : ?>
        <p class="alerta exito">
            Anuncio Actualizado Correctamente
        </p>
    <?php elseif ($resultado == 3) : ?>
        <p class="alerta exito">
            Anuncio Eliminado Correctamente
        </p>
    <?php endif; ?>
    <a href="/bienesraices_POO/admin/propiedades/crear.php" class="boton boton-verde">Nueva Propiedad</a>
    <h2>Propiedades</h2>
    <table class="propiedades">
        <thead>
            <tr>
                <th>ID</th>
                <th>Titulo</th>
                <th>Imagen</th>
                <th>Precio</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <!-- Mostrar resultados -->
        <tbody>
            <?php foreach ($propiedades as $row) :  ?>
                <tr>
                    <td><?php echo $row->id; ?></td>
                    <td><?php echo $row->titulo; ?></td>
                    <td><img class="imagen-tabla" src="/bienesraices_POO/imagenes/<?php echo $row->imagen; ?>" alt="<?php echo $row->titulo ?>"></td>
                    <td><?php echo "$" . $row->precio; ?></td>
                    <td>
                        <a class="boton-amarillo-block" href="/bienesraices_POO/admin/propiedades/actualizar.php?id=<?php echo $row->id ?>">Editar</a>
                        <form method="POST" class="w-100">
                            <input type="submit" class="boton-rojo-block" value="Eliminar">
                            <input type="hidden" class="" name="tipo" value="propiedad">
                            <input type="hidden" class="" name="id" value="<?php echo $row->id; ?>">
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <h2>Vendedores</h2>
    <table class="propiedades">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Apellido</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <!-- Mostrar resultados -->
        <tbody>
            <?php foreach ($vendedores as $row) :  ?>
                <tr>
                    <td><?php echo $row->id; ?></td>
                    <td><?php echo $row->nombre; ?></td>
                    <td><?php echo $row->apellido; ?></td>
                    <td>
                        <a class="boton-amarillo-block" href="/bienesraices_POO/admin/vendedores/actualizar.php?id=<?php echo $row->id ?>">Editar</a>
                        <form method="POST" class="w-100">
                            <input type="submit" class="boton-rojo-block" value="Eliminar">
                            <input type="hidden" class="" name="tipo" value="vendedor">
                            <input type="hidden" class="" name="id" value="<?php echo $row->id; ?>">
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</main>

<!-- Cerrar la conexion -->

<?php


incluirTemplate('footer');

?>