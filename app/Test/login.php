<?php
header('Content-Type: application/json');

require '../models/Usuarios.php';

$data = json_decode(file_get_contents('php://input'), true);

if (isset($data['usuario'], $data['password'])) {
    $usuario = $data['usuario'];
    $contraseña = $data['password'];

    $usuarioModel = new Usuarios();

    // Verificamos si las credenciales son correctas
    $resultado = $usuarioModel->verificarUsuario($usuario, $contraseña);
    
    if ($resultado) {
        echo json_encode([
            "success" => true,
            "message" => "Inicio de sesión exitoso",
            "data" => [
                "id" => $resultado['id'],
                "nombre" => $resultado['nombre'],
                "usuario" => $resultado['usuario']
            ]
        ]);
    } else {
        echo json_encode([
            "success" => false,
            "message" => "Usuario o contraseña incorrectos"
        ]);
    }
} else {
    echo json_encode([
        "success" => false,
        "message" => "Datos incompletos"
    ]);
}
