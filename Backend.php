<?php
$conn = new mysqli("34.205.104.220", "root", "CruzAzul2026!", "farmacia");

if ($conn->connect_error) {
    die("Error conexión");
}

// VALIDAR QUE EXISTEN LOS DATOS
if(isset($_POST['producto'], $_POST['descripcion'], $_POST['cantidad'], $_POST['precio'])){

    $stmt = $conn->prepare("INSERT INTO productos (producto, descripcion, cantidad, precio) VALUES (?, ?, ?, ?)");

    $stmt->bind_param("ssii",
        $_POST['producto'],
        $_POST['descripcion'],
        $_POST['cantidad'],
        $_POST['precio']
    );

    $stmt->execute();
    $stmt->close();
}

$conn->close();

// REDIRECCIÓN
header("Location: index.php");
exit();
?>