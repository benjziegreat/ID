<?php

include_once '../libs/model.php';
include_once '../config/cons.database.php';

class ModCJCIdSetupSettings extends Model {

    private $conn = null;
//    private $path = "C:/AppServ/www/CJC_IDSYSTEM/documents/EmployeePictures/";
    private $path = "../documents/zzzIDSetupImage/";

    public function __construct() {

        parent::__construct('', '', '', '');

        $this->action = (isset($_GET["ACTION"]) ? $_GET["ACTION"] : null);
        $this->getparams = (isset($_GET["GETPARAM"]) ? $_GET["GETPARAM"] : null);
        $this->postparams = (isset($_POST["POSTPARAM"]) ? $_POST["POSTPARAM"] : null);
        $this->type = (isset($_GET["TYPE"]) ? $_GET["TYPE"] : null);


        switch ($this->action) {
            case 'loadList':
                echo $this->loadList($this->getparams);
                break;
            case 'saveIDSetup':
                echo $this->saveIDSetup($this->postparams);
                break;
            case 'getImageOriginal':
                echo $this->getImageOriginal($this->getparams);
                break;
            case 'getImageThumbnail':
                echo $this->getImageThumbnail($this->getparams);
                break;
            case 'uploadImage':
                echo $this->uploadImage((sprintf($this->postparams["uploadID"])));
                break;
            case 'droplist':
                echo $this->dropList($this->getparams);
                break;
            case 'removeAttachment':
                echo $this->removeAttachment($this->postparams);
                break;

            default:
                break;
        }
    }

    public function dropList($param) {
        $dbname = DB_NAME;
        $strSQL = "SELECT * FROM `{$dbname}`.company ORDER BY ID ASC ";

//        return $this->getJSonJQGridPagingResponse($strSQL, null, false);
        return json_encode($this->db->fetchAll($strSQL));
    }

    public function loadList($param) {
        $dbname = DB_NAME;
        $strSQL = " 
                SELECT
                  `id`,
                  `title`,
                  `setdefault`,                  
                  `setuptype`,
                  `category`,
                  `idwidth`,
                  `idheight`,
                  `picwidth`,
                  `picheight`,
                  `frontpicturexy`,
                  `frontnamexy`,
                  `frontdesignationxy`,
                  `frontidnumxy`,
                  `frontcategoryxy`,
                  `frontbarcodexy`,
                  `backsssgsisnoxy`,
                  `backtinxy`,
                  `backphihealthxy`,
                  `backdateofbirthxy`,
                  `backcivilstatusxy`,
                  `backguardiannamexy`,
                  `backguardianaddressxy`,
                  `backguardiantelnoxy`,
                  `backsignaturexy`,
                  `frontbatchxy`,
                  `addedby`,
                  `datedadded`,
                  `datemodified`,
                  `modifiedby`
                FROM
                  `{$dbname}`.`zidsetupheader`

                                ";
        return $this->getJSonJQGridPagingResponse($strSQL, null, false);
    }

