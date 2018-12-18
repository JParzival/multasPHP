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
            if ($id_multa == null)
            {
                header("location: ../login_admin.html");
                return;
            }

            if (!isset($_SESSION["credencial"]) || !isset($_SESSION["isAdmin"]))
            {
                header("location: ../login_admin.html");
                return;
            }
            
            include "conexion_bd.php";
            $resultado = mysqli_query($conexion, "SELECT i.credencial, nombre, apellidos, tlf, f_exp_carnet FROM infractor i LEFT JOIN multas m ON m.credencial = i.credencial WHERE m.id = $id_multa");
            $nfilas = mysqli_num_rows($resultado);
            if ($nfilas != 0)
                $datosContacto = mysqli_fetch_array($resultado);
            else
                echo "No se ha encontrado la multa con id: $idMulta";

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
