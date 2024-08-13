<?php
// Conectar a la base de datos
$servername = "localhost"; // Cambia esto si es necesario
$username = "root"; // Cambia esto si es necesario
$password = ""; // Cambia esto si es necesario
$dbname = "EncuestaProfesores";

// Crear la conexión
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar la conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Obtener los datos del formulario y sanitizarlos para evitar inyección de código
$nombre_estudiante = $conn->real_escape_string($_POST['nombre']);
$correo_institucional = $conn->real_escape_string($_POST['email']);
$nombre_profesor = $conn->real_escape_string($_POST['profesor']);
$materia = $conn->real_escape_string($_POST['materia']);
$calificacion_profesor = intval($_POST['calificacion']); // Convertir la calificación a un número entero
$comentarios_adicionales = $conn->real_escape_string($_POST['comentarios']);

// Preparar la consulta SQL para insertar los datos
$sql = "INSERT INTO EvaluacionProfesor (nombre_estudiante, correo_institucional, nombre_profesor, materia, calificacion_profesor, comentarios_adicionales) 
        VALUES (?, ?, ?, ?, ?, ?)";

// Preparar la sentencia
$stmt = $conn->prepare($sql);
if ($stmt === false) {
    die("Error en la preparación de la consulta: " . $conn->error);
}

// Enlazar los parámetros
$stmt->bind_param("ssssds", $nombre_estudiante, $correo_institucional, $nombre_profesor, $materia, $calificacion_profesor, $comentarios_adicionales);

// Ejecutar la sentencia
if ($stmt->execute() === TRUE) {
    echo "¡Encuesta guardada exitosamente!";
} else {
    echo "Error: " . $stmt->error;
}

// Cerrar la sentencia y la conexión
$stmt->close();
$conn->close();
?>
