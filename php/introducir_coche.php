<?php
    session_start();

    function mostrarFormulario()
    {
        $color = isset($_SESSION["ncColor"]) ? $_SESSION["ncColor"] : "";
        $matricula = isset($_SESSION["ncMatricula"]) ? $_SESSION["ncMatricula"] : "";
        $numeroBastidor = isset($_SESSION["ncNumeroBastidor"]) ? $_SESSION["ncNumeroBastidor"] : "";
        $año = isset($_SESSION["ncAno"]) ? $_SESSION["ncAno"] : "";
        $potencia = isset($_SESSION["ncPotencia"]) ? $_SESSION["ncPotencia"] : "";

        $formulario = <<<FORM

        <form action="introducir_coche.php" method="POST" enctype="application/x-www-form-urlencoded">
        
            Color: <input type="text" name="color" value="$color">
            <br>
            Matrícula: <input type="text" name="matricula" value="$matricula">
            <br>
            Número Bastidor: <input type="number" name="numeroBastidor" value="$numeroBastidor">
            <br>
            Año: <input type="number" name="ano" value="$año">
            <br>
            Potencia (Caballos): <input type="number" name="potencia" value="$potencia">
            <br>

            <input type="submit" value="Registrar Coche">

        </form>
FORM;

        echo $formulario;
    }

    if ($_SERVER["REQUEST_METHOD"] != "POST")    # En este caso tenemos que mostrar el formulario
    {
        mostrarFormulario();
    }
    else	# En este caso validamos datos e insertamos
    {
        $credencial = isset($_SESSION["credencial"]) ? $_SESSION["credencial"] : null;
        if ($credencial == null)
        {
            header("location: ../login_infractor.html");
            return;
        }

        # Lo primero es validar datos
        $color = isset($_POST["color"]) ? $_POST["color"] : null;
        $matricula = isset($_POST["matricula"]) ? $_POST["matricula"] : null;
        $numeroBastidor = isset($_POST["numeroBastidor"]) ? $_POST["numeroBastidor"] : null;
        $año = isset($_POST["ano"]) ? $_POST["ano"] : null;
        $potencia = isset($_POST["potencia"]) ? $_POST["potencia"] : null;

        if ($color == null || $matricula == null || $numeroBastidor == null || $año == null ||
            $potencia == null)
        {
            echo "No se han introducido todos los datos requeridos.";
            return;
        }

        $_SESSION["ncColor"] = $color;
        $_SESSION["ncMatricula"] = $matricula;
        $_SESSION["ncNumeroBastidor"] = $numeroBastidor;
        $_SESSION["ncAno"] = $año;
        $_SESSION["ncPotencia"] = $potencia;

        $error = false;

        #Comprobamos matrícula
        if (preg_match("/[[:digit:]]{4} [[:alpha:]]{3}/", $matricula) != 1 &&
            preg_match("/[[:alpha:]]{1} [[:digit:]]{4} [[:alpha:]]{2}/", $matricula) != 1 &&
            preg_match("/[[:alpha:]]{2} [[:digit:]]{4} [[:alpha:]]{1}/", $matricula) != 1)
        {
            print("La matrícula introducida no es correcta.<br>");
            $_SESSION["ncMatricula"] = null;
            $error = true;
        }

        $matricula = strtoupper($matricula);

        # Comprobamos color
        if (preg_match("~[0-9]~", $color) == 1)
        {
            print("El color introducido no es valido.<br>");
            $_SESSION["ncColor"] = null;
            $error = true;
        }

        # Comprobamos número de bastidor
        if (preg_match("~[0-9]~", $numeroBastidor) != 1)
        {
            print("El numero de bastidor introducido no es valido.<br>");
            $_SESSION["ncNumeroBastidor"] = null;
            $error = true;
        }

        # Comprobar año
        if (preg_match("/[0-9]{4}/", $año) != 1)
        {
            print("El año debe de ser un número de 4 cifras.<br>");
            $_SESSION["ncAno"] = null;
            $error = true;
        }

        # Comprobar caballos
        if (strlen($potencia) < 2 || strlen($potencia) > 4)
        {
            print("La potencia debe de estar entre 10 y 9999 caballos");
            $_SESSION["ncPotencia"] = null;
            $error = true;
        }

        if ($error)
        {
            echo "<br>";
            mostrarFormulario();
            return;
        }

        # Ahora todos los datos están validados, vamos con la insercción
        include "conexion_bd.php";

        $query = "INSERT INTO coches (n_bastidor, matricula, `year`, color, potencia_cv, credencial)
                             VALUES  ($numeroBastidor, '$matricula', $año, '$color', $potencia, '$credencial')";

        $consulta = mysqli_query($conexion, $query);

        if ($consulta)
        {
            echo "Coche $numeroBastidor introducido correctamente!";
            header("refresh: 5; url=main_infractor.php");

            // Limpiamos las variables
            $_SESSION["ncColor"] = null;
            $_SESSION["ncMatricula"] = null;
            $_SESSION["ncNumeroBastidor"] = null;
            $_SESSION["ncAno"] = null;
            $_SESSION["ncPotencia"] = null;
        }
        else
        {
            echo mysqli_error($conexion);
            echo "El coche no ha podido ser introducido.";
            header("refresh: 5; url=introducir_coche.php");
        }
    }
?>
