<?php 
include_once 'conexionbasica.php';
$db = new Database();
$conexion = $db->connectar();
session_start();

if (!isset($_SESSION['idrol'])) {
    header('location: iniciarSesion.php');
    exit;
} else {
    if ($_SESSION['idrol'] != 2) {
        header('Location: iniciarSesion.php');
        exit;
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Muro Programador</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }
        header {
            background: #98f0ff;
            color: #fff;
            padding: 10px;
            text-align: center;
        }
        main {
            padding: 20px;
        }
        input[type="text"],
        textarea {
            width: 100%;
            margin-bottom: 10px;
        }
        textarea {
            max-height: 200px;
            resize: vertical;
        }
        button {
            padding: 10px;
            background-color: #3b5998;
            color: white;
            border: none;
            cursor: pointer;
        }
        #post-feed {
            margin-top: 20px;
            width: 100%;
            max-width: 700px;
            margin: 20px auto;
        }
        .post {
            border-bottom: 1px solid #ddd;
            padding: 10px 0;
        }
        .post-title {
            font-weight: bold;
        }
        .post-name {
            font-weight: bold;
            font-family: Verdana, Geneva, Tahoma, sans-serif;
            color: #2DB9BE;
        }
        #new-post {
            max-width: 700px;
            margin: 0 auto;
            padding: 20px;
            background-color: #f9f9f9;
            border-radius: 10px;
            border: 1px solid #ddd;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        .main-content {
            display: flex;
            gap: 30px;
            margin-top: 20px;
            max-width: 1700px;
            margin: 0 auto;
        }
        .sidebar-left {
            background-color: #b9f6ff;
            width: 60%;
            height: 600px;
            padding: 10px;
            box-sizing: border-box;
            overflow-y: auto;
            border-radius: 25px;
        }
        .aplicar {
            background-color: #E4FCFF;
            width: 60%;
            height: 50%;
            padding: 1%;
            box-sizing: border-box;
            overflow-y: auto; 
        }


        .publicaciones {
            background-color: #ffffff;
            width: 50%;
            height: 100%;
            padding: 10px;
            box-sizing: border-box;
            overflow-y: auto;
        }
        .content {
            flex: 1;
        }
        .comentarios {
            margin-top: 10px;
        }
        .comentario {
            border-bottom: 1px solid #ddd;
            padding: 5px 0;
        }
        .comentario-input {
            margin-top: 10px;
        }
        .comentario-btn {
            margin-top: 5px;
        }
        .like-btn {
            margin-top: 5px;
        }
    </style>
