<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Muro Social</title>
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
        
        input[type="text"], textarea {
            width: 100%;
            margin-bottom: 10px;
        }
        
        textarea {
            height: 100px;
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
            width: 400px;
            height: 600px;
            padding: 10px;
            box-sizing: border-box;
            overflow-y: auto;
            border-radius: 25px;
        }
        .publicar {
            background-color: #ffffff;
            width: 400px;
            height: 300px;
            padding: 10px;
            box-sizing: border-box;
            overflow-y: auto;
        }

        .publicaciones {
            background-color: #ffffff;
            width: 400px;
            height: 100%;
            padding: 10px;
            box-sizing: border-box;
            overflow-y: auto;
        }
    </style>
</head>
<body>
    <header>
        <div class="container text-center">
            <div class="row">
              <div class="col" align="left">
                <!-- <img src="makedlogo.png" width="90" height="30"> -->
              </div>
              <div class="row">
                <div class="col" align="right">
                    <input class="btn btn-dark" type="button" value="Cerrar sesión">
                </div>
            </div>
          </div>
    </header>
    <main>
        <div class="main-content">
            <div class="sidebar-left" align="center">
                <h2 align="center">Perfil</h2>
                <img src="perfil.png" width="90" height="90" alt="Perfil">
                <h4>Nombre del usuario</h4>
                <p>Perfil del usuario/profesión<br>Nivel / Fortaleza</p>
                <p>País</p>
                <br>
                <p>Proyectos finalizados: 6</p>
            </div>

            <div class="publicar" id="new-post">
                <h3>Hacer publicación</h3>
                <input type="text" id="post-title" placeholder="Título">
                <textarea id="post-content" placeholder="Escribe algo..."></textarea>
                <button type="button" class="btn btn-info" id="post-button">Publicar</button>
            </div>
            <div id="post-feed" class="publicaciones">
                <!-- Las publicaciones aparecerán aquí -->
            </div>
        </div>
    </main>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            loadPosts();

            document.getElementById('post-button').addEventListener('click', async () => {
                const titulo = document.getElementById('post-title').value;
                const texto = document.getElementById('post-content').value;

                if (titulo.trim() && texto.trim()) {
                    const response = await fetch('post.php', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/x-www-form-urlencoded'
                        },
                        body: new URLSearchParams({ title: titulo, content: texto })
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
            const response = await fetch('get_posts.php');
            if (response.ok) {
                const posts = await response.json();
                const postFeed = document.getElementById('post-feed');
                postFeed.innerHTML = posts.map(post => `
                    <div class="post" data-id="${post.id}">
                        <div class="post-title">${post.title}</div>
                        <div>${post.content}</div>
                        <small>${new Date(post.timestamp).toLocaleString()}</small>
                        <div class="comentarios">
                            ${post.comments.map(comment => `
                                <div class="comentario">
                                    <p class="texto">${comment.text}</p>
                                </div>
                            `).join('')}
                        </div>
                        <input type="text" class="comentario-input" placeholder="Escribe un comentario..." />
                        <button class="comentario-btn btn btn-secondary btn-sm">Comentar</button>
                        <button class="like-btn btn btn-primary btn-sm">Like (${post.likes})</button>
                    </div>
                `).join('');

                // Agregar event listeners para los botones de comentario y like
                document.querySelectorAll('.comentario-btn').forEach(button => {
                    button.addEventListener('click', async (e) => {
                        const postId = e.target.closest('.post').dataset.id;
                        const comentarioInput = e.target.previousElementSibling;
                        const textoComentario = comentarioInput.value;

                        if (textoComentario) {
                            const response = await fetch('add_comment.php', {
                                method: 'POST',
                                headers: {
                                    'Content-Type': 'application/x-www-form-urlencoded'
                                },
                                body: new URLSearchParams({ post_id: postId, text: textoComentario })
                            });

                            if (response.ok) {
                                comentarioInput.value = ''; // Limpiar el campo de entrada
                                loadPosts(); // Recargar publicaciones
                            } else {
                                console.error('Error al agregar comentario.');
                            }
                        }
                    });
                });

                document.querySelectorAll('.like-btn').forEach(button => {
                    button.addEventListener('click', async (e) => {
                        const postId = e.target.closest('.post').dataset.id;

                        const response = await fetch('add_like.php', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/x-www-form-urlencoded'
                            },
                            body: new URLSearchParams({ post_id: postId })
                        });

                        if (response.ok) {
                            loadPosts(); // Recargar publicaciones
                        } else {
                            console.error('Error al dar like.');
                        }
                    });
                });
            } else {
                console.error('Error al cargar publicaciones.');
            }
        }
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>
