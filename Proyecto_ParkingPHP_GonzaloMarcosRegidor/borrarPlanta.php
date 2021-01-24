<html>
    <body>
        <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
            <h2>Seleccione planta a borrar</h2>
            <p>
                <?php

                function Conectarse() {
                    if (!($link = mysql_connect("localhost", "root", "root"))) {
                        echo "algo a salido mal";
                        return 0;
                    }
                    if (!mysql_select_db("parking", $link)) {
                        return 0;
                    }
                    return $link;
                }

                $link = Conectarse();


                $result = mysql_query("select codigo from Planta", $link);

                $Nrecords = 1;
                echo "<select name = 'codigo'>";
                while ($row = mysql_fetch_array($result)) {
                    $mat = $row["codigo"];
                    echo "<option value = '$mat'>" . $row["codigo"] . "</option>";
                    $Nrecords++;
                }
                echo "</select>"
                ?>        
            </p>

            <p>
                Procesar: <input type="submit" value="Seleccionar planta" name="enviar">
            </p>

        </form>

        <?php
        if (isset($_POST['enviar'])) {
            $borrar = mysql_query("delete from Planta where codigo='".$_POST['codigo']."'", $link);
            
            echo "Planta" . $_POST['codigo'] . "Borrada";
            
            echo "<br>";
            echo "<a href='http://localhost/user1/Proyecto_ParkingPHP_GonzaloMarcosRegidor/index.php'>Volver a Inicio</a>";
        }
        ?>
    </body>
</html>

