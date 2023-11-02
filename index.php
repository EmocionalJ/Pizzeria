<!DOCTYPE html>
<html>
<head>
    <style>
        body {
            background-color: #721111; /* Código de color rojo */
            font-family: Arial, sans-serif;
            color: #000000; /* Color del texto */
        }
        img {
            width: 150px;
            display: block;
            margin: 25px auto;
            border: 5px solid #a31919;
            border-radius: 100%;
            background-color: #ffffff;
        }
        /* Agregamos estilos para el formulario de inicio de sesión */
        .login-form {
            text-align: center;
        }
        .login-form input[type="text"],
        .login-form input[type="password"] {
            width: 20%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        .login-form input[type="submit"] {
            background-color: #a31919;
            color: #fff;
            padding: 10px 20px;
            border: none;
            border-radius: 10px;
            cursor: pointer;
        }
    </style>
</head>
<body>
        <img src="fpizza.png" alt="Imagen" />
        
        <!-- Formulario de inicio de sesión -->
        <div class="login-form">
            <form method="post">
                <input type="text" name="txtRut" placeholder="Ingrese su RUT" required>
                <br>
                <input type="text" name="txtPas" placeholder="Ingrese su contraseña" required>
                <br>
                <input type="submit" name = "btnIng" value="Iniciar Sesión">
            </form>
            <?php
        require("iniciarSesion.php");
        if (isset($_SESSION['rut'])) {
            // Redirige a la página de menú del funcionario si ya ha iniciado sesión
            header("Location: MenuAdmin.php");
            exit();
        }

        if (isset($_POST['btnIng']) && $_POST['btnIng'] == "Iniciar Sesión") {
            include("funciones.php");
            $cnn = Conectar();

            $rut = $_POST['txtRut'];
            $pass = $_POST['txtPas'];
            
                // Verifica la autenticación en la tabla 'administrador'
            $sql_admin = "SELECT * FROM administrador WHERE rut = '$rut' AND pass = '$pass'";
            $result_admin = mysqli_query($cnn, $sql_admin);

            if (mysqli_num_rows($result_admin) == 1) {
                // Autenticación exitosa como administrador
                $_SESSION['rut'] = $rut;
                header("Location: MenuAdmin.php");
                exit();
            }

            // Verifica la autenticación en la tabla 'bodeguero'
            $sql_bodeguero = "SELECT * FROM bodeguero WHERE rut = '$rut' AND pass = '$pass'";
            $result_bodeguero = mysqli_query($cnn, $sql_bodeguero);

            if (mysqli_num_rows($result_bodeguero) == 1) {
                // Autenticación exitosa como bodeguero
                $_SESSION['rut'] = $rut;
                header("Location: MenuBodeguero.php");
                exit();
            }

            // Si no se encontró una coincidencia en ninguna tabla, la autenticación falla
            echo "Credenciales incorrectas. Inténtelo de nuevo.";
        }
        ?>
            </div>
        
    </div>
</body>
</html>
