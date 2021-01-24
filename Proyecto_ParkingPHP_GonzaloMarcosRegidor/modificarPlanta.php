<html>
    <body>

        <?php
        session_start();
        $codigo = $_POST['codigo'];        
        
        function Conectarse() {
            if (!($link = mysql_connect("localhost", "root", "root"))) {
                return 0;
            }
            if (!mysql_select_db("parking", $link)) {
                return 0;
            }
            return $link;
        }

        $link = Conectarse();

        $result = mysql_query("select * from planta where codigo='" . $codigo . "'", $link);

        $Nrecords = 1;
        $precio;
        $plazas;
        while ($row = mysql_fetch_array($result)) {
            $precio = $row["Precio"];
            $plazas = $row["NumeroPlazas"];
            $Nrecords++;
        }
                       
        echo "<table border='1'>";
        echo "<TR>";
        echo "<TD>Codigo: " . $codigo . "</TD>";
        echo "<TD>Plazas: " . $plazas . "</TD>";
        echo "<TD>Precio: " . $precio . "</TD>";
        echo "</TR>";
        echo "</table>";

        echo "<br>";
        echo "Modifica algo si lo deseas";
        echo "<br>";
        echo "<br>";       
        
        echo "<form action=".$_SERVER['PHP_SELF']." method='post'>";
            echo "<table border='1'>";
                echo "<TR>";
                    echo "<input id='Id' name='Id' type='hidden' value='$codigo'>";
                    echo "<TD>Plazas: <input type='text' name='plazas'></TD>";
                    echo "<TD>Precio: <input type='text' name='precio'></TD>";                    
                echo "</TR>";
            echo "</table>";            
            echo "<br>";
            echo "<input type='submit' value='Modificar Valores' name='modificar'>";
        echo "</form>";

        if (isset($_POST['modificar'])) {

            $precio1 = $_POST['precio'];
            $plazas1 = $_POST['plazas'];
            $codigo = $_POST['Id'];
            
            $resultado = mysql_query("UPDATE planta SET Precio = $precio1, NumeroPlazas = $plazas1 WHERE Codigo =$codigo", $link); 

            echo "Modificacion hecha correctamente";
            echo "<br>";
            echo "<a href='http://localhost/user1/Proyecto_ParkingPHP_GonzaloMarcosRegidor/index.php'>Volver a Inicio</a>";
            
            mysql_close($link);    
        }
        ?>
    </body>
</html>

