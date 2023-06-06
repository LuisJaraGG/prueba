<?php
require './includes/app.php';
$db = conectarDB();

$errores = array();

// Autenticar usuario
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $email = mysqli_real_escape_string($db, filter_var($_POST['email'], FILTER_VALIDATE_EMAIL));
    $password = mysqli_real_escape_string($db, $_POST['password']);

    if (!$email) {
        $errores[] = "El email es obligatorio o no es valido";
    }

    if (!$password) {
        $errores[] = "El password es obligatorio";
    }


    if (empty($errores)) {
        // Revisar si el usuario existe
        $query = "SELECT * FROM Usuarios WHERE email = '{$_POST['email']}'";
        $resultado = mysqli_query($db, $query);
        
        
        if ($resultado->num_rows) {
            //Revisar si el password es correcto
            $usuario = mysqli_fetch_assoc($resultado);
            // Verificar password
            $auth = password_verify($_POST['password'], $usuario['password']);
            
            if ($_POST['password']== $usuario['password']) {
                // El usuario esta autenticado
                session_start();

                //Llenar el arreglo de la session
                $_SESSION['usuario'] = $usuario['email'];
                $_SESSION['login'] = true;
                header('Location: /bienesraices_POO/index.php');
            } else {
                $errores[] = "El password es incorrecto";
            }
        } else {
            $errores[] = "El usuario no existe";
        }
    }
}


// Incluye el header
incluirTemplate('header');

?>

<main class="contenedor seccion contenido-centrado">
    <h1>Iniciar session</h1>

    <?php foreach ($errores as $error) : ?>
        <div class="alerta error">
            <p>
                <?php echo $error; ?>
            </p>
        </div>
    <?php endforeach ?>

    <form action="" method="POST" class="formulario">
        <fieldset>
            <legend>Email y Password</legend>

            <label for="email">Email</label>
            <input value="correo@example.com" name="email" type="email" placeholder="Tu Email" id="email">

            <label for="password">Password</label>
            <input value="password" name="password" type="password" placeholder="Tu Password" id="password">

        </fieldset>

        <input type="submit" value="Iniciar sesion" class="boton boton-verde">
    </form>
</main>

<?php
incluirTemplate('footer');


?>