<?php

require_once '../config/Server.php';

class Producto {

    private $pdo;

    // Constructor para inicializar la conexión PDO
    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    // Método para agregar un producto a la base de datos
    public function add($params) {
        try {
            $sql = "INSERT INTO productos (tipo, genero, talla, precio) VALUES (?, ?, ?, ?)";
            $consulta = $this->pdo->prepare($sql);
            $consulta->execute([$params['tipo'], $params['genero'], $params['talla'], $params['precio']]);
            return true;
        } catch (Exception $e) {
            echo "Error al insertar el producto: " . $e->getMessage();
            return false;
        }
    }

    // Método para actualizar un producto en la base de datos (PUT)
    public function update($id, $params) {
        try {
            $sql = "UPDATE productos SET tipo = ?, genero = ?, talla = ?, precio = ? WHERE id = ?";
            $consulta = $this->pdo->prepare($sql);
            $consulta->execute([$params['tipo'], $params['genero'], $params['talla'], $params['precio'], $id]);
            
            if ($consulta->rowCount() > 0) {
                return ['code' => 1, 'msg' => 'Producto actualizado correctamente'];
            } else {
                return ['code' => 0, 'msg' => 'No se encontró el producto o no se realizaron cambios'];
            }
        } catch (Exception $e) {
            return ['code' => 0, 'msg' => $e->getMessage()];
        }
    }

    // Método para eliminar un producto de la base de datos (DELETE)
    public function delete($id) {
        try {
            $sql = "DELETE FROM productos WHERE id = ?";
            $consulta = $this->pdo->prepare($sql);
            $consulta->execute([$id]);

            if ($consulta->rowCount() > 0) {
                return ['code' => 1, 'msg' => 'Producto eliminado correctamente'];
            } else {
                return ['code' => 0, 'msg' => 'No se encontró el producto para eliminar'];
            }
        } catch (Exception $e) {
            return ['code' => 0, 'msg' => $e->getMessage()];
        }
    }

    // Método para obtener todos los productos
    public function getAll() {
        try {
            $sql = "SELECT * FROM productos";
            $consulta = $this->pdo->prepare($sql);
            $consulta->execute();
            return $consulta->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            return ['code' => 0, 'msg' => $e->getMessage()];
        }
    }
}
