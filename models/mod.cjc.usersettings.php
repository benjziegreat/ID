<?php

include_once '../libs/model.php';
//include_once '../libs/msmodel.php';
include_once '../config/cons.database.php';

class ModCJCUserSettings extends Model {

    private $conn = null;
    private $path = "C:/AppServ/www/HRMS/documents/EmployeePictures/";

    public function __construct() {

        parent::__construct('',  '', '', '');

        $this->action = (isset($_GET["ACTION"]) ? $_GET["ACTION"] : null);
        $this->getparams = (isset($_GET["GETPARAM"]) ? $_GET["GETPARAM"] : null);
        $this->postparams = (isset($_POST["POSTPARAM"]) ? $_POST["POSTPARAM"] : null);
        $this->type = (isset($_GET["TYPE"]) ? $_GET["TYPE"] : null);

        switch ($this->action) {
            case 'loadList':
                echo $this->loadList($this->getparams);
                break;
            case 'getModuleList':
                echo $this->getModuleList($this->getparams);
                break;
            case 'loadListAssignDesignation':
                echo $this->loadListAssignDesignation($this->getparams);
                break;
            case 'loadListUserToJSON':
                echo $this->loadListUserToJSON($this->getparams);
                break;
            case 'LoginUser':
                echo $this->LoginUser($this->getparams);
                break;
             case 'ForcelogIn':
                echo $this->ForcelogIn($this->getparams);
                break;            
            case 'logOut':
                echo $this->logOut($this->getparams);
                break;
            case 'logOutMobile':
                echo $this->logOutMobile($this->getparams);
                break;            
            case 'checkUserAssign':
                echo $this->checkUserAssign($this->getparams);
                break;
            case 'RecordActivityLogs':
                echo $this->RecordActivityLogs($this->getparams);
                break;
            case 'checkUserIfAllowed':
                echo $this->checkUserIfAllowed($this->getparams);
                break;
            case 'saveData':
                echo $this->saveData($this->postparams);
                break;
            case 'saveAssignDesignation':
                echo $this->saveAssignDesignation($this->postparams);
                break;
            case 'changePassword':
                echo $this->changePassword($this->postparams);
                break;
            case 'loadEmployeeList':
                echo $this->loadEmployeeList();
                break;
            case 'GetUserAccess':
                echo $this->GetUserAccess($this->getparams);
                break;
            case 'GetUserAccessRole':
                echo $this->GetUserAccessRole($this->getparams);
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
            case 'removeAttachment':
                echo $this->removeAttachment($this->postparams);
                break;
            default:
                break;
        }
    }

    public function loadList($param) {
        $dbname = DB_NAME;
        $strSQL = " SELECT 
              users.`id` ID,
              users.`username` USERNAME ,
              users.`usertype` USERTYPE,
              users.`isactive` ISACTIVE,
              users.`name` PERSONNAME,
              users.`dateadded` DATEADDED,
              users.`userrole` USERROLE,
              users.`activationkey` ACTIVATIONKEY

            FROM 
              `{$dbname}`.`user` users               
              WHERE CONCAT_WS('',LCASE(users.`username`),LCASE(users.`name`))
                LIKE LCASE('%{$param["_searchKey"]}%')";

//        return json_encode($this->db->fetchAll($strSQL));
        return $this->getJSonJQGridPagingResponse($strSQL, null, false);
    }
       public function getModuleList($param) {
        $dbname = DB_NAME;
        $strSQL = "
                  SELECT 
                  `id` module_id,
                  `modulename`
                FROM 
                   `{$dbname}`.`user_modules`  
                            ";
        return $this->getJSonJQGridPagingResponse($strSQL, null, false);
    }

    public function loadListAssignDesignation($param) {
        $dbname = DB_NAME;
        $strSQL = " SELECT 
          userdes.`id` item_id,
          userdes.`user_id`,
          userdes.`module_id`,
          usermod.`modulename`,
          userdes.`allow_create`,
          userdes.`allow_update`,
          userdes.`allow_delete`,
          userdes.`allow_view`,
          userdes.`allow_print`
          
        FROM 
          `{$dbname}`.`user_designation` userdes
          LEFT JOIN `{$dbname}`.`user_modules` usermod ON (userdes.`module_id` = usermod.`id`)
        WHERE userdes.`user_id` = {$param["userid"]}";

//        return json_encode($this->db->fetchAll($strSQL));
        return $this->getJSonJQGridPagingResponse($strSQL, null, false);
    }

