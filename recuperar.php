<?php
// Incluir el archivo de autoload generado por Composer
//require 'vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';

$error_message = '';
$success_message = '';

// Verifica si el formulario se ha enviado
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Conectar a la base de datos
    $dsn = 'mysql:host=localhost;dbname=maked';
    $username = 'root'; // Cambia esto a tu usuario de la base de datos
    $password = ''; // Cambia esto a tu contraseña de la base de datos

    try {
        $db = new PDO($dsn, $username, $password);
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Obtener los datos del formulario
        $correo = $_POST['correo'];
        $fecha_nacimiento = $_POST['fecha_nacimiento'];

        // Buscar el usuario en la base de datos
        $query = $db->prepare('SELECT clave FROM usuarios WHERE correo = :correo AND fecha_nacimiento = :fecha_nacimiento');
        $query->execute(['correo' => $correo, 'fecha_nacimiento' => $fecha_nacimiento]);
        $usuario = $query->fetch(PDO::FETCH_ASSOC);

        if ($usuario) {
            // Datos correctos, enviar correo
            $clave = $usuario['clave'];

            $mail = new PHPMailer(true);

            try {
                // Configuración del servidor
                $mail->isSMTP();
                $mail->Host = 'smtp.office365.com'; // Cambia esto si usas un servidor diferente
                $mail->SMTPAuth = true;
                $mail->Username = 'makedjobs@outlook.com'; // Cambia esto a tu correo de Outlook
                $mail->Password = 'maked123'; // Cambia esto a tu contraseña de correo
                $mail->SMTPSecure = 'tls';
                $mail->Port = 587;

                // Remitente y destinatario
                $mail->setFrom('makedjobs@outlook.com', 'MaKeD'); // Cambia esto a tu correo y nombre
                $mail->addAddress($correo);

                // Contenido del correo
                $mail->isHTML(true);
                $mail->Subject = 'Recuperación de Contraseña';
                $mail->Body    = '
                <html>
                <head>
                    <style>
                        @import url(\'https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap\');
                        .content_body {
                            max-width: 620px;
                            margin: 0 auto;
                            font-family: Roboto, sans-serif;
                        }
                        h1 {
                            font-weight: 300;
                            text-align: center;
                        }
                        h2 {
                            font-weight: 300;
                            text-align: center;
                        }
                        .preparacion {
                            text-align: center;
                        }
                        .seguimiento {
                            text-align: center;
                            border: 1px solid #343434;
                            padding: 15px;
                        }
                        .footer {
                            background-color: #395898;
                            text-align: center;
                            color: #fff;
                            padding: 12px;
                        }
                        .footer a {
                            color: #fff;
                        }
                        @media only screen and (max-width: 600px) {
                            .content_body {
                                width: 100%;
                                padding: 0 10px;
                            }
                        }
                    </style>
                </head>
                <body>
                    <div class=\'content_body\'>
                        <img src=\'https://i.imgur.com/d2qHdW4.png\' alt=\'Logo\' style=\'width:100%; height:auto;\'/>
                        <div class=\'preparacion\'>
                            <h1><b>¡Hola MaKeR!</b></h1>
                            <h2><b></b></h2>
                        </div>
                        <br>
                        <div class=\'seguimiento\'>
                            <h2>Recibimos tu solicitud para recuperar la contraseña. Validamos la información que ingresaste y es correcta!</h2><br><br>
                            <h2><b>Tu contraseña es:</b> ' . htmlspecialchars($clave) . '</h2><br>
                            <h1><i>Sigue contando con MaKeD!</i></h1><br>
                            <h1><i>Donde las empresas y los freelance se unen para alcanzar la sinergia perfecta</i></h1><br>
                        </div>
                        <br><br>
                        <div class=\'footer\'>
                            <p>&copy;2024 Maked. Todos los derechos reservados.</p>
                        </div>
                    </div>
                </body>
                </html>';

                $mail->send();
                $success_message = 'Correo enviado con éxito. Revisa tu bandeja de entrada.';
            } catch (Exception $e) {
                $error_message = 'Error al enviar el correo: ' . $mail->ErrorInfo;
            }
        } else {
            $error_message = 'Correo o fecha de nacimiento incorrectos.';
        }
    } catch (PDOException $e) {
        $error_message = 'Error de conexión: ' . $e->getMessage();
    }
}
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Recuperar Contraseña</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>
<body>
    <div class="container mt-5">
        <h2 class="text-center">Recuperar Contraseña</h2>
        <form method="POST" action="recuperar.php">
            <div class="mb-3">
                <label for="correo" class="form-label">Correo</label>
                <input type="email" class="form-control" id="correo" name="correo" required>
            </div>
            <div class="mb-3">
                <label for="fecha_nacimiento" class="form-label">Fecha de Nacimiento</label>
                <input type="date" class="form-control" id="fecha_nacimiento" name="fecha_nacimiento" required>
            </div>
            <button type="submit" class="btn btn-primary">Recuperar Contraseña</button>
            <button type="button" class="btn btn-info" onclick="window.location.href='index.html'">Volver</button>
         
        
        </form>
        <?php if (!empty($error_message)): ?>
            <p class="text-danger mt-3"><?php echo $error_message; ?></p>
        <?php endif; ?>
        <?php if (!empty($success_message)): ?>
            <p class="text-success mt-3"><?php echo $success_message; ?></p>
        <?php endif; ?>
    </div>
</body>
</html>
