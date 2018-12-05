<?php

    $pass = $_POST['password'];
    $credencial = $_POST['credencial'];
    
    $user = 'root';
    $contrasena = '';
    $ip = 'localhost';
    $database = 'database_multas';
    
    $conexion = mysqli_connect($ip, $user, $contrasena, $database) or die ("Conexión Fallida a $database");
    
    $consulta = mysqli_query ($conexion, "SELECT CREDENCIAL, CONTRASENA FROM USUARIOS WHERE CONTRASENA = '$pass' AND CREDENCIAL = '$credencial'");
    $nfilas = mysqli_num_rows ($consulta);
    
    if($nfilas == 0)
    {
        print("No se ha encontrado al usuario");
        sleep(2);
        header("location:login_infractor.html");
    }
    else if($nfilas > 1)
    {
        print("Esto se ha jodido... hay inconsistencia");
    }
    else
    {
        header("location:login_ok.html");
    }