    public function loadListUserToJSON($param) {
        $dbname = DB_NAME;
        $dbHost = DB_HOST;
        $dbUser = DB_USER;
        $dbPass = DB_PASS;
        $strSQL = "
         SELECT 
              users.`id` ID,
              users.`username` USERNAME ,
              users.`usertype` USERTYPE,
              users.`isactive` ISACTIVE,
              users.`password` PASSWORD
            FROM 
              `{$dbname}`.`user` users               
              WHERE CONCAT_WS('',users.`personcode`,LCASE(users.`username`))
             LIKE LCASE('%{$param["_searchKey"]}%')  ";
        mysql_connect($dbHost, $dbUser, $dbPass);
        $res = mysql_query($strSQL);
        $records = array();
        while ($obj = mysql_fetch_object($res)) {
            $records [] = $obj;
        }
        file_put_contents("../documents/userJSON/users.json", json_encode($records));
        return true;
//        return json_encode($this->db->fetchAll($strSQL));
//        return $this->getJSonJQGridPagingResponse($strSQL, null, false);
    }

    public function LoginUser($param) {
        $dbname = DB_NAME;
        $strSQL = "SELECT 
          users.`id`,
          users.`username`,
          users.`password`,
          users.`usertype`,
          users.`isactive`,
          users.`name` EmployeeName

        FROM 
          `{$dbname}`.`user` users          
          WHERE  users.`isactive`=1 and  users.`username`='{$param["USERNAME"]}' and users.`password`=md5('{$param["PASSWORD"]}');";

        $loginData = $this->db->fetchAll($strSQL);
        if (sizeof($loginData) > 0) {
            setcookie('loginUserNameID', $loginData[0]["id"], 0, '/');
            setcookie('loginUserID', $loginData[0]["username"], 0, '/');
            setcookie('loginUserName', json_encode($loginData[0]["EmployeeName"]), 0, '/');
            setcookie('type', $loginData[0]['usertype'], 0, '/');

            return json_encode($this->db->fetchAll($strSQL));
        }
    }
     public function ForcelogIn($param) {
        $dbname = DB_NAME;
        $strSQL = "SELECT 
          users.`id`,
          users.`username`,
          users.`password`,
          users.`usertype`,
          users.`isactive`,
          users.`name` EmployeeName

        FROM 
          `{$dbname}`.`user` users          
          WHERE  users.`username`='{$param["USERNAME"]}';";

        $loginData = $this->db->fetchAll($strSQL);
        if (sizeof($loginData) > 0) {
            setcookie('loginUserNameID', $loginData[0]["id"], 0, '/');
            setcookie('loginUserID', $loginData[0]["username"], 0, '/');
            setcookie('loginUserName', json_encode($loginData[0]["EmployeeName"]), 0, '/');
            setcookie('type', $loginData[0]['usertype'], 0, '/');

            return json_encode($this->db->fetchAll($strSQL));
        }
    }
    

    public function checkUserAssign($param) {
        $dbname = DB_NAME;
        if ($param["type"] == "module") {
            $filterWhere = "and usermod.modulename='{$param["typename"]}' and userdes.`laboratory_id`=''";
        }

        $strSQL = "SELECT
          userdes.`id` item_id,
          userdes.`user_id`,
          userdes.`module_id`,
          usermod.`modulename`,
          userdes.`allow_create`,
          userdes.`allow_update`,
          userdes.`allow_delete`,
          userdes.`allow_view`,
          userdes.`allow_print`
          
        FROM
          `{$dbname}`.`user_designation` userdes
          LEFT JOIN `{$dbname}`.`user_modules` usermod ON (userdes.`module_id` = usermod.`id`)
        WHERE userdes.`user_id` ='" . $_COOKIE['loginUserNameID'] . "' {$filterWhere}";
        $rs = $this->db->fetchAll($strSQL);

        return (sizeof($rs) > 0);
    }

