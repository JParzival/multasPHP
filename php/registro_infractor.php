<?php
    session_start();

    if ($_SERVER["REQUEST_METHOD"] != "POST")
    {
        header("location: ../signup.html");
        return;
    }

    $inputCredencial = isset($_POST['inputCredencial']) ? $_POST['inputCredencial'] : null;
    $inputPassword = isset($_POST['inputPassword']) ? $_POST['inputPassword'] : null;
    $inputNombre = isset($_POST['inputNombre']) ? $_POST['inputNombre'] : null;
    $inputApellidos = isset($_POST['inputApellidos']) ? $_POST['inputApellidos'] : null;
    $inputTlf = isset($_POST['inputTlf']) ? $_POST['inputTlf'] : null;
    $inputFechaExpCarnet = isset($_POST['inputFechaExpCarnet']) ? $_POST['inputFechaExpCarnet'] : null;

    $_SESSION['inputCredencial'] = $inputCredencial;
    $_SESSION['inputNombre'] = $inputNombre;
    $_SESSION['inputApellidos'] = $inputApellidos;
    $_SESSION['inputTlf'] = $inputTlf;
    $_SESSION['inputFechaExpCarnet'] = $inputFechaExpCarnet;

    if ($inputCredencial == null || $inputPassword == null || $inputNombre == null || $inputApellidos == null ||
        $inputTlf == null || $inputFechaExpCarnet == null)
    {
        print("No se han proporcionado los parametros requeridos. Se te redireccionará en breve.");
        //sleep(5);
        //header("location: signup.php");
        header("refresh: 5; url=signup.php");
    }
    else
    {
        $error = false;

        if (strlen($inputCredencial) != 9)
        {
            print("El credencial introducido no es valido.<br>");
            header("refresh: 5; url=signup.php");
            $_SESSION['inputCredencial'] = null;
            $error = true;
        }

        if (strlen($inputPassword) < 5)
        {
            print("La contraseña proporcionada es muy corta.<br>");
            header("refresh: 5; url=signup.php");
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
            header("refresh: 5; url=signup.php");
            $_SESSION['inputNombre'] = null;
            $error = true;
        }

        if (!comprobarSiTieneNumeros($inputApellidos))
        {
            print("Los apellidos no pueden contener números.<br>");
            header("refresh: 5; url=signup.php");
            $_SESSION['inputApellidos'] = null;
            $error = true;
        }

        if (strlen($inputTlf) != 9)
        {
            print("El número de telefono no es valido.<br>");
            header("refresh: 5; url=signup.php");
            $_SESSION['inputTlf'] = null;
            $error = true;
        }

        $arrayFecha = explode("-", $inputFechaExpCarnet);
        if (sizeof($arrayFecha) != 3)
        {
            print("La fecha introducida no es valida.<br>");
            header("refresh: 5; url=signup.php");
            $_SESSION['inputFechaExpCarnet'] = null;
            $error = true;
        }

        if (!checkdate($arrayFecha[1], $arrayFecha[0], $arrayFecha[2]))
        {
            print("La fecha introducida no es valida.<br>");
            header("refresh: 5; url=signup.php");
            $_SESSION['inputFechaExpCarnet'] = null;
            $error = true;
        }

        if ($error)
        {
            echo "Existen errores en los datos de registro, se te redireccionará en breve.";
            header("refresh: 3; url=signup.php");
            return;
        }

        $fechaDB = $arrayFecha[2]."-".$arrayFecha[1]."-".$arrayFecha[0];

        ## Aquí ha pasado la criba, ahora tendremos que meterlo en la DB

        include "conexion_bd.php";

        $inputCredencial = mysqli_real_escape_string($conexion, $inputCredencial);
        $inputPassword = mysqli_real_escape_string($conexion, $inputPassword);
        $inputNombre = mysqli_real_escape_string($conexion, $inputNombre);
        $inputApellidos = mysqli_real_escape_string($conexion, $inputApellidos);
        $inputTlf = mysqli_real_escape_string($conexion, $inputTlf);
        $fechaDB = mysqli_real_escape_string($conexion, $fechaDB);

        mysqli_query($conexion, "INSERT INTO infractor(credencial, password, nombre, apellidos, tlf, f_exp_carnet) 
                                 VALUES('$inputCredencial', '$inputPassword', '$inputNombre', '$inputApellidos', '$inputTlf', '$fechaDB')") 
        or die("Error al guardar los datos en la base de datos.");

        echo "Éxito al crear el usuario, serás redirigido a la página de inicio.";
        header("refresh: 3; url=../login_infractor.html");

        // Si es correcto borramos las variables para que no se vuelvan a mostrar en signup
        
        $_SESSION['inputCredencial'] = null;
        $_SESSION['inputNombre'] = null;
        $_SESSION['inputApellidos'] = null;
        $_SESSION['inputTlf'] = null;
        $_SESSION['inputFechaExpCarnet'] = null;
    }
?>
