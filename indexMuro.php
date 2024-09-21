<?php 
include_once 'conexionbasica.php';
$db = new Database();
$conexion = $db->connectar();
session_start();
if (!isset($_SESSION['idrol'])) {
    header('location: iniciarSesion.php');
} else {
    if ($_SESSION['idrol'] != 1) {
        header('Location: iniciarSesion.php');
    }
}

?>
<!DOCTYPE html>
<html lang="es">

<head>
    <!-- Metadatos de la página -->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Muro Social</title>

    <!-- Importación de Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

    <style>
        /* Estilos personalizados para la página */
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }

        /* Estilos para la cabecera */
        header {
            background: #98f0ff;
            color: #fff;
            padding: 10px;
            text-align: center;
        }

        /* Estilos para el contenido principal */
        main {
            padding: 20px;
        }

        /* Estilos para los campos de texto y área de texto */
        input[type="text"],
        textarea {
            width: 100%;
            margin-bottom: 10px;
        }

        textarea {
            height: 100px;
        }

        /* Estilos para los botones */
        button {
            padding: 10px;
            background-color: #3b5998;
            color: white;
            border: none;
            cursor: pointer;
        }

        /* Estilos para la sección de publicaciones */
        #post-feed {
            margin-top: 20px;
            width: 100%;
            /* Ancho completo */
            max-width: 700px;
            /* Ancho máximo para centrar el contenido */
            margin: 20px auto;
            /* Centra horizontalmente el contenedor */
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

        /* Estilos para el contenedor de nueva publicación */
        #new-post {
            max-width: 700px;
            /* Ancho máximo para centrar el contenido */
            margin: 0 auto;
            /* Centra horizontalmente el contenedor */
            padding: 20px;
            background-color: #BDFEF4;
            border-radius: 10px;
            border: 1px solid #ddd;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            /* Sombra sutil */
        }

        /* Estilos para el contenedor principal que usa flexbox */
        .main-content {
            display: flex;
            gap: 30px;
            /* Espacio entre la barra lateral y el contenido principal */
            margin-top: 20px;
            /* Margen superior para separación del header */
            max-width: 1700px;
            /* Ancho máximo del contenedor principal */
            margin: 0 auto;
            /* Centra el contenedor principal */
        }

        /* Estilos para la barra lateral */
        .sidebar-left {
            background-color: #b9f6ff;
            width: 60%;
            /* Ancho fijo para la barra lateral */
            height: 600px;
            padding: 10px;
            box-sizing: border-box;
            overflow-y: auto;
            border-radius: 25px;
        }

        /* Estilos para la sección de publicar */
        .publicar {
            background-color: #ffffff;
            width: 50%;
            /* Ancho fijo para la barra lateral */
            height: 50%;
            padding: 10px;
            box-sizing: border-box;
            overflow-y: auto;
        }

        /* Estilos para la sección de publicaciones */
        .publicaciones {
            background-color: #ffffff;
            width: 50%;
            /* Ancho fijo para la barra lateral */
            height: 100%;
            padding: 10px;
            box-sizing: border-box;
            overflow-y: auto;
        }

        /* Estilos para el contenido principal */
        .content {
            flex: 1;
            /* Ocupa el espacio restante disponible */
        }

        /* Estilos para la sección de comentarios */
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

        /* Estilos para el botón de like */
        .like-btn {
            margin-top: 5px;
        }
    </style>
</head>

<body>

    <!-- Cabecera de la página -->
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

    <!-- Contenido principal de la página -->
    <main>
        <div class="main-content">
            <!-- Barra lateral izquierda (perfil del usuario) -->
            <div class="sidebar-left" 
            align="center">

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

            <!-- Sección para hacer una nueva publicación -->
            <div class="publicar" id="new-post">
                <h3>Hacer publicación</h3>
                <input type="text" id="post-title" placeholder="Título">
                <input type="text" id="pago" placeholder="Ofrece un pago"><br>
                Nivel de experiencia:<br>
                <select name ="niveles" id="niveles">
                <option value="principiante">Sin experiencia</option>
                <option value="junior">junior</option>
                <option value="semi-Senior">Semi senior</option>
                <option value="senior">Senior</option>
                </select><br><br>
                <input type="text" id="horas_dias" placeholder="Horas/días estimados de trabajo">
                <textarea id="post-content" placeholder="Descripcion de la oferta..."></textarea>
              <button class="btn btn-info" id="post-button">Publicar</button>
            </div>

            <!-- Sección para mostrar las publicaciones -->
            <div id="post-feed" class="publicaciones">
                <!-- Las publicaciones aparecerán aquí -->
            </div>
        </div>
    </main>


    <!-- Scripts para manejar las publicaciones y comentarios -->
    <script>
   document.addEventListener('DOMContentLoaded', () => {
    loadPosts(); 

    // Maneja el clic en el botón de publicar
    document.getElementById('post-button').addEventListener('click', async () => {
        // Captura los valores de los campos del formulario
        const title = document.getElementById('post-title').value;
        const pago = document.getElementById('pago').value;
        const nivel = document.getElementById('niveles').value;
        const horas = document.getElementById('horas_dias').value;
        const content = document.getElementById('post-content').value;

        // Imprime los valores capturados en la consola
        console.log({
            title,
            pago,
            nivel,
            horas,
            content
        });

        // Verifica si todos los campos están llenos
        if (title.trim() && pago.trim() && nivel.trim() && horas.trim() && content.trim()) {
            // Envía los datos al servidor
            const response = await fetch('post.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded'
                },
                body: new URLSearchParams({
                    title,
                    pago,
                    niveles: nivel, // Corrige el nombre del campo si es necesario
                    horas_dias: horas,
                    content
                })
            });

            if (response.ok) {
                // Limpia los campos del formulario
                document.getElementById('post-title').value = '';
                document.getElementById('pago').value = '';
                document.getElementById('niveles').value = '1'; // Ajusta el valor por defecto si es necesario
                document.getElementById('horas_dias').value = '';
                document.getElementById('post-content').value = '';
                loadPosts(); // Recarga las publicaciones
            } else {
                console.error('Error al publicar.');
            }
        } else {
            console.error('Por favor, completa todos los campos.');
        }
    });
});



        async function loadPosts() {
    try {
        const response = await fetch('get_posts.php');
        if (response.ok) {
            const posts = await response.json();
            console.log(posts); // Verifica la respuesta en la consola

            const postFeed = document.getElementById('post-feed');
            postFeed.innerHTML = posts.map(post => `
                <div class="post" data-id="${post.id}">
                    <div class="post-name">Publicado por: ${post.user_name} ${post.user_last_name}</div><br>
                    <div class="post-name" name="correo">Correo: ${post.user_email}</div><br>
                    <div class="post-title">${post.title}</div>
                    <div><strong>Pago tentativo:</strong> ${post.pago}</div>
                    <div> <strong>Nivel de experiencia requerido:</strong> ${post.nivel}</div>
                    <div> <strong>Horas de trabajo aproximadas:</strong> ${post.horas_dias}</div>
                    <div>${post.content}</div>
                    <small>Fecha: ${new Date(post.timestamp).toLocaleString()}</small>
                    
                </div>
            `).join('');
        } else {
            console.error('Error al cargar publicaciones:', response.statusText);
        }
    } catch (error) {
        console.error('Error en la solicitud de posts:', error);
    }
        }
    </script>

    <!-- Importación de Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>

</html>