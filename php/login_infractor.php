<?php

    session_start();

    if ($_SERVER["REQUEST_METHOD"] != "POST")
    {
        header("location: ../login_infractor.html");
        return;
    }

    $pass = isset($_POST['password']) ? $_POST['password'] : null;
    $credencial = isset($_POST['credencial']) ? $_POST['credencial'] : null;
    if ($pass == null || $credencial == null)
    {
        print("No se han proporcionado los parametros requeridos. Se te redireccionará en breve.");
        //sleep(5);
        //header("location: ../login_infractor.html");
        header("refresh: 5; url=../login_infractor.html");
        return;
    }

    $_SESSION['credencial'] = $credencial;

    include 'conexion_bd.php';
    
    $consulta = mysqli_query($conexion, "SELECT CREDENCIAL, `PASSWORD` FROM INFRACTOR WHERE `PASSWORD` = '$pass' AND CREDENCIAL = '$credencial'") or die("No existe el usuario indicado.");
    $nfilas = mysqli_num_rows($consulta);
    
    if ($nfilas == 0)
    {
        print("No se ha encontrado al usuario, se te redireccionará a la página de inicio de sesión.");
        //sleep(2);
        //header("location: ../login_infractor.html");
        header("refresh: 5; url=../login_infractor.html");
    }
    else
        header("location: ../login_ok.html");

    ?>
