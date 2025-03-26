<?php

require_once "../config/Server.php";

// las constantes deben definirse ¡fuera! de la clase
const METHOD = "AES-256-CBC";
const SECRET_KEY = "S3N@t1."; // ofuscar la palabra SENATI
const SECRET_IV = "037970";

class Conexion {

  // Método protegido que no se debe modificar
  protected static function getConexion(){
    try{
      $pdo = new PDO(SGBD, USER, PASS);
      $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      return $pdo;
    }
    catch(Exception $e){
      die($e->getMessage());
    }
  }

  // Método público que se puede acceder desde fuera de la clase
  public static function obtenerConexionPublica(){
    return self::getConexion();  // Llamamos al método protegido desde aquí
  }

  public static function ejecutarConsulaSimple($consulta){
    $sql = self::getConexion()->prepare($consulta);
    $sql->execute();
    return $sql;
  }

  public static function encryption($string){
    $output = FALSE;
    $key = hash('sha256', SECRET_KEY);
    $iv = substr(hash('sha256', SECRET_IV), 0, 16);
    $output = openssl_encrypt($string, METHOD, $key, 0, $iv);
    $output = base64_encode($output);
    return $output;
  }

  public static function decryption($string){
    $key = hash('sha256', SECRET_KEY);
    $iv = substr(hash('sha256', SECRET_IV), 0, 16);
    $output = openssl_decrypt(base64_decode($string), METHOD, $key, 0, $iv);
    return $output;
  }

  protected static function generarCodigoAleatorio($letra, $longitud, $numero){
    for ($i = 1; $i <= $longitud; $i++){
      $aleatorio = rand(0, 9);
      $letra .= $aleatorio;
    }
    return $letra . "-" . $numero;
  }

  public static function limpiarCadena($cadena){
    $cadena = trim($cadena);
    $cadena = stripslashes($cadena);
    $cadena = str_ireplace("<script>", "", $cadena);
    $cadena = str_ireplace("</script>", "", $cadena);
    $cadena = str_ireplace("<script src", "", $cadena);
    $cadena = str_ireplace("<script type", "", $cadena);
    $cadena = str_ireplace("SELECT * FROM", "", $cadena);
    $cadena = str_ireplace("DELETE FROM", "", $cadena);
    $cadena = str_ireplace("INSERT INTO", "", $cadena);
    $cadena = str_ireplace("DROP TABLE", "", $cadena);
    $cadena = str_ireplace("DROP DATABASE", "", $cadena);
    $cadena = str_ireplace("TRUNCATE TABLE", "", $cadena);
    $cadena = str_ireplace("SHOW TABLES", "", $cadena);
    $cadena = str_ireplace("SHOW DATABASES", "", $cadena);
    $cadena = str_ireplace("<?php", "", $cadena);
    $cadena = str_ireplace("?>", "", $cadena);
    $cadena = str_ireplace("--", "", $cadena);
    $cadena = str_ireplace(">", "", $cadena);
    $cadena = str_ireplace("<", "", $cadena);
    $cadena = str_ireplace("[", "", $cadena);
    $cadena = str_ireplace("]", "", $cadena);
    $cadena = str_ireplace("^", "", $cadena);
    $cadena = str_ireplace("==", "", $cadena);
    $cadena = str_ireplace(";", "", $cadena);
    $cadena = str_ireplace("::", "", $cadena);
    $cadena = stripslashes($cadena);
    $cadena = trim($cadena);
    return $cadena;
  }

}
