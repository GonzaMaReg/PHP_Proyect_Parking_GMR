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

        echo "<form action=".$_SERVER['PHP_SELF']." method='post'>";
            echo "<table border='1'>";
                echo "<TR>";
                    echo "<TD>Codigo: <input id='Id' type='text' name='codigo'></TD>";
                    echo "<TD>Plazas: <input type='text' name='plazas'></TD>";
                    echo "<TD>Precio: <input type='text' name='precio'></TD>";                    
                echo "</TR>";
            echo "</table>";            
            echo "<br>";
            echo "<input type='submit' value='Añadir planta' name='modificar'>";
        echo "</form>";

        if (isset($_POST['modificar'])) {

            $precio1 = $_POST['precio'];
            $plazas1 = $_POST['plazas'];
            $codigo = $_POST['codigo'];
            
            $resultado = mysql_query("INSERT INTO planta VALUES ('$codigo', '$precio1', '$plazas1');", $link); 

            echo "Planta añadida correctamente";
            echo "<br>";
            echo "<a href='http://localhost/user1/Proyecto_ParkingPHP_GonzaloMarcosRegidor/index.php'>Volver a Inicio</a>";
            
            mysql_close($link);    
        }
        ?>
    </body>
</html>

