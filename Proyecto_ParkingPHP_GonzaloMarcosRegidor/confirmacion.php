<html>
    <body>

        <?php
        session_start();
        $finalizar = $_POST['finalizar'];

        class Reservas {

            private $reservas = array();

            public function Agnadir($reserva) {
                array_push($this->reservas, $reserva);
            }

            public function getReservas() {
                return $this->reservas;
            }

        }

        $matricula = $_POST['matricula'];
        $fecha = $_POST['fecha'];
        $hinicio = $_POST['hinicio'];
        $hfinal = $_POST['hfinal'];
        $planta = $_POST['planta'];
        $plaza = $_POST['plaza'];

        $compMatricula = false;
        $compFecha = false;
        $comphentrada;
        $comphsalida;
        $compHoras = true;
        $compPlanta = false;
        $compPlaza = false;
        $reservaBaseDatos = false;
        $exisplaza = true;

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

        if ($finalizar == "Realizar otra Reserva") {
            $Reservas = new Reservas();
            $ReservasAux = new Reservas();
            $ReservasAux = $_SESSION['reservas'];

            if (count($ReservasAux) > 0) {
                $Reservas = clone $ReservasAux;
            }

            $contador = 0;
            for ($i = 0; $i < count($Reservas->getReservas()); ++$i) {
                $contador = 0;
                foreach ($Reservas->getReservas()[$i] as $posicion => $elemento) {
                    if ($contador == 0 && $elemento == $matricula) {
                        $compMatricula = true;
                    }if ($contador == 1 && $elemento == $fecha) {
                        $compFecha = true;
                    }if ($contador == 2) {
                        $comphentrada = $elemento;
                    }if ($contador == 3) {
                        $comphsalida = $elemento;
                        if ($hinicio < $comphentrada && $hfinal < $comphentrada) {
                            $compHoras = false;
                        }
                        if ($hinicio > $comphsalida) {
                            $compHoras = false;
                        }if ($hfinal == $comphentrada) {
                            $compHoras = true;
                        }if ($hinicio > $comphentrada && $hfinal < $comphsalida) {
                            $compHoras = true;
                        }if ($hinicio > $comphentrada && $hinicio < $comphsalida) {
                            $compHoras = true;
                        }
                    }if ($contador == 4 && $elemento == $planta) {
                        $compPlanta = true;
                    }if ($contador == 5 && $elemento == $plaza) {
                        $compPlaza = true;
                    }
                    if ($compFecha == true & $compHoras == true & $compPlanta == true & $compPlaza == true) {
                        echo "Reserva repetida";
                        break;
                    }
                    ++$contador;
                }
            }

            for ($u = $hinicio; $u <= $hfinal; $u++) {
                $result = mysql_query("select * from reserva where CodPlanta = '" . $planta . "' and Fecha = '" . $fecha . "' and HoraReserva = '" . $u . "' and Plaza = '" . $plaza . "'", $link);

                while ($row = mysql_fetch_array($result)) {
                    if ($row != null) {
                        $reservaBaseDatos = true;
                    }
                }
            }

            $result2 = mysql_query("select NumeroPlazas from planta where Codigo = '" . $planta . "'", $link);

            while ($row = mysql_fetch_array($result2)) {
                if ($plaza > $row['NumeroPlazas']) {
                    $exisplaza = false;
                }
            }

            if ($compFecha == true & $compHoras == true & $compPlanta == true & $compPlaza == true) {
                echo "Reserva repetida en la sesión";
            } else if ($reservaBaseDatos == true) {
                echo "Reserva repetida en la Base de datos";
            } else if ($exisplaza == false) {
                echo "La plaza no existe";
            } else if ($hinicio >= $hfinal) {
                echo "Horas no validas";
            } else {
                $reserva = array($matricula, $fecha, $hinicio, $hfinal, $planta, $plaza);
                $Reservas->Agnadir($reserva);

                $_SESSION['reservas'] = $Reservas;
                header('Location:' . getenv('HTTP_REFERER'));
            }
        }

        $Reservas = new Reservas();
        $ReservasAux = new Reservas();
        $ReservasAux = $_SESSION['reservas'];

        if (count($ReservasAux) > 0) {
            $Reservas = clone $ReservasAux;
        }

        $contador = 0;
        for ($i = 0; $i < count($Reservas->getReservas()); ++$i) {
            $contador = 0;
            foreach ($Reservas->getReservas()[$i] as $posicion => $elemento) {
                if ($contador == 0 && $elemento == $matricula) {
                    $compMatricula = true;
                }if ($contador == 1 && $elemento == $fecha) {
                    $compFecha = true;
                }if ($contador == 2) {
                    $comphentrada = $elemento;
                }if ($contador == 3) {
                    $comphsalida = $elemento;
                    if ($hinicio < $comphentrada && $hfinal < $comphentrada) {
                        $compHoras = false;
                    }
                    if ($hinicio > $comphsalida) {
                        $compHoras = false;
                    }if ($hfinal == $comphentrada) {
                        $compHoras = true;
                    }if ($hinicio > $comphentrada && $hfinal < $comphsalida) {
                        $compHoras = true;
                    }if ($hinicio > $comphentrada && $hinicio < $comphsalida) {
                        $compHoras = true;
                    }
                }if ($contador == 4 && $elemento == $planta) {
                    $compPlanta = true;
                }if ($contador == 5 && $elemento == $plaza) {
                    $compPlaza = true;
                }
                if ($compFecha == true & $compHoras == true & $compPlanta == true & $compPlaza == true) {
                    echo "Reserva repetida";
                    break;
                }
                ++$contador;
            }
        }

        for ($u = $hinicio; $u <= $hfinal; $u++) {
            $result = mysql_query("select * from reserva where CodPlanta = '" . $planta . "' and Fecha = '" . $fecha . "' and HoraReserva = '" . $u . "' and Plaza = '" . $plaza . "'", $link);

            while ($row = mysql_fetch_array($result)) {
                if ($row != null) {
                    $reservaBaseDatos = true;
                }
            }
        }

        $result2 = mysql_query("select NumeroPlazas from planta where Codigo = '" . $planta . "'", $link);

        while ($row = mysql_fetch_array($result2)) {
            if ($plaza > $row['NumeroPlazas']) {
                $exisplaza = false;
            }
        }

        if ($compFecha == true & $compHoras == true & $compPlanta == true & $compPlaza == true) {
            echo "Reserva repetida en la sesión";
        } else if ($reservaBaseDatos == true) {
            echo "Reserva repetida en la Base de datos";
        } else if ($exisplaza == false) {
            echo "La plaza no existe";
        } else if ($hinicio >= $hfinal) {
            echo "Horas no validas";
        } else {
            $reserva = array($matricula, $fecha, $hinicio, $hfinal, $planta, $plaza);
            $Reservas->Agnadir($reserva);
        }

        echo "<h1>Pantalla de pago</h1>";
        echo "<br>";
        echo "<table border='1'>";
        echo "<TR>";
        echo "<TD>Matricula</TD>";
        echo "<TD>Fecha</TD>";
        echo "<TD>Hora Inicio</TD>";
        echo "<TD>Hora Final</TD>";
        echo "<TD>Planta</TD>";
        echo "<TD>Plaza</TD>";
        echo "<TD>Precio</TD>";
        echo "</TR>";

        $contador2 = 0;
        $hinicioaux = 0;
        $hfinalaux = 0;
        $Precio2 = 0;
        $ImporteTotal = 0;
        $TotalPrecio2 = 0;
        for ($i = 0; $i < count($Reservas->getReservas()); $i++) {
            $contador2 = 0;
            echo "<TR>";
            foreach ($Reservas->getReservas()[$i] as $posicion => $elemento) {
                echo "<TD>" . $elemento . "</TD>";
                if ($contador2 == 2) {
                    $hinicioaux = $elemento;
                }if ($contador2 == 3) {
                    $hfinalaux = $elemento;
                }
                if ($contador2 == 4) {
                    $result = mysql_query("select Precio from planta where codigo='" . $elemento . "'", $link);
                    while ($row = mysql_fetch_array($result)) {
                        $Precio2 = $row["Precio"];
                    }
                }if ($contador2 == 5) {
                    $TotalPrecio2 = ($hinicioaux - $hfinalaux) * $Precio2;
                    echo "<TD>" . -$TotalPrecio2 . "</TD>";
                    $ImporteTotal = $ImporteTotal + $TotalPrecio2;
                    $TotalPrecio2 = 0;
                    $Precio2 = 0;
                }
                $contador2++;
            }
            echo "</TR>";
        }

        echo "</table>";

        $ImporteTotal = -$ImporteTotal;

        //echo $compHoras ? 'true' : 'false';

        echo "<br>";
        echo "<br>";

        echo "El Importe total a pagar sera: " . $ImporteTotal;

        mysql_close($link);

        $_SESSION['reservas'] = $Reservas;
        $_SESSION['ImporteTotal'] = $ImporteTotal       
        ?>

        <br>
        <br>

        <form id="realizarPago" action="https://www.sandbox.paypal.com/cgi-bin/webscr" method="post">
            <input name="cmd" type="hidden" value="_cart" />
            <input name="upload" type="hidden" value="1" />
            <input name="business" type="hidden" value="sb-uaji83783478@business.example.com" />
            <input name="currency_code" type="hidden" value="EUR" />
            <input name="return" type="hidden" value="http://localhost/user1/Proyecto_ParkingPHP_GonzaloMarcosRegidor/factura.php" />
            <input name="cancel_return" type="hidden" value="http://localhost/user1/Proyecto_ParkingPHP_GonzaloMarcosRegidor/index.php" />
            <input name="tax_rate" type="hidden" value="21.000" />
            <input name="item_name_1" type="hidden" value="Reserva Parking El Cañaveraaaaaal" />
            <input name="amount_1" type="hidden" value="<?php echo $_SESSION['ImporteTotal'] ?>" />

            <input type="image" src="https://www.sandbox.paypal.com/es_ES/ES/i/btn/btn_paynowCC_LG.gif" border="0" name="submit">
            <img alt="" border="0" src="https://www.sandbox.paypal.com/es_ES/i/scr/pixel.gif" width="1" height="1">
        </form>

    </body>
</html>

