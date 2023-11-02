<?php
include("iniciarSesion.php"); // Incluye el archivo que inicia la sesión

if (!isset($_SESSION['rut'])) {
    // Si el usuario no está autenticado, redirige a la página de inicio de sesión
    header("Location: index.php");
    exit(); // Asegura que el script se detenga después de redirigir
}
?>

<?php
include("funciones.php");

$producto = [
    'id_producto_bodega' => '',
    'nombre' => '',
    'descripcion' => '',
    'stock' => 0,
    'Kilos' => '',
    'Gramos' => '',
    'mililitros' => '',
    'precio' => '',
    'id_bodega' => '',
    'fecha_ingreso' => '',
];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $cnn = Conectar();

    if (isset($_POST['btnBuscar'])) {
        $productID = $_POST['txtPro'];

        $query = "SELECT * FROM productos_bodega WHERE id_producto_bodega = $productID";
        $result = $cnn->query($query);

        if ($result && $result->num_rows > 0) {
            $row = $result->fetch_assoc();

            $producto['id_producto_bodega'] = $row['id_producto_bodega'];
            $producto['nombre'] = $row['nombre'];
            $producto['descripcion'] = $row['descripcion'];
            $producto['stock'] = intval($row['stock']);
            $producto['Kilos'] = $row['Kilos'];
            $producto['Gramos'] = $row['Gramos'];
            $producto['mililitros'] = $row['mililitros'];
            $producto['precio'] = $row['precio_producto'];
            $producto['id_bodega'] = $row['id_bodega_vinculada'];
            $producto['fecha_ingreso'] = $row['fecha_ingreso'];
        } else {
            echo "Producto no encontrado.";
        }
    } elseif (isset($_POST['btnIngresar'])) {
        $productID = $_POST['txtPro'];
        $cantidadAIngresar = intval($_POST['txtCantidad']);
        $fechaIngreso = $_POST['txtFec'];

        $query = "UPDATE productos_bodega SET stock = stock + $cantidadAIngresar, fecha_ingreso = '$fechaIngreso' WHERE id_producto_bodega = $productID";
        $result = $cnn->query($query);

        if ($result) {
            echo "Stock y fecha de ingreso actualizados exitosamente.";
        } else {
            echo "Error al actualizar el stock y la fecha de ingreso: " . $cnn->error;
        }
    }
}
?>


<!DOCTYPE html>
<html>
<head>
    <title>Ingresar Producto</title>
</head>
<body bgcolor="">
    <center>
        <h2>Ingresar Producto</h2>
        <form method="post">
            <table border="1">
                <tr>
                    <td bgcolor="">ID de Producto:</td>
                    <td>
                        <input type="text" name="txtPro" value="<?php echo $producto['id_producto_bodega']; ?>">
                        <input type="submit" name="btnBuscar" value="Buscar">
                    </td>
                </tr>
                <tr>
                    <td bgcolor="">Nombre de Producto:</td>
                    <td><input type="text" name="txtNom" value="<?php echo $producto['nombre']; ?>" readonly></td>
                </tr>
                <tr>
                    <td bgcolor="">Descripción de Producto:</td>
                    <td><textarea name="txtDes" rows="5" cols="21" readonly><?php echo $producto['descripcion']; ?></textarea></td>
                </tr>
                <tr>
                    <td bgcolor="">Cantidad a Ingresar:</td>
                    <td><input type="number" name="txtCantidad" value="0"></td>
                </tr>
                <tr>
                    <td bgcolor="">Stock de Producto:</td>
                    <td><input type="number" name="txtSto" value="<?php echo $producto['stock']; ?>"readonly></td>
                </tr>
                <tr>
                    <td bgcolor="">Kilos del Producto:</td>
                    <td><input type="number" name="txtKil" value="<?php echo $producto['Kilos']; ?>" readonly></td>
                </tr>
                <tr>
                    <td bgcolor="">Gramos del Producto:</td>
                    <td><input type="number" name "txtGra" value="<?php echo $producto['Gramos']; ?>" readonly></td>
                </tr>
                <tr>
                    <td bgcolor="">Mililitros de Producto:</td>
                    <td><input type="text" name="txtMil" value="<?php echo $producto['mililitros']; ?>" readonly></td>
                </tr>
                <tr>
                    <td bgcolor="">Precio de Producto:</td>
                    <td><input type="number" name="txtPre" value="<?php echo $producto['precio']; ?>" readonly></td>
                </tr>
                <tr>
                    <td bgcolor="">ID de Bodega:</td>
                    <td><input type="number" name="txtBod" value="<?php echo $producto['id_bodega']; ?>" readonly></td>
                </tr>
                <tr>
                    <td bgcolor="">Fecha de Ingreso:</td>
                    <td><input type="date" name="txtFec" value="<?php echo $producto['fecha_ingreso']; ?>"></td>
                </tr>
            </table>
            <br>
            <center>
                <input type="submit" name="btnIngresar" value="Ingresar">
            </center>
        </form>
        <br>
        <a href="MenuBodeguero.php">Volver al menú</a>
    </center>
    <a href="CerrarSesion.php">Cerrar Sesión</a>
</body>
</html>


