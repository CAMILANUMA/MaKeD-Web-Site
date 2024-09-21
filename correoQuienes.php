<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';

if (isset($_POST['enviar'])) {
  if (!empty($_POST['nombre']) && !empty($_POST['correo']) && !empty($_POST['mensaje'])) {
    $nombre = $_POST['nombre'];
    $correo = $_POST['correo'];
    $telefono = $_POST['telefono'];
    $msg = $_POST['mensaje'];
    
    $miCorreo = "makedjobs@outlook.com";

    // Crear una nueva instancia de PHPMailer
    $mail = new PHPMailer(true);
    try {
      // Configurar el servidor SMTP
      $mail->isSMTP();
      $mail->Host       = 'smtp-mail.outlook.com'; // Cambia esto por tu servidor SMTP
      $mail->SMTPAuth   = true;
      $mail->Username   = 'makedjobs@outlook.com'; // Cambia esto por tu correo SMTP
      $mail->Password   = 'maked123'; // Cambia esto por tu contraseña SMTP
      $mail->SMTPSecure = 'tls';
      $mail->Port       = 587;
      $mail->CharSet    = 'UTF-8';

      // Remitente y destinatario
      $mail->setFrom('makedjobs@outlook.com', 'Contacto MAKED');
      $mail->addAddress($miCorreo);

      // Contenido del correo
      $mail->isHTML(true);
      $mail->Subject = 'Queja/Reclamo/Felicitacion';

      $htmlcontenido = "
      <!DOCTYPE html>
      <html lang='en'>
      <head>
          <meta charset='UTF-8'>
          <meta name='viewport' content='width=device-width, initial-scale=1.0'>
          <title>Document</title>
      </head>
      <body>
          <div>
              <img src='https://i.imgur.com/d2qHdW4.png' alt='Logo' style='width:100%; height:auto;'/>
              <di>
                  <h1>Hola Administrador!</h1>
                  <h2><b>Soy un cliente con una duda, queja, reclamo o solicitud</b></h2>
              </div>
              <br>
              <div>
                  <b>Mi nombre es: $nombre </b><br><br>
                  <b>Mi numero de contacto es: $telefono</b><br><br>
                  <b>Mi correo es: $correo </b><br><br>
                  <b>Queria decirte que: $msg</b><br><br>
              </div>
              <br><br>
              <div class='footer'>
                  <p>&copy; 2024 Maked. Todos los derechos reservados.</p>
              </div>
      </body>
      </html>";

      $mail->Body = $htmlcontenido;

      // Enviar el correo
      $mail->send();
      
      // Redirigir después de enviar el correo
      header("Location: quienesSomos.php");
      exit(); // Asegúrate de detener la ejecución del script después de la redirección
    } catch (Exception $e) {
      echo "El correo no pudo ser enviado. Mailer Error: {$mail->ErrorInfo}";
    }
  } else {
    echo "Por favor, completa todos los campos.";
  }
}
?>
