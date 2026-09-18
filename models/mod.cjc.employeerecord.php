<?php

include_once '../libs/model.php';
include_once '../config/cons.database.php';

class ModCJCEmployeeRecord extends Model {

    private $conn = null;
//    private $path = "C:/AppServ/www/CJC_IDSYSTEM/documents/EmployeePictures/";
    private $path1 = "../documents/EmployeePictures/";
    private $path2 = "../documents/EmployeeSignature/";

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
            case 'GetDetailList':
                echo $this->GetDetailList($this->getparams);
                break;
             case 'GetImagePictures':
                echo $this->GetImagePictures($this->getparams);
                break;
            case 'GetImageSignature':
                echo $this->GetImageSignature($this->getparams);
                break;
            case 'saveEmployeeInformation':
                echo $this->saveEmployeeInformation($this->postparams);
                break;
            case 'updateprintinghistory':
                echo $this->updateprintinghistory($this->postparams);
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
        // category designation
        $filterWhere = "";
        if ($param["category"] == "ALL" || $param["category"] == "") {
            
        } else {
            $filterWhere.=" AND LCASE(category) LIKE LCASE('{$param["category"]}%') ";
        }
        if ($param["designation"] == "ALL" || $param["designation"] == "") {
            
        } else {
            $filterWhere.=" AND LCASE(designation) LIKE LCASE('{$param["designation"]}%') ";
        }
        $filterPrintingList = "";
        if ($param["printtype"] == "IsAllList") {
            $filterPrintingList = "";
        } else if ($param["printtype"] == "IsForPrinting") {
            $filterPrintingList = " and isforprint=1";
        } else if ($param["printtype"] == "IsPrintedList") {
            $filterPrintingList = " and printinghistory is not null";
        } else if ($param["printtype"] == "IsNoPicture") {
            $filterPrintingList = " and pathpicture is  null";
        } else if ($param["printtype"] == "IsWithPicture") {
            $filterPrintingList = " and pathpicture is not null";
        } else if ($param["printtype"] == "IsNoSignature") {
            $filterPrintingList = " and pathsignature is  null";
        } else if ($param["printtype"] == "IsWithSignature") {
            $filterPrintingList = " and pathsignature is not null";
        } 

