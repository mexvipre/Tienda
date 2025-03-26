<?php

require_once '../models/Usuarios.php';

$usuario = new Usuarios();

$nombre = 'Juan Perez';
$usuario_nombre = 'juan123';
$contraseña = '123456';

if ($usuario->registrarUsuario($nombre, $usuario_nombre, $contraseña)) {
    echo "Usuario registrado correctamente.";
} else {
    echo "Error al registrar el usuario.";
}