    public function RecordActivityLogs($param) {
        $dbname = DB_NAME;
        $computername = gethostbyaddr($_SERVER['REMOTE_ADDR']);
        $ID = 'NULL';
        $strSQL = " INSERT INTO `{$dbname}`.user_activitylogs SET                  
              `id`={$ID},
              `user_id`='" . $_COOKIE['loginUserNameID'] . "',
              `modulename`='" . $this->db->real_escape_string($param["typename"]) . "',
              `activity`='" . $this->db->real_escape_string($param["assign"]) . "',
              `datelog`=now(),
              `ipaddress`='{$_SERVER['REMOTE_ADDR']}',
               `compname`='{$computername}' ";



//       echo $strSQL;
        if ($this->db->query($strSQL)) {
            //Initialized values ::::::::::::::::::::::::::::::::::::::::::
            $strSQL = "select last_insert_id(id) as id from `{$dbname}`.user_activitylogs order by id desc limit 1";
            $arrLastInsertedID = $this->db->fetchAll($strSQL);
            $lastInsertedID = (int) $arrLastInsertedID[0]['id'];

            $ID = $lastInsertedID;
            //End of Initialized values

            $this->db->commit();
            return $ID;
        } else {
            $this->db->rollback();
            return 'Error';
        }
    }

    public function checkUserIfAllowed($param) {
        $dbname = DB_NAME;
        if ($param["type"] == "module") {
            $filterWhere = "and usermod.modulename='{$param["typename"]}' and (userdes.`laboratory_id`='' OR userdes.`laboratory_id` is null)";

            if ($param["assign"] == "create") {
                $filterWhere = $filterWhere . " and userdes.`allow_create`=1";
            } else if ($param["assign"] == "update") {
                $filterWhere = $filterWhere . " and userdes.`allow_update`=1";
            } else if ($param["assign"] == "view") {
                $filterWhere = $filterWhere . " and userdes.`allow_view`=1";
            } else if ($param["assign"] == "delete") {
                $filterWhere = $filterWhere . " and userdes.`allow_delete`=1";
            } else if ($param["assign"] == "print") {
                $filterWhere = $filterWhere . " and userdes.`allow_print`=1";
            } else {
                $filterWhere = $filterWhere . " and userdes.`allow_create`=100";
            }
        } 

        $strSQL = "SELECT
          userdes.`id` item_id,
          userdes.`user_id`,
          userdes.`module_id`,
          usermod.`modulename`,
          userdes.`laboratory_id`,
          userdes.`allow_create`,
          userdes.`allow_update`,
          userdes.`allow_delete`,
          userdes.`allow_view`,
          userdes.`allow_print`
          
        FROM
          `{$dbname}`.`user_designation` userdes
          LEFT JOIN `{$dbname}`.`user_modules` usermod ON (userdes.`module_id` = usermod.`id`)
        WHERE userdes.`user_id` ='" . $_COOKIE['loginUserNameID'] . "' {$filterWhere}";
        $rs = $this->db->fetchAll($strSQL);

        return (sizeof($rs) > 0);
    }

    function GetUserAccess($param) {
        $dbname = DB_NAME;
        $strSQL = "SELECT 
          users.`id`,
          users.`username`,
          users.`password`,
          users.`usertype`,
          users.`isactive`,
          users.`userrole`,
          users.`name` EmployeeName

        FROM 
          `{$dbname}`.`user` users          
          WHERE  users.`id`='{$param["USERID"]}' ;";

        $loginData = $this->db->fetchAll($strSQL);
        if (sizeof($loginData) > 0) {

            return json_encode($this->db->fetchAll($strSQL));
        }
    }

    function GetUserAccessRole($param) {
        $dbname = DB_NAME;
        $strSQL = "SELECT 
          users.`id`,
          users.`username`,
          users.`password`,
          users.`usertype`,
          users.`isactive`,
          users.`userrole`,
          users.`name` EmployeeName

        FROM 
          `{$dbname}`.`user` users          
          WHERE  users.`id`='{$_COOKIE['loginUserNameID']}' ;";

        $loginData = $this->db->fetchAll($strSQL);
        if (sizeof($loginData) > 0) {

            return json_encode($this->db->fetchAll($strSQL));
        }
    }

    function loadEmployeeList() {
        $dbname = DB_NAME;
        $strSQL = "
              SELECT 
              p.`person_code`,
              CONCAT(p.`l_name`,' ',p.`f_name`,' ',LEFT(p.`m_name`,1),'.' ) EmployeeName
            FROM 
              `{$dbname}`.`person`  p
               #where  p.`dateresign` IS NULL OR p.`dateresign` >= CURDATE()
              ORDER BY  p.`l_name` asc
        ";

        return json_encode($this->db->fetchAll($strSQL));
    }