        $strSQL = "SELECT 
                  rec.`idnum`,
                  rec.`emp_id`,
                  CONCAT(rec.lname,', ',rec.fname,' ',if(rec.nameext is NULL OR rec.nameext='','',concat(rec.nameext,' ')),(rec.mname),'' ) StudentName,
                  rec.`lname`, 
                  (CASE rec.`sex`  WHEN 0 THEN 'Female' WHEN 1 THEN 'Male'  END) as Sex,
                  rec.`fname`,
                  rec.`mname`,
                  rec.`nameext`,
                  rec.`designation`,
                  rec.`birthdate`, 
                  DATE_FORMAT(rec.birthdate, '%M %d, %Y') `birthdatevalue`,
                  DATE_FORMAT(NOW(), '%Y') - DATE_FORMAT( CAST(if(rec.`birthdate` = '0000-00-00', null, rec.`birthdate`) as DATETIME), '%Y') - (DATE_FORMAT(NOW(), '00-%m-%d') < DATE_FORMAT(CAST(if(rec.`birthdate` = '0000-00-00', null,rec.`birthdate`) as DATETIME), '00-%m-%d')) as Age,
                  rec.`contact_guardian`,
                  rec.`contact_relation`,
                  rec.`contact_address`,
                  rec.`contactno`,
                  rec.`status`,
                  rec.`sssgsisno`,
                  rec.`tinno`,
                  rec.`philno`,
                  rec.`pagibigno`,
                  rec.`isactive`,
                  rec.`category`,
                  rec.`company`,
                  rec.`printinghistory`,
                  rec.`pathpicture`,
                  rec.`pathsignature`,
                  rec.`isforprint`,
                  rec.`addedby`,
                  rec.`addeddate`,
                  rec.`modifiedby`,                  
                  rec.`modifieddate`
                FROM 
                  `{$dbname}`.`employee` rec                  
                  where  CONCAT_WS('',emp_id,LCASE(lname),LCASE((CASE `sex`  WHEN 0 THEN 'Female' WHEN 1 THEN 'Male'  END)),LCASE(CONCAT(lname,' ',fname,' ',if(nameext is NULL OR nameext='','',concat(nameext,' ')),(mname),'' ))) LIKE LCASE('%{$param["_searchKey"]}%')
                  {$filterWhere}
                  {$filterPrintingList} #and CHAR_LENGTH(rec.`emp_id`)=11
                  ";
        return $this->getJSonJQGridPagingResponse($strSQL, null, false);
        //   return $this->getJSonJQGridResponseLimit($strSQL, null, false);
    }

    public function GetDetailList($param) {
        $dbname = DB_NAME;
        if ($param["type"] == "idnum") {
            $wherefilterby = "where  rec.`idnum` ='{$param["recid"]}'";
        } else {
            $wherefilterby = "where rec.`emp_id` in('{$param["recid"]}') ";
        }
        $strSQL = "                 
               SELECT tbl.*
               FROM(
                      SELECT
                      rec.`idnum`,
                      rec.`emp_id`,
                      CONCAT(rec.lname,', ',rec.fname,' ',if(rec.nameext is NULL OR rec.nameext='','',concat(rec.nameext,' ')),(rec.mname),'' ) StudentName,
                      rec.`lname`,
                      (CASE rec.`sex`  WHEN 0 THEN 'Female' WHEN 1 THEN 'Male'  END) as Sex,
                      rec.`fname`,
                      rec.`mname`,
                      rec.`nameext`,
                      ifnull(rec.`designation`,'') designation,
                      ifnull(rec.`birthdate`,'') birthdate,
                      ifnull(DATE_FORMAT(rec.birthdate, '%M %d, %Y'),'') `birthdatevalue`,
                      DATE_FORMAT(NOW(), '%Y') - DATE_FORMAT( CAST(if(rec.`birthdate` = '0000-00-00', null, rec.`birthdate`) as DATETIME), '%Y') - (DATE_FORMAT(NOW(), '00-%m-%d') < DATE_FORMAT(CAST(if(rec.`birthdate` = '0000-00-00', null,rec.`birthdate`) as DATETIME), '00-%m-%d')) as Age,
                      ifnull(rec.`contact_guardian`,'') contact_guardian,
                      ifnull(rec.`contact_relation`,'') contact_relation,
                      ifnull(rec.`contact_address`,'') contact_address,
                      ifnull(rec.`contactno`,'') contactno,
                      ifnull(rec.`status`,'') status,
                      ifnull(rec.`sssgsisno`,'') sssgsisno,
                      ifnull(rec.`tinno`,'') tinno,
                      ifnull(rec.`philno`,'') philno,
                      ifnull(rec.`pagibigno`,'') pagibigno,
                      rec.`isactive`,
                      ifnull(rec.`category`,'') category,
                      ifnull(rec.`company`,'') company,
                      ifnull(rec.`printinghistory`,'') printinghistory,
                      rec.`pathpicture`,
                      rec.`pathsignature`,
                      rec.`isforprint`,
                      rec.`addedby`,
                      rec.`addeddate`,
                      rec.`modifiedby`,
                      rec.`modifieddate`,
                      zid.`id` setupid,
                      zid.`idwidth`,
                      zid.`idheight`,
                      zid.`picwidth`,
                      zid.`picheight`,
                      zid.`frontpicturexy`,
                      zid.`frontnamexy`,
                      zid.`frontdesignationxy`,
                      zid.`frontidnumxy`,
                      zid.`frontcategoryxy`,
                      zid.`frontbarcodexy`,
                      zid.`backsssgsisnoxy`,
                      zid.`backtinxy`,
                      zid.`backphihealthxy`,
                      zid.`backdateofbirthxy`,
                      zid.`backcivilstatusxy`,
                      zid.`backguardiannamexy`,
                      zid.`backguardianaddressxy`,
                      zid.`backguardiantelnoxy`,
                      zid.`backsignaturexy`
                    FROM
                      `{$dbname}`.`employee` rec
                        left join(
                       SELECT
                        *,'Employee' typeid
                        FROM `{$dbname}`.`zidsetupheader`
                        where setuptype='Employee' and setdefault=1
                   )zid ON((rec.typeid=zid.typeID and rec.company=zid.category) OR  IF(rec.typeid=zid.typeID and (rec.company='' or rec.company is null),zid.category='CJC',''))
                    {$wherefilterby}

                      UNION ALL

                       SELECT
                       null `idnum`,
                      null `emp_id`,
                      null StudentName,
                      null `lname`,
                      null  as Sex,
                      null `fname`,
                      null `mname`,
                      null `nameext`,
                      null `designation`,
                      null `birthdate`,
                      null `birthdatevalue`,
                      null as Age,
                      null `contact_guardian`,
                      null `contact_relation`,
                      null `contact_address`,
                      null `contactno`,
                      null `status`,
                      null `sssgsisno`,
                      null `tinno`,
                      null `philno`,
                      null `pagibigno`,
                      null `isactive`,
                      null `category`,
                      null `company`,
                      null `printinghistory`,
                      null `pathpicture`,
                      null `pathsignature`,
                      0 `isforprint`,
                       '' `addedby`,
                      '' `addeddate`,
                      '' `modifiedby`,
                      '' `modifieddate`,
                      zid.`id` setupid,
                      zid.`idwidth`,
                      zid.`idheight`,
                      zid.`picwidth`,
                      zid.`picheight`,
                      zid.`frontpicturexy`,
                      zid.`frontnamexy`,
                      zid.`frontdesignationxy`,
                      zid.`frontidnumxy`,
                      zid.`frontcategoryxy`,
                      zid.`frontbarcodexy`,
                      zid.`backsssgsisnoxy`,
                      zid.`backtinxy`,
                      zid.`backphihealthxy`,
                      zid.`backdateofbirthxy`,
                      zid.`backcivilstatusxy`,
                      zid.`backguardiannamexy`,
                      zid.`backguardianaddressxy`,
                      zid.`backguardiantelnoxy`,
                      zid.`backsignaturexy`
                        FROM `{$dbname}`.`zidsetupheader` zid
                        where zid.setuptype='Employee' and zid.setdefault=1  and zid.category='CJC' 
               )tbl                   
                    ";

//        return $this->getJSonJQGridPagingResponse($strSQL, null, false);
        return json_encode($this->db->fetchAll($strSQL));
    }

     public function GetImagePictures($param) {
      $dbname = DB_NAME;
        $strSQL = "SELECT
              `id` imgID,
              `emp_id`,
              `idtype`,
              `path`,
              `filename` Filename,
              `isdeleted`,
               if(concat(emp_id,'.png')=filename,1,0) isactive
            FROM
              `$dbname`.`zpicturerecord` where emp_id='{$param["emp_id"]}' and isdeleted=0 and idtype='Employee'
               ";
        return $this->getJSonJQGridPagingResponse($strSQL, null, false);
        // return $this->getJSonJQGridResponseLimit($strSQL, null, false);
    }
    
    public function GetImageSignature($param) {
      $dbname = DB_NAME;
        $strSQL = "SELECT
              `id` imgID,
              `emp_id`,
              `idtype`,
              `path`,
              `filename` Filename,
              `isdeleted`,
              if(concat(emp_id,'.png')=filename,1,0) isactive
            FROM
              `$dbname`.`zsignaturerecord` where emp_id='{$param["emp_id"]}' and isdeleted=0 and idtype='Employee'
               ";
        return $this->getJSonJQGridPagingResponse($strSQL, null, false);
        // return $this->getJSonJQGridResponseLimit($strSQL, null, false);
    }
    
    public function saveEmployeeInformation($param) {
        $dbname = DB_NAME;
        $this->db->autocommit(FALSE);
        $strNewID = ($param["idnum"] == "" ? 'NULL' : $param["idnum"]);
        if ($strNewID == 'NULL') {
            $strSQL = "INSERT INTO `$dbname`.employee SET                           
                          idnum={$strNewID},
                          emp_id='" . $this->db->real_escape_string($param["emp_id"]) . "',
                          lname='" . $this->db->real_escape_string($param["lname"]) . "',
                          fname='" . $this->db->real_escape_string($param["fname"]) . "',
                          mname='" . $this->db->real_escape_string($param["mname"]) . "',
                          nameext='" . $this->db->real_escape_string($param["nameext"]) . "',
                          designation='" . $this->db->real_escape_string($param["designation"]) . "',
                          birthdate='" . $this->db->real_escape_string($param["birthdate"]) . "',
                          contact_guardian='" . $this->db->real_escape_string($param["contact_guardian"]) . "',
                          contact_relation='" . $this->db->real_escape_string($param["contact_relation"]) . "',
                          contact_address='" . $this->db->real_escape_string($param["contact_address"]) . "',
                          contactno='" . $this->db->real_escape_string($param["contactno"]) . "',
                          sex='" . $this->db->real_escape_string($param["sex"]) . "',
                          sssgsisno='" . $this->db->real_escape_string($param["sssgsisno"]) . "',
                          tinno='" . $this->db->real_escape_string($param["tinno"]) . "',
                          philno='" . $this->db->real_escape_string($param["philno"]) . "',
                          status='" . $this->db->real_escape_string($param["status"]) . "',
                          category='" . $this->db->real_escape_string($param["category"]) . "',
                          company='" . $this->db->real_escape_string($param["company"]) . "',
                          pagibigno='" . $this->db->real_escape_string($param["pagibigno"]) . "',
                          typeid='Employee',
                          isforprint='" . $this->db->real_escape_string($param["isforprint"]) . "',
                          `addedby`='" . $_COOKIE['loginUserID'] . "',
                          `addeddate`=NOW(),
                          `modifiedby`='" . $_COOKIE['loginUserID'] . "',
                          `modifieddate`=NOW()        
                  ";
        } else {
            $strSQL = "UPDATE `$dbname`.employee SET
                           emp_id='" . $this->db->real_escape_string($param["emp_id"]) . "',
                          lname='" . $this->db->real_escape_string($param["lname"]) . "',
                          fname='" . $this->db->real_escape_string($param["fname"]) . "',
                          mname='" . $this->db->real_escape_string($param["mname"]) . "',
                          nameext='" . $this->db->real_escape_string($param["nameext"]) . "',
                          designation='" . $this->db->real_escape_string($param["designation"]) . "',
                          birthdate='" . $this->db->real_escape_string($param["birthdate"]) . "',
                          contact_guardian='" . $this->db->real_escape_string($param["contact_guardian"]) . "',
                          contact_relation='" . $this->db->real_escape_string($param["contact_relation"]) . "',
                          contact_address='" . $this->db->real_escape_string($param["contact_address"]) . "',
                          contactno='" . $this->db->real_escape_string($param["contactno"]) . "',
                          sex='" . $this->db->real_escape_string($param["sex"]) . "',
                          sssgsisno='" . $this->db->real_escape_string($param["sssgsisno"]) . "',
                          tinno='" . $this->db->real_escape_string($param["tinno"]) . "',
                          philno='" . $this->db->real_escape_string($param["philno"]) . "',
                          status='" . $this->db->real_escape_string($param["status"]) . "',
                          category='" . $this->db->real_escape_string($param["category"]) . "',
                          company='" . $this->db->real_escape_string($param["company"]) . "',
                          pagibigno='" . $this->db->real_escape_string($param["pagibigno"]) . "',
                          typeid='Employee',
                          isforprint='" . $this->db->real_escape_string($param["isforprint"]) . "',
                          `modifiedby`='" . $_COOKIE['loginUserID'] . "',
                          `modifieddate`=NOW()
                         
                              WHERE idnum = '{$strNewID}'";
        }


        //  print_r($strSQL);
//        $strSQL = mb_convert_encoding($strSQL, "SJIS-win", "UTF8");
//        mb_convert_variables("UTF-8", "SJIS-win", $strSQL);

        $strResult = $this->db->query($strSQL) or die($this->db->error());

        if ($strResult) {
            //Initialized values ::::::::::::::::::::::::::::::::::::::::::
            $strSQL = "select last_insert_id(idnum) as id from `$dbname`.employee order by id desc limit 1";
            $arrLastInsertedID = $this->db->fetchAll($strSQL);
            $lastInsertedID = (int) $arrLastInsertedID[0]['id'];
            $strIDholder = $strNewID;
            $strNewID = $strNewID == 'NULL' ? $lastInsertedID : $strNewID;




            //End of Initialized values
            //::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::
            //#1 Personal Information ::::::::::::::::::::::::::::::::::::::::::
//            $jsonItemInfo = json_decode(stripcslashes($param['PersonInfoAddressItem']));
//
//            for ($intCntr = 0; $intCntr < count($jsonItemInfo); $intCntr++) {
//
//                $strSQL2 = "";
//
//                $strNewItemID = ($jsonItemInfo[$intCntr]->FLAG == "New" ? '' : $jsonItemInfo[$intCntr]->addID);
////                $strSQLDD = " DELETE FROM `$dbname`.person_address
////                      WHERE person_code ='{$strNewID}'";
////                  $strResultRemoveExtraAddress = $this->db->query($strSQLDD) or die($this->db->error);     
//                if ($jsonItemInfo[$intCntr]->FLAG == "New") {
//                    $strSQL2 = "INSERT INTO `$dbname`.person_address SET
//                     `id`=NULL,
//                     `person_code`='{$strNewID}',
//                     `addresstype`='" . $jsonItemInfo[$intCntr]->piAddressType . "',
//                     `house_st_vlg_brgy`='" . $jsonItemInfo[$intCntr]->piAddress . "',
//                     `city_municipality`='" . $jsonItemInfo[$intCntr]->piCity . "',
//                     `province`='" . $jsonItemInfo[$intCntr]->piProvince . "',   
//                     `zipcode`='" . $jsonItemInfo[$intCntr]->piZipCode . "',   
//                     `telno`='" . $jsonItemInfo[$intCntr]->piTelNo . "'";
//                } else if ($jsonItemInfo[$intCntr]->FLAG == "Edit") {
//                    $strSQL2 = "UPDATE `$dbname`.person_address SET
//                       person_code = '{$strNewID}',
//                      `addresstype`='" . $jsonItemInfo[$intCntr]->piAddressType . "',
//                      `house_st_vlg_brgy`='" . $jsonItemInfo[$intCntr]->piAddress . "',
//                      `city_municipality`='" . $jsonItemInfo[$intCntr]->piCity . "',
//                      `province`='" . $jsonItemInfo[$intCntr]->piProvince . "',   
//                      `zipcode`='" . $jsonItemInfo[$intCntr]->piZipCode . "',   
//                      `telno`='" . $jsonItemInfo[$intCntr]->piTelNo . "'
//                       WHERE id = '{$strNewItemID}'";
//                } else if ($jsonItemInfo[$intCntr]->FLAG == "Delete") {
////                    $strSQL2 = " DELETE FROM `$dbname`.person_address
////                      WHERE addr_code = '{$strNewItemID}'";
//                }
////                print_r($strSQL2);
//                if ($strSQL2 != "") {
//                    $strResultAddress = $this->db->query($strSQL2) or die($this->db->error);
//                    if (!$strResultAddress) {
//                        $this->db->rollback();
//                        exit("Error saving record.");
//                    }
//                }
//            }
//            //End Personal Information::::::::::::::::::::::::::::::::::::::::::
//            //::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::
////             //::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::
////            //#2 Family Background:::::::::::::::::::::::::::::::::::::::::::


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

    public function updateprintinghistory($param) {
        $dbname = DB_NAME;
        $this->db->autocommit(FALSE);
        $strNewID = ($param["idnum"] == "" ? 'NULL' : $param["idnum"]);

        $strSQL = "UPDATE `$dbname`.employee SET  
                          isforprint=0,
                          printinghistory=concat(if(printinghistory is null,\"\",concat(printinghistory,'\n')),'Date Printed: ',DATE_FORMAT(NOW(),'%M %d, %Y %h:%i %p'))
                         WHERE idnum  in({$strNewID})";



        //print_r($strSQL);
//        $strSQL = mb_convert_encoding($strSQL, "SJIS-win", "UTF8");
//        mb_convert_variables("UTF-8", "SJIS-win", $strSQL);

        $strResult = $this->db->query($strSQL) or die($this->db->error());

        if ($strResult) {
            //Initialized values ::::::::::::::::::::::::::::::::::::::::::
            if ($param["type"] == 'Individual') {
                $strSQL = "select printinghistory  from `$dbname`.employee  WHERE idnum  in({$strNewID})";
                $arrLastInsertedID = $this->db->fetchAll($strSQL);
                $lastInsertedID = $arrLastInsertedID[0]['printinghistory'];
                $strIDholder = $strNewID;
                $strNewID = $lastInsertedID;
            }

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
        $dbname = DB_NAME;
        $this->db->autocommit(FALSE);
        $strSQL = "select (emp_id) as id from `$dbname`.employee  where idnum='{$strID}'";
        $arrstrIDID = $this->db->fetchAll($strSQL);
        $strID = $arrstrIDID[0]['id'];
        $imagePath = $this->path1;
        $isExist = false;
        $imgsizer = new Resize($_FILES['binImage1']['tmp_name']);
        if ($imgsizer->isHasImage()) {
            //Rename Existing


            $fullpath = $imagePath . $strID . ".png";
            if (file_exists($fullpath)) {
                $newpieces = explode(".", $fullpath);
                $frontpath = str_replace('.' . end($newpieces), '', $fullpath);
                $newFileName = strtotime(date("Y-m-d H:i:s")) . '.' . end($newpieces);
                $newpath = $frontpath . '_' . $newFileName;
                $success = rename($fullpath, $newpath);
                // unlink($file); // delete file               
//                $strSQL = "UPDATE `$dbname`.employee SET                       
//                          pathpicture='{$newpath}'
//                         WHERE emp_id='{$strID}'";
//
//                $strResult = $this->db->query($strSQL) or die($this->db->error());
                $strSQL2 = "INSERT INTO `$dbname`.zpicturerecord SET  
                          id=null,
                          emp_id='{$strID}',
                          idtype='Employee',
                          path='{$newpath}',
                          filename='{$strID}_{$newFileName}'  ";

               $strResult = $this->db->query($strSQL2) or die($this->db->error());
                if ($strResult) {
                    //Initialized values ::::::::::::::::::::::::::::::::::::::::::
                    $this->db->commit();  //Uncomment to enable saving
                } else {
                    if (!$strResult) {
                        $this->db->rollback();
                        exit("Error saving record.");
                    }
                }
                $isExist = true;
            }



            print $success ? $file . $upload_dir : 'Unable to save the file.';
            //Renaming

            if ($imgsizer->getWidth() <= 1280 && $imgsizer->getHeight() <= 1280) {

                if ($imgsizer->getWidth() > $imgsizer->getHeight()) {
                    //landscape
                    $imgsizer->resizeImage($imgsizer->getWidth(), $imgsizer->getWidth());
                    $imgsizer->saveImage($imagePath . $strID . ".png", 1);
                } elseif ($imgsizer->getWidth() < $imgsizer->getHeight()) {
                    //portrait
                    $imgsizer->resizeImage($imgsizer->getWidth(), $imgsizer->getWidth());
                    $imgsizer->saveImage($imagePath . $strID . ".png", 1);
                } else {
                    $imgsizer->resizeImage($imgsizer->getWidth(), $imgsizer->getWidth());
                    $imgsizer->saveImage($imagePath . $strID . ".png", 1);
                }
            } else {

                if ($imgsizer->getWidth() > $imgsizer->getHeight()) {
                    //landscape
                    $intLandscapeWidth = 1280;
                    $intLandscapeHeight = 800;

                    $imgsizer->resizeImage($intLandscapeWidth, $intLandscapeHeight, 'auto');
                    $imgsizer->saveImage($imagePath . $strID . ".png", 1);
                } elseif ($imgsizer->getWidth() < $imgsizer->getHeight()) {
                    //portrait
                    $intPortraitWidth = 800;
                    $intPortraitHeight = 1280;

                    $imgsizer->resizeImage($intPortraitWidth, $intPortraitHeight, 'auto');
                    $imgsizer->saveImage($imagePath . $strID . ".png", 1);
                } else {
                    $imgsizer->resizeImage($imgsizer->getWidth(), $imgsizer->getWidth());
                    $imgsizer->saveImage($imagePath . $strID . ".png", 1);
                }
            }

            if ($isExist) {
                
            } else {
                $imagePicturePath = $imagePath . $strID . ".png";
                $strSQL = "UPDATE `$dbname`.employee SET                       
                          pathpicture='{$imagePicturePath}'
                         WHERE emp_id='{$strID}'";

                $strResult = $this->db->query($strSQL) or die($this->db->error());
                $strSQL2 = "INSERT INTO `$dbname`.zpicturerecord SET  
                          id=null,
                          emp_id='{$strID}',
                          idtype='Employee',
                          path='{$imagePicturePath}',
                          filename='{$strID}.png'  ";

                $this->db->query($strSQL2) or die($this->db->error());
                if ($strResult) {
                    //Initialized values ::::::::::::::::::::::::::::::::::::::::::
                    $this->db->commit();  //Uncomment to enable saving
                } else {
                    if (!$strResult) {
                        $this->db->rollback();
                        exit("Error saving record.");
                    }
                }
            }
        }
        //Save Signature file
        $imagePath = $this->path2;
        $isExist = false;
        $imgsizer = new Resize($_FILES['binImage2']['tmp_name']);
        if ($imgsizer->isHasImage()) {
            $fullpath = $imagePath . $strID . ".png";
            if (file_exists($fullpath)) {
                $newpieces = explode(".", $fullpath);
                $frontpath = str_replace('.' . end($newpieces), '', $fullpath);
                $newFileName = strtotime(date("Y-m-d H:i:s")) . '.' . end($newpieces);
                $newpath = $frontpath . '_' . $newFileName;
                $success = rename($fullpath, $newpath);
                // unlink($file); // delete file               
//                $strSQL = "UPDATE `$dbname`.employee SET                       
//                          pathsignature='{$newpath}'
//                         WHERE idnum='{$strID}'";
//                $strResult = $this->db->query($strSQL) or die($this->db->error());
                 $strSQL2 = "INSERT INTO `$dbname`.zsignaturerecord SET  
                          id=null,
                          emp_id='{$strID}',
                          idtype='Employee',
                          path='{$newpath}',
                          filename='{$strID}_{$newFileName}'  ";

                $strResult =$this->db->query($strSQL2) or die($this->db->error());
                if ($strResult) {
                    //Initialized values ::::::::::::::::::::::::::::::::::::::::::
                    $this->db->commit();  //Uncomment to enable saving
                } else {
                    if (!$strResult) {
                        $this->db->rollback();
                        exit("Error saving record.");
                    }
                }
                $isExist = true;
            }

            if ($imgsizer->getWidth() <= 1280 && $imgsizer->getHeight() <= 1280) {

                if ($imgsizer->getWidth() > $imgsizer->getHeight()) {
                    //landscape
                    $imgsizer->resizeImage($imgsizer->getWidth(), $imgsizer->getWidth());
                    $imgsizer->saveImage($imagePath . $strID . ".png", 1);
                } elseif ($imgsizer->getWidth() < $imgsizer->getHeight()) {
                    //portrait
                    $imgsizer->resizeImage($imgsizer->getWidth(), $imgsizer->getWidth());
                    $imgsizer->saveImage($imagePath . $strID . ".png", 1);
                } else {
                    $imgsizer->resizeImage($imgsizer->getWidth(), $imgsizer->getWidth());
                    $imgsizer->saveImage($imagePath . $strID . ".png", 1);
                }
            } else {

                if ($imgsizer->getWidth() > $imgsizer->getHeight()) {
                    //landscape
                    $intLandscapeWidth = 1280;
                    $intLandscapeHeight = 800;

                    $imgsizer->resizeImage($intLandscapeWidth, $intLandscapeHeight, 'auto');
                    $imgsizer->saveImage($imagePath . $strID . ".png", 1);
                } elseif ($imgsizer->getWidth() < $imgsizer->getHeight()) {
                    //portrait
                    $intPortraitWidth = 800;
                    $intPortraitHeight = 1280;

                    $imgsizer->resizeImage($intPortraitWidth, $intPortraitHeight, 'auto');
                    $imgsizer->saveImage($imagePath . $strID . ".png", 1);
                } else {
                    $imgsizer->resizeImage($imgsizer->getWidth(), $imgsizer->getWidth());
                    $imgsizer->saveImage($imagePath . $strID . ".png", 1);
                }
            }
            if ($isExist) {
                
            } else {
                $imageSignaturePath = $imagePath . $strID . ".png";
                $strSQL = "UPDATE `$dbname`.employee SET                       
                          pathsignature='{$imageSignaturePath}'
                         WHERE emp_id='{$strID}'";

                $strResult = $this->db->query($strSQL) or die($this->db->error());
                $strSQL2 = "INSERT INTO `$dbname`.zsignaturerecord SET  
                          id=null,
                          emp_id='{$strID}',
                          idtype='Employee',
                          path='{$imagePicturePath}',
                          filename='{$strID}.png'  ";

                $strResult = $this->db->query($strSQL2) or die($this->db->error());
                if ($strResult) {
                    //Initialized values ::::::::::::::::::::::::::::::::::::::::::
                    $this->db->commit();  //Uncomment to enable saving
                } else {
                    if (!$strResult) {
                        $this->db->rollback();
                        exit("Error saving record.");
                    }
                }
            }
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

$model = new ModCJCEmployeeRecord();
?>
