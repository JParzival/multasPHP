<?php
    session_start();

    if (!isset($_SESSION["credencial"]) || !isset($_SESSION["isAdmin"]))
    {
        header("location: ../login_admin.html");
        return;
    }

    ## Obtenemos la id de la multa de la pantalla anterior.

    $id_multa = isset($_POST['detMulta']) ? $_POST['detMulta'] : null;
    if ($id_multa == null)
    {
        header("location: main_administrador.php");
        return;
    }
    
    echo "<b>Id multa:</b> $id_multa<br>";
    include 'conexion_bd.php';
    
    $consulta = mysqli_query ($conexion, "SELECT fecha, razon, reclamada, direccion, precio, estado, matricula, credencial FROM multas WHERE id = '$id_multa'");
    $nfilas = mysqli_num_rows($consulta);
    
    if ($nfilas == 0)
    {
        print("Excepción encontrando multa, ninguna encontrada");
        header("refresh: 5; url:../index.html");
        return;
    }

    ## Esto significa que lo hemos hecho bien y que por lo tanto ahora podremos recuperar los resultados de la consulta.
    $fila = mysqli_fetch_array($consulta);

    print("<b>Matrícula multada: </b> ".$fila['matricula']);
    print("<br><b>Infractor: </b> ".$fila['credencial']);

    print("<br> <b>Fecha: </b> ".$fila['fecha']);
    print("<br> <b>Razón: </b> ".$fila['razon']);
    print("<br> <b>Dirección: </b> ".$fila['direccion']);
    print("<br> <b>Precio: </b> ".$fila['precio']);

    switch($fila['reclamada'])
    {
        case 0: print("<br> <b>Reclamada: </b> No ha sido reclamada");
                break;
        case 1: print("<br> <b>Reclamada: </b> Ha sido reclamada");
                break;
    }

    switch($fila['estado'])
    {
        case 0: print("<br> <b>Estado: </b> No Pagado");
                break;
        case 1: print("<br> <b>Estado: </b> Procesando Pago");
                break;
        case 2: print("<br> <b>Estado: </b> Pagada");
                break;
    }

    echo "<br>";
    include "detalles_reclamacion.php";
    
    if ($fila['reclamada'] == "1")
    {
        $formulario1 = <<<FORM
        <br><br>
        <form action="procesar_reclamacion_admin.php" method="POST" ENCTYPE="multipart/form-data">
            <input type="hidden" name="idMulta" value="$id_multa"/>
            <input type="hidden" name="accion" value="1"/>
            <input type="submit" value="Rechazar reclamacion"/>
        </form>
FORM;

        $formulario2 = <<<FORM2
        
        <form action="procesar_reclamacion_admin.php" method="POST" ENCTYPE="multipart/form-data">
            <input type="hidden" name="idMulta" value="$id_multa"/>
            <input type="hidden" name="accion" value="2"/>
            <input type="submit" value="Aceptar reclamación, borrar multa"/>
        </form>
FORM2;

        echo $formulario1;
        echo $formulario2;
    }
?>
