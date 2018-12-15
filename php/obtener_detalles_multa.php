<?php

    ## Obtenemos la id de la multa de la pantalla anterior.

    $id_multa = isset($_POST['multa']) ? $_POST['multa'] : null;
    
    include 'conexion_bd.php';
    
    $consulta = mysqli_query ($conexion, "SELECT fecha, razon, reclamada, direccion, precio, estado, n_bastidor FROM multas WHERE id = '$id_multa'");
    $nfilas = mysqli_num_rows($consulta);
    
    if ($nfilas == 0)
    {
        print("Excepción encontrando multa, ninguna encontrada");
        header("refresh: 3; url:../index.html");
        
    }

    if($nfilas == 2)
    {
        print("Excepción encontrando multa, más de una encontrada");
        header("refresh: 3; url=../index.html");
    }

    ## Esto significa que lo hemos hecho bien y que por lo tanto ahora podremos recuperar los resultados de la consulta.

    $i = 0;
    for($i; $i < $nfilas; $i++)
    {
        $fila = mysqli_fetch_array($consulta);

        print("<b>Número Bastidor Multado: </b> ".$fila['n_bastidor']);

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
        
    }

    print("<br> <form action=\"../formas_pago.html\" method=\"POST\" ENCTYPE=\"multipart/form-data\"> <input type=\"Submit\" value=\"Pagar\" > </form>");

    $_SESSION['id_multa'] = $id_multa;
    

?>    