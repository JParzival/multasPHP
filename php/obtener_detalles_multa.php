<?php

    ## Obtenemos la id de la multa de la pantalla anterior.
    $id_multa = $_SERVER['multa']
    
    ## Credenciales de la base de datos
    $user = 'root';
    $contrasena = '';
    $ip = 'localhost';
    $database = 'database_multas';
    
    ## Hacemos la conexión pasándole los credenciales
    $conexion = mysqli_connect($ip, $user, $contrasena, $database) or die ("Conexión Fallida a $database");
    
    
    $consulta = mysqli_query ($conexion, "SELECT FECHA, RAZON, LUGAR, PRECIO, PAGO FROM MULTAS WHERE ID = '$id_multa'");
    $nfilas = mysqli_num_rows ($consulta);
    
    if($nfilas == 0)
    {
        print("Excepción encontrando multa");
        sleep(2);
        header("location:index.html");
        
    }
    if($nfilas == 2)
    {
        print("Excepción encontrando multa");
        sleep(2);
        header("location:index.html");
    }

    ## Esto significa que lo hemos hecho bien y que por lo tanto ahora podremos recuperar los resultados de la consulta.