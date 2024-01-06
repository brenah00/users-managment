<?php
require 'vendor/autoload.php';
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

date_default_timezone_set('America/Mexico_City');

// Función para calcular la edad
function calcularEdad($fechaNacimiento) {
    $fechaActual = new DateTime();
    $fechaNacimiento = new DateTime($fechaNacimiento);
    $edad = $fechaActual->diff($fechaNacimiento)->y;
    return $edad;
}

// Conexión a la base de datos (asume que ya tienes esto configurado)
$inc = include("conexion.php");

if ($inc) {
    // Consulta a la base de datos
    $consulta = "SELECT * FROM users";
    $resultado = mysqli_query($conex, $consulta);

    // Crear instancia de PhpSpreadsheet
    $spreadsheet = new Spreadsheet();
    $sheet = $spreadsheet->getActiveSheet();

    // Encabezados de la tabla
    $sheet->setCellValue('A1', 'Nombre');
    $sheet->setCellValue('B1', 'Fecha de nacimiento');
    $sheet->setCellValue('C1', 'Edad');
    $sheet->setCellValue('D1', 'Género');

    // Rellenar la tabla con datos
    $row = 2;
    while ($row_data = $resultado->fetch_assoc()) {
        $sheet->setCellValue('A' . $row, $row_data['nombre']);
        $sheet->setCellValue('B' . $row, $row_data['fecha_de_nacimiento']);
        $sheet->setCellValue('C' . $row, calcularEdad($row_data['fecha_de_nacimiento']));
        $sheet->setCellValue('D' . $row, $row_data['genero']);
        $row++;
    }

    // Crear un objeto Writer para Xlsx (Excel)
    $writer = new Xlsx($spreadsheet);

    // Guardar el archivo en el servidor
    $excel_filename = 'ListaUsuarios.xlsx';
    $writer->save($excel_filename);

    // Descargar el archivo Excel
    header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    header('Content-Disposition: attachment;filename="' . $excel_filename . '"');
    header('Cache-Control: max-age=0');
    $writer->save('php://output');

} else {
    echo "Error al conectar a la base de datos";
}
?>