    public function logOut() {

        if (setcookie('loginUserNameID', '', time(), '/') &&
                setcookie('loginUserID', '', time(), '/') &&
                setcookie('loginUserName', '', time(), '/') &&
                setcookie('type', '', time(), '/') &&
                setcookie('hisaccordButton', Null, time(), '/HIS/views/default/gui') &&
                setcookie('hisaccordHover', Null, time(), '/HIS/views/default/gui')
        ) {
            header('location: ../redirectindex.php');
        } else {
            echo "wala";
        }
    }
    public function logOutMobile() {

        if (setcookie('loginUserNameID', '', time(), '/') &&
                setcookie('loginUserID', '', time(), '/') &&
                setcookie('loginUserName', '', time(), '/') &&
                setcookie('type', '', time(), '/') &&
                setcookie('hisaccordButton', Null, time(), '/HIS/views/default/gui') &&
                setcookie('hisaccordHover', Null, time(), '/HIS/views/default/gui')
        ) {
            header('location: ../webprofile/');
        } else {
            echo "wala";
        }
    }

    public function saveData($param) {
        $dbname = DB_NAME;
//        print_r($param);
        foreach ($param as $key => $value)
            $$key = $value;

        $this->db->autocommit(false);
        $ID = $ID == "" ? 'NULL' : $ID;
        if ($ID == 'NULL') {
            $strSQL = "select id from `{$dbname}`.user where username='{$USERNAME}'";
            $arrFound = $this->db->fetchAll($strSQL);
            $FoundID = (int) $arrFound[0]['id'];
        }
        if ($FoundID < 1) {//Validate username if exist
            if ($ID == 'NULL') {
                $strSQL = " INSERT INTO `{$dbname}`.user SET                  
              `id`={$ID},
              `username`='" . $this->db->real_escape_string($USERNAME) . "',
              `password`=md5('" . $this->db->real_escape_string($PASSWORD) . "'),
              `usertype`='" . $this->db->real_escape_string($usertype) . "',
               `userrole`='" . $this->db->real_escape_string($USERROLE) . "',
              `isactive`='" . $this->db->real_escape_string($ISACTIVE) . "',
               `name`='" . $this->db->real_escape_string($employee) . "',
               `dateadded`=now()
              ";
            } else {
                $strSQL = "UPDATE `{$dbname}`.user SET
             `username`='" . $this->db->real_escape_string($USERNAME) . "',
              `password`=md5('" . $this->db->real_escape_string($PASSWORD) . "'),
              `usertype`='" . $this->db->real_escape_string($usertype) . "',
               `userrole`='" . $this->db->real_escape_string($USERROLE) . "',
              `isactive`='" . $this->db->real_escape_string($ISACTIVE) . "',
              `name`='" . $this->db->real_escape_string($employee) . "'
                 WHERE id = '{$ID}'";
            }


//           echo $strSQL;
            if ($this->db->query($strSQL)) {
                //Initialized values ::::::::::::::::::::::::::::::::::::::::::
                $strSQL = "select last_insert_id(id) as id from `{$dbname}`.user order by id desc limit 1";
                $arrLastInsertedID = $this->db->fetchAll($strSQL);
                $lastInsertedID = (int) $arrLastInsertedID[0]['id'];

                $ID = $ID == 'NULL' ? $lastInsertedID : $ID;
                //End of Initialized values

                $this->db->commit();
                return $ID;
            } else {
                $this->db->rollback();
                return '';
            }
        } else {
            return 'Username Exist';
        }
    }

    public function changePassword($param) {
        $dbname = DB_NAME;
        $this->db->autocommit(false);
        $strSQL = "select id from `{$dbname}`.user where username='{$param["username"]}' and password=md5('{$param["currentpassword"]}')";
        $arrLastInsertedID = $this->db->fetchAll($strSQL);
        $lastInsertedID = (int) $arrLastInsertedID[0]['id'];
        $ID = $lastInsertedID;
        if ($ID > 0) {
            $strSQL = "UPDATE `{$dbname}`.user SET
             `username`='" . $this->db->real_escape_string($param["username"]) . "',
              `password`=md5('" . $this->db->real_escape_string($param["password"]) . "')
                 WHERE id = '{$ID}'";
            //echo $strSQL;
            if ($this->db->query($strSQL)) {

                $this->db->commit();
                return $ID;
            } else {
                $this->db->rollback();
                return '';
            }
        } else {
            return 'not found';
        }
    }

