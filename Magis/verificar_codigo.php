<?php

error_log("Consultando controlador verificar_codigo.php");

include 'conexion_bd.php';


$response = array();


$query_all = "SELECT codigo FROM magis_links";
$result_all = $conexion->query($query_all);

if ($result_all) {

    $codigos = array();
    while ($row_all = $result_all->fetch_assoc()) {
        $codigos[] = $row_all['codigo'];
    }
    $response['todos_los_codigos'] = $codigos;
} else {

    $response['error_consulta'] = 'Error al obtener los códigos de la base de datos.';
}


if (isset($_POST['codigo'])) {
    $codigoIngresado = $_POST['codigo'];


    $query = "SELECT * FROM magis_links WHERE codigo = ?";
    $stmt = $conexion->prepare($query);
    $stmt->bind_param("s", $codigoIngresado);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {

        $row = $result->fetch_assoc();
        $estado = $row['estado'];

        if ($estado == '1') {

            $query_update = "UPDATE magis_links SET estado = '0' WHERE codigo = ?";
            $stmt_update = $conexion->prepare($query_update);
            $stmt_update->bind_param("s", $codigoIngresado);
            $stmt_update->execute();
            $stmt_update->close();


            $response['Codigo'] = 'success';
            $response['message'] = 'Código Correcto, su descarga iniciará en breve ...';
        } else {

            $response['error'] = 'Este Código ya ha sido utilizado comunicate con soporte.';
        }
    } else {

        $response['error'] = 'Código incorrecto. Inténtelo de nuevo.';
    }


    $stmt->close();
} else {

    $response['error'] = 'No se proporcionó ningún código.';
}


$conexion->close();


echo json_encode($response);
?>