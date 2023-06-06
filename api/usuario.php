<?php
// Importar conexion
require './includes/app.php';
$db = conectarDB();

// Crear un email y password
$email = 'correo@example.com';
$password = 'password';

$passwordHast = password_hash($password, PASSWORD_BCRYPT);

// query para la db
// $query = "SELECT * FROM usuarios WHERE email = '{$email}'";
$query = "INSERT INTO usuarios (email, password) VALUES ('{$email}', '{$passwordHast}')";

// Agregarlo a la base de datos
mysqli_query($db, $query);
