<?php

    ## Obtenemos la id de la multa de la pantalla anterior.

    $id_multa = $_SERVER['multa'];
    
    include 'conexion_bd.php';
    
    $consulta = mysqli_query ($conexion, "SELECT FECHA, RAZON, LUGAR, PRECIO, PAGO FROM MULTAS WHERE ID = '$id_multa'");
    $nfilas = mysqli_num_rows ($consulta);
    
    if($nfilas == 0)
    {
        print("Excepción encontrando multa");
        header("refresh: 3; url:../index.html");
        
    }
    if($nfilas == 2)
    {
        print("Excepción encontrando multa");
        header("refresh: 3; url=../index.html");
    }

    ## Esto significa que lo hemos hecho bien y que por lo tanto ahora podremos recuperar los resultados de la consulta.

    