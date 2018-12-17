<?php

    # Lo primero que tenemos que hacer es comprobar que todos los campos de la multa sean correctos

    if($_SERVER["REQUEST_METHOD"] != POST)  # Quiere obtener el formulario
    {
        $formulario = <<<FORM

        <form action="introducir_multa.php" enctype="application/x-www-form-urlencoded" method="POST">

            Razón Multa: <input name="razon" type="text" id="razon">
            <br>
            Fecha: <input name="fecha" type="date" id="fecha">
            <br>
            Dirección: <input name="direccion" type="text" id="direccion">
            <br>
            Precio: <input name="precio" type="number" id="precio">
            <br>
            Número de Bastidor: <input name="numeroBastidor" type="number" id="nbastidor">
            <br>
            Credencial a Multar: <input name="credencial" type="text" id="credencial">
            <br>
            <input type="submit" value="Registrar Multa">

        </form>
FORM;

        print($formulario);
    }
    else	                                # Quiere comprobar los datos e introducirlos
    {
        # Quito espacios en blanco

        $fecha = trim($_POST["fecha"]);
        $razon = trim($_POST["razon"]);
        $direccion = trim($_POST["direccion"]);
        $precio = trim($_POST["precio"]);
        $n_bastidor = trim($_POST["numeroBastidor"]);
        $credencial = trim($_POST["credencial"]);

        # Compruebo precio

        if(!preg_match('~[0-9]~', $precio) != 1)
        {
            echo "El precio no es número";
        }

        # Compruebo fecha

        $fecha_exp = explode("/", $fecha);
        if (sizeof($arrayFecha) != 3)
        {
            print("La fecha introducida no es valida.<br>");
            header("refresh:2, url=introducir_multa.php");
        }

        if (!checkdate($arrayFecha[1], $arrayFecha[0], $arrayFecha[2]))
        {
            print("La fecha introducida no es valida.<br>");
            header("refresh:2, url=introducir_multa.php");
        }

        # Compruebo número de bastidor

        if(!preg_match('~[0-9]~', $n_bastidor) != 1)
        {
            echo "El número de bastidor no es número";
            header("refresh:2, url=introducir_multa.php");
        }

        # En caso de que hayamos pasado todos los elementos, vamos a introducir la multa

        include "conexion_bd.php";

        $query = "INSERT INTO multas
                         (razon, fecha, reclamada, direccion, precio, estado, n_bastidor)
                   VALUES('$razon', '$fecha', 0, '$direccion', '$precio', 0, '$n_bastidor')";
        
        $resultado = mysqli_query($conexion, $query);

        if($resultado == TRUE)
        {
            echo "Éxito en la insercción";
            header("refresh:2, url=main_admin.php");
        }
        else
        {
            echo "Error en la insercción";
            header("refresh=2, url=introducir_multa.php");
        }

    }
   


?>