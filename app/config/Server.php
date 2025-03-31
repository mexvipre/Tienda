<?php

define('SGBD', 'mysql:host=localhost;dbname=tiendaropa');
define('USER', 'root'); 
define('PASS', ''); 

class Conexion {
    // Método estático para obtener la conexión a la base de datos
    public static function getConexion() {
        try {   
      
            $pdo = new PDO(SGBD, USER, PASS);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return $pdo;
        } catch (PDOException $e) {
  
            echo "Error de conexión: " . $e->getMessage();
            exit;
        }
    }
}
