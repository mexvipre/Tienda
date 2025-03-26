<?php
require_once '../models/Usuarios.php';

$usuarios = new Usuarios();

$usuario = $_POST['usuario'];

if ($usuarios->usuarioExiste($usuario)) {
    echo json_encode(["status" => "error", "message" => "El usuario ya existe."]);
} else {
    echo json_encode(["status" => "success", "message" => "El usuario está disponible."]);
}
