<?php

require_once '../config/Server.php';

class Usuarios {
    private $conexion;

    public function __construct() {
        $this->conexion = Conexion::getConexion();
    }

    // Método para registrar un usuario
    public function registrarUsuario($nombre, $usuario, $password) {
        $sql = "INSERT INTO usuarios (nombre, usuario, password) VALUES (:nombre, :usuario, :password)";
        $stmt = $this->conexion->prepare($sql);
        $stmt->bindParam(':nombre', $nombre, PDO::PARAM_STR);
        $stmt->bindParam(':usuario', $usuario, PDO::PARAM_STR);
        $stmt->bindParam(':password', $password, PDO::PARAM_STR);
    
        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    }

    // Método para verificar credenciales en el login
    public function verificarUsuario($usuario, $contraseña) {
        $sql = "SELECT * FROM usuarios WHERE usuario = :usuario";
        $stmt = $this->conexion->prepare($sql);
        $stmt->bindParam(':usuario', $usuario, PDO::PARAM_STR);
        $stmt->execute();
    
        if ($stmt->rowCount() > 0) {
            $usuarioData = $stmt->fetch(PDO::FETCH_ASSOC);
    
            // Comparar usando password_verify para bcrypt
            if (password_verify($contraseña, $usuarioData['password'])) {
                return $usuarioData; // Usuario autenticado correctamente
            }
        }
    
        return false; // Usuario o contraseña incorrectos
    }
    
    
    

    // Método para verificar si un usuario existe
    public function usuarioExiste($usuario) {
        $sql = "SELECT COUNT(*) FROM usuarios WHERE usuario = :usuario";
        $stmt = $this->conexion->prepare($sql);
        $stmt->bindParam(':usuario', $usuario, PDO::PARAM_STR);
        $stmt->execute();

        $count = $stmt->fetchColumn();
        return $count > 0;
    }
}

