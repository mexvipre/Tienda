<?php
require_once '../models/Usuarios.php';

$mensaje = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $nombre = $_POST['nombre'];
    $usuario = $_POST['usuario'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    if ($password !== $confirm_password) {
        $mensaje = "<p style='color: red;'>Las contraseñas no coinciden.</p>";
    } else {
        $usuarioObj = new Usuarios();

        if ($usuarioObj->registrarUsuario($nombre, $usuario, $password)) {
            $mensaje = "<p style='color: green;'>Usuario registrado correctamente.</p>";
        } else {
            $mensaje = "<p style='color: red;'>Error al registrar el usuario.</p>";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro de Usuario</title>
    <script>
        function validarFormulario(event) {
            const password = document.getElementById('password').value;
            const confirmPassword = document.getElementById('confirm_password').value;

            if (password !== confirmPassword) {
                alert('Las contraseñas no coinciden.');
                event.preventDefault(); // Evita que se envíe el formulario
            }
        }
    </script>
</head>
<body>
    <h2>Registro de Usuario</h2>

    <?php 
        if (!empty($mensaje)) {
            echo $mensaje;
        }
    ?>

    <form method="POST" action="" onsubmit="validarFormulario(event)">
        <label for="nombre">Nombre:</label>
        <input type="text" id="nombre" name="nombre" required><br><br>

        <label for="usuario">Usuario:</label>
        <input type="text" id="usuario" name="usuario" required><br><br>

        <label for="password">Contraseña:</label>
        <input type="password" id="password" name="password" required><br><br>

        <label for="confirm_password">Repetir Contraseña:</label>
        <input type="password" id="confirm_password" name="confirm_password" required><br><br>

        <button type="submit">Registrar</button>
    </form>
</body>
</html>
