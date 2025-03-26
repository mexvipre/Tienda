<?php

require_once '../config/Server.php';

class Usuarios {
    private $conexion;

    public function __construct() {
        $this->conexion = Conexion::getConexion();
    }

    // Método para encriptar la contraseña usando SHA-256
    private function encriptarContraseña($contraseña) {
        return hash('sha256', $contraseña);
    }

    // Método para registrar un usuario
    public function registrarUsuario($nombre, $usuario, $contraseña) {
        $contraseñaEncriptada = $this->encriptarContraseña($contraseña);

        $sql = "INSERT INTO usuarios (nombre, usuario, password) VALUES (:nombre, :usuario, :password)";

        $stmt = $this->conexion->prepare($sql);
        $stmt->bindParam(':nombre', $nombre, PDO::PARAM_STR);
        $stmt->bindParam(':usuario', $usuario, PDO::PARAM_STR);
        $stmt->bindParam(':password', $contraseñaEncriptada, PDO::PARAM_STR);

        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    }

    // Método para verificar credenciales en el login
    public function verificarUsuario($usuario, $contraseña) {
        $contraseñaEncriptada = $this->encriptarContraseña($contraseña);

        $sql = "SELECT * FROM usuarios WHERE usuario = :usuario AND password = :password";
        $stmt = $this->conexion->prepare($sql);
        $stmt->bindParam(':usuario', $usuario, PDO::PARAM_STR);
        $stmt->bindParam(':password', $contraseñaEncriptada, PDO::PARAM_STR);
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } else {
            return false;
        }
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
