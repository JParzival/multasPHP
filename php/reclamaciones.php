<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Reclamaciones</title>
</head>
<body>

    <table class="table mt-4">
        <thead>
        <tr>
            <th scope="col">#</th>
            <th scope="col">Fecha</th>
            <th scope="col">Razón</th>
            <th scope="col">Lugar</th>
            <th scope="col">Precio</th>
            <th scope="col">Acciones</th>
        </tr>
        </thead>
        <tbody>
        <?php
            session_start();

            if (!isset($_SESSION["credencial"]) || !isset($_SESSION["isAdmin"]))
            {
                header("location: ../login_admin.html");
                return;
            }
            
            include "obtener_reclamaciones.php";

            $nrow = 0;
            foreach ($arrayMultas as $multa)
            {
                ++$nrow;
                $idMulta = $multa["idMulta"];
                $razon = $multa["razon"];
                $fecha = $multa["fecha"];
                //$reclamada = $multa["reclamada"];
                $precio = $multa["precio"];
                //$estado = $multa["estado"];
                //$nbastidor = $multa["n_bastidor"];
                $direccion = $multa["direccion"];

                echo "<th scope='row'>$nrow</th>";
                echo "<td>$fecha</td>";
                echo "<td>$razon</td>";
                echo "<td>$direccion</td>";
                echo "<td>$precio €</td>";
                echo "<td>";
                echo "  <form action='detalles_reclamacion.php' method='POST' ENCTYPE='multipart/form-data'>";
                echo "    <input type='hidden' name='multa' value='$idMulta'>";
                echo "    <input class='btn btn-primary' type='submit' value='Detalles reclamacion'>";
                echo "  </form>";
                echo "</td>";
                echo "</tr>";
            }
        ?>
        </tbody>
    </table>
    
</body>
</html>