</head>
<body>
    <header>
        <div class="container text-center">
            <div class="row">
                <div class="col" align="left">
                    <!-- Logo del sitio (comentado) -->
                    <!-- <img src="makedlogo.png" width="90" height="30"> -->
                </div>
                <div class="row">
                    <div class="col" align="right">
                        <!-- Botón para cerrar sesión -->
                        <form method="POST" action="iniciarSesion.php">
                            <button type="submit" name="cerrar_sesion" class="btn btn-dark">Cerrar sesión</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <main>
        <div class="main-content">
            <div class="sidebar-left" align="center">
            <?php
                $usuario = $_SESSION['nombre'];  
                $apellido = $_SESSION['apellido'];
                $correo = $_SESSION['correo'];
                $fecha = isset($_SESSION['fecha_nacimiento']) ? $_SESSION['fecha_nacimiento'] : null;
                $timestamp = strtotime($fecha);

                // Formatear la fecha a un formato de cadena
                $fecha_formateada = date('d/m/Y', $timestamp);
                // echo $apellido; 
                $fotoPerfil = isset($_SESSION['foto']) ? $_SESSION['foto'] : 'perfil.png'; // Imagen predeterminada
                ?>

                <h2 align="center">Perfil</h2>
                <img src="<?php echo $fotoPerfil; ?>" width="120" height="120" alt="Perfil">
                <h4><?php echo "<br>". $usuario = $_SESSION['nombre']; 
                 echo " ".$apellido = $_SESSION['apellido'];  ?></h4>
                 <h5><?php echo"<br>" .$correo = $_SESSION['correo']; 
                 echo "<br><br>Fecha de nacimiento: ".$fecha_formateada ?></h5>
            </div>

            <!-- Sección para enviar el correo -->
            <div class="aplicar">
            <?php
          use PHPMailer\PHPMailer\PHPMailer;
          use PHPMailer\PHPMailer\Exception;
  
          require 'PHPMailer/src/Exception.php';
          require 'PHPMailer/src/PHPMailer.php';
          require 'PHPMailer/src/SMTP.php';
          ?>
        <form method = "post">
        <h4 align = center>Por favor Ingresa aquí tus datos para aplicar a una empresa</h4>
        Nombre: <input type="text" name="nombre"><br>
        Correo: <input type="text" name="correo"><br>
        Numero de contacto: <input type="text" name="telefono"><br>
        Correo de la empresa a la que aplicas: <input type="text" name="correoEmpresa"><br>
        Algo sobre mí: <textarea class = "textarea" name="mensaje"></textarea><br>
        <input class="btn btn-success" width="80 px" type="submit" name="enviar" value="Enviar"><br>
        </form>
        <?php
      
        if (isset($_POST['enviar'])) {
            if (!empty($_POST['nombre']) && !empty($_POST['correo']) && !empty($_POST['mensaje']) && !empty($_POST['telefono']) && !empty($_POST['correoEmpresa'])) {
              $nombre = $_POST['nombre'];
              $correo = $_POST['correo'];
              $telefono = $_POST['telefono'];
              $msg = $_POST['mensaje'];
              $correoEmpresa = $_POST['correoEmpresa'];
            }
            $mail = new PHPMailer(true);
            $mail->isSMTP();
            $mail->Host       = 'smtp-mail.outlook.com';
            $mail->SMTPAuth   = true;
            $mail->Username   = 'makedjobs@outlook.com';
            $mail->Password   = 'maked123';
            $mail->SMTPSecure = 'tls';
            $mail->Port       = 587;
            $mail->CharSet    = 'UTF-8';

            $mail->setFrom('makedjobs@outlook.com', 'Contacto MAKED');
            $mail->addAddress($correoEmpresa);

            $mail->isHTML(true);
            $mail->Subject = 'Tienes una nueva aplicación a tu oferta!!';

            $htmlcontenido = "
            <!DOCTYPE html>
            <html lang='en'>
            <head>
                <meta charset='UTF-8'>
                <meta name='viewport' content='width=device-width, initial-scale=1.0'>
                <title>Document</title>
            </head>
            <body>
                <div class='content_body'>
                    <img src='https://i.imgur.com/d2qHdW4.png' alt='Logo' style='width:100%; height:auto;'/>
                    <div class='preparacion'>
                        <h1><b>¡Hola MaKeR!</b></h1>
                        <h2><b></b></h2>
                    </div>
                    <br>
                    <div class='seguimiento'>
                        <h2>Queremos contarte que un experto se ha interesado en tu oferta y aquí te dejamos sus datos para que puedas contactarlo si así lo deseas.</h2><br><br>

                        <b>Su nombre es: $nombre </b><br><br>
                        <b>Su numero de contacto es: $telefono</b><br><br>
                        <b>Su correo es: $correo </b><br><br>
                        <b>Quiere decirte que: $msg</b><br><br>

                        <h2><b>Esperamos tener la oportunidad de seguir trabajando juntos en tus próximos proyectos</b></h2><br>
                        <h1><i>Donde las empresas y los freelance se unen para alcanzar la sinergia perfecta</i></h1><br>
                    </div>
                    <br><br>
                    <div class='footer'>
                        <p>&copy;2024 Maked. Todos los derechos reservados.</p>
                    </div>
                </div>
            </body>
            </html>";

            $mail->Body = $htmlcontenido;
            $mail->send();

        }
    ?>
            </div>

            <div id="post-feed" class="publicaciones">
                <!-- Las publicaciones aparecerán aquí -->
            </div>
        </div>
    </main>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            loadPosts();

            document.getElementById('post-button')?.addEventListener('click', async () => {
                const title = document.getElementById('post-title').value;
                const content = document.getElementById('post-content').value;

                if (title.trim() && content.trim()) {
                    const response = await fetch('post.php', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/x-www-form-urlencoded'
                        },
                        body: new URLSearchParams({
                            title,
                            content
                        })
                    });

                    if (response.ok) {
                        document.getElementById('post-title').value = '';
                        document.getElementById('post-content').value = '';
                        loadPosts();
                    } else {
                        console.error('Error al publicar.');
                    }
                }
            });
        });

        async function loadPosts() {
            try {
                const response = await fetch('get_posts.php');
                if (response.ok) {
                    const posts = await response.json();
                    console.log(posts); 

                    const postFeed = document.getElementById('post-feed');
                    postFeed.innerHTML = posts.map(post => `
                         <div class="post" data-id="${post.id}">
                            <div class="post-name">Publicado por: ${post.user_name} ${post.user_last_name}</div><br>
                            <div class="post-name" name="correo">Correo: ${post.user_email}</div><br>
                            <div class="post-title">${post.title}</div>
                            <div><strong>Pago tentativo:</strong> ${post.pago}</div>
                            <div> <strong>Nivel de experiencia requerido:</strong> ${post.niveles}</div>
                            <div> <strong>Horas de trabajo aproximadas:</strong> ${post.horas_dias}</div>
                            <div>${post.content}</div>
                            <small>Fecha: ${new Date(post.timestamp).toLocaleString()}</small>
                            
                        </div>
                `).join('');


                    document.querySelectorAll('.apply-btn').forEach(button => {
                        button.addEventListener('click', (e) => {
                            const publicacionId = e.target.parentNode.dataset.id;
                            aplicar(publicacionId, e.target);
                        });
                    });
                } else {
                    console.error('Error al cargar publicaciones:', response.statusText);
                }
            } catch (error) {
                console.error('Error en la solicitud de posts:', error);
            }
        }
        </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>
