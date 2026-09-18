<?php

//include_once '../libs/resize.php';


$link = mysql_connect("192.168.0.6", "ric202", "test");
mysql_select_db("hr_ntc");
 $sql = "SELECT PICTURE as picture FROM APPLICANTS WHERE APPLICANT_ID='{$_GET['id']}'";
$result = mysql_query("$sql");
$row = mysql_fetch_assoc($result);
mysql_close($link);

function resizer($blob_binary, $desired_width, $desired_height) { // simple function for resizing images to specified dimensions from the request variable in the url
    $im = imagecreatefromstring($blob_binary);

    $new = imagecreatetruecolor($desired_width, $desired_height) or exit("bad url");
    $x = imagesx($im);
    $y = imagesy($im);

//    $optionArray = $this->getDimensions($newWidth, $newHeight, $option);
//    var_dump($x, $y, $desired_width, $desired_height);

    $optionArray = getSizeByAuto($x, $y, $desired_width, $desired_height);
    $optimalWidth  = $optionArray['optimalWidth'];
    $optimalHeight = $optionArray['optimalHeight'];

//    var_dump($optionArray);

    imagecopyresampled($new, $im, 0, 0, 0, 0, $optimalWidth, $optimalHeight, $x, $y) or exit("bad url");
    imagedestroy($im);
    return imagejpeg($new, null, 100) or exit("bad url");
//    return $new;
}

function getSizeByFixedHeight($origWidth, $origHeight, $newHeight){

    $ratio = $origWidth / $origHeight;
    $newWidth = $newHeight * $ratio;
    return $newWidth;
}

function getSizeByFixedWidth($origWidth, $origHeight, $newWidth){

    $ratio = $origHeight / $origWidth;
    $newHeight = $newWidth * $ratio;
    return $newHeight;
}

function getSizeByAuto($origWidth, $origHeight, $newWidth, $newHeight){

    // *** Image to be resized is wider (landscape)
    if ($origHeight < $origWidth){
        $optimalWidth = $newWidth;
        $optimalHeight= $this->getSizeByFixedWidth($origWidth, $origHeight, $newWidth);
    }
    // *** Image to be resized is taller (portrait)
    elseif ($origHeight > $origWidth){
        $optimalHeight= $newHeight;
        $optimalWidth = $this->getSizeByFixedHeight($origWidth, $origHeight, $newHeight);
    }
    // *** Image to be resizerd is a square
    else{
        if ($newHeight < $newWidth) {
            $optimalWidth = $newWidth;
            $optimalHeight= $this->getSizeByFixedWidth($origWidth, $origHeight, $newWidth);

        } else if ($newHeight > $newWidth) {
            $optimalHeight= $newHeight;
            $optimalWidth = $this->getSizeByFixedHeight($origWidth, $origHeight, $newHeight);

        } else {
            // *** Sqaure being resized to a square
            $optimalWidth = $newWidth;
            $optimalHeight= $newHeight;
        }
    }

    return array('optimalWidth' => $optimalWidth, 'optimalHeight' => $optimalHeight);
}

header("Content-type: image/jpg");
echo $row['picture'];
//echo resizer($row['picture'], 150, 150);
//ob_end_clean();

    
?>