<?php

    session_start();

    $pass = $_POST['password'];
    $credencial = $_POST['credencial'];

    $_SESSION['credencial'] = $credencial;

    include 'conexion_bd.php';
    
    $consulta = mysqli_query($conexion, "SELECT CREDENCIAL, `PASSWORD` FROM INFRACTOR WHERE `PASSWORD` = '$pass' AND CREDENCIAL = '$credencial'");
    $nfilas = mysqli_num_rows ($consulta);
    
    if ($nfilas == 0)
    {
        print("No se ha encontrado al usuario");
        sleep(2);
        header("location:login_infractor.html");
    }
    else if ($nfilas > 1)
    {
        print("Esto se ha jodido... hay inconsistencia");
    }
    else
    {
        header("location:login_ok.html");
    }

    ?>