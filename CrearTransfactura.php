<!DOCTYPE html>
<html>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Comparación de Pedidos Recibidos</title>
    <style>
    body {
        background-color: #a31919;
        font-family: Arial, sans-serif;
        color: #fff; /* Cambiado a blanco */
        text-align: center;
        margin: 0;
        padding: 0;
    }
    h1 {
        font-size: 35px;
        text-shadow: 2px 2px 4px #000;
    }
    h2 {
        color: #fff; /* Cambiado a blanco */
        text-shadow: 2px 2px 4px #000;
    }
    h3 {
        color: #a31919;
        text-shadow: 2px 2px 4px #000;
    }
    a {
        text-decoration: none;
        color: #fff; /* Cambiado a blanco */
        font-weight: bold;
    }
    b {
        text-decoration: none;
        color: #fff; /* Cambiado a blanco */
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
        background-color: ##ba3d3d;
        color: #fff; /* Cambiado a blanco */
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
        color: #fff; /* Cambiado a blanco */
        padding: 10px 20px;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        font-weight: bold;
        text-transform: uppercase;
    }

    .logout-button button:hover {
        background-color: #FF5555;
    }
    input[type="submit"] {
        background-color: #FF0000;
        color: #fff; /* Cambiado a blanco */
        padding: 10px 20px;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        font-weight: bold;
        text-transform: uppercase;
    }
    .back-button {
    background-color: #a31919;
    color: #fff; /* Cambiado a blanco */
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
<script type="text/javascript">
        function ValidaSoloNumeros(event) {
            if (event.keyCode < 48 || event.keyCode > 57) {
                event.returnValue = false;
            }
        }

        function ValidaSoloLetras(event) {
            if ((event.keyCode !== 32) && (event.keyCode < 65 || event.keyCode > 90) && (event.keyCode < 97 || event.keyCode > 122)) {
                event.returnValue = false;
            }
        }
    </script>
</head>
<body>
    <h1>Registro de Materiales Transfactura</h1>

    <form method="post" action="procesar_registro3.php">
        <table border="1">
            <tr>
                <th>Producto</th>
                <th>Acción</th>
            </tr>
            <?php
            // Conexión a la base de datos
            $conexion = new mysqli('localhost', 'root', '', 'pizzeria');

            if ($conexion->connect_error) {
                die("Error de conexión a la base de datos: " . $conexion->connect_error);
            }

            // Consulta para obtener la lista de productos desde la tabla productos_bodega
            $query = "SELECT id_producto_bodega, nombre FROM productos_bodega";
            $result = $conexion->query($query);

            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . $row["nombre"] . "</td>";
                    echo "<td>";
                    echo "<input type='number' name='cantidad[" . $row["id_producto_bodega"] . "]' min='0' value='0'>";
                    echo "</td>";
                    echo "</tr>";
                }
            }

            $conexion->close();
            ?>
        </table>

        <label for="bodega_recibida">Bodega Recibida:</label>
        <input type="text" name="bodega_recibida" id="bodega_recibida" onkeypress="ValidaSoloNumeros(event)" required>
        <br>
        <br>
        <input type="submit" value="Registrar Material">
    </form>
    <?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Conexión a la base de datos
    $conexion = new mysqli('localhost', 'root', '', 'pizzeria');

    if ($conexion->connect_error) {
        die("Error de conexión a la base de datos: " . $conexion->connect_error);
    }

    // Obtén los datos del formulario
    $cantidad = $_POST['cantidad'];
    $bodega_recibida = $_POST['bodega_recibida'];

    // Verificar si al menos un material ha sido seleccionado
    $materialesSeleccionados = array_filter($cantidad, function ($cantidad_valor) {
        return intval($cantidad_valor) > 0;
    });

    if (empty($materialesSeleccionados)) {
        echo "Debes seleccionar al menos un material antes de registrar.";
    } else {
        foreach ($materialesSeleccionados as $id_material => $cantidad_valor) {
            // Insertar en la tabla transfactura
            $query = "INSERT INTO transfactura (id_producto_t, nombre, precio_producto, stock, bodega_recibida, fecha, hora) 
                      SELECT id_producto_bodega, nombre, precio_producto, $cantidad_valor, $bodega_recibida, CURDATE(), CURTIME() 
                      FROM productos_bodega 
                      WHERE id_producto_bodega = $id_material";

            $resultado = $conexion->query($query);

            if ($resultado) {
                $id_transfactura = $conexion->insert_id; // Obtener el id_transfactura generado

                // Ahora, consulta el producto asociado al número de Transfactura
                $query_material = "SELECT nombre FROM productos_bodega WHERE id_producto_bodega = $id_material";
                $result_material = $conexion->query($query_material);

                if ($result_material && $row_material = $result_material->fetch_assoc()) {
                    $nombre_material = $row_material['nombre'];
                    echo "Material registrado con éxito. Número de Transfactura: $id_transfactura. Material: $nombre_material<br>";
                } else {
                    echo "Material registrado con éxito. Número de Transfactura: $id_transfactura. No se pudo obtener el nombre del material.<br>";
                }
            } else {
                echo "Error al registrar el material: " . $conexion->error . "<br>";
            }
        }
    }

    $conexion->close();
}
?>
   </div>
    <br><center>
        <a href="MenuBodeguero.php" class="back-button">Volver</a>
