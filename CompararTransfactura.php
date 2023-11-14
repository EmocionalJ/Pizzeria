<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Comparación de Pedidos Recibidos</title>
    <style>
        body {
            background-color: #a31919;
            font-family: Arial, sans-serif;
            color: #000;
            text-align: center;
            margin: 0;
            padding: 0;
        }
        h1 {
        font-size: 35px;
        text-shadow: 2px 2px 4px #000;
        color: #fff;
        }
         h2 {
         
            text-shadow: 2px 2px 4px #000;
        }
        h3 {
            color: #a31919;
            text-shadow: 2px 2px 4px #000;
        }
        a {
            text-decoration: none;
            color: #fff;
            font-weight: bold;
        }
        b {
            text-decoration: none;
            color: #fff;
            font-weight: bold;
        }
        b:hover {
            color: #000;
        }
        a:hover {
            color: #000;
        }
        .container {
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
            background-color: #fff;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            border-radius: 10px;
            min-height: 300px;
        }
        .table-container {
            margin-top: 50px;
            display: flex;
            justify-content: center;
        }
        table {
            border: 4px solid #000;
            border-collapse: collapse;
            width: 48%;
            background-color: #721111;
            color: #000;
            margin: 5px auto;
        }
        table td {
            padding: 10px;
            text-align: center;
        }
        img {
            width: 150px;
            display: block;
            margin: 25px auto;
            border: 5px solid #721111;
            border-radius: 100%;
        }

        .logout-button {
            position: fixed;
            bottom: 10px;
            left: 50%;
            transform: translateX(-50%);
            text-align: center;
            margin-top: 10px;
        }

        .logout-button button {
            background-color: #FF0000;
            color: #FFFFFF;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-weight: bold;
            text-transform: uppercase;
        }

        .logout-button button:hover {
            background-color: #FF5555;
        } input[type="submit"] {
            background-color: #FF0000;
            color: #FFFFFF;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-weight: bold;
            text-transform: uppercase;
        }
        .back-button {
        background-color: #a31919;
        color: #fff;
        padding: 10px 20px;
        border: none;
        border-radius: 5px;
        text-decoration: none;
        display: inline-block;
        font-weight: bold;
        text-transform: uppercase;
        }

        .back-button:hover {
        background-color: #FF0000;
        }
    </style>
</head>
<body>
<h1>Comparación de Pedidos Recibidos</h1>
    <div class="container">


        <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
            <label for="id_transfactura">Seleccionar ID Transfactura:</label>
            <select name="id_transfactura">
                <?php
                // Conexión a la base de datos
                $conexion = new mysqli('localhost', 'root', '', 'pizzeria');

                if ($conexion->connect_error) {
                    die("Error de conexión a la base de datos: " . $conexion->connect_error);
                }

                // Consulta para obtener la lista de ID de Transfactura
                $query = "SELECT id_transfactura FROM transfactura";
                $result = $conexion->query($query);

                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<option value='" . $row["id_transfactura"] . "'>" . $row["id_transfactura"] . "</option>";
                    }
                }

                $conexion->close();
                ?>
            </select>
            <br>
            <br>
            <input type="submit" value="Seleccionar Transfactura">
        </form>

        <?php
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $conexion = new mysqli('localhost', 'root', '', 'pizzeria');

            if ($conexion->connect_error) {
                die("Error de conexión a la base de datos: " . $conexion->connect_error);
            }

            // Obtén el ID de Transfactura seleccionado
            $id_transfactura = $_POST['id_transfactura'];

            // Consulta para obtener la información del producto
            $query = "SELECT id_transfactura, nombre, stock FROM transfactura WHERE id_transfactura = $id_transfactura";
            $result = $conexion->query($query);

            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
                $nombre_producto = $row["nombre"];

                // Mostrar la información del producto
                echo "<h2>Producto Seleccionado: <h3>$nombre_producto</h3></h2>";

                // Formulario para ingresar la cantidad recibida
                echo "<h2><form method='post' action='" . $_SERVER['PHP_SELF'] . "' onsubmit='return validarFormulario();'></h2>";
                echo "<h2><label for='cantidad_recibida'>Cantidad Recibida:</label></h2>";
                echo "<h2><input type='text' name='cantidad_recibida' id='cantidad_recibida' required pattern='^[1-9][0-9]*$' title='Por favor, ingrese una cantidad válida sin un 0 como primera cifra.'></h2>";
                echo "<h2><input type='hidden' name='id_transfactura' value='$id_transfactura'></h2>";
                echo "<h2><input type='submit' value='Comparar Pedido'></h2>";
                echo "</form>";
            } else {
                echo "No se encontró la Transfactura seleccionada.";
            }

            $conexion->close();
        }

        if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['cantidad_recibida'])) {
            // Conexión a la base de datos
            $conexion = new mysqli('localhost', 'root', '', 'pizzeria');

            if ($conexion->connect_error) {
                die("Error de conexión a la base de datos: " . $conexion->connect_error);
            }

            // Obtén los datos del formulario
            $cantidad_recibida = (int) $_POST['cantidad_recibida']; // Convertir a entero
            $id_transfactura = $_POST['id_transfactura'];

            // Consulta para obtener la cantidad pedida
            $query = "SELECT stock FROM transfactura WHERE id_transfactura = $id_transfactura";
            $result = $conexion->query($query);

            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
                $cantidad_pedida = (int) $row["stock"]; 

                // Calcula la diferencia
                $diferencia = $cantidad_recibida - $cantidad_pedida;

                // Comprueba si la cantidad recibida es mayor o menor
                if ($diferencia > 0) {
                    $mensaje_diferencia = "Usted ha recibido $diferencia unidades más de las solicitadas. Verifíquelo con el proveedor.";
                } elseif ($diferencia < 0) {
                    $mensaje_diferencia = "Usted ha recibido " . abs($diferencia) . " unidades menos de las solicitadas. Verifíquelo con el proveedor.";
                } else {
                    $mensaje_diferencia = "La cantidad recibida coincide con la cantidad pedida.";
                }

                // Mostrar la diferencia
                echo "<h2>Comparación de Pedido</h2>";
                echo "<p>Producto: $nombre_producto</p>";
                echo "<p>Cantidad Pedida: $cantidad_pedida</p>";
                echo "<p>Cantidad Recibida: $cantidad_recibida</p>";
                echo "<p>Diferencia: $mensaje_diferencia";
            }

            $conexion->close();
        }
        ?>
        
    </div>
    <br><center>
        <a href="MenuBodeguero.php" class="back-button">Volver</a>

</body>
</html>