<?php 
include("conexion.php"); 
$id = $_GET["id"]; 
$consulta = "SELECT * FROM users WHERE id = '$id'";
$resultado = mysqli_query($conex, $consulta);

if (!$resultado) {
    die('Error en la consulta: ' . mysqli_error($conex));
}
$row = mysqli_fetch_array($resultado);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Actualizar información</title>
</head>
<body>
    <form method="post"  action="guardarCambios.php">
        <h2>Actualizar información de usuario</h2>
        <input name="user-id" type="hidden" value="<?php echo $row['id']?>">
        <label for="username">Nombre</label>
        <input id="username" type="text" name="name" value="<?php echo $row['nombre']?>">
        <label for="user-birthday">Fecha de nacimiento</label>
        <input type="date" name="date_of_birth" id="user-birthday" value="<?php echo $row['fecha_de_nacimiento']?>">
        <label for="gender">Género</label>
        <select name="gender" id="gender">
            <option value="Masculino" <?php echo ($row['genero'] == 'Masculino') ? 'selected' : ''; ?>>Masculino</option>
            <option value="Femenino" <?php echo ($row['genero'] == 'Femenino') ? 'selected' : ''; ?>>Femenino</option>
        </select>
        <input type="submit" name="save-changes" value="Guardar cambios">
    </form>
</body>
</html>
