<?php
///
/// Created By: Ayant P. Orcasitas
/// Date Created: 12-Dec-2011
/// Remarks: Contains common function that shall be used in the system
/// 

function GetFileContent($filename)
{
	
	if (file_exists($filename))
	{
		$fo = fopen($filename, 'r');
		$data = fread($fo, filesize($filename));
		fclose($fo);
		return $data;
	}
}

/// Function that will convert the data to array
/// Row delimiter : "chr(13)" or "enter" 
/// Item and Value delimiter : "="
/// Comment delimiter : if the first character is "#"
function DataToArray($data)
{
	$arr =explode(chr(13),$data);
	$valArr=array();
	foreach($arr as $val)
	{
		$subArr=explode("=",$val);
		if (isset($subArr[0]) && substr(trim($subArr[0]),0,1)!="#" && trim($subArr[0])!='') $valArr[ trim($subArr[0])]=$subArr[1];
	}
	
	return $valArr;	
}

function CleanText($text)
{
	 return substr(substr($text,1),0,strlen($text)-2);
}



?>