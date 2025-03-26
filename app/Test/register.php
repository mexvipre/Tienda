<?php
header('Content-Type: application/json');

require '../models/Usuarios.php';

$data = json_decode(file_get_contents('php://input'), true);

if (isset($data['nombre'], $data['usuario'], $data['password'])) {
    $nombre = $data['nombre'];
    $usuario = $data['usuario'];
    $password = password_hash($data['password'], PASSWORD_DEFAULT);

    $usuarioModel = new Usuarios();
    if ($usuarioModel->registrarUsuario($nombre, $usuario, $password)) {
        echo json_encode(["status" => "success", "message" => "Usuario registrado correctamente."]);
    } else {
        echo json_encode(["status" => "error", "message" => "Error al registrar usuario."]);
    }
} else {
    echo json_encode(["status" => "error", "message" => "Datos incompletos."]);
}
