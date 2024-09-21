<?php
include_once 'conexionbasica.php';
session_start();

// Configuración de conexión a la base de datos
$host = 'localhost';
$db = 'maked';
$user = 'root';
$pass = '';

// Crear conexión
$conn = new mysqli($host, $user, $pass, $db);

// Verificar conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Asegurarse de que el usuario está autenticado
if (!isset($_SESSION['id'])) {
    die("No estás autenticado. Por favor, inicia sesión.");
}

// Obtener datos del post
$title = $_POST['title'] ?? '';
$pago = $_POST['pago'] ?? '';
$nivel = $_POST['niveles'] ?? ''; // Verifica el nombre del campo enviado
$horas = $_POST['horas_dias'] ?? '';
$content = $_POST['content'] ?? '';
$id_usuario = $_SESSION['id']; // Obtener ID del usuario desde la sesión

// Evitar inyecciones SQL
$title = $conn->real_escape_string($title);
$pago = $conn->real_escape_string($pago);
$nivel = $conn->real_escape_string($nivel);
$horas = $conn->real_escape_string($horas);
$content = $conn->real_escape_string($content);

// Insertar nuevo post
$sql = "INSERT INTO posts (id_usuario, title, pago, nivel, horas_dias, content) VALUES ('$id_usuario', '$title', '$pago', '$nivel', '$horas', '$content')";

if ($conn->query($sql) === TRUE) {
    echo "Nuevo post creado exitosamente";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();
?>
