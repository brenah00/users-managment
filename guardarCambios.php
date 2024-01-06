<?php
include("conexion.php");
    if(isset($_POST["save-changes"])){
        if(
            strlen($_POST['name']) >= 1 &&
            strlen($_POST['date_of_birth']) >= 1 &&
            strlen($_POST['gender']) >= 1
            ){
                $id = trim($_POST['user-id']);
                $name = trim($_POST['name']);
                $date_of_birth = trim($_POST['date_of_birth']);
                $gender = trim($_POST['gender']);

                $actualizar = "UPDATE users SET nombre='$name', fecha_de_nacimiento='$date_of_birth', genero='$gender' WHERE id='$id'";
                $resultado = mysqli_query($conex, $actualizar);

                if($resultado){
                    ?>
                    <h3>Informacion almacenada</h3>
                    <?php
                    header("Location: index.php");
                    exit;
                } else {
                    ?>
                    <h3>Ha ocurrido un error</h3>
                    <?php
                }
        }
        else {
            ?>
            <h3>Llena todos los campos</h3>
            <?php
        }
    }
?>