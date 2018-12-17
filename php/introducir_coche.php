<?php

    if($_SERVER["REQUEST_METHOD"] != "POST")    # En este caso tenemos que mostrar el formulario
    {
        $formulario = <<<FORM

        <form action="introducir_coche.php" method="POST" enctype="application/x-www-form-urlencoded">
        
            Color: <input type="text" name="color">
            <br>
            Matrícula: <input type="text" name="matricula">
            <br>
            Número Bastidor: <input type="number" name="numeroBastidor">
            <br>
            Año: <input type="number" name="ano">
            <br>
            Potencia (Caballos): <input type="number" name="potencia">
            <br>

            <input type="submit" value="Registrar Coche">

        </form>
FORM;

        echo "$formulario";
    }
    else	# En este caso validamos datos e insertamos
    {
        # Lo primero es validar datos

        $color = trim($_POST["color"]);
        $matricula = trim($_POST["matricula"]);
        $numeroBastidor = trim($_POST["numeroBastidor"]);
        $año = trim($_POST["ano"]);
        $potencia = trim($_POST["potencia"]);

        #Comprobamos matrícula

        if(!preg_match("/.[[:num:]]{4}[[::alpha::]]{3}/", $matricula) == 1 || !preg_match("/.[[:alpha:]]{1}[[::num::]]{4}[[:alpha::]]{2}/", $matricula) == 1 ||  !preg_match("/.[[:alpha:]]{2}[[::num::]]{4}[[:alpha::]]{1}/", $matricula) == 1)
        {
            print("La matrícula $matricula no es correcta");
            header("refresh:2, url=introducir_coche.php");
        }
        $matricula = strtoupper($matricula);

        # Comprobamos color

        if(!preg_match("/. [[:alpha::]]+/", $color) == 1)
        {
            print("El color debe de ser todo letras || No puede ser null");
            header("refresh:3, url=introducir_coche.php");
        }

        # Comprobamos número de bastidor

        if(!preg_match("/. [[:num::]]+/", $numeroBastidor) == 1)
        {
            print("El número de bastidor debe de ser todo números || No puede ser null");
            header("refresh:3, url=introducir_coche.php");
        }

        # Comprobar año

        if(!preg_match("/. [[:num::]]{4}/", $año) == 1)
        {
            print("El año debe de ser un número de 4 cifras");
            header("refresh:3, url=introducir_coche.php");
        }

        # Comprobar caballos

        if(strlen($potencia) < 2 || strlen($potencia) > 4)
        {
            print("La potencia debe de estar entre 10 y 9999 caballos");
            header("refresh:3, url=introducir_coche.php");
        }


        # Ahora todos los datos están validados, vamos con la insercción

        include "conexion_bd.php";

        $credencial = $_SESSION["user"];
        if($credencial == NULL)
        {
            header("location:login.php");
        }

        $query = "INSERT INTO coches (n_bastidor, matricula, year, color, potencia_cv, credencial)
                             VALUES  ($numeroBastidor, '$matricula', $año, '$color', $potencia, '$credencial')";

        $consulta = mysqli_query($conexion, $query);

        if($consulta)
        {
            echo "Coche $numeroBastidor introducido correctamente!";
            header("refresh: 2, url=introducir_coche.php");
        }
        else
        {
            echo "El coche no ha podido ser introducido";
            header ("refresh: 2, url=introducir_coche.php");
            mysqli_close();
        }

    }

?>