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
            <th scope="col">Id</th>
            <th scope="col">Contacto</th>
            <th scope="col">Detalles</th>
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

            foreach ($arrayMultas as $multa)
            {
                $idMulta = $multa["idMulta"];

                echo "<th scope='row'>$idMulta</th>";
                echo "<td>";
                echo "  <form action='detalles_reclamacion.php' method='POST' ENCTYPE='multipart/form-data'>";
                echo "    <input type='hidden' name='recMulta' value='$idMulta'>";
                echo "    <input class='btn btn-primary' type='submit' value='Detalles reclamacion'>";
                echo "  </form>";
                echo "</td>";
                echo "<td>";
                echo "  <form action='detalles_multa_admin.php' method='POST' ENCTYPE='multipart/form-data'>";
                echo "    <input type='hidden' name='detMulta' value='$idMulta'>";
                echo "    <input class='btn btn-primary' type='submit' value='Detalles multa'>";
                echo "  </form>";
                echo "</td>";
                echo "</tr>";
            }
        ?>
        </tbody>
    </table>
    
</body>
</html>
