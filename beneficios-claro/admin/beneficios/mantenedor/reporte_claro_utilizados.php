<?php
session_start();
if (isset($_SESSION["id"])){
    /**
     *DESPCRIPCION:          Obtiene reporte segun SQL
     *CLUB:                  Fidelis
     *FECHA CREACION:        02/06/2016.
     *FECHA MODIFICACION:    02/05/2016.
     *AUTOR MODIFICACION:    Felipe Polanco.
     *MOTIVO MODIFICACION:   Obtiene reporte segun SQL
     *
     **/


    ini_set('memory_limit', '256M'); //AUMENTAMOS EL LIMITE DE MEMORIA
    set_time_limit (3000); // AUMENTAMOS EL TIEMPO DE EJECUCION
    error_reporting(E_ALL); // MUESTRA TODO LOS ERRORES
    include('includes/connLocal.php'); // ARCHIVO DE CONEXION
    require_once 'clases/PHPExcel.php'; // clase PHPExcel
    include('clases/fecha.class.php');

    $objPHPExcel = new PHPExcel();
    $objFecha = new fecha();

    /*Nombre de la planilla excel*/

    $hoy = date("Ymd");

    $fecha_desde = $objFecha->to_sql($_GET["fecha_desde"]);
    $fecha_hasta = $objFecha->to_sql($_GET["fecha_hasta"]);


    $nombre_planilla="Reporte Convenios Utilizados";
    /*Fin Nombre de la planilla excel*/

    /*SQL para obtener datos del reporte*/

    $sql="SELECT codigo.id_Convenio as ID_Convenio,convenio.marca as Nombre_Convenio,codigo.Rut as Rut_Cliente,codigo.Fecha_Uso as Fecha_Uso FROM codigo, convenio WHERE codigo.id_Convenio = convenio.id AND (fecha_uso >='".$fecha_desde." 00:00:00' and fecha_uso <= '".$fecha_hasta." 23:59:59') GROUP BY id_Convenio";
    /*Fin SQL para obtener datos del reporte*/

    $result = @mysql_query($sql,$link_local )
    or die("Couldn't execute query:<br>" . mysql_error(). "<br>" . mysql_errno());



// Establecer la hoja de cálculo Excel 0

    $objPHPExcel->setActiveSheetIndex(0);

// Seteamos número de fila de Excel

    $rowCount = 1;


//Asignamos a la primera fila los nombres de los campos de SQL

    $objPHPExcel->getActiveSheet()->setCellValue('A'.$rowCount, 'Fecha Solicitud: '.date("j-m-Y"));
    $rowCount = 2;
    $objPHPExcel->getActiveSheet()->setCellValue('A'.$rowCount, 'Rango de fechas seleccionadas: '.$fecha_desde. " - ".$fecha_hasta);
    $rowCount = 3;

    $column = 'A';
    for ($i = 0; $i < mysql_num_fields($result); $i++)
    {
        $objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, mysql_field_name($result,$i));
        $column++;
    }
//Fin Asignamos a la primera fila los nombres de los campos de SQL

    /*Definir Columnas para tipos de datos numericos que se deben mostrar como string, ej: codigos de giftcard*/

    $array_codigos = array("A");
    /*Fin Definir Columnas para tipos de datos numericos que se deben mostrar como string, ej: codigos de giftcard*/

//Generar loop para recorrer los datos obtenidos mediante la consulta.
    $rowCount = 4;

    while($row = mysql_fetch_row($result))
    {
        $column = 'A';
        for($j=0; $j<mysql_num_fields($result);$j++)
        {
            if(!isset($row[$j]))
                $value = NULL;
            elseif ($row[$j] != "")
                $value = strip_tags($row[$j]);
            else
                $value = "";

            if (in_array($column, $array_codigos)) { // TRANSFORMA LOS CODIGOS A STRING

                $objPHPExcel->getActiveSheet()->setCellValueExplicit($column.$rowCount, utf8_encode($value),PHPExcel_Cell_DataType::TYPE_STRING);
            }else{  //Almacena los datos con utf8 encode

                $objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, utf8_encode($value));
            }

            $column++;
        }
        $rowCount++;
    }
//FIN Generar loop para recorrer los datos obtenidos mediante la consulta.

// Redirigir salida al navegador como XLS o XLSX

    /*XLS*/
    /*
    header('Content-Type: application/vnd.ms-excel');
    header('Content-Disposition: attachment;filename="'$nombre_planilla'.xls"');
    header('Cache-Control: max-age=0');
    $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
    $objWriter->save('php://output');
    */
    /*FIN XLS*/


    /*XLSX*/

    header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    header('Content-Disposition: attachment;filename="'.$nombre_planilla.'.xlsx"');
    header('Cache-Control: max-age=0');
    $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
    $objWriter->save('php://output');

    /*FIN XLSX*/
}else{

    header ("Location: Login.php");

}