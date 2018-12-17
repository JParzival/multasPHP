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
        $fecha = isset($_SESSION["nmFecha"]) ? $_SESSION["nmFecha"] : "";
        $razon = isset($_SESSION["nmRazon"]) ? $_SESSION["nmRazon"] : "";
        $direccion = isset($_SESSION["nmDireccion"]) ? $_SESSION["nmDireccion"] : "";
        $precio = isset($_SESSION["nmPrecio"]) ? $_SESSION["nmPrecio"] : "";
        $n_bastidor = isset($_SESSION["nmNBastidor"]) ? $_SESSION["nmNBastidor"] : "";

        $formulario = <<<FORM

        <form action="introducir_multa.php" enctype="application/x-www-form-urlencoded" method="POST">

            Razón Multa: <input name="razon" type="text" value="$razon">
            <br>
            Fecha: <input name="fecha" type="date" value="$fecha">
            <br>
            Dirección: <input name="direccion" type="text" value="$direccion">
            <br>
            Precio: <input name="precio" type="number" value="$precio">
            <br>
            Número de Bastidor: <input name="numeroBastidor" type="number" value="$n_bastidor">
            <br>
            <input type="submit" value="Registrar Multa">

        </form>
FORM;

        print($formulario);
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
        $n_bastidor = isset($_POST["numeroBastidor"]) ? $_POST["numeroBastidor"] : null;
        if ($fecha == null || $razon == null || $direccion == null || $precio == null ||
            $n_bastidor == null)
        {
            echo "No se han introducido todos los datos requeridos.<br>";
            mostrarFormulario();
            return;
        }

        $_SESSION["nmFecha"] = $fecha;
        $_SESSION["nmRazon"] = $razon;
        $_SESSION["nmDireccion"] = $direccion;
        $_SESSION["nmPrecio"] = $precio;
        $_SESSION["nmNBastidor"] = $n_bastidor;

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

        # Compruebo número de bastidor
        if (preg_match('~[0-9]~', $n_bastidor) !== 1)
        {
            echo "El número de bastidor no es número<br>";
            $error = true;
            $_SESSION["nmNBastidor"] = null;
        }

        if ($error)
        {
            echo "<br>";
            mostrarFormulario();
            return;
        }

        # En caso de que hayamos pasado todos los elementos, vamos a introducir la multa

        include "conexion_bd.php";

        $queryCoche = "SELECT n_bastidor, credencial FROM coches WHERE n_bastidor = '$n_bastidor'";
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
                         (razon, fecha, reclamada, direccion, precio, estado, n_bastidor, credencial, `admin`)
                   VALUES('$razon', '$fecha', 0, '$direccion', '$precio', 0, '$n_bastidor', '$credencial', '$credencialAdmin')";
        
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
            $_SESSION["nmNBastidor"] = null;
        }
        else
        {
            echo mysqli_error($conexion);
            echo "<br>Se ha producido un error interno al guardar la multa.";
            header("refresh: 10; url=introducir_multa.php");
        }
    }
?>
