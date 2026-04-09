<?php
$conn = new mysqli("localhost", "root", "", "farmacia");

if ($conn->connect_error) {
    die("Error conexión");
}

// OBTENER ID
$id = $_GET['id'];

// SI ENVÍA FORMULARIO → ACTUALIZAR
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $stmt = $conn->prepare("UPDATE productos SET producto=?, descripcion=?, cantidad=?, precio=? WHERE id=?");

    $stmt->bind_param("ssiii",
        $_POST['producto'],
        $_POST['descripcion'],
        $_POST['cantidad'],
        $_POST['precio'],
        $id
    );

    $stmt->execute();

    $stmt->close();
    $conn->close();

    header("Location: index.php");
    exit();
}

// OBTENER DATOS ACTUALES
$result = $conn->query("SELECT * FROM productos WHERE id=$id");
$row = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html>
<head>
<title>Editar Producto</title>
</head>

<body>

<h2>Editar Producto</h2>

<form method="POST">
    <input type="text" name="producto" value="<?php echo $row['producto']; ?>"><br>
    <input type="text" name="descripcion" value="<?php echo $row['descripcion']; ?>"><br>
    <input type="number" name="cantidad" value="<?php echo $row['cantidad']; ?>"><br>
    <input type="number" name="precio" value="<?php echo $row['precio']; ?>"><br>

    <button type="submit">Guardar Cambios</button>
</form>

</body>
</html>