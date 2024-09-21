<?php
// Configuración de conexión a la base de datos
$host = 'localhost';
$db = 'maked';
$user = 'root';
$pass = '';

// Crear conexión
$conn = new mysqli($host, $user, $pass, $db);
session_start();

// Verificar conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Consultar publicaciones y datos del usuario, incluyendo el correo electrónico
$sql = "
    SELECT 
        posts.id AS post_id, 
        posts.title, 
        posts.pago, 
        posts.nivel, 
        posts.horas_dias, 
        posts.content, 
        posts.timestamp, 
        usuarios.nombre AS user_name, 
        usuarios.apellido AS user_last_name,
        usuarios.correo AS user_email
    FROM 
        posts
    INNER JOIN 
        usuarios ON posts.id_usuario = usuarios.id
    ORDER BY 
        posts.timestamp DESC
";

$result = $conn->query($sql);

$posts = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $posts[] = [
            'id' => $row['post_id'],
            'title' => $row['title'],
            'pago' => $row['pago'],
            'nivel' => $row['nivel'], // Correcto como 'nivel'
            'horas_dias' => $row['horas_dias'],
            'content' => $row['content'],
            'timestamp' => $row['timestamp'],
            'user_name' => $row['user_name'],
            'user_last_name' => $row['user_last_name'],
            'user_email' => $row['user_email'] // Correcto como 'user_email'
        ];
    }
}

header('Content-Type: application/json');
echo json_encode($posts);

$conn->close();
?>
