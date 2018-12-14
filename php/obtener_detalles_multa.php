<?php

    ## Obtenemos la id de la multa de la pantalla anterior.

    $id_multa = $_GET['multa'];
    
    include 'conexion_bd.php';
    
    $consulta = mysqli_query ($conexion, "SELECT FECHA, RAZON, LUGAR, PRECIO, PAGO FROM MULTAS WHERE ID = '$id_multa'");
    $nfilas = mysqli_num_rows ($consulta);
    
    if($nfilas == 0)
    {
        print("Excepción encontrando multa, ninguna encontrada");
        header("refresh: 3; url:../index.html");
        
    }
    if($nfilas == 2)
    {
        print("Excepción encontrando multa, más de una encontrada");
        header("refresh: 3; url=../index.html");
    }

    ## Esto significa que lo hemos hecho bien y que por lo tanto ahora podremos recuperar los resultados de la consulta.

    $i = 0;
    for($i; $i < $nfilas; $i++)
    {
        $fila = mysqli_fetch_array($consulta);

        print($fila['FECHA']);
        print($fila['RAZON']);
        print($fila['LUGAR']);
        print($fila['PRECIO']);
        
    }
    

    