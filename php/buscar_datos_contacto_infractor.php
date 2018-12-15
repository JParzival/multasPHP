<?php
    if (session_status() == PHP_SESSION_NONE)
        session_start();

    if (!isset($_SESSION["credencial"]) || !isset($_SESSION["isAdmin"]))
    {
        header("location: ../login_admin.html");
        return;
    }

    $idMulta = isset($_POST["recMulta"]) ? $_POST["recMulta"] : null;
    if ($idMulta == null)
    {
        header("location: reclamaciones.php");
        return;
    }

    include "conexion_bd.php";
    $resultado = mysqli_query($conexion, "SELECT i.credencial, nombre, apellidos, tlf, f_exp_carnet FROM infractor i LEFT JOIN coches c ON i.credencial = c.credencial LEFT JOIN multas m ON m.n_bastidor = c.n_bastidor WHERE m.id = $idMulta");
    $nfilas = mysqli_num_rows($resultado);
    if ($nfilas != 0)
        $datosContacto = mysqli_fetch_array($resultado);
    else
        echo "No se ha encontrado la multa con id: $idMulta";
?>
