<?php
// Incluir la clase Database para la conexión
require_once 'conexionbasica.php';

$nombres = $apellidos = $correo = $clave = $confirmar_clave = $fecha_nacimiento = $idrol = "";
$error_nombres = $error_apellidos = $error_correo = $error_clave = $error_confirmar_clave = $error_fecha_nacimiento = $error_idrol = $error_foto = "";
$mensaje = $clase = "";

// Validar el método del formulario
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Recoger datos del formulario
    $nombres = isset($_POST['nombres']) ? trim($_POST['nombres']) : '';
    $apellidos = isset($_POST['apellidos']) ? trim($_POST['apellidos']) : '';
    $correo = isset($_POST['correo']) ? trim($_POST['correo']) : '';
    $clave = isset($_POST['clave']) ? trim($_POST['clave']) : '';
    $confirmar_clave = isset($_POST['confirmar_clave']) ? trim($_POST['confirmar_clave']) : '';
    $fecha_nacimiento = isset($_POST['fecha_nacimiento']) ? trim($_POST['fecha_nacimiento']) : '';
    $idrol = isset($_POST['idrol']) ? $_POST['idrol'] : '';


    // Validar campos vacíos
    if (empty($nombres)) {
        $error_nombres = "El campo nombres es obligatorio.";
    }
    if (empty($apellidos)) {
        $error_apellidos = "El campo apellidos es obligatorio.";
    }
    if (empty($correo)) {
        $error_correo = "El campo correo es obligatorio.";
    }
    if (empty($clave)) {
        $error_clave = "El campo clave es obligatorio.";
    } elseif (strlen($clave) < 6) {
        $error_clave = "La clave debe tener al menos 6 caracteres.";
    }
    if (empty($confirmar_clave)) {
        $error_confirmar_clave = "Confirma la clave.";
    } elseif ($clave !== $confirmar_clave) {
        $error_confirmar_clave = "Las claves no coinciden.";
    }
    if (empty($fecha_nacimiento)) {
        $error_fecha_nacimiento = "El campo fecha de nacimiento es obligatorio.";
    } else {
        // Validar que el usuario tenga al menos 15 años
        $hoy = new DateTime();
        $fecha_nacimiento_dt = new DateTime($fecha_nacimiento);
        $diferencia = $hoy->diff($fecha_nacimiento_dt);
        $edad = $diferencia->y;
        if ($edad < 15) {
            $error_fecha_nacimiento = "Debes tener al menos 15 años.";
        }
    }
    if (empty($idrol)) {
        $error_idrol = "Selecciona un tipo de usuario.";
    }

    // Validar formato de correo
    if (!filter_var($correo, FILTER_VALIDATE_EMAIL)) {
        $error_correo = "El correo electrónico no es válido.";
    }

    // Validar y subir la foto
    if (isset($_FILES["foto"]) && $_FILES["foto"]["error"] === UPLOAD_ERR_OK) {
        $fotosDir = __DIR__ . "/uploads/";

        // Verificar si la carpeta uploads/ existe y si no, crearla
        if (!is_dir($fotosDir)) {
            mkdir($fotosDir, 0777, true);
        }

        $fotosPath = $fotosDir . basename($_FILES["foto"]["name"]);
        $fotoTipo = strtolower(pathinfo($fotosPath, PATHINFO_EXTENSION));

        $check = getimagesize($_FILES["foto"]["tmp_name"]);
        if ($check === false) {
            $error_foto = "El archivo no es una imagen.";
        }

        $formatosPermitidos = ["jpg", "jpeg", "png", "gif"];
        if (!in_array($fotoTipo, $formatosPermitidos)) {
            $error_foto = "Solo se permiten archivos JPG, JPEG, PNG y GIF.";
        }

        if ($_FILES["foto"]["size"] > 5000000) { // 5MB máximo
            $error_foto = "El archivo es demasiado grande.";
        }

        // Intentar mover el archivo solo si no hay errores
        if (empty($error_foto)) {
            if (!move_uploaded_file($_FILES["foto"]["tmp_name"], $fotosPath)) {
                $error_foto = "Hubo un error al subir la imagen.";
            }
        }
    } else {
        $error_foto = "El campo foto es obligatorio.";
    }

    // Verificar si no hay errores antes de insertar en la base de datos
    if (empty($error_nombres) && empty($error_apellidos) && empty($error_correo) && empty($error_clave) && 
        empty($error_confirmar_clave) && empty($error_fecha_nacimiento) && empty($error_idrol) && empty($error_foto)) {

        try {
            $db = new Database();
            $pdo = $db->connectar();

            // Verificar si el correo ya existe
            $stmt = $pdo->prepare("SELECT COUNT(*) FROM usuarios WHERE correo = ?");
            $stmt->execute([$correo]);
            if ($stmt->fetchColumn() > 0) {
                $error_correo = "El correo electrónico ya está registrado.";
            }

            if (empty($error_correo)) {
                $sql = "INSERT INTO usuarios (idrol, nombre, apellido, correo, clave, fecha_nacimiento, foto) 
                        VALUES (?, ?, ?, ?, ?, ?, ?)";
                $stmt = $pdo->prepare($sql);
                $stmt->execute([$idrol, $nombres, $apellidos, $correo, $clave, $fecha_nacimiento, $fotosPath]);

                $mensaje = "Registro exitoso.";
                $clase = "alert-success";
            }
        } catch (PDOException $e) {
            $mensaje = "Error: " . $e->getMessage();
            $clase = "alert-danger";
        }
    } else {
        $mensaje = "Corrige los errores en el formulario.";
        $clase = "alert-danger";
    }
}
?>

