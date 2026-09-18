<?php

//$upload_dir = "upload/";
include '../../../../../config/cons.paths.php';
//$upload_dir = "C:/AppServ/www/SignaturePad/signaturepictures/";
//C:\AppServ\www\CJC_IDSYSTEM\documents\PresidentSignature
$upload_dir = PATHROOT . "/" . PROJECTNAME . "/documents/PresidentSignature/";

$file = $upload_dir . $filename . ".png";
$fullpath = $file;

//REMOVE FILES EXCEPT TO LATEST FILES AND DEFAULT FILE
//if ($_POST["REMOVEFILES"] == "TRUE") {
$newpieces = explode(".", $fullpath);
$path = str_replace('.' . end($newpieces), '', $fullpath);
$files = glob($path . '/*'); // get all file names
foreach ($files as $file) { // iterate files
    if (is_file($file)) {
        $filename = explode("//", $file);

        if (end($filename) == "default.png" || end($filename) == "PresidentSignature.png") {
//            echo end($filename) . '<br>';
        } else {
//            echo end($filename) . '<br>';
            unlink($file); // delete file
        }
    }
//          
}

//}
print  'Not Latest File in President Signature has been deleted.';
?>
