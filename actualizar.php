<?php
include("conexion.php");

$id = $_GET["id"];
$consulta = "SELECT * FROM users WHERE id = '$id'";
$resultado = mysqli_query($conex, $consulta);

if (!$resultado) {
    die('Error en la consulta: ' . mysqli_error($conex));
}

$row = mysqli_fetch_array($resultado);

$fecha_actual = date("Y-m-d");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Actualizar información</title>
    <link rel="stylesheet" type="text/css" href="style.css">

</head>
<body>
    <form method="post">
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
        <?php 
            if (isset($_POST["save-changes"])) {
                $name = trim($_POST['name']);
                $date_of_birth = trim($_POST['date_of_birth']);
                $gender = trim($_POST['gender']);
            
                if (!empty($name) && !empty($date_of_birth) && !empty($gender)) {
                    if ($date_of_birth <= $fecha_actual) {
                        $actualizar = "UPDATE users SET nombre='$name', fecha_de_nacimiento='$date_of_birth', genero='$gender' WHERE id='$id'";
                        $resultado = mysqli_query($conex, $actualizar);
            
                        if ($resultado) {
                            header("Location: index.php");
                            exit;
                        } else {
                            echo "<p class='error-message'>Ha ocurrido un error</p>";
                        }
                    } else {
                        echo "<p class='error-message'>La fecha de nacimiento no puede ser posterior a la fecha actual</p>";
                    }
                } else {
                    echo "<p class='error-message'>Llena todos los campos</p>";
                }
            }
        ?>
        <input type="submit" name="save-changes" value="Guardar cambios">
    </form>
</body>
</html>