    public function saveIDSetup($param) {
        $dbname = DB_NAME;
        $this->db->autocommit(FALSE);
        $strNewID = ($param["id"] == "" ? 'NULL' : $param["id"]);
        if ($strNewID == 'NULL') {
            $strSQL = "INSERT INTO `$dbname`.zidsetupheader SET
                      `id`={$strNewID},
                      `title`='" . $this->db->real_escape_string($param["title"]) . "',
                      `setdefault`='" . $this->db->real_escape_string($param["setdefault"]) . "',
                      `setuptype`='" . $this->db->real_escape_string($param["setuptype"]) . "',
                      `category`='" . $this->db->real_escape_string($param["category"]) . "',
                      `idwidth`='" . $this->db->real_escape_string($param["idwidth"]) . "',
                      `idheight`='" . $this->db->real_escape_string($param["idheight"]) . "',
                      `picwidth`='" . $this->db->real_escape_string($param["picwidth"]) . "',
                      `picheight`='" . $this->db->real_escape_string($param["picheight"]) . "',
                      `frontpicturexy`='" . $this->db->real_escape_string($param["frontpicturexy"]) . "',
                      `frontnamexy`='" . $this->db->real_escape_string($param["frontnamexy"]) . "',
                      `frontdesignationxy`='" . $this->db->real_escape_string($param["frontdesignationxy"]) . "',
                      `frontidnumxy`='" . $this->db->real_escape_string($param["frontidnumxy"]) . "',
                      `frontcategoryxy`='" . $this->db->real_escape_string($param["frontcategoryxy"]) . "',
                      `frontbarcodexy`='" . $this->db->real_escape_string($param["frontbarcodexy"]) . "',
                      `backsssgsisnoxy`='" . $this->db->real_escape_string($param["backsssgsisnoxy"]) . "',
                      `backtinxy`='" . $this->db->real_escape_string($param["backtinxy"]) . "',
                      `backphihealthxy`='" . $this->db->real_escape_string($param["backphihealthxy"]) . "',
                      `backdateofbirthxy`='" . $this->db->real_escape_string($param["backdateofbirthxy"]) . "',
                      `backcivilstatusxy`='" . $this->db->real_escape_string($param["backcivilstatusxy"]) . "',
                      `backguardiannamexy`='" . $this->db->real_escape_string($param["backguardiannamexy"]) . "',
                      `backguardianaddressxy`='" . $this->db->real_escape_string($param["backguardianaddressxy"]) . "',
                      `backguardiantelnoxy`='" . $this->db->real_escape_string($param["backguardiantelnoxy"]) . "',
                      `backsignaturexy`='" . $this->db->real_escape_string($param["backsignaturexy"]) . "',
                      `frontbatchxy`='" . $this->db->real_escape_string($param["frontbatchxy"]) . "',
                      `addedby`='" . $_COOKIE['loginUserID'] . "',
                      `datedadded`=NOW(),
                      `datemodified`=NOW(),
                      `modifiedby`='" . $_COOKIE['loginUserID'] . "' 
                    ";
        } else {
            $strSQL = "UPDATE `$dbname`.zidsetupheader SET
                      `title`='" . $this->db->real_escape_string($param["title"]) . "',
                      `setdefault`='" . $this->db->real_escape_string($param["setdefault"]) . "',
                      `setuptype`='" . $this->db->real_escape_string($param["setuptype"]) . "',
                      `category`='" . $this->db->real_escape_string($param["category"]) . "',
                      `idwidth`='" . $this->db->real_escape_string($param["idwidth"]) . "',
                      `idheight`='" . $this->db->real_escape_string($param["idheight"]) . "',
                      `picwidth`='" . $this->db->real_escape_string($param["picwidth"]) . "',
                      `picheight`='" . $this->db->real_escape_string($param["picheight"]) . "',    
                      `frontpicturexy`='" . $this->db->real_escape_string($param["frontpicturexy"]) . "',
                      `frontnamexy`='" . $this->db->real_escape_string($param["frontnamexy"]) . "',
                      `frontdesignationxy`='" . $this->db->real_escape_string($param["frontdesignationxy"]) . "',
                      `frontidnumxy`='" . $this->db->real_escape_string($param["frontidnumxy"]) . "',
                      `frontcategoryxy`='" . $this->db->real_escape_string($param["frontcategoryxy"]) . "',
                      `frontbarcodexy`='" . $this->db->real_escape_string($param["frontbarcodexy"]) . "',
                      `backsssgsisnoxy`='" . $this->db->real_escape_string($param["backsssgsisnoxy"]) . "',
                      `backtinxy`='" . $this->db->real_escape_string($param["backtinxy"]) . "',
                      `backphihealthxy`='" . $this->db->real_escape_string($param["backphihealthxy"]) . "',
                      `backdateofbirthxy`='" . $this->db->real_escape_string($param["backdateofbirthxy"]) . "',
                      `backcivilstatusxy`='" . $this->db->real_escape_string($param["backcivilstatusxy"]) . "',
                      `backguardiannamexy`='" . $this->db->real_escape_string($param["backguardiannamexy"]) . "',
                      `backguardianaddressxy`='" . $this->db->real_escape_string($param["backguardianaddressxy"]) . "',
                      `backguardiantelnoxy`='" . $this->db->real_escape_string($param["backguardiantelnoxy"]) . "',
                      `backsignaturexy`='" . $this->db->real_escape_string($param["backsignaturexy"]) . "',
                      `frontbatchxy`='" . $this->db->real_escape_string($param["frontbatchxy"]) . "',
                      `addedby`='" . $_COOKIE['loginUserID'] . "',
                      `datedadded`=NOW(),
                      `datemodified`=NOW(),
                      `modifiedby`='" . $_COOKIE['loginUserID'] . "' 
                              WHERE id = '{$strNewID}'";
        }


        //  print_r($strSQL);
//        $strSQL = mb_convert_encoding($strSQL, "SJIS-win", "UTF8");
//        mb_convert_variables("UTF-8", "SJIS-win", $strSQL);
        if ($param["setdefault"] == "1") {
            if ($param["setuptype"] == "Student") {
                $strSQLSetDefault = "UPDATE `{$dbname}`.`zidsetupheader`                                 
                                  SET 
                               setdefault=0 
                               where  setuptype='{$param["setuptype"]}' and `category`='{$param["category"]}'
                              ";
            } else if ($param["setuptype"] == "Employee") {
                $strSQLSetDefault = "UPDATE `{$dbname}`.`zidsetupheader`                                 
                                  SET 
                               setdefault=0 
                               where  setuptype='{$param["setuptype"]}' and `category`='{$param["category"]}'
                              ";
            } else if ($param["setuptype"] == "Alumni") {
                $strSQLSetDefault = "UPDATE `{$dbname}`.`zidsetupheader`                                 
                                  SET 
                               setdefault=0 
                               where  setuptype='{$param["setuptype"]}' and `category`='{$param["category"]}'
                              ";
            }

            if ($strSQLSetDefault != "") {
                $strResultSQLSetDefaultt = $this->db->query($strSQLSetDefault) or die($this->db->error);
                if (!$strResultSQLSetDefaultt) {
                    $this->db->rollback();
                    exit("Error setting default record.");
                }
            }
        }

        $strResult = $this->db->query($strSQL) or die($this->db->error());

        if ($strResult) {
            //Initialized values ::::::::::::::::::::::::::::::::::::::::::
            $strSQL = "select last_insert_id(id) as id from `$dbname`.zidsetupheader order by id desc limit 1";
            $arrLastInsertedID = $this->db->fetchAll($strSQL);
            $lastInsertedID = (int) $arrLastInsertedID[0]['id'];
            $strIDholder = $strNewID;
            $strNewID = $strNewID == 'NULL' ? $lastInsertedID : $strNewID;

            //Updating Default Setup
            if ($param["setuptype"] == "Student") {
                $whereUpdate = " where id=2";
            } else if ($param["setuptype"] == "Employee") {
                $whereUpdate = " where id=1";
            } else if ($param["setuptype"] == "Alumni") {
                $whereUpdate = " where id=3";
            }

            $strUpdate = "SELECT 
                  `id`  
                FROM
                  `$dbname`.`zidsetupheader`
                  where setuptype='" . $this->db->real_escape_string($param["setuptype"]) . "' and setdefault=1";
            $arrUpdateID = $this->db->fetchAll($strUpdate);
            $lastUpdateID = (int) $arrUpdateID[0]['id'];
            if ($lastUpdateID < 1) {
                $strddd = "update  `$dbname`.`zidsetupheader`
                  set `setdefault`=1
                  {$whereUpdate}";
                if ($strddd != "") {
                    $strResultstrddd = $this->db->query($strddd) or die($this->db->error);
                    if (!$strResultstrddd) {
                        $this->db->rollback();
                        exit("Error setting default record.");
                    }
                }
            }
//End of updating default setup
//           

            $this->db->commit();  //Uncomment to enable saving
        } else {
            $strNewID = "";
            if (!$strResult) {
                $this->db->rollback();
                exit("Error saving record.");
            }
        }
        return $strNewID;
    }

