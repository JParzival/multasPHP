<?php

    $nombre_titular = $_SERVER['nombre_titular'];
    $fecha_caducidad = $_SERVER['fecha_caducidad'];
    $numero_tarjeta = $_SERVER['numero_tarjeta'];
    $cvv = $_SERVER['CVV'];

    if(length($cvv) != 3)
    {
        print("CVV incorrecto");
    }
    if(length($numero_tarjeta) != 20)
    {
        print("Número Tarjeta Incorrecto");
    }

    header("url=pago_realizado.php");

?>

