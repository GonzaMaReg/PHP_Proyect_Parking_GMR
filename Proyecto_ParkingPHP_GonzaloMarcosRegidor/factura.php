<?php
session_start();

class Reservas {

    private $reservas = array();

    public function Agnadir($reserva) {
        array_push($this->reservas, $reserva);
    }

    public function getReservas() {
        return $this->reservas;
    }

}

$Reservas = new Reservas();
$Reservas = clone $_SESSION['reservas'];

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

$matricula;
$fecha;
$hinicio;
$hfinal;
$planta;
$plaza;

$contadorReservas = 0;

for ($i = 0; $i < count($Reservas->getReservas()); ++$i) {
    $contadorReservas++;
    $contador = 0;
    foreach ($Reservas->getReservas()[$i] as $posicion => $elemento) {
        if ($contador == 0) {
            $matricula = $elemento;
        }if ($contador == 1) {
            $fecha = $elemento;
        }if ($contador == 2) {
            $hinicio = $elemento;
        }if ($contador == 3) {
            $hfinal = $elemento;
        }if ($contador == 4) {
            $planta = $elemento;
        }if ($contador == 5) {
            $plaza = $elemento;
            for ($u = $hinicio; $u < $hfinal; $u++) {
                $consulta = "INSERT INTO reserva VALUES ('".$matricula."', '".$planta."', '".$fecha."', '".$u."', '".$plaza."');";
                $resultado = mysql_query($consulta, $link);
            }
            $matricula = 0;
            $fecha = 0;
            $hinicio = 0;
            $hfinal = 0;
            $planta = 0;
            $plaza = 0;
        }
        ++$contador;
    }
}
$_SESSION['numres'] = $contadorReservas;
mysql_close($link);
?>
<html>
    <body>
        <h1>Factura</h1>
        <h3>Parking El Cañaveraaaaaal</h3>
        <h4>Telefono: 123456789</h4>
        <h4>Ciudad: Marbella de la Encomienda</h4>

        <br>
        <br>
        <br>

        <table border='1'>
            <TR>
                <TD>Numero Factura</TD>
                <TD>Fecha</TD>
                <TD>Concepto</TD>
                <TD>Cantidad Reservas</TD>
                <TD>Importe Total</TD>
            </TR>
            <TR>
                <TD>0001</TD>
                <TD><?php date_default_timezone_set('UTC'); $hoy = date("j, n, Y"); echo $hoy; ?></TD>
                <TD>Aparcando en el Cañaveraaaal</TD>
                <TD><?php echo $_SESSION['numres']; ?></TD>
                <TD><?php echo $_SESSION['ImporteTotal']; ?></TD>
            </TR>
        </table> 
        <br>
        <br>
        <?php
        $Importe = $_SESSION['ImporteTotal'];
        $iva = $Importe * 0.21;
        $total = $iva + $Importe;
        echo "<h4>Total a pagar de IVA(21%): " . $iva . "<h4>";
        echo "<h4>Total a pagar con iva: " . $total . "<h4>";
        ?>
        
        <a href='http://localhost/user1/Proyecto_ParkingPHP_GonzaloMarcosRegidor/index.php'>Volver a Inicio</a>
    </body>
</html>

