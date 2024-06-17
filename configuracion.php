<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pannel Comunica Digital</title>

    <!--google fonts-->
    <link rel="icon" type="image/png" href="img\logo.png">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat&display=swap" rel="stylesheet">
    <!-- -->


    <link rel="stylesheet" href="config_styles.css">
    <?php
session_start(); // Iniciar la sesión si aún no se ha iniciado

if(isset($_SESSION['usuario'])) {
    // Incluir el archivo de conexión a la base de datos
    include("conexion_bd.php");

    // Obtener el usuario actual de la sesión
    $usuario_actual = $_SESSION['usuario'];

    // Consulta SQL para obtener los datos del usuario actual
    $consulta_usuario = $conexion->prepare("SELECT * FROM datos_usuarios WHERE usuario = ?");
    if ($consulta_usuario === false) {
        echo '<div>Error en la consulta SQL</div>';
    } else {
        // Vincular parámetros y ejecutar la consulta
        $consulta_usuario->bind_param("s", $usuario_actual);
        $consulta_usuario->execute();

        // Obtener el resultado de la consulta
        $resultado_usuario = $consulta_usuario->get_result();

        // Verificar si se encontraron filas
        if ($resultado_usuario->num_rows > 0) {
            // Obtener los datos del usuario
            $fila_usuario = $resultado_usuario->fetch_assoc();
            $nombre = $fila_usuario['nombre'];
            $correo = $fila_usuario['correo'];
            $codigo_referido = $fila_usuario['codigo_de_referido'];
            $whatsapp = $fila_usuario['whatsapp'];
            $codigo_personal = $fila_usuario['iddatos_usuarios'];
        }

        // Cierra la consulta preparada
        $consulta_usuario->close();
    }
}
?>
    
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var logoutLink = document.getElementById('logout');

            if (logoutLink) {
                logoutLink.addEventListener('click', function(event) {
                    event.preventDefault(); // Evitar que el enlace se comporte normalmente (navegación)

                    // Realizar la acción de cerrar sesión aquí, por ejemplo, eliminando las variables de sesión
                    // y luego redireccionar al usuario a index.php
                    window.location.href = 'logout.php'; // Redireccionar al script de cierre de sesión
                });
            }
        });
    </script>

</head>

<body>

    <section class="contenedor">

        <div class="izquierdo">

            <div class="logo">
                <img src="img\logo.png" alt="">
            </div>

            <div class="menu1">
                <ul>
                    <li> <a href="pannel.php">Pannel</a></li>
                    <li> <a href="digitalplus.php">Digital Plus</a></li>
                    <li> <a href="configuracion.php">Configuración</a></li>
                    <li> <a href="https://wa.link/del7fe">Recargas</a></li>
                    <li> <a href="historial.php">Historial</a></li>
                    <li> <a href="#" id="logout">Cerrar Sesión</a></li>

                </ul>

            </div>

        </div>


        <div class="derecho">

            <div class="contdere">
                <div class="Bienvenido">
                    <div>
                    <h3>Bienvenido!
                    <?php
                    // Iniciar sesión si aún no se ha iniciado
                    session_start();

                    // Verificar si el usuario ha iniciado sesión
                    if(isset($_SESSION['usuario'])) {
                        // La sesión está activa, puedes acceder a los datos del usuario
                        $usuario = $_SESSION['usuario'];
                        echo $usuario; // Mostrar el nombre de usuario
                    } else {
                        // Si el usuario no ha iniciado sesión, redirigirlo a la página de inicio de sesión
                        header("Location: index.php");
                        exit();
                    }
                    ?>
                    </h3>
                    </div>
                    

                    <div class="saldo">Saldo: $
                    <div>
                    <?php
                    // Incluir el archivo de conexión a la base de datos
                    include("conexion_bd.php");

                    // Consultar el saldo del usuario
                    $query_saldo = "SELECT saldo FROM datos_usuarios WHERE usuario = '$usuario'";
                    $resultado_saldo = $conexion->query($query_saldo);

                    // Verificar si la consulta fue exitosa
                    if ($resultado_saldo) {
                        // Obtener el saldo del usuario y mostrarlo con solo la unidad y dos decimales
                        $fila_saldo = $resultado_saldo->fetch_assoc();
                        $saldo_usuario = number_format($fila_saldo['saldo'], 2);
                        echo $saldo_usuario;
                    } else {
                        // Si hay un error en la consulta
                        echo "Error al obtener el saldo del usuario.";
                    }
                    ?>
                    </div>


                    </div>
                    <!-- Código PHP para mostrar el saldo del usuario justo después del div "saldo" -->
                    

                    <!-- Otras partes de tu página aquí -->
                    
                </div>
                
                
                <div class="config">

                    
                    <form class="forrm" action="guardar_datos.php" method="post">
                        <label for="nombre">Nombre:</label>
                        <input type="text" id="nombre" name="nombre" value="<?php echo $nombre; ?>" required><br><br>

                        <label for="correo">Correo:</label>
                        <input type="text" id="correo" name="correo" value="<?php echo $correo; ?>" required><br><br>

                        <label for="codigo_referido">Código de Referido:</label>
                        <input type="text" id="codigo_referido" name="codigo_referido" value="<?php echo $codigo_referido; ?>"><br><br>

                        <label for="whatsapp">Whatsapp:</label>
                        <input type="text" id="whatsapp" name="whatsapp" value="<?php echo $whatsapp; ?>"><br><br>

                        <label for="codigo_personal">Código Personal:</label>
                        <input type="text" id="codigo_personal" name="codigo_personal" value="<?php echo $codigo_personal; ?>" required><br><br>

                        <input type="submit" value="Guardar Datos">
                    </form>

                </div>
    
            </div>

    


                
            </div>

        </div>

    </section>
    

</body>

</html>