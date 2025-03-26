<?php
require_once '../models/Usuarios.php';

$usuarios = new Usuarios();

$usuario = "juan123";
$contraseña = "123456";

// ✅ Verificar usuario
$resultado = $usuarios->verificarUsuario($usuario, $contraseña);

if ($resultado) {
    echo "✅ Login exitoso. Bienvenido, " . $resultado['nombre'];
} else {
    echo "❌ Usuario o contraseña incorrectos.";
}
