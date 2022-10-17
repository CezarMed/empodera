<?php

//clase de login para acceso y cierre de sesion
require 'class/class_login.php';
//instaciando la clase login
$Login = new login();
//cerrando y destruyendo variables de la session
$Login->cerrarSession();
//direccionando al index despues de salir
header("Location: index");
?>