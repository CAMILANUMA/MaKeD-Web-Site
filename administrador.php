<?php
session_start();
require_once 'conexionbasica.php';

// Establecer la conexión a la base de datos
$db = new Database();
$pdo = $db->connectar();

// Verificar si el usuario está autenticado y tiene el rol de administrador
if (!isset($_SESSION['idrol']) || $_SESSION['idrol'] != 3) {
    header('Location: iniciarSesion.php');
    exit();
}

// Manejo de eliminación de usuario
if (isset($_GET['action']) && $_GET['action'] == 'delete' && isset($_GET['id'])) {
    $id = $_GET['id'];
    $stmt = $pdo->prepare("DELETE FROM usuarios WHERE id = ?");
    $stmt->execute([$id]);
    header('Location: ?'); // Redirige a la misma página después de eliminar
    exit();
}

// Manejo de actualización de usuario
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] == 'edit') {
    $id = $_POST['id'];
    $nombre = $_POST['nombre'];
    $apellido = $_POST['apellido'];
    $correo = $_POST['correo'];
    $fecha_nacimiento = $_POST['fecha_nacimiento'];

    $stmt = $pdo->prepare("UPDATE usuarios SET nombre = ?, apellido = ?, correo = ?, fecha_nacimiento = ? WHERE id = ?");
    $stmt->execute([$nombre, $apellido, $correo, $fecha_nacimiento, $id]);

    header('Location: ?'); // Redirige a la misma página después de actualizar
    exit();
}

// Obtener todos los usuarios
$stmt = $pdo->prepare("SELECT id, nombre, apellido, correo, fecha_nacimiento, foto FROM usuarios");
$stmt->execute();
$usuarios = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Usuarios</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
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
        .container {
            max-width: 1200px;
            margin: 0 auto;
        }
        .table-container {
            background-color: #f9f9f9;
            padding: 20px;
            border-radius: 10px;
            border: 1px solid #ddd;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        .table {
            width: 100%;
            border-collapse: collapse;
        }
        .table th, .table td {
            padding: 15px;
            text-align: center;
            vertical-align: middle;
            border: 1px solid #ddd;
        }
        .table thead th {
            background-color: #b9f6ff;
            color: #333;
        }
        .table tbody tr:nth-child(even) {
            background-color: #f2f2f2;
        }
        .btn-custom {
            margin: 0 10px; /* Mayor espacio entre botones */
        }
        .user-photo {
            width: 100px;
            height: 100px;
            object-fit: cover;
            border-radius: 50%;
        }
        .table-container h2 {
            font-size: 1.5rem;
            margin-bottom: 20px;
        }
        .table-container {
            max-width: 1000px;
            margin: 0 auto;
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
        <div class="container">
            <div class="table-container">
                <h2 class="text-center">Lista de Usuarios Registrados</h2>
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Foto</th>
                            <th>ID</th>
                            <th>Nombre</th>
                            <th>Apellido</th>
                            <th>Correo</th>
                            <th>Edad</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($usuarios as $usuario): ?>
                            <?php
                                $fechaNacimiento = new DateTime($usuario['fecha_nacimiento']);
                                $hoy = new DateTime();
                                $edad = $hoy->diff($fechaNacimiento)->y;
                            ?>
                            <tr>
                                <td><img src="<?php echo htmlspecialchars($usuario['foto']); ?>" alt="Foto" class="user-photo"></td>
                                <td><?php echo htmlspecialchars($usuario['id']); ?></td>
                                <td><?php echo htmlspecialchars($usuario['nombre']); ?></td>
                                <td><?php echo htmlspecialchars($usuario['apellido']); ?></td>
                                <td><?php echo htmlspecialchars($usuario['correo']); ?></td>
                                <td><?php echo $edad; ?></td>
                                <td>
                                    <a href="?action=edit&id=<?php echo urlencode($usuario['id']); ?>" class="btn btn-primary btn-custom">Editar</a>
                                    <br><br>
                                    <a href="?action=delete&id=<?php echo urlencode($usuario['id']); ?>" class="btn btn-danger btn-custom" onclick="return confirm('¿Estás seguro de eliminar este usuario?');">Eliminar</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>

        <?php if (isset($_GET['action']) && $_GET['action'] == 'edit' && isset($_GET['id'])): ?>
            <?php
                $id = $_GET['id'];
                $stmt = $pdo->prepare("SELECT * FROM usuarios WHERE id = ?");
                $stmt->execute([$id]);
                $usuario = $stmt->fetch(PDO::FETCH_ASSOC);
            ?>
            <div class="container mt-5">
                <h2 class="text-center">Editar Usuario</h2>
                <form method="POST">
                    <input type="hidden" name="action" value="edit">
                    <input type="hidden" name="id" value="<?php echo htmlspecialchars($usuario['id']); ?>">
                    <div class="mb-3">
                        <label for="nombre" class="form-label">Nombre</label>
                        <input type="text" class="form-control" id="nombre" name="nombre" value="<?php echo htmlspecialchars($usuario['nombre']); ?>" required>
                    </div>
                    <div class="mb-3">
                        <label for="apellido" class="form-label">Apellido</label>
                        <input type="text" class="form-control" id="apellido" name="apellido" value="<?php echo htmlspecialchars($usuario['apellido']); ?>" required>
                    </div>
                    <div class="mb-3">
                        <label for="correo" class="form-label">Correo</label>
                        <input type="email" class="form-control" id="correo" name="correo" value="<?php echo htmlspecialchars($usuario['correo']); ?>" required>
                    </div>
                    <div class="mb-3">
                        <label for="fecha_nacimiento" class="form-label">Fecha de Nacimiento</label>
                        <input type="date" class="form-control" id="fecha_nacimiento" name="fecha_nacimiento" value="<?php echo htmlspecialchars($usuario['fecha_nacimiento']); ?>" required>
                    </div>
                    <button type="submit" class="btn btn-success">Guardar Cambios</button>
                    <br><br>
                    <a href="muroAdministrador.php" class="btn btn-secondary">Volver</a>
                </form>
            </div>
        <?php endif; ?>
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>