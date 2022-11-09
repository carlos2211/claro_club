<?php
session_start();
if (isset($_SESSION["id"])){
ini_set('mssql.charset', 'UTF-8');
include("includes/conn.php"); 
require("clases/PHPExcel.php");
include("clases/convenio.class.php");
include("includes/connLocal.php");

$idcliente = 35;

$sql = "SELECT 
						idconvenio as 'ID', 
					    marca as 'Nombre Del Convenio',
					    descuento as 'Descuento',
					    vigencia as 'Vigencia',
					    constatus as 'Estado del Convenio',
						cliconstatus as 'Publicacion'
					FROM 
						VIS_datos_convenio c 
					WHERE 
						idcliente = ".$idcliente." 
					GROUP BY idconvenio";

$res=mysql_query($sql,$link);

$arregloCanjes = array();


while ($rs = mysql_fetch_assoc($res))
{
	$arregloCanjes[$i]['ID'] 					= $rs['ID'];
	$arregloCanjes[$i]['Nombre Del Convenio']   = $rs['Nombre Del Convenio'];
	$arregloCanjes[$i]['Descuento']			    = $rs['Descuento'];
	$arregloCanjes[$i]['Vigencia'] 				= $rs['Vigencia'];
	$arregloCanjes[$i]['Estado del Convenio']	= $rs['Estado del Convenio'];
	$arregloCanjes[$i]['Publicacion'] 			= $rs['Publicacion'];
	
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
			->setCellValue('B'.$j.'','Nombre Del Convenio')
			->setCellValue('C'.$j.'','Descuento')
			->setCellValue('D'.$j.'','Vigencia')
			->setCellValue('E'.$j.'','Estado del Convenio')
			->setCellValue('F'.$j.'','Publicacion');

foreach ($arregloCanjes as $k => $vl)
{
	$j++;
	if ($j > 1)
	{
		$objPHPExcel->setActiveSheetIndex(0)
		->setCellValue('A'.$j.'',$vl['ID'])
		->setCellValue('B'.$j.'',$vl['Nombre Del Convenio'])
		->setCellValue('C'.$j.'',$vl['Descuento'])
		->setCellValue('D'.$j.'',$vl['Vigencia'])
		->setCellValue('E'.$j.'',$vl['Estado del Convenio'])
		->setCellValue('F'.$j.'',$vl['Publicacion']);
	}

}

$objPHPExcel->getActiveSheet()->setTitle('Claro - Convenios ');
$objPHPExcel->setActiveSheetIndex(0);

header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="Club_Claro_Convenios_'.$hoy.'.xlsx"');
header('Cache-Control: max-age=0');
$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
$objWriter->save('php://output');
exit;
}else{

header ("Location: Login.php");

}
?>