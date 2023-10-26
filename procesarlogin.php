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
        <img src="pizza.png" alt="Imagen" />
        
        <!-- Formulario de inicio de sesión -->
        <div class="login-form">
            <h2>Iniciar Sesión</h2>
            <form action="procesarlogin.php" method="post">
                <input type="text" name="username" placeholder="Nombre de usuario" required>
                <br>
                <input type="password" name="password" placeholder="Contraseña" required>
                <br>
                <input type="submit" value="Iniciar Sesión">
            </form>
        </div>
    </div>
</body>
</html>
