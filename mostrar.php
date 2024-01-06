<?php
$inc = include("conexion.php");
    if($inc){
        $consulta = "SELECT * FROM users";
        $resultado = mysqli_query($conex, $consulta);

        if($resultado){
            ?>
            <table>
                <tr>
                    <th>Nombre</th>
                    <th>Fecha de nacimiento</th>
                    <th>Género</th>
                </tr>
                <?php
            
                while($row = $resultado -> fetch_array()){
                    $id = $row['id'];
                    $name =  $row['nombre'];
                    $date_of_birth = new DateTime($row['fecha_de_nacimiento']);
                    $gender =  $row['genero'];
                ?>
                    <tr>
                        <td><?php echo $name; ?></td>
                        <td><?php echo $date_of_birth->format('d-m-Y'); ?></td>
                        <td><?php echo $gender; ?></td>
                        <td><a href="actualizar.php?id=<?php echo $id ?>"><button>Editar</button></a></td>
                    </tr>
                    <?php
                }
            ?>
            </table>
            <?php
            
            }
        ?>
        <?php        
    }
    else {
        ?>
            <h3>Ha ocurrido un error</h3>
        <?php
        }
    ?>