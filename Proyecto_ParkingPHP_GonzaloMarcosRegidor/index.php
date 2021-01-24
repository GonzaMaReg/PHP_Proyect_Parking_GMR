<html>
    <body>
        <?php 
            session_start();
            unset($_SESSION);
            session_destroy();
        ?>
        <h1>Parking El Cañaveraaaal</h1>
        <br>
        <h2>¿Como le gustaria iniciar sesión?</h2>
        <br>
        <form action="propietario.php" method="post">
            <p>
                Como Propietario: <input type="submit" value="Propietario" name="enviar">
            </p>
        </form>
        <form action="cliente.php" method="post">
            <p>
                Como Cliente: <input type="submit" value="Cliente" name="enviar">
            </p>
        </form>
    </body>
</html>

