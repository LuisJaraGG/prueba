<?php

session_start();
//Reescritura de la session a un arreglo basio
$_SESSION = [];

header('Location: /bienesraices_fin');
