<?php

    if($_SERVER["REQUEST_METHOD"] != "POST")    # Mostrar el formulario
    {
        $formulario = <<<FORM

        <form action="eliminarMulta.php" method="POST" enctype='multipart/form-data'/>

            ID Multa: <input type="number" name="idMulta">
            <br>
            Credencial Usuario Multado: <input type="text" name="credencial"/>
            <br>

            <input type="submit" value="Eliminar"/>

        </form>


FORM;
        echo "$formulario";

    }
    else	# Comprobar datos y eliminar
    {
        $idMulta = trim($_POST["idMulta"]);
        $credencial = trim($_POST["credencial"]);

        if(!preg_match("/. [[:num:]]+/", $idMulta) == 1)
        {
            echo "La ID de la multa tiene que estar formada por números";
            header("refresh: 3, url=eliminarMulta.php");
        }

        $credencial = strtoupper($credencial);

        if(!preg_match("/. [[:num:]]{8}[[:alpha:]]{1} /", $credencial) == 1)
        {
            echo "El credencial $credencial tiene que estar formado por 8 números y 1 letra";
        }
        
        # Ahora los datos han sido validados, tenemos que eliminar la multa en caso de que exista

        $query = "DELETE FROM multas WHERE id = $idMulta AND credencial = '$credencial'";

        $consulta = ($conexion, $query);

        if($consulta)
        {
            echo "La multa $idMulta ha sido eliminada!";
            header("refresh: 3, url=main_admin.php");
        }
        else
        {
            echo "La multa $idMulta no ha podido ser eliminada!";
            header("refresh: 2, url=eliminarMulta.php");
        }
    }