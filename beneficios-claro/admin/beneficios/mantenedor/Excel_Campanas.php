<?php
session_start();
if (isset($_SESSION["id"])){
	
ini_set('mssql.charset', 'UTF-8');
include("includes/conn.php");
require("clases/PHPExcel.php");
include("clases/campana.class.php");
include("includes/connLocal.php");


$sql = "SELECT 
		    c.id_Campana AS 'ID',
		    c.Descripcion AS 'Nombre',
		    c.id_Convenio AS 'ID Convenio',
		    es.Descripcion AS 'Estado',
		    c.Fecha_Vigencia AS 'Fecha de Vigencia'
		FROM
		    campana AS c
		        LEFT JOIN
		    estado AS es ON es.id_Estado = c.id_Estado";

$res=mysql_query($sql,$link_local);
$arregloCanjes = array();

while ($rs = mysql_fetch_assoc($res))
{
	$arregloCanjes[$i]['ID']			= $rs['ID'];
	$arregloCanjes[$i]['Nombre']		= $rs['Nombre'];
	$arregloCanjes[$i]['ID Convenio']	= $rs['ID Convenio'];
	$arregloCanjes[$i]['Estado']		= $rs['Estado'];
	$arregloCanjes[$i]['Fecha de Vigencia']	= $rs['Fecha de Vigencia'];

	$i++;

}

//print_r($arregloCanjes);


$hoy = date('Ymd');
$j= 1 ;


$objPHPExcel = new PHPEXcel();


$objPHPExcel->getProperties()
			->setTitle("Documento Excel")
			->setSubject("Documento Excel")
			->setKeywords("Excel Office");

$objPHPExcel->setActiveSheetIndex(0)
			->setCellValue('A'.$j.'','ID')
			->setCellValue('B'.$j.'','Nombre')
			->setCellValue('C'.$j.'','ID Convenio')
			->setCellValue('D'.$j.'','Estado')
			->setCellValue('E'.$j.'','Fecha de Vigencia');

foreach ($arregloCanjes as $k => $vl)
{
	$j++;
	if ($j > 1)
	{
		$objPHPExcel->setActiveSheetIndex(0)
		->setCellValue('A'.$j.'',$vl['ID'])
		->setCellValue('B'.$j.'',$vl['Nombre'])
		->setCellValue('C'.$j.'',$vl['ID Convenio'])
		->setCellValue('D'.$j.'',$vl['Estado'])
		->setCellValue('E'.$j.'',$vl['Fecha de Vigencia']);
	}

}

$objPHPExcel->getActiveSheet()->setTitle('Claro - Campanas');
$objPHPExcel->setActiveSheetIndex(0);

header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="Club_Claro_Campanas_'.$hoy.'.xlsx"');
header('Cache-Control: max-age=0');
$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
$objWriter->save('php://output');
exit;


}else{

header ("Location: Login.php");

}

?>