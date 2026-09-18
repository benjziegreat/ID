<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of mod
 *
 * @author Lewin
 */

include_once  '../libs/model.php';

class ModelTestEmployee extends Model {
    
    public function __construct() {
        
        parent::__construct(DB_HOST_MAIN,DB_USER_MAIN,DB_PASS_MAIN,'sjis');
//         parent::__construct();
        $this->action = (isset($_GET["ACTION"])? $_GET["ACTION"] : null);
        $this->params = (isset($_GET["PARAM"])? $_GET["PARAM"] : null);
        $this->type = (isset($_GET["TYPE"])? $_GET["TYPE"] : null);
        $this->limit = (isset($_GET["LIMIT"])? $_GET["LIMIT"]: null);
        
        if ($this->action == 'getEmployeeList'){
            echo $this->getEmployeeList($this->params,$this->type);
        }else if($this->action == 'getEmployeeActiveList') {
            echo $this->getEmployeeActiveList($this->params,$this->type,$this->limit);
        }else if($this->action == 'getEmployeeInfo') {
            echo $this->getEmployeeInfo($this->params);
        }else if($this->action == 'getEmployeeDependentList') {
            echo $this->getEmployeeDependentList($this->params);
        }else if($this->action == 'getRelationList') {
            echo $this->getRelationList($this->params,$this->type,$this->limit);
        }else if($this->action == 'getEmployeeImage') {
            echo $this->getEmployeeImage($this->params);
        }
    }
    
    public function getEmployeeList($strSearchKey = '', $isJQGrid = false){
        
        $strSQL = 
        "SELECT false as IsChecked,
                emp.emp_id as EmpID,
                emp.emp_name as EmpName,
                emp.emp_furigana as EmpFurigana,
                emp.position as Position,
                emp.category as Category,
                if((emp.datesep is null or  emp.datesep >= curdate()),1,0) as IsActive
        FROM hrms.m_employee emp 
        WHERE CONCAT_WS('',cast(emp.emp_id as char),emp.emp_name,emp.emp_furigana,emp.position,emp.category)
        LIKE '%" . $strSearchKey . "%' ";
      
        if ($isJQGrid){     
            return $this->getJSonJQGridPagingResponse($strSQL,"EmpID",true);
        }else{
            return json_encode($this->convertArraySJISToUTF8($this->db->fetchAll($strSQL)));
        }
       
    }
    public function getEmployeeActiveList($strSearchKey = '', $isJQGrid = false , $lngBrowserLimit = 0){
        
        $strSQL = 
        "SELECT emp.emp_id as EmpID,
               emp.emp_name as EmpName,
               emp.emp_furigana as EmpFurigana,
               emp.position as Position,
               emp.category as Category,
               if((emp.datesep is null or  emp.datesep >= curdate()),1,0) as IsActive
        FROM hrms.m_employee emp 
        WHERE (emp.datesep is null or  emp.datesep >= curdate()) 
        AND CONCAT_WS('',cast(emp.emp_id as char),emp.emp_name,emp.emp_furigana,emp.position,emp.category)
        LIKE '%" . $strSearchKey . "%' ";
        
        if ($isJQGrid){
           return $this->getJSonJQGridResponse($strSQL, "EmpID",$lngBrowserLimit,true);
        }else{
            return json_encode($this->convertArraySJISToUTF8($this->db->fetchAll($strSQL)));
        }
        
    }
    
    public function getEmployeeInfo($lngEmpID){
        
        $strSQL = 
        "SELECT
               emp.emp_id as EmpID,
               emp.emp_name as EmpName,
               emp.emp_furigana as EmpFurigana,
               emp.position as Position,
               emp.category as Category
        FROM hrms.m_employee emp 
        WHERE emp.emp_id = " . $lngEmpID;

        return json_encode($this->convertArraySJISToUTF8($this->db->fetchAll($strSQL)));
    }
    public function getEmployeeDependentList($lngEmpID){
        
        $strSQL = 
        "SELECT
              dpend.trans_id as RecordNo,
              dpend.name as DependentName,
              dpend.job_type as JobType,
              dpend.relation as Relation,
              dpend.remarks as Remarks
        FROM hrms.emp_dependents dpend
        WHERE dpend.emp_id = ". $lngEmpID;
       

        
        //return $this->getJSonJQGridFormat($this->convertArraySJISToUTF8($this->db->fetchAll($strSQL)));
        
       return json_encode($this->convertArraySJISToUTF8($this->db->fetchAll($strSQL)));
    }
    public function getRelationList($strSearchKey = '', $isJQGrid = false , $lngBrowserLimit = 0){
        
        $strSQL = 
        "SELECT
            ID,
            Relation
        FROM hrms.MstRelationTest rel 
        WHERE CONCAT_WS('',cast(rel.ID as char),rel.Relation)
        LIKE '%" . $strSearchKey . "%' ";
        
        if ($isJQGrid){
           return $this->getJSonJQGridResponse($strSQL, "ID",$lngBrowserLimit,true);
        }else{
            return json_encode($this->convertArraySJISToUTF8($this->db->fetchAll($strSQL)));
        }
    }
      
    public function getEmployeeImage($lngEmpID){
        
            
//        $this->img->load("../empPics/".$lngEmpID."_50_50.jpg");
//        
//        if (!$this->img->output(IMAGETYPE_JPEG)){
//            header("Content-type:image/png");
//            $imgName = "../views/default/images/user.icon.png";
//            $img = @imagecreatefrompng($imgName);
//            imagealphablending($img, true);
//            imagesavealpha($img, true); 						
//            ob_start();
//            imagepng($img);
//            $contents =  ob_get_contents();
//            ob_end_clean();	
//            echo $contents;
//            imagedestroy($img);
//        }

        $this->db6 = new Database();
        $this->db6->changeServerSJIS('192.168.0.6', 'ric202', 'test');
        $this->db6->set_charset('utf8');
      
//        Image from Database
         $strSQL =
        "SELECT picture as EmpImage
        FROM hr_ntc.person_pic
        WHERE person_code = '{$lngEmpID}'";
        
        $rs = $this->db6->fetchAll($strSQL);
        $imgEmp = $rs[0]["EmpImage"];
    
        if (!empty ($imgEmp)){
            
            header("Content-type:image/jpeg");
            echo $imgEmp;
            
        }else{
            
            header("Content-type:image/png");
            $imgName = "../views/default/images/user.icon.png";  
            $img = @imagecreatefrompng($imgName);
            imagealphablending($img, true);
            imagesavealpha($img, true); 						
            ob_start();
            imagepng($img);
            $contents =  ob_get_contents();
            ob_end_clean();	
            echo $contents;
            imagedestroy($img);
        }

        
        
    }

    //put your code here
}
   

$model = new ModelTestEmployee();

?>
