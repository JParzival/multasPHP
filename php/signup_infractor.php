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
        //header("location: ../signup.html");
        header("refresh: 5; url=../signup.html");
    }
    else
    {
        if (strlen($inputCredencial) != 10)
        {
            print("El credencial introducido no es valido, se te redireccionará en breve.");
            header("refresh: 5; url=../signup.html");
            $_SESSION['inputCredencial'] = null;
            return;
        }

        if (strlen($inputPassword) < 5)
        {
            print("La contraseña proporcionada es muy corta, se te redireccionará en breve.");
            header("refresh: 5; url=../signup.html");
            return;
        }

        function comprobarSiTieneNumeros($string)
        {
            if (preg_match('~[0-9]~', $string) === 1)
                return false;

            return true;
        }

        if (!comprobarSiTieneNumeros($inputNombre))
        {
            print("El nombre no puede contener números, se te redireccionará en breve.");
            header("refresh: 5; url=../signup.html");
            $_SESSION['inputNombre'] = null;
            return;
        }

        if (!comprobarSiTieneNumeros($inputApellidos))
        {
            print("Los apellidos no pueden contener números, se te redireccionará en breve.");
            header("refresh: 5; url=../signup.html");
            $_SESSION['inputApellidos'] = null;
            return;
        }

        if (strlen($inputTlf) != 9)
        {
            print("El número de telefono no es valido, se te redireccionará en breve.");
            header("refresh: 5; url=../signup.html");
            $_SESSION['inputTlf'] = null;
            return;
        }

        $arrayFecha = explode("-", $inputFechaExpCarnet);
        if (sizeof($arrayFecha) != 3)
        {
            print("La fecha introducida no es valida, se te redireccionará en breve.");
            header("refresh: 5; url=../signup.html");
            $_SESSION['inputFechaExpCarnet'] = null;
            return;
        }

        if (!checkdate($arrayFecha[1], $arrayFecha[0], $arrayFecha[2]))
        {
            print("La fecha introducida no es valida, se te redireccionará en breve.");
            header("refresh: 5; url=../signup.html");
            $_SESSION['inputFechaExpCarnet'] = null;
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

        mysqli_query($conexion, "INSERT INTO infractor(credencial, password, nombre, apellidos, tlf, f_exp_carnet) VALUES
            ('$inputCredencial', '$inputPassword', '$inputNombre', '$inputApellidos', '$inputTlf', '$fechaDB')") or die("Error al guardar los datos en la base de datos.");
        echo "Exito al crear el usuario, seras redirigido a la pagina de inicio.";
        header("refresh: 5; url=../login_infractor.html");
    }
?>
