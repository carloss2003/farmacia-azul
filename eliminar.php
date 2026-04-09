<?php
$conn = new mysqli("172.31.16.172", "root", "CruzAzul2026!", "farmacia");

if ($conn->connect_error) {
    die("Error conexión");
}

$id = $_GET['id'];

$stmt = $conn->prepare("DELETE FROM productos WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();

$stmt->close();
$conn->close();

// volver al panel
header("Location: index.php");
exit();
?>