    public function saveAssignDesignation($param) {
        $dbname = DB_NAME;
        $this->db->autocommit(FALSE);
        //Update activation key
        if ($param['activationkey'] == "") {
            //Empty Activation
        } else {
            $strVal = "SELECT * FROM `{$dbname}`.`user` where activationkey='{$param['activationkey']}' and id<>'{$param['userid']}'";
            $arrLast = $this->db->fetchAll($strVal);
            $isExist = (int) $arrLast[0]['id'];
//            print_r($isExist . "sgfg");
            if ($isExist == 0) {
                $strSQL = "update  `{$dbname}`.`user` set activationkey='{$param['activationkey']}' where id='{$param['userid']}'";
                if ($strSQL != "") {
                    $strResult1 = $this->db->query($strSQL) or die($this->db->error);
                    if (!$strResult1) {
                        $this->db->rollback();
                        exit("Error saving record.");
                    }
                }
            } else {
                $this->db->rollback();
                exit("Activationkey already in used.");
            }
        }
//          userid activationkey
        //::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::
        //#1 Laboratory Items ::::::::::::::::::::::::::::::::::::::::::
        $jsonItemInfo = json_decode(stripcslashes($param['AssignDesignationItems']));
        for ($intCntr = 0; $intCntr < count($jsonItemInfo); $intCntr++) {
            $strSQL2 = "";
            $strNewItemID = ($jsonItemInfo[$intCntr]->FLAG == "New" ? 'NULL' : $jsonItemInfo[$intCntr]->item_id);
            if ($jsonItemInfo[$intCntr]->FLAG == "New") {
                $strSQL2 = "INSERT INTO `$dbname`.user_designation SET                     
                      `id`=NULL,
                      `user_id`='" . $jsonItemInfo[$intCntr]->user_id . "',
                      `module_id`='" . $jsonItemInfo[$intCntr]->module_id . "',
                      `laboratory_id`='" . $jsonItemInfo[$intCntr]->laboratory_id . "',
                      `allow_create`='" . $jsonItemInfo[$intCntr]->allow_create . "',
                      `allow_update`='" . $jsonItemInfo[$intCntr]->allow_update . "',
                      `allow_delete`='" . $jsonItemInfo[$intCntr]->allow_delete . "',
                      `allow_view`='" . $jsonItemInfo[$intCntr]->allow_view . "',
                      `allow_print`='" . $jsonItemInfo[$intCntr]->allow_print . "'
                       ";
            } else if ($jsonItemInfo[$intCntr]->FLAG == "Edit") {
                $strSQL2 = "UPDATE `$dbname`.user_designation SET
                     `user_id`='" . $jsonItemInfo[$intCntr]->user_id . "',
                      `module_id`='" . $jsonItemInfo[$intCntr]->module_id . "',
                      `laboratory_id`='" . $jsonItemInfo[$intCntr]->laboratory_id . "',
                      `allow_create`='" . $jsonItemInfo[$intCntr]->allow_create . "',
                      `allow_update`='" . $jsonItemInfo[$intCntr]->allow_update . "',
                      `allow_delete`='" . $jsonItemInfo[$intCntr]->allow_delete . "',
                      `allow_view`='" . $jsonItemInfo[$intCntr]->allow_view . "',
                      `allow_print`='" . $jsonItemInfo[$intCntr]->allow_print . "'
                       WHERE id = '{$strNewItemID}'";
            } else if ($jsonItemInfo[$intCntr]->FLAG == "Delete") {
                $strSQL2 = " DELETE FROM `$dbname`.user_designation
                      WHERE id = '{$strNewItemID}'";
            }
//             print_r($strSQL2);
            if ($strSQL2 != "") {
                $strResult = $this->db->query($strSQL2) or die($this->db->error);
                if (!$strResult) {
                    $this->db->rollback();
                    exit("Error saving record.");
                }
            }
        }
        //End Personal Information::::::::::::::::::::::::::::::::::::::::::
        //::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::
        $this->db->commit();  //Uncomment to enable saving

        return $strNewItemID;
    }

