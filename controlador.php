<?php
// Establecer la zona horaria a Ecuador
date_default_timezone_set('America/Guayaquil');

// Verificar si el formulario ha sido enviado
if (isset($_POST["iniciobutt"])) {
    // Verificar si los campos están vacíos
    if (empty($_POST["Fullname"]) || empty($_POST["Clave"])) {
        echo '<div>Por favor, completa ambos campos</div>';
    } else {
        // Incluir el archivo de conexión a la base de datos
        include("conexion_bd.php");

        // Obtener los valores de usuario y contraseña del formulario
        $usuario = $_POST["Fullname"];
        $clave = $_POST["Clave"];

        // Obtener la IP del usuario
        $ip_usuario = $_SERVER['REMOTE_ADDR'];

        // Consulta SQL segura usando consultas preparadas
        $consulta = $conexion->prepare("SELECT * FROM datos_usuarios WHERE usuario=? AND contraseña=?");

        // Verificar si la consulta se preparó correctamente
        if ($consulta === false) {
            echo '<div>Error en la consulta SQL</div>';
        } else {
            // Vincular parámetros y ejecutar la consulta
            $consulta->bind_param("ss", $usuario, $clave);
            $consulta->execute();

            // Obtener el resultado de la consulta
            $resultado = $consulta->get_result();

            // Verificar si se encontraron filas
            if ($resultado->num_rows > 0) {
                // Iniciar sesión si aún no se ha iniciado
                session_start();

                // Guardar la información del usuario en variables de sesión
                $_SESSION['usuario'] = $usuario;
                $_SESSION['contraseña'] = $clave;

                // Obtener la fecha y hora actual en el horario de Ecuador
                $fecha_actual = date("Y-m-d H:i:s");

                // Insertar el registro en la tabla historial
                $insert_query = $conexion->prepare("INSERT INTO historial (usuario, fecha, ip) VALUES (?, ?, ?)");
                if ($insert_query === false) {
                    echo '<div>Error al preparar la consulta para insertar en la tabla historial</div>';
                } else {
                    // Vincular parámetros y ejecutar la consulta de inserción
                    $insert_query->bind_param("sss", $usuario, $fecha_actual, $ip_usuario);
                    $insert_query->execute();
                    $insert_query->close();
                }

                // Redirigir al usuario a la página pannel.php
                header("Location: pannel.php");
                exit(); // Asegura que no haya más salida después de la redirección
            } else {
                // Usuario o contraseña incorrectos
                echo '<div>Usuario o contraseña incorrectos</div>';
            }

            // Cierra la consulta preparada
            $consulta->close();
        }
    }
}
?>
