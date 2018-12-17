<?php
    session_start();

    $id_multa = isset($_SESSION['id_multa']) ? $_SESSION['id_multa'] : null;
    if (!$id_multa)
    {
        header("location: main_infractor.php");
        return;
    }

    include 'conexion_bd.php';
    
    $query = mysqli_query($conexion, "UPDATE multas SET reclamada = 1 WHERE id = $id_multa");
    if ($query)
    {
        echo "Multa reclamada con exito, se te redireccionará en breve.";
        header("refresh: 3; url=obtener_detalles_multa.php");
    }
    else
    {
        echo "Se ha producido un error al reclamar la multa, intentelo más tarde, se te redireccionará en breve.";
        header("refresh: 3; url=obtener_detalles_multa.php");
    }
?>
