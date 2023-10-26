<!DOCTYPE html>
<html>
<head>
    <style>
        body {
            background-color: #a31919; /* Fondo  */
            font-family: Arial, sans-serif;
            color: #000000; /* Texto */
        }
        h1 {
			text-align: center;
            color: #000000; /* Color de título lila */
            font-size: 32px;
            text-shadow: 2px 2px 4px #000;
        }
        h2 {
            margin-top: -20px;
			text-align: center;
            color: #000000; /* Color de título lila */
            font-size: 10px;
            text-shadow: 2px 2px 4px #000;
        }
        a {
            text-decoration: none;
            color: #fff; /* Color de enlaces morado más claro */
            font-weight: bold;
        }
        a:hover {
            color: #000000; /* Color de enlaces morados más claro al pasar el ratón */
        }
        .container {
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
            background-color: #fff; /* Fondo blanco */
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            border-radius: 10px;
        }
        .table-container {
            margin-top: 20px;
            display: flex;
            justify-content: center; /* Centrar horizontalmente */
        }
        .tabla {
            border: 4px solid #000; /* Borde de tablas */
            border-collapse: collapse;
            width: 48%;
            background-color: #721111; /* Fondo de tablas */
            color: #000; /* Texto en tablas en color */
            margin: 5px auto; /* Centrar horizontalmente */
        }
        .tabla td {
            padding: 10px;
            text-align: center;
        }
        img {
            width: 150px;
            display: block;
            margin: 25px auto;
            border: 5px solid #721111; /* Borde alrededor de la imagen */
            border-radius: 100%; /* Forma circular de la imagen */
        }
        .tabla caption {
            color: #000000; /* Etiqueta caption a negro */
        }
        .logout-button {
            position: fixed;
            bottom: 70px; /* Ajusta el valor según tu preferencia */
            left: 50%;
            transform: translateX(-50%);
            text-align: center;
            margin-top: 10px;
        } 
        .logout-button button {
            background-color: #FF0000; /* Cambia el color de fondo del botón */
            color: #FFFFFF; /* Cambia el color del texto del botón */
            padding: 10px 20px; /* Cambia el tamaño del botón */
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-weight: bold;
            text-transform: uppercase;
        }
        .logout-button button:hover {
            background-color: #FF5555; /* Cambia el color de fondo del botón al pasar el ratón */
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Gestión de Bodega</h1>
        <h2>Bodeguero</h2>
        
        <div class "table-container">
            <table class="tabla">
                <tr>
                    <td><a href="XXXXXXX.php">Ingresar Stock</a></td>
                </tr>
                <tr>
                    <td><a href="XXXXXXX.php">Comparar con transfactura</a></td>
                </tr>
                <tr>
                    <td><a href="XXXXXXX.php">Mover stock</a></td>
                </tr>
            </table>
        </div>
        
        <img src="fpizza.png" alt="Imagen" />
    </div>
    <div class="logout-button">
        <button onclick="cerrarSesion()">Cerrar Sesión</button>
    </div>

    <script>
        function cerrarSesion() {
            // Redirigir al usuario a la página de inicio de sesión (login.php)
            window.location.href = "login.php";
        }
    </script>
</body>
</html>
