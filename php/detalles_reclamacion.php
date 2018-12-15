<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Reclamaciones</title>
</head>
<body>
        <?php
            session_start();

            if (!isset($_SESSION["credencial"]) || !isset($_SESSION["isAdmin"]))
            {
                header("location: ../login_admin.html");
                return;
            }
            
            include "buscar_datos_contacto_infractor.php";

            if ($datosContacto != null)
            {
                $dni = $datosContacto["credencial"];
                $nombre = $datosContacto["nombre"];
                $apellidos = $datosContacto["apellidos"];
                $tlf = $datosContacto["tlf"];
                $f_exp_carnet = $datosContacto["f_exp_carnet"];
                echo "DNI: $dni<br>";
                echo "Nombre: $nombre<br>";
                echo "Apellidos: $apellidos<br>";
                echo "Teléfono: $tlf<br>";
                echo "Fecha de expedición del carnet: $f_exp_carnet<br>";
            }
        ?> 
</body>
</html>
