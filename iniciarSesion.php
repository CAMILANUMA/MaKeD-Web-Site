<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Iniciar Sesión y Perfil</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <style>
      .contenedor {
        height: 20%;
        margin: 0% 11%;
      }

      html, body {
        height: 100%;
      }

      .contenedorR {
        height: 20%;
        margin: 0% 0%;
      }

      .formulario {
        align-items: center;
        width: 490px;
        background: linear-gradient(to right, #98f0ff, #dfefff);
        border-radius: 20px;
        padding: 20px;
        margin: 20px;
        text-align: center;
        box-shadow: 0 12px 10px rgba(0, 0, 0, 0.2);
      }
      
      .nav-link {
        position: relative;
        display: inline-block;
        text-decoration: none;
        color: black;
        transition: transform 0.3s ease, background-color 0.3s ease;
        border-radius: 15px;
        overflow: hidden;
        padding: 10px 20px;
        height: 40px;
      }

      .nav-link::before {
      content: '';
      position: absolute;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      background-color: #5df1f67d;; /* Color de iluminación */
      transform: scale(0);
      transition: transform 0.3s ease;
      border-radius: 10px; /* Asegura el border-radius en el pseudo-elemento */
      z-index: -1; /* Pone el pseudo-elemento detrás del texto */
  }

  .nav-link:hover::before {
      transform: scale(1);
  }
      .nav-link:hover {
        transform: scale(1.1);
      }

      .btn {
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        border-radius: 10px;
      }

      .btn:hover {
        transform: scale(1.1);
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
      }

      .toggle-password {
        right: 20px;
        top: 50%;
        transform: translateY(-50%);
        cursor: pointer;
        background: none;
        border: none;
      }

      .input-group {
        position: relative;
      }

      .toggle-password {
        position: absolute;
        right: 3px;
        top: 50%;
        transform: translateY(-10%);
        background: none;
        border: none;
        cursor: pointer;
      }
    </style>
  </head>
  <body>

<?php 
include_once 'conexionbasica.php';
session_start();

// Manejo de cierre de sesión
if(isset($_POST['cerrar_sesion'])) {
    include_once 'cerrar.php';
}

// Redirección basada en el rol
if (isset($_SESSION['idrol'])) {
    switch ($_SESSION['idrol']) {
        case 1:
            header('Location: empresa.php');
            exit();
        case 2:
            header('Location: programador.php');
            exit();
            case 3:
              header('Location: administrador.php');
              exit();
        default:
            echo "Este rol no existe dentro de las opciones";
            exit();
    }
}

$error_message = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (empty($_POST['correo']) || empty($_POST['clave'])) {
        $error_message = 'Llena todos los campos';
    } else {
        $username = $_POST['correo'];
        $password = $_POST['clave'];

        $db = new Database();
        $query = $db->connectar()->prepare('SELECT * FROM usuarios WHERE correo = :correo AND clave = :clave');
        $query->execute(['correo' => $username, 'clave' => $password]);
        $arreglofila = $query->fetch(PDO::FETCH_ASSOC);

        if ($arreglofila) {
            $rol = $arreglofila['idrol']; 
            $_SESSION['idrol'] = $rol;
            $_SESSION['id'] = $arreglofila['id'];
            $_SESSION['nombre'] = $arreglofila['nombre'];
            $_SESSION['apellido'] = $arreglofila['apellido'];
            $_SESSION['correo'] = $arreglofila['correo'];
            $_SESSION['fecha_nacimiento'] = $arreglofila['fecha_nacimiento'];
            $_SESSION['foto'] = $arreglofila['foto'];

            // Redirigir según el rol
            switch ($rol) {
                case 1:
                    header('Location: empresa.php');
                    exit();
                case 2:
                    header('Location: programador.php');
                    exit();
                    case 3:
                      header('Location: administrador.php');
                      exit();
                default:
                    echo "Este rol no existe dentro de las opciones";
                    exit();
            }
        } else {
            // Verificar si el correo existe en la base de datos
            $query = $db->connectar()->prepare('SELECT * FROM usuarios WHERE correo = :correo');
            $query->execute(['correo' => $username]);
            if ($query->fetch(PDO::FETCH_ASSOC)) {
                $error_message = 'Confirma tu clave o correo';
            } else {
                $error_message = 'Usuario no registrado. Regístrate.';
            }
        }
    }
}
?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <br>
    <div class="container text-center">
      <div class="row">
        <div class="col" align="left">
          <img src="makedlogo.png" width="90" height="30">
        </div>
        <div class="col">
          <a class="nav-link py-2 px-0 px-lg-2" href="index.html" onclick="href='index.html'"><p>INICIO</p></a>
        </div>
        <div class="col">
          <a class="nav-link py-2 px-0 px-lg-2" href="quienesSomos.php" onclick="href='quienesSomos.php'"><p>¿QUIÉNES SOMOS?</p></a>
        </div>
        <div class="col">
          <a class="nav-link py-2 px-0 px-lg-2" href="empresas.html" onclick="href='empresas.html'"><p>EMPRESA</p></a>
        </div>
        <div class="col">
          <a class="nav-link py-2 px-0 px-lg-2" href="programador.html" onclick="href='programador.html'"><p>PROGRAMADOR</p></a>
        </div>
        <div class="col" align="right">
          <button type="button" class="btn btn-light" onclick="window.location.href='iniciarSesion.php'">Iniciar sesión</button>
        </div>
        <div class="col" align="left">
          <button type="button" class="btn btn-info" onclick="window.location.href='registro.php'">Registro</button>
        </div>
      </div>
    </div>
    <div align="center" >
      <br><br><br>
      <div class="formulario" align="center">
        <div class="container"></div>
        <br>
        <div class="p-3 mb-2 bg-info-subtle text-info-emphasis" style="border-radius: 30px; height: 60px">
          <p class="fs-5">Inicia sesión y desbloquea tu potencial</p>
        </div>
        <br>
        <form method="POST" action="iniciarSesion.php">
          <h4>Ingresa tu correo</h4>
          <br>
          <input type="email" class="form-control" name="correo" placeholder="correo">
          <br>
          <h4>Ingresa tu clave</h4>
          <br>
          <div class="input-group">
              <input type="password" class="form-control" name="clave" id="password" placeholder="clave">
              <button class="btn btn-outline-secondary toggle-password" type="button" onclick="togglePassword()">
                  <img src="https://cdn-icons-png.flaticon.com/512/709/709724.png" alt="mostrar" width="24" height="24">
              </button>
          </div>
          <br><br>
          <?php if (!empty($error_message)): ?>
              <div class="alert alert-danger"><?php echo $error_message; ?></div>
          <?php endif; ?>
          <button type="submit" class="btn btn-info btn-lg">Iniciar</button>
          <br><br>
          <a href="recuperar.php" class="btn btn-secondary">Recuperar contraseña</a>
        </form>
        <br><br><br>
      </div>
    </div>

    <script>
      function togglePassword() {
        var passwordField = document.getElementById("password");
        var passwordType = passwordField.getAttribute("type");

        if (passwordType === "password") {
          passwordField.setAttribute("type", "text");
        } else {
          passwordField.setAttribute("type", "password");
        }
      }
    </script>
  </body>
</html>
