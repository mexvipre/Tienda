<?php

require_once "../config/Server.php";
require_once "../models/Producto.php";

// Instanciar Producto
$conexion = Conexion::getConexion();
$producto = new Producto($conexion);

$metodo = $_SERVER['REQUEST_METHOD'];

if ($metodo == 'GET') {
    // Obtener todos los productos
    $response = $producto->getAll();
    echo json_encode($response);
    
} elseif ($metodo == 'POST') {
    // Agregar un nuevo producto
    $data = json_decode(file_get_contents('php://input'), true);
    
    if (isset($data['tipo'], $data['genero'], $data['talla'], $data['precio'])) {
        $registro = [
            "tipo" => $data["tipo"],
            "genero" => $data["genero"],
            "talla" => $data["talla"],
            "precio" => $data["precio"]
        ];
        $status = $producto->add($registro);
        echo json_encode($status ? ["status" => "success", "msg" => "Producto agregado correctamente"] : ["status" => "error", "msg" => "No se pudo agregar el producto"]);
    } else {
        echo json_encode(["status" => "error", "msg" => "Faltan datos en la solicitud"]);
    }

} else {
    echo json_encode(["status" => "error", "msg" => "Método no permitido"]);
}
