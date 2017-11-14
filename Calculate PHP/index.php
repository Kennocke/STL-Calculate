<?php
//error_reporting(E_ALL ^ E_NOTICE);

$filename = "C:/xampp/tmp/" .basename($_FILES['uploadfile']['tmp_name']);
$count = 3;
$handle = fopen($filename, "rb");
//fseek($handle,80);
$header = fread($handle, 80);
$rnum = fread($handle, 4);
$num = unpack('I', $rnum);
print_r($num);

//die();

$sum = 0;
//   while (feof($handle)==false) {
for ($i = 0; $i< $num; $i++) {
	$contents = fread($handle, 4);
	$normal1 = unpack('f', fread($handle, 4));
	$contents = fread($handle, 4);
	$normal2 = unpack('f', $contents);
	$contents = fread($handle, 4);
	$normal3 = unpack('f', $contents);
		
	$contents = fread($handle, 4);
	$vertex11 = unpack('f', $contents);
	$contents = fread($handle, 4);
	$vertex12 = unpack('f', $contents);
	$contents = fread($handle, 4);
	$vertex13 = unpack('f', $contents);
	
	$contents = fread($handle, 4);
	$vertex21 = unpack('f', $contents);
	$contents = fread($handle, 4);
	$vertex22 = unpack('f', $contents);
	$contents = fread($handle, 4);
	$vertex23 = unpack('f', $contents);
	

	$contents = fread($handle, 4);
	$vertex31 = unpack('f', $contents);
	$contents = fread($handle, 4);
	$vertex32 = unpack('f', $contents);
	$contents = fread($handle, 4);
	$vertex33 = unpack('f', $contents);
	
	$atrib = fread($handle, 2);
	
	$sum = $sum + ((float)$vertex31 * (float)$vertex22);
	//$sum += (float)((((-1) * $vertex31 * $vertex22 * $vertex13) + $vertex21 * $vertex32 * $vertex13 + $vertex31 * $vertex12 * $vertex23 - $vertex11 * $vertex32 * $vertex23 - $vertex21 * $vertex12 * $vertex33 + $vertex11 * $vertex22 * $vertex33) / 6);
	
	//$sum += (float)((((-1) * current($vertex3) * next($vertex2) * end($vertex1)) + prev($vertex2) * next($vertex3) * prev($vertex1) + prev($vertex3) * current($vertex1) * end($vertex2) - prev($vertex1) * next($vertex3) * current($vertex2) - reset($vertex2) * next($vertex1) * next($vertex3) + prev($vertex1) * next($vertex2) * current($vertex3)) / 6);
	//$sum = $sum + ((((-1) * $vertex3[0] * $vertex2[1] * $vertex1[2]) + $vertex2[0] * $vertex3[1] * $vertex1[2] + $vertex3[0] * $vertex1[1] * $vertex2[2] - $vertex1[0] * $vertex3[1] * $vertex2[2] - $vertex2[0] * $vertex1[1] * $vertex3[2] + $vertex1[0] * $vertex2[1] * $vertex3[2]) / 6);
} 
fclose($handle);
print($sum);
?>