    public function uploadImage($strID) {
        $imagePath = $this->path;
//        print_r($_FILES['binImage']['tmp_name']);
        // if(){
        //  Delete($imagePath . $strID . ".jpg"); 
        //  }
        $imgsizer = new Resize($_FILES['binImage1']['tmp_name']);

        if ($imgsizer->isHasImage()) {

            if ($imgsizer->getWidth() <= 1280 && $imgsizer->getHeight() <= 1280) {

//                if ($imgsizer->getWidth() > $imgsizer->getHeight()) {
//                    //landscape
//                    $imgsizer->resizeImage($imgsizer->getWidth(), $imgsizer->getWidth());
//                    $imgsizer->saveImage($imagePath . "FRONT" . $strID . ".png", 100);
//                } elseif ($imgsizer->getWidth() < $imgsizer->getHeight()) {
//                    //portrait
//                    $imgsizer->resizeImage($imgsizer->getWidth(), $imgsizer->getWidth());
//                    $imgsizer->saveImage($imagePath . "FRONT" . $strID . ".png", 100);
//                } else {
                $imgsizer->resizeImage($imgsizer->getWidth(), $imgsizer->getWidth(),'idsetup');
                $imgsizer->saveImage($imagePath . "FRONT" . $strID . ".png", 100);
//                }
            } else {

//                if ($imgsizer->getWidth() > $imgsizer->getHeight()) {
//                    //landscape
//                    $intLandscapeWidth = 1280;
//                    $intLandscapeHeight = 800;
//
//                    $imgsizer->resizeImage($intLandscapeWidth, $intLandscapeHeight, 'auto');
//                    $imgsizer->saveImage($imagePath . "FRONT" . $strID . ".png", 100);
//                } elseif ($imgsizer->getWidth() < $imgsizer->getHeight()) {
//                    //portrait
//                    $intPortraitWidth = 800;
//                    $intPortraitHeight = 1280;
//
//                    $imgsizer->resizeImage($intPortraitWidth, $intPortraitHeight, 'auto');
//                    $imgsizer->saveImage($imagePath . "FRONT" . $strID . ".png", 100);
//                } else {
                $imgsizer->resizeImage($imgsizer->getWidth(), $imgsizer->getWidth(),'idsetup');
                $imgsizer->saveImage($imagePath . "FRONT" . $strID . ".png", 100);
//                }
            }
        }
        $imgsizer = new Resize($_FILES['binImage2']['tmp_name']);

        if ($imgsizer->isHasImage()) {

            if ($imgsizer->getWidth() <= 1280 && $imgsizer->getHeight() <= 1280) {

//                if ($imgsizer->getWidth() > $imgsizer->getHeight()) {
//                    //landscape
//                    $imgsizer->resizeImage($imgsizer->getWidth(), $imgsizer->getWidth());
//                    $imgsizer->saveImage($imagePath . "BACK" . $strID . ".png", 100);
//                } elseif ($imgsizer->getWidth() < $imgsizer->getHeight()) {
//                    //portrait
//                    $imgsizer->resizeImage($imgsizer->getWidth(), $imgsizer->getWidth());
//                    $imgsizer->saveImage($imagePath . "BACK" . $strID . ".png", 100);
//                } else {
                $imgsizer->resizeImage($imgsizer->getWidth(), $imgsizer->getWidth(),'idsetup');
                $imgsizer->saveImage($imagePath . "BACK" . $strID . ".png", 100);
//                }
            } else {

//                if ($imgsizer->getWidth() > $imgsizer->getHeight()) {
//                    //landscape
//                    $intLandscapeWidth = 1280;
//                    $intLandscapeHeight = 800;
//
//                    $imgsizer->resizeImage($intLandscapeWidth, $intLandscapeHeight, 'auto');
//                    $imgsizer->saveImage($imagePath . "BACK" . $strID . ".png", 100);
//                } elseif ($imgsizer->getWidth() < $imgsizer->getHeight()) {
//                    //portrait
//                    $intPortraitWidth = 800;
//                    $intPortraitHeight = 1280;
//
//                    $imgsizer->resizeImage($intPortraitWidth, $intPortraitHeight, 'auto');
//                    $imgsizer->saveImage($imagePath . "BACK" . $strID . ".png", 100);
//                } else {
                $imgsizer->resizeImage($imgsizer->getWidth(), $imgsizer->getWidth(),'idsetup');
                $imgsizer->saveImage($imagePath . "BACK" . $strID . ".png", 100);
//                }
            }
        }



//        print_r($imgsizer->saveImage($imagePath . $strID . "_" . $intThumbnailWidth . "_" . $intThumbnailHeight . ".jpg", 100));
//        print_r("uRL OF IMAGE:" . $imagePath . $strID . ".jpg");
        //  print_r("uRL OF IMAGE:" . $imagePath . $strID . ".jpg");
    }

