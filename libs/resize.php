<?php

# ========================================================================#
#
#  Author:    Jarrod Oberto
#  Version:	 1.0
#  Date:      17-Jan-10
#  Purpose:   Resizes and saves image
#  Requires : Requires PHP5, GD library.
#  Usage Example:
#                     include("classes/resize_class.php");
#                     $resizeObj = new resize('images/cars/large/input.jpg');
#                     $resizeObj -> resizeImage(150, 100, 0);
#                     $resizeObj -> saveImage('images/cars/large/output.jpg', 100);
#
#
# ========================================================================#

class Resize {

    // *** Class variables
    private $image;
    private $width;
    private $height;
    private $size;
    private $imageResized;

    public function __construct($fileName) {
        // *** Open up the file
        $this->image = $this->openImage($fileName);

        // *** Get width and height
        $this->width = imagesx($this->image);
        $this->height = imagesy($this->image);

        //** Get images size in bits
        $this->size = filesize($fileName);
    }

    public function size() {
        return $this->size;
    }

    public function getWidth() {
        return $this->width;
    }

    public function getHeight() {
        return $this->height;
    }

    public function isHasImage() {
        return ($this->image != false);
    }

    ## --------------------------------------------------------

    private function openImage($file) {
        // *** Get extension
        $image_info = getimagesize($file);
        //$this->image_type = $image_info[2];
        //$extension = strtolower(strrchr($file, '.'));
        $imagetype = $image_info[2];

        switch ($imagetype) {

            case IMAGETYPE_JPEG:
                $img = @imagecreatefromjpeg($file);
                break;
            case IMAGETYPE_GIF:
                $img = @imagecreatefromgif($file);
                break;
            case IMAGETYPE_PNG:
                $img = @imagecreatefrompng($file);
                break;
            default:
                $img = false;
                break;
        }
        return $img;
    }

    ## --------------------------------------------------------

    public function resizeImage($newWidth, $newHeight, $option = "auto") {
        // *** Get optimal width and height - based on $option
        $optionArray = $this->getDimensions($newWidth, $newHeight, $option);
        $optimalWidth = $option=="idsetup"? $this->width:$optionArray['optimalWidth'];
        $optimalHeight =$option=="idsetup"? $this->height: $optionArray['optimalHeight'];

        // *** Resample - create image canvas of x, y size
        $this->imageResized = imagecreatetruecolor($optimalWidth, $optimalHeight);
        imagealphablending($this->imageResized, false);
        imagesavealpha($this->imageResized, true);
        imagecopyresampled($this->imageResized, $this->image, 0, 0, 0, 0, $optimalWidth, $optimalHeight, $this->width, $this->height);


        // *** if option is 'crop', then crop too
        if ($option == 'crop') {
            $this->crop($optimalWidth, $optimalHeight, $newWidth, $newHeight);
        }
    }

    ## --------------------------------------------------------

    public function getDimensions($newWidth, $newHeight, $option) {

        switch ($option) {

            case 'exact':
                $optimalWidth = $newWidth;
                $optimalHeight = $newHeight;
                break;
            case 'portrait':
                $optimalWidth = $this->getSizeByFixedHeight($newHeight);
                $optimalHeight = $newHeight;
                break;
            case 'landscape':
                $optimalWidth = $newWidth;
                $optimalHeight = $this->getSizeByFixedWidth($newWidth);
                break;
            case 'auto':
                $optionArray = $this->getSizeByAuto($newWidth, $newHeight);
                $optimalWidth = $optionArray['optimalWidth'];
                $optimalHeight = $optionArray['optimalHeight'];
                break;
            case 'crop':
                $optionArray = $this->getOptimalCrop($newWidth, $newHeight);
                $optimalWidth = $optionArray['optimalWidth'];
                $optimalHeight = $optionArray['optimalHeight'];
                break;
        }
        return array('optimalWidth' => $optimalWidth, 'optimalHeight' => $optimalHeight);
    }

    ## --------------------------------------------------------

    private function getSizeByFixedHeight($newHeight) {

        $ratio = $this->width / $this->height;
        $newWidth = $newHeight * $ratio;
        return $newWidth;
    }

    private function getSizeByFixedWidth($newWidth) {

        $ratio = $this->height / $this->width;
        $newHeight = $newWidth * $ratio;
        return $newHeight;
    }

    private function getSizeByAuto($newWidth, $newHeight) {

        // *** Image to be resized is wider (landscape)
        if ($this->height < $this->width) {
            $optimalWidth = $newWidth;
            $optimalHeight = $this->getSizeByFixedWidth($newWidth);
        }
        // *** Image to be resized is taller (portrait)
        elseif ($this->height > $this->width) {
            $optimalWidth = $this->getSizeByFixedHeight($newHeight);
            $optimalHeight = $newHeight;
        }
        // *** Image to be resizerd is a square
        else {
            if ($newHeight < $newWidth) {
                $optimalWidth = $newWidth;
                $optimalHeight = $this->getSizeByFixedWidth($newWidth);
            } else if ($newHeight > $newWidth) {
                $optimalWidth = $this->getSizeByFixedHeight($newHeight);
                $optimalHeight = $newHeight;
            } else {
                // *** Sqaure being resized to a square
                $optimalWidth = $newWidth;
                $optimalHeight = $newHeight;
            }
        }

        return array('optimalWidth' => $optimalWidth, 'optimalHeight' => $optimalHeight);
    }

