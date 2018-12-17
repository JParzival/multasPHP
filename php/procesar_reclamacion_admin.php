<?php
    session_start();

    if (!isset($_SESSION["credencial"]) || !isset($_SESSION["isAdmin"]))
    {
        header("location: ../login_admin.html");
        return;
    }

    ## Obtenemos la id de la multa de la pantalla anterior.

    $idMulta = isset($_POST['idMulta']) ? $_POST['idMulta'] : null;
    $accion = isset($_POST['accion']) ? $_POST['accion'] : null;
    if ($idMulta == null)
    {
        header("location: main_administrador.php");
        return;
    }

    if ($accion == null || ($accion != 1 && $accion != 2))
    {
        header("location: main_administrador.php");
        return;
    }

    include "conexion_bd.php";

    if ($accion == 1)
    {
        $query = "UPDATE multas SET reclamada = 0 WHERE id = $idMulta";
        $result = mysqli_query($conexion, $query);
    }
    else
    {
        $query = "DELETE FROM multas WHERE id = $idMulta";
        $result = mysqli_query($conexion, $query);
    }

    if ($result)
    {
        if ($accion == 1)
            echo "Se ha rechazado la reclamacion de la multa correctamente, seras redireccionado en breve.";
        else
            echo "Se ha borrado la multa corretamente, seras redireccionado en breve.";

        header("refresh: 5; url=main_admin.php");
    }
    else
    {
        echo mysqli_error($conexion);
        echo "<br>Error al procesar la operación.";
        header("refresh: 5; url=main_administrador.php");
    }
?>
