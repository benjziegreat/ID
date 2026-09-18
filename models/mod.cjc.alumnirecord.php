<?php

include_once '../libs/model.php';
include_once '../config/cons.database.php';

class ModCJCAlumniRecord extends Model {

    private $conn = null;
//    private $path = "C:/AppServ/www/CJC_IDSYSTEM/documents/AlumniPictures/";
    private $path1 = "../documents/AlumniPictures/";
    private $path2 = "../documents/AlumniSignature/";

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
            case 'saveAlumniInformation':
                echo $this->saveAlumniInformation($this->postparams);
                break;
            case 'updateprintinghistory':
                echo $this->updateprintinghistory($this->postparams);
                break;
            case 'generatenewid':
                echo $this->generatenewid($this->postparams);
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
             case 'loadCourseList':
                echo $this->loadCourseList();
                break;

            default:
                break;
        }
    }

       function loadCourseList() {
$strSQLinject="  INSERT INTO cjc_idsystem.coursedesignationlist
  SELECT tbl.*
  from(
  SELECT
  null `id`,
  prog.`PROG_SHORT_NAME` `shortdesc`,
  prog.`PROG_DESC` `desc`,
  1 `isactive`
FROM
   smis.`js_program` prog
  where prog.`PROGCODE`is not null
  group by prog.`PROG_SHORT_NAME`
  order by prog.PROG_SHORT_NAME asc
 )tbl
   where  tbl.`shortdesc` not IN(select shortdesc from cjc_idsystem.coursedesignationlist)";
if ($strSQLinject != "") {
        $strResultAutoinsertcourse = $this->db->query($strSQLinject) or die($this->db->error);
        if (!$strResultAutoinsertcourse) {
            $this->db->rollback();
            exit("Error inserting record.");
        }
    }



        $strSQL = "
            SELECT 
             `id`,
              `shortdesc`,
              `desc`,
              `isactive`
            FROM 
            `cjc_idsystem`.`coursedesignationlist`
            where isactive=1
            order by shortdesc asc

        ";

        return json_encode($this->db->fetchAll($strSQL));
    }

    public function loadList($param) {
        $strSQLa = "INSERT INTO cjc_idsystem.alumni
                   SELECT
             null `idnum`,
             stud.`STDNTID`  `emp_id`,
             stud.`LASTNAME` `lname`,
             stud.`FIRSTNAME` `fname`,
             stud.`MIDDLENAME`  `mname`,
             null `nameext`,
             prog.`PROG_SHORT_NAME` `designation`,
             stud.`BIRTHDATE`  `birthdate`,
             stud.GUARDIAN  `contact_guardian`,
             null  `contact_relation`,
             CONCAT(tblAddress.HOMESTREET,' ',tblAddress.Barangay,' ',tblAddress.Town,' ',tblAddress.Province)  `contact_address`,
             stud.GUARDIANTEL  `contactno`,
             1  `isactive`,
            (CASE stud.SEX  WHEN 'M' THEN 1 WHEN 'F' THEN 0 ELSE 1 END)  `sex`,
             null  `sssgsisno`,
             null  `tinno`,
             null  `philno`,
             stud.`CIVIL_STATUS` `status`,
            (CASE stud.`INSTITUTIONAL_CATEGORY`  WHEN 1 THEN 'COLLEGE' WHEN 2 THEN 'LAW SCHOOL' WHEN 3 THEN 'GRADUATE SCHOOL' WHEN 4 THEN 'BASIC EDUCATION'  END)  `category`,
             null  `pagibigno`,
             null  `printinghistory`,
            'Alumni' `typeid`,
             null pathpicture,
             null pathsignature,
             0 isforprint,
             'System Generated'  `addedby`,
             now() `addeddate`,
             'System Generated' `modifiedby`,                  
             now() `modifieddate`,
             left(stud.`STDNTID`,4) batch

            FROM
              smis.`jd_student` stud
              left join smis.`js_curriculum` curr ON(stud.`CURRICULUM`=curr.`CURRICODE`)
              LEFT JOIN smis.`js_program` prog ON(curr.`PROGCODE`=prog.`PROGCODE`)
              LEFT JOIN(
                   SELECT
                      `STUDENTID`,
                      `HOMESTREET`,
                       bar.`NAME` Barangay,
                       town.NAME Town,
                       prov.NAME Province
                    FROM
                      smis.`jd_address1` adds
                      left join smis.`jd_barangay` bar ON(adds.`HOMEBARANGAY`=bar.`ID`)
                      left join smis.jd_town town ON(adds.HOMETOWN=town.`ID`)
                      LEFT JOIN smis.`jd_province` prov ON(town.`PROVINCE`=prov.`ID`)
              )tblAddress ON(tblAddress.STUDENTID=stud.`STDNTID`)
               where LCASE(stud.`STUDENT_STATUS`)=LCASE('GRADUATED') AND stud.`STDNTID` not IN(select emp_id from cjc_idsystem.alumni)  # limit 0,1000
              ORDER BY stud.`created_timestamp` #desc limit 1000 
                 ";
      $strSQLa="INSERT INTO cjc_idsystem.alumni
      SELECT
 null `idnum`,
  `emp_id`,
  `lname`,
  `fname`,
  `mname`,
  `nameext`,
  `designation`,
  `birthdate`,
  `contact_guardian`,
  `contact_relation`,
  `contact_address`,
  `contactno`,
  `isactive`,
  `sex`,
  `sssgsisno`,
  `tinno`,
  `philno`,
  `status`,
  `category`,
  `pagibigno`,
   null `printinghistory`,
  'Alumni' `typeid`,
  null `pathpicture`,
  null `pathsignature`,
  0 `isforprint`,
  'System Generated' `addedby`,
  now() `addeddate`,
  'System Generated' `modifiedby`,
  now() `modifieddate`,
  left(emp_id,4) `batch`
FROM
   cjc_idsystem.`student`
  where  `emp_id` not IN(select emp_id from cjc_idsystem.alumni)";
    if ($strSQLa != "") {
       $strResultAutoinsertcf3 = $this->db->query($strSQLa) or die($this->db->error);
       if (!$strResultAutoinsertcf3) {
           $this->db->rollback();
           exit("Error saving record.");
       }
   }

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
        $filterbybatch="";
       if($param["batch"]==""){           
       }else{
           $filterbybatch=" and rec.`batch` LIKE LCASE('%{$param["batch"]}%') ";
       }

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
                  rec.`printinghistory`,
                  rec.`pathpicture`,
                  rec.`pathsignature`,
                  rec.`isforprint`,
                  rec.`addedby`,
                  rec.`addeddate`,
                  rec.`modifiedby`,                  
                  rec.`modifieddate`,
                  rec.`batch`
                FROM 
                  `{$dbname}`.`alumni` rec                   
                  where  CONCAT_WS('',emp_id,LCASE(lname),LCASE((CASE `sex`  WHEN 0 THEN 'Female' WHEN 1 THEN 'Male'  END)),LCASE(CONCAT(lname,', ',fname,' ',if(nameext is NULL OR nameext='','',concat(nameext,' ')),(mname),'' ))) LIKE LCASE('%{$param["_searchKey"]}%')
                  {$filterWhere}
                  {$filterbybatch}
                  {$filterPrintingList} #and CHAR_LENGTH(rec.`emp_id`)=11
                  ";
         return $this->getJSonJQGridPagingResponse($strSQL, null, false);
       // return $this->getJSonJQGridResponseLimit($strSQL, null, false);
    }

    public function GetDetailList($param) {
        $dbname = DB_NAME;
        
             $file = "../documents/StudentPictures/{$param["recid"]}.png";
             $newfile = "../documents/AlumniPictures/{$param["recid"]}.png";
             if (file_exists($file)) {
              if (file_exists($newfile)) {
                 //picture exist in alumni
               }
                else{
                  if (!copy($file, $newfile)) {
                // echo "failed to copy $file...\n";
                  }else{
                      $strSQL = "UPDATE `$dbname`.alumni SET                       
                          pathpicture='{$newfile}'
                         WHERE emp_id='{$param["recid"]}'";

                $strResult = $this->db->query($strSQL) or die($this->db->error());
                $strSQL2 = "INSERT INTO `$dbname`.zpicturerecord SET  
                          id=null,
                          emp_id='{$param["recid"]}',
                          idtype='Alumni',
                          path='{$newfile}',
                          filename='{$param["recid"]}.png'  ";

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
            }
              $file2 = "../documents/StudentSignature/{$param["recid"]}.png";
             $newfile2 = "../documents/AlumniSignature/{$param["recid"]}.png";
             if (file_exists($file2)) {
               if (file_exists($newfile2)) {
                 //picture exist in alumni
               }
                else{
                   if (!copy($file2, $newfile2)) {
                  // echo "failed to copy $file...\n";
                     }else{
                                  $strSQL = "UPDATE `$dbname`.alumni SET                       
                          pathsignature='{$newfile2}'
                         WHERE emp_id='{$param["recid"]}'";

                $strResult = $this->db->query($strSQL) or die($this->db->error());
                $strSQL2 = "INSERT INTO `$dbname`.zsignaturerecord SET  
                          id=null,
                          emp_id='{$param["recid"]}',
                          idtype='Alumni',
                          path='{$newfile2}',
                          filename='{$param["recid"]}.png'  ";

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
             } 
        
        $idarrLength=explode("','",$param["recid"]) ;
        
        if(count($idarrLength)<=2){
         // var_dump($idarrLength) ;
          //var_dump(strlen($idarrLength[0])) ;
          $empid='0';
          if(strlen($idarrLength[0])==1){
            $empid=$idarrLength[1];
          }else{
             $empid=$param["recid"];
          }
             $strSQLUpdateRec = " update  `{$dbname}`.`alumni` alum
  left join `{$dbname}`.`student` stud ON(alum.emp_id=stud.emp_id)
  set
  alum.`lname`=ifnull(alum.`lname`,stud.`lname`),
  alum.`fname`=ifnull(alum.`fname`,stud.`fname`),
  alum.`mname`=ifnull(alum.`mname`,stud.`mname`),
  alum.`nameext`=ifnull(alum.`nameext`,stud.`nameext`),
  alum.`designation`=ifnull(alum.`designation`,stud.`designation`),
  alum.`birthdate`=ifnull(alum.`birthdate`,stud.`birthdate`),
  alum.`contact_guardian`=ifnull(alum.`contact_guardian`,stud.`contact_guardian`),
  alum.`contact_relation`=ifnull(alum.`contact_relation`,stud.`contact_relation`),
  alum.`contact_address`=ifnull(alum.`contact_address`,stud.`contact_address`),
  alum.`contactno`=ifnull(alum.`contactno`,stud.`contactno`),
  alum.`sex`=ifnull(alum.`sex`,stud.`sex`),
  alum.`sssgsisno`=ifnull(alum.`sssgsisno`,stud.`sssgsisno`),
  alum.`tinno`=ifnull(alum.`tinno`,stud.`tinno`),
  alum.`philno`=ifnull(alum.`philno`,stud.`philno`),
  alum.`status`=ifnull(alum.`status`,stud.`status`),
  alum.`category`=ifnull(alum.`category`,stud.`category`),
  alum.`pagibigno`=ifnull(alum.`pagibigno`,stud.`pagibigno`)
  where alum.emp_id ='{$empid}'";

               $strResult= $this->db->query($strSQLUpdateRec) or die($this->db->error());
                if ($strResult) {
                    //Initialized values ::::::::::::::::::::::::::::::::::::::::::
                    $this->db->commit();  //Uncomment to enable saving
                  } else {
                    if (!$strResult) {
                        $this->db->rollback();
                        exit("Error saving record .");
                    }
                   }
        }
          
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
                      ifnull(rec.`printinghistory`,'') printinghistory,
                      ifnull(rec.`batch`,'') batch,
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
                      zid.`backsignaturexy`,
                      zid.`frontbatchxy`
                    FROM 
                      `{$dbname}`.`alumni` rec
                        left join(
                       SELECT
                        *,'Alumni' typeid
                        FROM `{$dbname}`.`zidsetupheader`
                        where setuptype='Alumni' and setdefault=1
                      )zid ON((rec.typeid=zid.typeID and rec.category=zid.category)  OR  IF(rec.typeid=zid.typeID and (rec.category='' or rec.category is null OR (rec.category not in('COLLEGE','BASIC EDUCATION','LAW SCHOOL','GRADUATE SCHOOL','VOC TECHNOLOGY'))),zid.category='COLLEGE',''))
                       {$wherefilterby}

                      UNION ALL

                       SELECT
                       '' `idnum`,
                      '' `emp_id`,
                      '' StudentName,
                      '' `lname`,
                      ''  as Sex,
                      '' `fname`,
                      '' `mname`,
                      '' `nameext`,
                      '' `designation`,
                      '' `birthdate`,
                      '' `birthdatevalue`,
                      '' as Age,
                      '' `contact_guardian`,
                      '' `contact_relation`,
                      '' `contact_address`,
                      '' `contactno`,
                      '' `status`,
                      '' `sssgsisno`,
                      '' `tinno`,
                      '' `philno`,
                      '' `pagibigno`,
                      '' `isactive`,
                      '' `category`,
                      '' `printinghistory`,
                      '' `pathpicture`,
                      '' `pathsignature`,
                      0 `isforprint`,
                      '' `addedby`,
                      '' `addeddate`,
                      '' `modifiedby`,
                      '' `modifieddate`,
                      '' `batch`,
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
                      zid.`backsignaturexy`,
                      zid.`frontbatchxy`
                        FROM `{$dbname}`.`zidsetupheader` zid
                        where zid.setuptype='Alumni' and zid.setdefault=1  and zid.category='COLLEGE' 
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
              `$dbname`.`zpicturerecord` where emp_id='{$param["emp_id"]}' and isdeleted=0 and idtype='Alumni'
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
              `$dbname`.`zsignaturerecord` where emp_id='{$param["emp_id"]}' and isdeleted=0 and idtype='Alumni'
               ";
        return $this->getJSonJQGridPagingResponse($strSQL, null, false);
        // return $this->getJSonJQGridResponseLimit($strSQL, null, false);
    }
    
    public function saveAlumniInformation($param) {
        $dbname = DB_NAME;
        $this->db->autocommit(FALSE);
        $strNewID = ($param["idnum"] == "" ? 'NULL' : $param["idnum"]);
        if ($strNewID == 'NULL') {
            $strSQL = "INSERT INTO `$dbname`.alumni SET                           
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
                          pagibigno='" . $this->db->real_escape_string($param["pagibigno"]) . "', 
                          typeid='Alumni',
                          isforprint='" . $this->db->real_escape_string($param["isforprint"]) . "',
                          `addedby`='" . $_COOKIE['loginUserID'] . "',
                          `addeddate`=NOW(),
                          `modifiedby`='" . $_COOKIE['loginUserID'] . "',
                          `modifieddate`=NOW(),
                          `batch`='" . $this->db->real_escape_string($param["batch"]) . "'
                  ";
        } else {
            $strSQL = "UPDATE `$dbname`.alumni SET
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
                          pagibigno='" . $this->db->real_escape_string($param["pagibigno"]) . "',
                          typeid='Alumni',
                          isforprint='" . $this->db->real_escape_string($param["isforprint"]) . "',
                          `modifiedby`='" . $_COOKIE['loginUserID'] . "',
                          `modifieddate`=NOW(),
                          `batch`='" . $this->db->real_escape_string($param["batch"]) . "'
                         
                              WHERE idnum = '{$strNewID}'";
        }


        //  print_r($strSQL);
//        $strSQL = mb_convert_encoding($strSQL, "SJIS-win", "UTF8");
//        mb_convert_variables("UTF-8", "SJIS-win", $strSQL);

        $strResult = $this->db->query($strSQL) or die($this->db->error());

        if ($strResult) {
            //Initialized values ::::::::::::::::::::::::::::::::::::::::::
            $strSQL = "select last_insert_id(idnum) as id from `$dbname`.alumni order by id desc limit 1";
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

    public function generatenewid($param) {
        $dbname = DB_NAME;
        $this->db->autocommit(FALSE);
        $idnew = $param["idnum"];

        $strSQL = "SELECT emp_id FROM `$dbname`.`student` where emp_id='{$idnew}' ";
        $arrLastInsertedID = $this->db->fetchAll($strSQL);
        $lastInsertedID = $arrLastInsertedID[0]['emp_id'];
        $strIDholder = $strNewID;
        $strNewID = $lastInsertedID;

        $this->db->commit();  //Uncomment to enable saving

        return $strNewID == "" ? "none" : $strNewID;
    }

    public function updateprintinghistory($param) {
        $dbname = DB_NAME;
        $this->db->autocommit(FALSE);
        $strNewID = ($param["idnum"] == "" ? 'NULL' : $param["idnum"]);

        $strSQL = "UPDATE `$dbname`.alumni SET  
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
                $strSQL = "select printinghistory  from `$dbname`.alumni  WHERE idnum  in({$strNewID})";
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
        $strSQL = "select (emp_id) as id from `$dbname`.alumni  where idnum='{$strID}'";
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
//                $strSQL = "UPDATE `$dbname`.alumni SET                       
//                          pathpicture='{$newpath}'
//                         WHERE emp_id='{$strID}'";
//
//                $strResult = $this->db->query($strSQL) or die($this->db->error());
                $strSQL2 = "INSERT INTO `$dbname`.zpicturerecord SET  
                          id=null,
                          emp_id='{$strID}',
                          idtype='Alumni',
                          path='{$newpath}',
                          filename='{$strID}_{$newFileName}'  ";

               $strResult =  $this->db->query($strSQL2) or die($this->db->error());
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
                $strSQL = "UPDATE `$dbname`.alumni SET                       
                          pathpicture='{$imagePicturePath}'
                         WHERE emp_id='{$strID}'";

                $strResult = $this->db->query($strSQL) or die($this->db->error());
                $strSQL2 = "INSERT INTO `$dbname`.zpicturerecord SET  
                          id=null,
                          emp_id='{$strID}',
                          idtype='Alumni',
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
//                $strSQL = "UPDATE `$dbname`.alumni SET                       
//                          pathsignature='{$newpath}'
//                         WHERE idnum='{$strID}'";
//                $strResult = $this->db->query($strSQL) or die($this->db->error());
                 $strSQL2 = "INSERT INTO `$dbname`.zsignaturerecord SET  
                          id=null,
                          emp_id='{$strID}',
                          idtype='Alumni',
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
                $strSQL = "UPDATE `$dbname`.alumni SET                       
                          pathsignature='{$imageSignaturePath}'
                         WHERE emp_id='{$strID}'";

                $strResult = $this->db->query($strSQL) or die($this->db->error());
                $strSQL2 = "INSERT INTO `$dbname`.zsignaturerecord SET  
                          id=null,
                          emp_id='{$strID}',
                          idtype='Alumni',
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

$model = new ModCJCAlumniRecord();
?>
