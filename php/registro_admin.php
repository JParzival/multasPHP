<?php
    session_start();

    if ($_SERVER["REQUEST_METHOD"] != "POST")
    {
        header("location: signup_admin.php");
        return;
    }

    $inputCredencial = isset($_POST['inputCredencial']) ? $_POST['inputCredencial'] : null;
    $inputPassword = isset($_POST['inputPassword']) ? $_POST['inputPassword'] : null;
    $inputPassword2 = isset($_POST['inputPassword2']) ? $_POST['inputPassword2'] : null;
    $inputNombre = isset($_POST['inputNombre']) ? $_POST['inputNombre'] : null;
    $inputApellidos = isset($_POST['inputApellidos']) ? $_POST['inputApellidos'] : null;

    $_SESSION['inputCredencial'] = $inputCredencial;
    $_SESSION['inputNombre'] = $inputNombre;
    $_SESSION['inputApellidos'] = $inputApellidos;
    $_SESSION['inputPassword'] = $inputPassword;

    if ($inputCredencial == null || $inputPassword == null || $inputNombre == null || $inputApellidos == null || $inputPassword2 == null)
    {
        print("No se han proporcionado los parametros requeridos. Se te redireccionará en breve.");
        header("refresh: 5; url=signup_admin.php");
        return;
    }
    else
    {
        $error = false;

        if (strlen($inputCredencial) != 9)
        {
            print("El credencial introducido no es valido.<br>");
            $_SESSION['inputCredencial'] = null;
            $error = true;
        }

        if (strlen($inputPassword) < 5)
        {
            print("La contraseña proporcionada es muy corta.<br>");
            $error = true;
        }

        if (strcmp($inputPassword, $inputPassword2) != 0)
        {
            echo "Las contraseñas no coinciden.<br>";
            $error = true;
        }

        function comprobarSiTieneNumeros($string)
        {
            if (preg_match('~[0-9]~', $string) === 1)
                return false;

            return true;
        }

        if (!comprobarSiTieneNumeros($inputNombre))
        {
            print("El nombre no puede contener números.<br>");
            $_SESSION['inputNombre'] = null;
            $error = true;
        }

        if (!comprobarSiTieneNumeros($inputApellidos))
        {
            print("Los apellidos no pueden contener números.<br>");
            $_SESSION['inputApellidos'] = null;
            $error = true;
        }

        if ($error)
        {
            echo "Existen errores en los datos de registro, se te redireccionará en breve.";
            header("refresh: 5; url=signup_admin.php");
            return;
        }

        include "conexion_bd.php";

        $inputCredencial = mysqli_real_escape_string($conexion, $inputCredencial);
        $inputPassword = mysqli_real_escape_string($conexion, $inputPassword);
        $inputNombre = mysqli_real_escape_string($conexion, $inputNombre);
        $inputApellidos = mysqli_real_escape_string($conexion, $inputApellidos);

        mysqli_query($conexion, "INSERT INTO admins(credencial_admin, password_admin, nombre_admin, apellidos_admin) 
                                 VALUES('$inputCredencial', '$inputPassword', '$inputNombre', '$inputApellidos')") 
        or die("Error al guardar los datos en la base de datos: " . mysqli_connect_error());

        echo "Éxito al registrar el admin, serás redirigido a la página de inicio.";
        header("refresh: 3; url=../login_admin.html");
        return;
        
        $_SESSION['inputCredencial'] = null;
        $_SESSION['inputNombre'] = null;
        $_SESSION['inputApellidos'] = null;
    }
?>