    ## --------------------------------------------------------

    private function getOptimalCrop($newWidth, $newHeight) {

        $heightRatio = $this->height / $newHeight;
        $widthRatio = $this->width / $newWidth;

        if ($heightRatio < $widthRatio) {
            $optimalRatio = $heightRatio;
        } else {
            $optimalRatio = $widthRatio;
        }

        $optimalHeight = $this->height / $optimalRatio;
        $optimalWidth = $this->width / $optimalRatio;

        return array('optimalWidth' => $optimalWidth, 'optimalHeight' => $optimalHeight);
    }

    ## --------------------------------------------------------

    private function crop($optimalWidth, $optimalHeight, $newWidth, $newHeight) {
        // *** Find center - this will be used for the crop
        $cropStartX = ( $optimalWidth / 2) - ( $newWidth / 2 );
        $cropStartY = ( $optimalHeight / 2) - ( $newHeight / 2 );

        $crop = $this->imageResized;
//        //imagedestroy($this->imageResized);
//        // *** Now crop from center to exact requested size
//        $this->imageResized = imagecreatetruecolor($newWidth, $newHeight);
        imagecopyresampled($this->imageResized, $crop, 0, 0, $cropStartX, $cropStartY, $newWidth, $newHeight, $newWidth, $newHeight);
    }

    ## --------------------------------------------------------

    public function saveImage($savePath, $imageQuality = "100") {
        // *** Get extension
        $extension = strrchr($savePath, '.');
        $extension = strtolower($extension);

        switch ($extension) {
            case '.jpg':
            case '.jpeg':

                if (imagetypes() & IMG_JPG) {
                    imagejpeg($this->imageResized, $savePath, $imageQuality);
                    return true;
                }
                break;

            case '.gif':
                if (imagetypes() & IMG_GIF) {
                    imagegif($this->imageResized, $savePath);
                    return true;
                }
                break;

            case '.png':
                // *** Scale quality from 0-100 to 0-9
                $scaleQuality = round(($imageQuality / 100) * 9);

                // *** Invert quality setting as 0 is best, not 9
                $invertScaleQuality = 9 - $scaleQuality;
                if (imagetypes() & IMG_PNG) {
                    imagepng($this->imageResized, $savePath, $invertScaleQuality);
                    return true;
                }
                break;

            // ... etc

            default:
                // *** No extension - No save.
                return false;
                break;
        }

        imagedestroy($this->imageResized);
    }

    public function addBorders($b = 5) {
        $im = $this->imageResized;
        $bordercolors = imagecolorallocate($im, 255, 255, 255); //Define border color  Yellow

        $x = 0;
        $y = 0;
        $w = imagesx($im) - 1; //get width image and decrease 1px or points ?
        $h = imagesy($im) - 1; //get height image and decrease 1px or points ?


        $this->imagelinethick($im, $x, $y, $x, $y + $h, $bordercolors, $b); //left
        $this->imagelinethick($im, $x, $y, $x + $w, $y, $bordercolors, $b); //top
        $this->imagelinethick($im, $x + $w, $y, $x + $w, $y + $h, $bordercolors, $b); //right
        $this->imagelinethick($im, $x, $y + $h, $x + $w, $y + $h, $bordercolors, $b); //bottom

        $this->imageResized = $im;
    }

    public function imagelinethick($image, $x1, $y1, $x2, $y2, $color, $thick = 1) {
        /* this way it works well only for orthogonal lines
          imagesetthickness($image, $thick);
          return imageline($image, $x1, $y1, $x2, $y2, $color);
         */
        if ($thick == 1) {
            return imageline($image, $x1, $y1, $x2, $y2, $color);
        }

        $t = $thick / 2 - 0.5;
        if ($x1 == $x2 || $y1 == $y2) {
            return imagefilledrectangle($image, round(min($x1, $x2) - $t), round(min($y1, $y2) - $t), round(max($x1, $x2) + $t), round(max($y1, $y2) + $t), $color);
        }

        $k = ($y2 - $y1) / ($x2 - $x1); //y = kx + q
        $a = $t / sqrt(1 + pow($k, 2));

        $points = array(
            round($x1 - (1 + $k) * $a), round($y1 + (1 - $k) * $a),
            round($x1 - (1 - $k) * $a), round($y1 - (1 + $k) * $a),
            round($x2 + (1 + $k) * $a), round($y2 - (1 - $k) * $a),
            round($x2 + (1 - $k) * $a), round($y2 + (1 + $k) * $a),
        );

        imagefilledpolygon($image, $points, 4, $color);
        return imagepolygon($image, $points, 4, $color);
    }

    ## --------------------------------------------------------
}

?>