    public function uploadImage($strID) {
        $imagePath = $this->path;
//        print_r($_FILES['binImage']['tmp_name']);
        // if(){
        //  Delete($imagePath . $strID . ".jpg"); 
        //  }
        $imgsizer = new Resize($_FILES['binImage']['tmp_name']);

        if ($imgsizer->isHasImage()) {

            if ($imgsizer->getWidth() <= 1280 && $imgsizer->getHeight() <= 1280) {

                if ($imgsizer->getWidth() > $imgsizer->getHeight()) {
                    //landscape
                    $imgsizer->resizeImage($imgsizer->getWidth(), $imgsizer->getWidth());
                    $imgsizer->saveImage($imagePath . $strID . ".jpg", 100);
                } elseif ($imgsizer->getWidth() < $imgsizer->getHeight()) {
                    //portrait
                    $imgsizer->resizeImage($imgsizer->getWidth(), $imgsizer->getWidth());
                    $imgsizer->saveImage($imagePath . $strID . ".jpg", 100);
                } else {
                    $imgsizer->resizeImage($imgsizer->getWidth(), $imgsizer->getWidth());
                    $imgsizer->saveImage($imagePath . $strID . ".jpg", 100);
                }
            } else {

                if ($imgsizer->getWidth() > $imgsizer->getHeight()) {
                    //landscape
                    $intLandscapeWidth = 1280;
                    $intLandscapeHeight = 800;

                    $imgsizer->resizeImage($intLandscapeWidth, $intLandscapeHeight, 'auto');
                    $imgsizer->saveImage($imagePath . $strID . ".jpg", 100);
                } elseif ($imgsizer->getWidth() < $imgsizer->getHeight()) {
                    //portrait
                    $intPortraitWidth = 800;
                    $intPortraitHeight = 1280;

                    $imgsizer->resizeImage($intPortraitWidth, $intPortraitHeight, 'auto');
                    $imgsizer->saveImage($imagePath . $strID . ".jpg", 100);
                } else {
                    $imgsizer->resizeImage($imgsizer->getWidth(), $imgsizer->getWidth());
                    $imgsizer->saveImage($imagePath . $strID . ".jpg", 100);
                }
            }

            //Saving thumbnail image
            if (true) {

                $intThumbnailWidth = 150;
                $intThumbnailHeight = 150;
                $imgsizer->resizeImage($intThumbnailWidth, $intThumbnailHeight);
                $imgsizer->saveImage($imagePath . $strID . "_" . $intThumbnailWidth . "_" . $intThumbnailHeight . ".jpg", 100);
                print_r("uRL OF IMAGE:" . $imagePath . $strID . ".jpg");


                //Inserting picture to database..::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::
                //:::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::


                $connectionString = sprintf("mysql:host=%s;dbname=%s;charset=utf8", 'localhost', 'ftigroup');
                // echo phpinfo();
                try {
                    $this->conn = new PDO($connectionString, 'root', 'root');
                    //for prior PHP 5.3.6
//                    $conn->exec("set names utf8");
                } catch (PDOException $pe) {
                    print_r($pe->getMessage() . "error ");
                    die($pe->getMessage());
                }

                if (file_exists($imagePath . $strID . ".jpg")) {
                    $blob = fopen($imagePath . $strID . ".jpg", 'rb');

                    $sql = "UPDATE person
				SET picture = :picture
				WHERE id = :id";

                    $stmt = $this->conn->prepare($sql);
                    $stmt->bindParam(':picture', $blob, PDO::PARAM_LOB);
                    $stmt->bindParam(':id', $strID);
                    $stmt->execute();
                }


                $this->conn = null;

                //End of Inserting picture to database::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::
                //::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::
            }
//            print_r("uRL OF IMAGE:" . $imagePath . $strID . ".jpg");
        }



//        print_r($imgsizer->saveImage($imagePath . $strID . "_" . $intThumbnailWidth . "_" . $intThumbnailHeight . ".jpg", 100));
//        print_r("uRL OF IMAGE:" . $imagePath . $strID . ".jpg");
        //  print_r("uRL OF IMAGE:" . $imagePath . $strID . ".jpg");
    }

    public function getImageOriginal($strItemID) {

        $path_to_img = $this->path;
        $imgName = $strItemID . ".jpg";

        $this->img->load($path_to_img . $imgName);

        if (!$this->img->output(IMAGETYPE_JPEG)) {
            $this->img->load($path_to_img . "nopic.jpg");
            $this->img->output(IMAGETYPE_JPEG);
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
        $ftp_server = "192.168.0.3";
        $ftp_user = "nkymerp";
        $ftp_pass = "nkymerp";

// set up a connection or die
        $conn_id = ftp_connect($ftp_server) or die("Couldn't connect to $ftp_server");

// login with username and password
        $login_result = ftp_login($conn_id, $ftp_user, $ftp_pass);

// try to delete $file
        if (ftp_delete($conn_id, $file) && ftp_delete($conn_id, $file2)) {
            echo "$file deleted successful\n";
        } else {
            echo "could not delete $file\n";
        }

// close the connection
        ftp_close($conn_id);
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

$model = new ModCJCUserSettings();
?>