    public function getImageOriginal($param) {
//        https://localhost/ID/models/mod.cjc.idsetupsettings.php?ACTION=getImageOriginal&GETPARAM%5Bitemid%5D=BACK1
        $strItemID = $param["itemid"];
        $path_to_img = $this->path;
        $imgName = $strItemID . ".PNG";

        $this->img->load($path_to_img . $imgName);

        if (!$this->img->output(IMAGETYPE_PNG)) {
            $this->img->load($path_to_img . "nopic.png");
            $this->img->output(IMAGETYPE_PNG);
        }
    }

    public function getImageThumbnail($strItemID) {

        $this->img->load($this->path . $strItemID . "_150_150.jpg");

        if (!$this->img->output(IMAGETYPE_JPEG)) {
            $this->img->load($path_to_img . "nopic.jpg");
            $this->img->output(IMAGETYPE_JPEG);
        }
    }

    function removeAttachment($fileName = 'test.jpg') {
        $file = $this->path . $fileName . '.jpg';
        $file2 = $this->path . $fileName . '_150_150.jpg';
        $this->Delete($file);
        $this->Delete($file2);

//        $ftp_server = "192.168.1.39";
//        $ftp_user = "admin";
//        $ftp_pass = "1234";
//
//// set up a connection or die
//        $conn_id = ftp_connect($ftp_server) or die("Couldn't connect to $ftp_server");
//
//// login with username and password
//        $login_result = ftp_login($conn_id, $ftp_user, $ftp_pass);
//        var_dump(ftp_delete($conn_id, $file));
//// try to delete $file
//        if (ftp_delete($conn_id, $file) && ftp_delete($conn_id, $file2)) {
//            echo "$file deleted successful\n";
//        } else {
//            echo "could not delete $file\n";
//        }
//        
//// close the connection
//        ftp_close($conn_id);
    }

    function Delete($path) {
        if (is_dir($path) === true) {
            $files = array_diff(scandir($path), array('.', '..'));

            foreach ($files as $file) {
                Delete(realpath($path) . '/' . $file);
            }

            return rmdir($path);
        } else if (is_file($path) === true) {
            return unlink($path);
        }

        return false;
    }

}

$model = new ModCJCIdSetupSettings();
?>
