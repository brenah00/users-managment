<?php
date_default_timezone_set('America/Mexico_City');
$fechaActual = new DateTime();

function calcularEdad($fechaNacimiento) {
    $fechaActual = new DateTime();
    $fechaNacimiento = new DateTime($fechaNacimiento);
    $edad = $fechaActual->diff($fechaNacimiento)->y;
    return $edad;
}
ob_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<style>
    /* Estilos para el contenido de la página */
body {
    font-family: Arial, sans-serif;
    margin: 20px;
}

h2 {
    text-align: center;
    color: #333;
}

/* Estilos para la tabla */
table {
    width: 100%;
    border-collapse: collapse;
    margin-top: 20px;
}

th, td {
    border: 1px solid #dddddd;
    text-align: left;
    padding: 8px;
}

th {
    background-color: #f2f2f2;
}

</style>
<body>
    <h2>Lista de usuarios</h2>
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
                    <th>Edad</th>
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
                        <td><?php echo calcularEdad($row['fecha_de_nacimiento']); ?></td>
                        <td><?php echo $gender; ?></td>
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
    <p>Reporte generado <?php echo $fechaActual->format('d-m-Y H:i:s');?></p>
</body>
</html>
<?php
    $html = ob_get_clean();

require_once "./libreria/dompdf/autoload.inc.php";
use Dompdf\Dompdf;
$dompdf = new Dompdf();
$options = $dompdf->getOptions();
$options->set(array('isRemoteEnabled'=> true));
$dompdf->setOptions($options);

$dompdf->loadHtml($html);
$dompdf->setPaper('letter');

$dompdf->render();

$dompdf->stream("ListaUsuarios.pdf", array("Attachment"=> false));
?>