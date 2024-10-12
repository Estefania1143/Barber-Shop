<?php

$nombredelservidor = "localhost";
$nombre_de_usuario = "root"; 
$contraseña = "";
$dbname = "formulario";

$conn = mysqli_connect($nombredelservidor, $nombre_de_usuario, $contraseña, $dbname);

// Verificar conexión
if (!$conn) {
    die("Error de conexión: " . mysqli_connect_error());
}

// Obtener datos del formulario
$nombre = $_POST['nombre'] ?? 'Nombre no proporcionado';
$celular = $_POST['celular'] ?? 'Celular no proporcionado';
$fecha = $_POST['fecha'] ?? 'Fecha no proporcionada';

// Preparar la consulta SQL
$stmt = $conn->prepare("INSERT INTO dato (nombre, celular, fecha) VALUES (?, ?, ?)");
$stmt->bind_param("sss", $nombre, $celular, $fecha);

// Ejecutar la consulta
if ($stmt->execute()) {
    echo "Datos insertados correctamente";
} else {
    echo "Error al insertar datos: " . $stmt->error;
}

// Cerrar la declaración
$stmt->close();

// Mostrar los datos insertados en una tabla separada
$sql = "SELECT * FROM dato WHERE nombre = ? AND celular = ? AND fecha = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("sss", $nombre, $celular, $fecha);
$stmt->execute();
$resultado = $stmt->get_result();

if ($resultado->num_rows > 0) {
    echo "<h2>Datos Insertados</h2>";
    echo "<table>";
    echo "<tr><th>ID</th><th>Nombre</th><th>Celular</th><th>Fecha</th></tr>";
    while ($fila = $resultado->fetch_assoc()) {
        echo "<tr>";
        echo "<td>" . $fila["id"] . "</td>";
        echo "<td>" . $fila["nombre"] . "</td>";
        echo "<td>" . $fila["celular"] . "</td>";
        echo "<td>" . $fila["fecha"] . "</td>";
        echo "</tr>";
    }
    echo "</table>";
} else {
    echo "No se encontraron datos";
}

// Cerrar la conexión
$conn->close();

?>
