<?php
$conn = new mysqli("34.205.104.220", "root", "CruzAzul2026!", "farmacia");

if ($conn->connect_error) {
    die("Error conexión");
}

// detectar página
$page = isset($_GET['page']) ? $_GET['page'] : 'dashboard';

// métricas
$total = 0;
$bajo_stock = 0;
$valor_total = 0;

$result = $conn->query("SELECT * FROM productos");

if ($result) {
    while($row = $result->fetch_assoc()){
        $total++;
        
        if($row['cantidad'] < 5){
            $bajo_stock++;
        }

        $valor_total += $row['cantidad'] * $row['precio'];
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<title>ERP Farmacia</title>

<style>
body { margin:0; font-family: Arial; background:#eef2f7; }

.sidebar {
    width:220px; height:100vh;
    background:#1e293b; color:white;
    position:fixed; padding:20px;
}

.sidebar a {
    display:block; color:white;
    padding:10px; text-decoration:none;
    margin-top:10px;
}

.sidebar a:hover {
    background:#334155;
}

.main {
    margin-left:240px;
    padding:20px;
}

.cards {
    display:flex;
    gap:15px;
    margin-bottom:20px;
}

.card {
    background:white;
    padding:20px;
    border-radius:10px;
    flex:1;
    box-shadow:0px 2px 5px rgba(0,0,0,0.1);
}

input {
    width:100%;
    padding:10px;
    margin:5px 0;
    border:1px solid #ccc;
    border-radius:5px;
}

button {
    background:#0b5ed7;
    color:white;
    padding:10px;
    border:none;
    border-radius:5px;
    cursor:pointer;
}

table {
    width:100%;
    border-collapse:collapse;
    margin-top:20px;
    background:white;
}

th {
    background:#0b5ed7;
    color:white;
}

th, td {
    border:1px solid #ddd;
    padding:10px;
    text-align:center;
}

.bajo {
    background:#ffcccc;
}
</style>
</head>

<body>

<!-- SIDEBAR -->
<div class="sidebar">
    <h2>💊 ERP</h2>
    <a href="index.php?page=dashboard">Dashboard</a>
    <a href="index.php?page=inventario">Inventario</a>
</div>

<!-- MAIN -->
<div class="main">

<h2>Gestión de Inventario</h2>

<?php if($page == 'dashboard'): ?>

<!-- DASHBOARD -->

<div class="cards">
    <div class="card">
        <h3><?php echo $total; ?></h3>
        <p>Productos registrados</p>
    </div>

    <div class="card">
        <h3><?php echo $bajo_stock; ?></h3>
        <p>Bajo stock</p>
    </div>

    <div class="card">
        <h3>$<?php echo number_format($valor_total,0,',','.'); ?></h3>
        <p>Valor inventario</p>
    </div>
</div>

<div class="card">
<h3>Ingresar Producto</h3>

<form action="backend.php" method="POST">
    <input type="text" name="producto" placeholder="Producto" required>
    <input type="text" name="descripcion" placeholder="Descripción" required>
    <input type="number" name="cantidad" placeholder="Cantidad" required>
    <input type="number" name="precio" placeholder="Precio" required>
    <button type="submit">Guardar</button>
</form>
</div>

<?php endif; ?>


<?php if($page == 'inventario'): ?>

<!-- INVENTARIO -->

<div class="card">
<h3>Inventario</h3>

<table>
<tr>
<th>ID</th>
<th>Producto</th>
<th>Descripción</th>
<th>Cantidad</th>
<th>Precio</th>
<th>Acciones</th>
</tr>

<?php
$result = $conn->query("SELECT * FROM productos");

if ($result && $result->num_rows > 0) {
    while($row = $result->fetch_assoc()){

        $clase = ($row['cantidad'] < 5) ? "class='bajo'" : "";

        echo "<tr $clase>
        <td>{$row['id']}</td>
        <td>{$row['producto']}</td>
        <td>{$row['descripcion']}</td>
        <td>{$row['cantidad']}</td>
        <td>{$row['precio']}</td>
        <td>
            <a href='editar.php?id={$row['id']}'>Editar</a> |
            <a href='eliminar.php?id={$row['id']}' 
               onclick='return confirmar()' 
               style='color:red;'>Eliminar</a>
        </td>
        </tr>";
    }
} else {
    echo "<tr><td colspan='6'>Sin productos</td></tr>";
}
?>

</table>

</div>

<?php endif; ?>

</div>

<!-- CONFIRMAR ELIMINAR -->
<script>
function confirmar() {
    return confirm("¿Seguro que quieres eliminar este producto?");
}
</script>

</body>
</html>