<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Registro</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
      .formularioR {
        width: 490px;
        background: linear-gradient(to right, #98f0ff, #dfefff);
        border-radius: 20px;
        padding: 20px;
        margin: 0 auto;
        text-align: left;
        box-sizing: border-box;
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
        background-color: #5df1f67d;
        transform: scale(0);
        transition: transform 0.3s ease;
        border-radius: 10px;
        z-index: -1;
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
    </style>
  </head>
  <body>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <br>
    <div class="container text-center">
      <div class="row">
        <div class="col" align="left">
          <img src="makedlogo.png" width="90" height="30">
        </div>
        <div class="col">
          <a class="nav-link py-2 px-0 px-lg-2" href="index.html"><p>INICIO</p></a>
        </div>
        <div class="col">
          <a class="nav-link py-2 px-0 px-lg-2" href="quienesSomos.php"><p>¿QUIENES SOMOS?</p></a>
        </div>
        <div class="col">
          <a class="nav-link py-2 px-0 px-lg-2" href="empresas.html"><p>EMPRESA</p></a>
        </div>
        <div class="col">
          <a class="nav-link py-2 px-0 px-lg-2" href="programador.html"><p>PROGRAMADOR</p></a>
        </div>
        <div class="col" align="right">
          <button type="button" class="btn btn-light" onclick="window.location.href='iniciarSesion.php'">Iniciar sesion</button>
        </div>
        <div class="col" align="left">
          <button type="button" class="btn btn-info" onclick="window.location.href='registro.php'">Registro</button>
        </div>
      </div>
    </div>
    <div class="container d-flex justify-content-center">
        <div class="formularioR">
            <?php if (!empty($mensaje)): ?>
            <div class="alert <?= $clase ?>"><?= $mensaje ?></div>
            <?php endif; ?>
            <form method="post" action="<?= htmlspecialchars($_SERVER["PHP_SELF"]); ?>" enctype="multipart/form-data">
                <br>
                <p class="fs-3" align="center">Regístrate y descubre los beneficios</p>
                <br>
                <div class="mb-3">
                    <label for="nombres" class="form-label">Nombres:</label>
                    <input type="text" class="form-control" id="nombres" name="nombres" value="<?= htmlspecialchars($nombres); ?>" placeholder="Nombres">
                    <span class="text-danger"><?= $error_nombres; ?></span>
                </div>
                <div class="mb-3">
                    <label for="apellidos" class="form-label">Apellidos:</label>
                    <input type="text" class="form-control" id="apellidos" name="apellidos" value="<?= htmlspecialchars($apellidos); ?>" placeholder="Apellidos">
                    <span class="text-danger"><?= $error_apellidos; ?></span>
                </div>
                <div class="mb-3">
                    <label for="correo" class="form-label">Correo:</label>
                    <input type="email" class="form-control" id="correo" name="correo" value="<?= htmlspecialchars($correo); ?>" placeholder="Correo" >
                    <span class="text-danger"><?= $error_correo; ?></span>
                </div>

                <!-- Campo de Clave con Mostrar/Ocultar -->
                <div class="mb-3">
                    <label for="clave" class="form-label">Clave:</label>
                    <div class="input-group">
                        <input type="password" class="form-control" id="clave" name="clave" value="<?= htmlspecialchars($clave); ?>" placeholder="Minimo 6 caracteres">
                        <button class="btn btn-outline-secondary" type="button" onclick="togglePassword('clave')">
                            <img src="https://cdn-icons-png.flaticon.com/512/709/709724.png" alt="mostrar" width="24" height="24">
                        </button>
                    </div>
                    <span class="text-danger"><?= $error_clave; ?></span>
                </div>

                <!-- Confirmar Clave con Mostrar/Ocultar -->
                <div class="mb-3">
                    <label for="confirmar_clave" class="form-label">Confirmar clave:</label>
                    <div class="input-group">
                        <input type="password" class="form-control" id="confirmar_clave" name="confirmar_clave" value="<?= htmlspecialchars($confirmar_clave); ?>" placeholder="Contraseña">
                        <button class="btn btn-outline-secondary" type="button" onclick="togglePassword('confirmar_clave')">
                            <img src="https://cdn-icons-png.flaticon.com/512/709/709724.png" alt="mostrar" width="24" height="24">
                        </button>
                    </div>
                    <span class="text-danger"><?= $error_confirmar_clave; ?></span>
                </div>

                <div class="mb-3">
                    <label for="fecha_nacimiento" class="form-label">Fecha de nacimiento:</label>
                    <input type="date" class="form-control" id="fecha_nacimiento" name="fecha_nacimiento" value="<?= htmlspecialchars($fecha_nacimiento); ?>">
                    <span class="text-danger"><?= $error_fecha_nacimiento; ?></span>
                </div>
                <div class="mb-3">
                    <label for="foto" class="form-label">Foto de perfil:</label>
                    <input type="file" class="form-control" id="foto" name="foto">
                    <span class="text-danger"><?= $error_foto; ?></span>
                </div>
                <div class="mb-3">
                    <label for="idrol" class="form-label">Tipo de usuario:</label>
                    <select class="form-select" id="idrol" name="idrol">
                        <option value="">Seleccionar</option>
                        <option value="1" <?= $idrol == 1 ? 'selected' : ''; ?>>Programador</option>
                        <option value="2" <?= $idrol == 2 ? 'selected' : ''; ?>>Empresa</option>
                    </select>
                    <span class="text-danger"><?= $error_idrol; ?></span>
                    <div align="center">
                    <br><br>
                  <button type="submit" class="btn btn-info btn-lg">Registrarse</button>
    
            </form>
        </div>
    </div>

    <script>
      function togglePassword(id) {
        var passwordField = document.getElementById(id);
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