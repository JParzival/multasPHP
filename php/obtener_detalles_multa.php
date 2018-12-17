<?php
    session_start();
    ## Obtenemos la id de la multa de la pantalla anterior.

    $id_multa = isset($_POST['multa']) ? $_POST['multa'] : null;
    if (!$id_multa)
    {
        $id_multa = isset($_SESSION['id_multa']) ? $_SESSION['id_multa'] : null;
        if (!$id_multa)
        {
            header("location: main_infractor.php");
            return;
        }
    }
    
    include 'conexion_bd.php';
    
    $consulta = mysqli_query ($conexion, "SELECT fecha, razon, reclamada, direccion, precio, estado, n_bastidor FROM multas WHERE id = '$id_multa'");
    $nfilas = mysqli_num_rows($consulta);
    if ($nfilas == 0)
    {
        print("Excepción encontrando multa, ninguna encontrada");
        header("refresh: 5; url:../index.html");
        return;
    }

    if ($nfilas == 2)
    {
        print("Excepción encontrando multa, más de una encontrada");
        header("refresh: 5; url=../index.html");
    }

    ## Esto significa que lo hemos hecho bien y que por lo tanto ahora podremos recuperar los resultados de la consulta.
    $fila = mysqli_fetch_array($consulta);

    print("<b>Número Bastidor Multado: </b> ".$fila['n_bastidor']);

    print("<br> <b>Fecha: </b> ".$fila['fecha']);
    print("<br> <b>Razón: </b> ".$fila['razon']);
    print("<br> <b>Dirección: </b> ".$fila['direccion']);
    print("<br> <b>Precio: </b> ".$fila['precio']);

    switch($fila['reclamada'])
    {
        case 0:
            print("<br> <b>Reclamada: </b> No ha sido reclamada");
            break;
        case 1:
            print("<br> <b>Reclamada: </b> Ha sido reclamada");
            break;
        default:
            break;
    }

    switch($fila['estado'])
    {
        case 0: print("<br> <b>Estado: </b> No Pagado");
                break;
        case 1: print("<br> <b>Estado: </b> Procesando Pago");
                break;
        case 2:
            print("<br> <b>Estado: </b> Pagada");
            break;
        default:
            break;
    }

    if ($fila['estado'] == "2")
        print("<br><br> <form action=\"../formas_pago.html\" method=\"POST\" ENCTYPE=\"multipart/form-data\"> <input type=\"Submit\" value=\"Pagar\" disabled> </form>");
    else
        print("<br><br> <form action=\"../formas_pago.html\" method=\"POST\" ENCTYPE=\"multipart/form-data\"> <input type=\"Submit\" value=\"Pagar\"> </form>");
    
    if ($fila["reclamada"] == 0)
        print("<form action=\"procesar_reclamar_multa.php\" method=\"POST\" ENCTYPE=\"multipart/form-data\"> <input type=\"Submit\" value=\"Reclamar multa\"> </form>");
    else
        print("<form action=\"procesar_reclamar_multa.php\" method=\"POST\" ENCTYPE=\"multipart/form-data\"> <input type=\"Submit\" value=\"Reclamar multa\" disabled> </form>");

    $_SESSION['id_multa'] = $id_multa;
    printf("<a href='main_infractor.php'>Volver atrás</a>");
?>
