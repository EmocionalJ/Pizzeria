<?php
include("iniciarSesion.php"); // Incluye el archivo que inicia la sesión

if (!isset($_SESSION['rut'])) {
    // Si el usuario no está autenticado, redirige a la página de inicio de sesión
    header("Location: index.php");
    exit(); // Asegura que el script se detenga después de redirigir
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Ingresar Producto</title>
    <style>
        body {
            background-color: #a31919;
            font-family: Arial, sans-serif;
            color: #000;
            text-align: center;
            margin: 0;
            padding: 0;
        }
        h2 {
            font-size: 14px;
        }
        h1 {
            font-size: 35px;
            text-shadow: 2px 2px 4px #000;
            color: #fff;
        }
        .container {
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            background-color: #fff;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            border-radius: 10px;
        }
        table {
            width: 100%;
        }
        table td {
            padding: 5px;
            text-align: left;
        }
        .center {
            text-align: center;
        }
        input[type="text"],
        input[type="number"],
        input[type="date"],
        textarea {
            width: 100%;
            padding: 5px;
            border: 1px solid #000;
            border-radius: 3px;
        }
        input[type="text"], input[type="number"], input[type="date"], textarea {
            width: 100%;
            max-width: 400px; /* Reduce el ancho máximo de los recuadros */
            padding: 5px;
            border: 1px solid #000;
            border-radius: 3px;
        }
        input[type="submit"] {
            background-color: #FF0000;
            color: #FFFFFF;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-weight: bold;
            text-transform: uppercase;
        }
        input[type="submit"]:hover {
            background-color: #FF5555;
        }
        a {
            text-decoration: none;
            color: #fff;
            font-weight: bold;
        }
        a:hover {
            color: #000;
        }  .logout-button button:hover {
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

<head>
    <title>Ingresar Producto</title>
</head>
<body bgcolor="">
    <center>
        <h1>Ingresar Producto</h1>
            <form method="post">
                <div class="container">
                    <td bgcolor=""><h2>ID de Producto:</h2></td>
        
                        <input type="text" name="txtPro" value="<?php echo $producto['id_producto_bodega']; ?>">
                        <br>
                        <br>
                        <input type="submit" name="btnBuscar" value="Buscar">
                        <br>
          
                    <td bgcolor=""><h2>Nombre de Producto:</h2></td>
                    <td><input type="text" name="txtNom" value="<?php echo $producto['nombre']; ?>" readonly></td>
       
              
                    <td bgcolor=""><h2>Descripción de Producto:</h2></td>
                    <td><textarea name="txtDes" rows="5" cols="21" readonly><?php echo $producto['descripcion']; ?></textarea></td>
            
            
                    <td bgcolor=""><h2>Cantidad a Ingresar:</h2></td>
                    <td><input type="number" name="txtCantidad" value="0"></td>
              
             
                    <td bgcolor=""><h2>Stock de Producto:</h2></td>
                    <td><input type="number" name="txtSto" value="<?php echo $producto['stock']; ?>"readonly></td>
               
            
                    <td bgcolor=""><h2>Kilos del Producto:</h2></td>
                    <td><input type="number" name="txtKil" value="<?php echo $producto['Kilos']; ?>" readonly></td>
                
             
                    <td bgcolor=""><h2>Gramos del Producto:</h2></td>
                    <td><input type="number" name "txtGra" value="<?php echo $producto['Gramos']; ?>" readonly></td>
              
              
                    <td bgcolor=""><h2>Mililitros de Producto:</h2></td>
                    <td><input type="text" name="txtMil" value="<?php echo $producto['mililitros']; ?>" readonly></td>
              
                
                    <td bgcolor=""><h2>Precio de Producto:</h2></td>
                    <td><input type="number" name="txtPre" value="<?php echo $producto['precio']; ?>" readonly></td>
             
              
                    <td bgcolor=""><h2>ID de Bodega:</h2></td>
                    <td><input type="number" name="txtBod" value="<?php echo $producto['id_bodega']; ?>" readonly></td>
            
           
                    <td bgcolor=""><h2>Fecha de Ingreso:</h2></td>
                    <td><input type="date" name="txtFec" value="<?php echo $producto['fecha_ingreso']; ?>"></td>
        
                    <center>
                    <br>
                    <input type="submit" name="btnIngresar" value="Ingresar">
</form>
</div>
        <br><center>
        <a href="MenuBodeguero.php" class="back-button">Volver</a>
</body>
</html>


