<?php

    ## Obtenemos la id de la multa de la pantalla anterior.

    $id_multa = $_SERVER['multa'];
    
    include 'conexion_bd.php';
    
    $consulta = mysqli_query ($conexion, "UPDATE multas SET ");
    $nfilas = mysqli_num_rows ($consulta);
    
?>