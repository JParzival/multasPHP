<?php

    session_start();

    $credencial = isset($_SESSION["credencial"]) ? $_SESSION["credencial"] : null;
    if ($credencial == null)
    {
        header("location: ../login_infractor.html");
        return;
    }

    include "conexion_bd.php";
    $resultado = mysqli_query($conexion, "SELECT id, razon, fecha, reclamada, precio, estado, m.n_bastidor, direccion FROM multas m LEFT JOIN coches c ON m.n_bastidor = c.n_bastidor WHERE c.credencial = '$credencial'");

    $arrayMultas = array();

    while ($row = mysqli_fetch_array($resultado))
    {
        $idMulta = $row["id"];
        $razon = $row["razon"];
        $fecha = $row["fecha"];
        $reclamada = $row["reclamada"];
        $precio = $row["precio"];
        $estado = $row["estado"];
        $nbastidor = $row["n_bastidor"];
        $direccion = $row["direccion"];

        $arrayMultas[$idMulta] = array(
            "idMulta" => $idMulta,
            "razon" => $razon,
            "fecha" => $fecha,
            "reclamada" => $reclamada,
            "precio" => $precio,
            "estado" => $estado,
            "nbastidor" => $nbastidor,
            "direccion" => $direccion
        );
    }

    $_SESSION["multas"] = $arrayMultas;
?>
