<?php
    session_start();

    // Limpiamos cache
    session_destroy();
    session_start();

    if ($_SERVER["REQUEST_METHOD"] != "POST")
    {
        header("location: ../login_infractor.html");
        return;
    }

    $typeLogin = isset($_POST["typeLogin"]) ? $_POST["typeLogin"] : null;

    if ($typeLogin == null || ($typeLogin != "admin" && $typeLogin != "infractor"))
    {
        header("location: ../login_infractor.html");
        return;
    }

    $_SESSION["typeLogin"] = $_POST["typeLogin"];

    if(strlen($_POST['password']) < 5)
    {
        print("La contraseña es demasiado corta.");

        if($typeLogin == "infractor")
        {
            header("refresh: 3; url=../login_infractor.html");
            return;
        }
        else
        {
            header("refresh: 3; url=../login_admin.html");
            return;
        }
        
    }

    $pass = isset($_POST['password']) ? $_POST['password'] : null;
    $credencial = isset($_POST['credencial']) ? $_POST['credencial'] : null;

    if ($pass == null || $credencial == null)
    {
        print("No se han proporcionado los parámetros requeridos. Se te redireccionará en breve.");
        header("refresh: 5; url=../login_infractor.html");
        return;
    }

    $_SESSION['credencial'] = $credencial;
    if ($typeLogin == "admin")
        $_SESSION["isAdmin"] = true;

    include 'conexion_bd.php';
    
    if ($typeLogin == "admin") # Caso del admin
        $sqlQuery = "SELECT credencial_admin, `password_admin` FROM admins WHERE `password_admin` = '$pass' AND credencial_admin = '$credencial'";
    else	                   # Caso del infractor
        $sqlQuery = "SELECT credencial, `password` FROM infractor WHERE `password` = '$pass' AND credencial = '$credencial'";

    $consulta = mysqli_query($conexion, $sqlQuery) or die("No existe el usuario indicado, error DB.");
    $nfilas = mysqli_num_rows($consulta);
    
    if ($nfilas == 0)
    {
        print("No se ha encontrado al usuario, se te redireccionará a la página de inicio de sesión.");
        header("refresh: 5; url=../login_$typeLogin.html");
    }
    else
        header("location: login_ok.php");
?>
