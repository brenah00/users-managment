<?php
include("conexion.php");
    if(isset($_POST["save"])){
        if(
            strlen($_POST['name']) >= 1 &&
            strlen($_POST['date_of_birth']) >= 1 &&
            strlen($_POST['gender']) >= 1
            ){
                $name = trim($_POST['name']);
                $date_of_birth = trim($_POST['date_of_birth']);
                $gender = trim($_POST['gender']);

                $consulta = "INSERT INTO users(nombre, fecha_de_nacimiento, genero) VALUES('$name','$date_of_birth','$gender')";
                $resultado = mysqli_query($conex, $consulta);

                if($resultado){
                    ?>
                    <p>Informacion almacenada</p>
                    <?php
                } else {
                    ?>
                    <p>Ha ocurrido un error</p>
                    <?php
                }
        }
        else {
            ?>
            <p>Llena todos los campos</p>
            <?php
        }
    }
?>