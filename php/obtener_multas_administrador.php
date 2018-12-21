<?php

    if (session_status() == PHP_SESSION_NONE)
        session_start();

    $credencial = isset($_SESSION["credencial"]) ? $_SESSION["credencial"] : null;
    if ($credencial == null)
    {
        header("location: ../login_infractor.html");
        return;
    }

    include "conexion_bd.php";
    $resultado = mysqli_query($conexion, "SELECT id, razon, fecha, reclamada, precio, estado, matricula, direccion, credencial FROM multas WHERE `admin` = '$credencial'");

    $arrayMultas = array();

    while ($row = mysqli_fetch_array($resultado))
    {
        $idMulta = $row["id"];
        $razon = $row["razon"];
        $fecha = $row["fecha"];
        $reclamada = $row["reclamada"];
        $precio = $row["precio"];
        $estado = $row["estado"];
        $matricula = $row["matricula"];
        $direccion = $row["direccion"];
        $infractor = $row["credencial"];

        $arrayMultas[$idMulta] = array
        (
            "idMulta" => $idMulta,
            "razon" => $razon,
            "fecha" => $fecha,
            "reclamada" => $reclamada,
            "precio" => $precio,
            "estado" => $estado,
            "matricula" => $matricula,
            "direccion" => $direccion,
            "infractor" => $infractor
        );
    }

    $_SESSION["multas"] = $arrayMultas;
?>
