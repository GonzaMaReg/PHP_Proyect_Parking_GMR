<html>
    <body>
        <h1>Realice Reserva</h1>
         <form action="confirmacion.php" method="post">            
                Escriba Matricula del vehiculo (ej: 1234ABC): <input type="text" name="matricula" required>
                <br>
                <br>                
                Escriba fecha (ej: YYYY-MM-DD): <input type="text" name="fecha" required>
                <br>
                <br>
                Seleccione hora de inicio de reserva (ej: 00): <input type="text" name="hinicio" required>
                Seleccione hora de final de reserva (ej: 23): <input type="text" name="hfinal" required>
                <br>
                <br> 
                
                <?php
                function Conectarse() {
                    if (!($link = mysql_connect("localhost", "root", "root"))) {
                        return 0;
                    }
                    if (!mysql_select_db("Parking", $link)) {
                        return 0;
                    }
                    return $link;
                }

                $link = Conectarse();

                $result = mysql_query("select codigo from planta", $link);

                $Nrecords = 1;
                echo "Seleccione Planta: <select name = 'planta'> required";
                while ($row = mysql_fetch_array($result)) {
                    $mat = $row["codigo"];
                    echo "<option value = '$mat'>" . $row["codigo"] . "</option>";
                    $Nrecords++;
                }
                echo "</select>"
                ?>
                
                <br>
                <br>               
                Seleccione Plaza: <input type="text" name="plaza" required>
                <br>
                <br>
                <input type="submit" value="Realizar otra Reserva" name="finalizar">
                <input type="submit" value="Finalizar Reserva" name="finalizar">              
        </form>
    </body>
</html>

