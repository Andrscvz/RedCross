<?php
  // connection with the database
  include "../../includes/conexion.php";

  // require the PHPExcel file
  require '../../includes/PHPExcel.php';

  // simple query

  $query = "SELECT 
                  id_carrera,
                  c_nombre,
                  c_desc,
                  c_fechaCreacion,
                  if(c_estatus = 1,'Activo','Baja') as Estatus
              FROM
                  carrera
              order by
                c_nombre";
  $headings = array('id', 'Siglas','Nombre', 'Fecha Creacion', 'Estatus');

  if ($result = mysqli_query($conexion, $query) or die(mysql_error())) {
    // Create a new PHPExcel object
    $objPHPExcel = new PHPExcel();
    $objPHPExcel->getActiveSheet()->setTitle('Lista de Carreras');

    $rowNumber = 1;
    $col = 'A';
    foreach($headings as $heading) {
      $objPHPExcel->getActiveSheet()->setCellValue($col.$rowNumber,$heading);
      $col++;
    }

    // Loop through the result set
    $rowNumber = 2;
    while ($row = mysqli_fetch_assoc($result)) {
      $col = 'A';
      foreach($row as $cell) {
        $objPHPExcel->getActiveSheet()->setCellValue($col.$rowNumber,$cell);
        $col++;
      }
      $rowNumber++;
    }

    // Freeze pane so that the heading line won't scroll
    $objPHPExcel->getActiveSheet()->freezePane('A2');

    // Save as an Excel BIFF (xls) file
    $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');

    header('Content-Type: application/vnd.ms-excel');
    header('Content-Disposition: attachment;filename="reporteCarreras.xls"');
    header('Cache-Control: max-age=0');

    $objWriter->save('php://output');
    exit();
  }
  echo 'A problem has occurred... no data retrieved from the database';
?>
