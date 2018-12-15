<!DOCTYPE html>
<html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title>Pago Realizado</title>

        <link href="../css/pago_satisfactorio.css" rel="stylesheet">
    </head>
    
    <body>

        <?php

            echo("<br> <h1 id=\"h1\"> Pago Realizado Satisfactoriamente!</h1> ");

            header("refresh: 3; url=main_infractor.php");

            ?>
    </body>
</html>