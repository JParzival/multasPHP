<?php

    ## Obtenemos la id de la multa de la pantalla anterior.

    $id_multa = $_SERVER['multa'];
    
    include 'conexion_bd.php';
    
    mysqli_query ($conexion, "UPDATE multas SET estado = 2 where id = $id_multa") or die ("Hubo un poblema al realizar el pago.");
    header("refresh: 3; url=../pago_realizado.html");
        
?>