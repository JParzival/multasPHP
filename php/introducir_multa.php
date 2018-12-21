<?php
    session_start();

    if (!isset($_SESSION["credencial"]) || !isset($_SESSION["isAdmin"]))
    {
        header("location: ../login_admin.html");
        return;
    }

    # Lo primero que tenemos que hacer es comprobar que todos los campos de la multa sean correctos

    function mostrarFormulario()
    {
        include "conexion_bd.php";
        $arrayMatriculas = array();
        $matriculasResult = mysqli_query($conexion, "SELECT matricula FROM matriculas");
        
        if (mysqli_num_rows($matriculasResult) > 0)
            while ($row = mysqli_fetch_array($matriculasResult))
                array_push($arrayMatriculas, $row["matricula"]);

        $fecha = isset($_SESSION["nmFecha"]) ? $_SESSION["nmFecha"] : "";
        $razon = isset($_SESSION["nmRazon"]) ? $_SESSION["nmRazon"] : "";
        $direccion = isset($_SESSION["nmDireccion"]) ? $_SESSION["nmDireccion"] : "";
        $precio = isset($_SESSION["nmPrecio"]) ? $_SESSION["nmPrecio"] : "";
        $matriculaInput = isset($_SESSION["nmMatricula"]) ? $_SESSION["nmMatricula"] : "";

        $formulario = <<<FORM

        <form action="introducir_multa.php" enctype="application/x-www-form-urlencoded" method="POST">

            Razón Multa: <input name="razon" type="text" value="$razon" required>
            <br>
            Fecha: <input name="fecha" type="date" value="$fecha" required>
            <br>
            Dirección: <input name="direccion" type="text" value="$direccion" required>
            <br>
            Precio: <input name="precio" type="number" value="$precio" required>
            <br>
FORM;
        print($formulario);

        echo "Matrícula: <select name='numeroMatricula' required>";
        echo "<option disabled selected value>";
        foreach ($arrayMatriculas as $matricula)
        {
            if ($matriculaInput == $matricula)
                echo "<option value='$matricula' selected> $matricula</option>";
            else
                echo "<option value='$matricula'> $matricula </option>";
        }

        echo "</select>";

        echo "<br><input type='submit' value='Registrar Multa'>";

        echo "</form>";
    } 

    if ($_SERVER["REQUEST_METHOD"] != "POST")  # Quiere obtener el formulario
    {
        mostrarFormulario();
    }
    else	                                # Quiere comprobar los datos e introducirlos
    {
        $fecha = isset($_POST["fecha"]) ? $_POST["fecha"] : null;
        $razon = isset($_POST["razon"]) ? $_POST["razon"] : null;
        $direccion = isset($_POST["direccion"]) ? $_POST["direccion"] : null;
        $precio = isset($_POST["precio"]) ? $_POST["precio"] : null;
        $matricula = isset($_POST["numeroMatricula"]) ? $_POST["numeroMatricula"] : null;
        if ($fecha == null || $razon == null || $direccion == null || $precio == null ||
            $matricula == null)
        {
            echo "No se han introducido todos los datos requeridos.<br>";
            mostrarFormulario();
            return;
        }

        $_SESSION["nmFecha"] = $fecha;
        $_SESSION["nmRazon"] = $razon;
        $_SESSION["nmDireccion"] = $direccion;
        $_SESSION["nmPrecio"] = $precio;
        $_SESSION["nmMatricula"] = $matricula;

        $error = false;

        # Compruebo precio
        if (preg_match('~[0-9]~', $precio) !== 1)
        {
            echo "El precio no es número.<br>";
            $_SESSION["nmPrecio"] = null;
            $error = true;
        }

        # Compruebo fecha
        $fechaOk = true;
        $arrayFecha = explode("-", $fecha);
        if (sizeof($arrayFecha) != 3)
        {
            print("La fecha introducida no es valida.<br>");
            $_SESSION["nmFecha"] = null;
            $error = true;
            $fechaOk = false;
        }

        if ($fechaOk && !checkdate($arrayFecha[1], $arrayFecha[2], $arrayFecha[0]))
        {
            print("La fecha introducida no es valida.<br>");
            $error = true;
            $_SESSION["nmFecha"] = null;
        }

       // Warning, Warning: date(): It is not safe to rely on the system's timezone settings. You are *required* to use the date.timezone setting or the date_default_timezone_set() function. In case you used any of those methods and you are still getting this warning, you most likely misspelled the timezone identifier. We selected the timezone 'UTC' for now, but please set date.timezone to select your timezone.
       date_default_timezone_set("Europe/Madrid");
       if ($fechaOk && $fecha > date("Y-m-d"))
       {
           print("La fecha introducida no puede ser mayor a la actual.<br>");
           $_SESSION['nmFecha'] = null;
           $error = true;
       }

        #Comprobamos matrícula
        if (preg_match("/[[:digit:]]{4} [[:alpha:]]{3}/", $matricula) != 1 &&
            preg_match("/[[:alpha:]]{1} [[:digit:]]{4} [[:alpha:]]{2}/", $matricula) != 1 &&
            preg_match("/[[:alpha:]]{2} [[:digit:]]{4} [[:alpha:]]{1}/", $matricula) != 1)
        {
            print("La matrícula introducida no es correcta.<br>");
            $_SESSION["nmMatricula"] = null;
            $error = true;
        }

        if ($error)
        {
            echo "<br>";
            mostrarFormulario();
            return;
        }

        # En caso de que hayamos pasado todos los elementos, vamos a introducir la multa

        include "conexion_bd.php";

        $queryCoche = "SELECT m.matricula, m.n_bastidor, c.credencial FROM matriculas m LEFT JOIN coches c ON m.n_bastidor = c.n_bastidor WHERE m.matricula = '$matricula'";
        $resultadoCoche = mysqli_query($conexion, $queryCoche);
        if (mysqli_num_rows($resultadoCoche) == 0)
        {
            echo "No existe el coche introducido.<br>";
            mostrarFormulario();
            return;
        }
        else
        {
            $fila = mysqli_fetch_array($resultadoCoche);
            $credencial = $fila["credencial"];
        }

        if (!$credencial)
        {
            echo "Error interno al guardar la multa.<br>";
            mostrarFormulario();
            return;
        }

        $credencialAdmin = $_SESSION["credencial"];
        $query = "INSERT INTO multas
                         (razon, fecha, reclamada, direccion, precio, estado, matricula, credencial, `admin`)
                   VALUES('$razon', '$fecha', 0, '$direccion', '$precio', 0, '$matricula', '$credencial', '$credencialAdmin')";
        
        $resultado = mysqli_query($conexion, $query);

        if ($resultado == true)
        {
            echo "La multa ha sido registrada con exito.";
            header("refresh: 5; url=main_admin.php");

            // Limpiamos el formulario
            $_SESSION["nmFecha"] = null;
            $_SESSION["nmRazon"] = null;
            $_SESSION["nmDireccion"] = null;
            $_SESSION["nmPrecio"] = null;
            $_SESSION["nmMatricula"] = null;
        }
        else
        {
            echo mysqli_error($conexion);
            echo "<br>Se ha producido un error interno al guardar la multa.";
            header("refresh: 10; url=introducir_multa.php");
        }
    }
?>
