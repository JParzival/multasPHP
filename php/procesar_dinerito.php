<?php

    ## Obtenemos la id de la multa de la pantalla anterior.

    $id_multa = $_SESSION['id_multa'];
    
    include 'conexion_bd.php';
    
    mysqli_query ($conexion, "UPDATE multas SET estado = 2 WHERE id = $id_multa") or die ("Hubo un poblema al realizar el pago.");
    header("refresh: 3; url=../pago_realizado.html");
        
?>