<?php

//$upload_dir = "upload/";
include '../../../../../config/cons.paths.php';
//$upload_dir = "C:/AppServ/www/SignaturePad/signaturepictures/";
//C:\AppServ\www\CJC_IDSYSTEM\documents\PresidentSignature
$upload_dir = PATHROOT . "/" . PROJECTNAME . "/documents/EmployeeSignature/";
$img = $_POST['hidden_data'];
$img = str_replace('data:image/png;base64,', '', $img);
$img = str_replace(' ', '+', $img);
$data = base64_decode($img);
$filename = $_POST['filename'];
$file = $upload_dir . $filename . ".png";
$fullpath = $upload_dir . "tempSignature.png";
if (file_exists($fullpath)) {
    $newpieces = explode(".", $fullpath);
    $frontpath = str_replace('.' . end($newpieces), '', $fullpath);
    $newpath = $frontpath . '_' . strtotime(date("Y-m-d H:i:s")) . '.' . end($newpieces);
     unlink($file); // delete file
}

$success = rename($fullpath, $file);


print $success ? $file . $upload_dir : 'Unable to save the file.';
?>
