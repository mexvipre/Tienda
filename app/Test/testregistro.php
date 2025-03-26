<?php
require_once '../models/Usuarios.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = $_POST['nombre'];
    $usuario = $_POST['usuario'];
    $password = $_POST['password'];

    if (!empty($nombre) && !empty($usuario) && !empty($password)) {
        $usuarios = new Usuarios();

        if ($usuarios->usuarioExiste($usuario)) {
            echo json_encode(["status" => "error", "message" => "El usuario ya existe."]);
        } else {
            if ($usuarios->registrarUsuario($nombre, $usuario, $password)) {
                echo json_encode(["status" => "success", "message" => "Usuario registrado correctamente."]);
            } else {
                echo json_encode(["status" => "error", "message" => "Error al registrar el usuario."]);
            }
        }
    } else {
        echo json_encode(["status" => "error", "message" => "Todos los campos son obligatorios."]);
    }
} else {
    echo json_encode(["status" => "error", "message" => "Método no permitido."]);
}
