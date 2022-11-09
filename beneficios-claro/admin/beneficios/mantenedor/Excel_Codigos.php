<?php
session_start();
if (isset($_SESSION["id"])){
ini_set('mssql.charset', 'UTF-8');
include("includes/conn.php");
require("clases/PHPExcel.php");
include("clases/codigo.class.php");
include("includes/connLocal.php");


$sql = "SELECT 
		    c.id_Codigo AS 'ID',
		    c.Rut AS 'Rut Cliente',
		    c.id_Convenio AS 'ID Convenio',
		    ca.Descripcion AS 'Campaña',
		    c.Codigo AS 'Codigo',
		    es.Descripcion AS 'Estado',
		    c.Fecha_Creacion AS 'Fecha de Creacion',
		    c.Fecha_Vigencia AS 'Fecha de Vigencia'
		FROM
		    codigo AS c
		LEFT JOIN
		    estado AS es ON es.id_Estado = c.id_Estado
		LEFT JOIN
		    campana AS ca ON ca.id_Campana = c.id_Campana
        ORDER BY c.Fecha_Canje DESC LIMIT 100";
	    
//echo $sql;

$res=mysql_query($sql,$link_local);

$arregloCanjes = array();


while ($rs = mysql_fetch_assoc($res))
{
	$arregloCanjes[$i]['ID']			=$rs['ID'];
	$arregloCanjes[$i]['Rut Cliente']	=$rs['Rut Cliente'];
	$arregloCanjes[$i]['ID Convenio']	=$rs['ID Convenio'];
	$arregloCanjes[$i]['Campaña']	=$rs['Campaña'];
	$arregloCanjes[$i]['Codigo']		=$rs['Codigo'];
	$arregloCanjes[$i]['Estado']		=$rs['Estado'];
	$arregloCanjes[$i]['Fecha de Creacion']=$rs['Fecha de Creacion'];
	$arregloCanjes[$i]['Fecha de Vigencia']		=$rs['Fecha de Vigencia'];

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
			->setCellValue('B'.$j.'','Rut Cliente')
			->setCellValue('C'.$j.'','ID Convenio')
			->setCellValue('D'.$j.'','Campaña')
			->setCellValue('E'.$j.'','Codigo')
			->setCellValue('F'.$j.'','Estado')
		    ->setCellValue('G'.$j.'','Fecha de Creacion')
			->setCellValue('J'.$j.'','Fecha de Vigencia');

foreach ($arregloCanjes as $k => $vl)
{
	$j++;
	if ($j > 1)
	{
		$objPHPExcel->setActiveSheetIndex(0)
		->setCellValue('A'.$j.'',$vl['ID'])
		->setCellValue('B'.$j.'',$vl['Rut Cliente'])
		->setCellValue('C'.$j.'',$vl['ID Convenio'])
		->setCellValue('D'.$j.'',$vl['Campaña'])
		->setCellValueExplicit('E'.$j.'',$vl['Codigo'],PHPExcel_Cell_DataType::TYPE_STRING)
		->setCellValue('F'.$j.'',$vl['Estado'])
		->setCellValue('G'.$j.'',$vl['Fecha de Creacion'])
		->setCellValue('J'.$j.'',$vl['Fecha de Vigencia']);
	}

}

$objPHPExcel->getActiveSheet()->setTitle('Claro - Codigos');
$objPHPExcel->setActiveSheetIndex(0);

header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="Club_Claro_Codigos_'.$hoy.'.xlsx"');
header('Cache-Control: max-age=0');
$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
$objWriter->save('php://output');
exit;
}else{

header ("Location: Login.php");

}
?>