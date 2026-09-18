<?php

    include_once '../config/cons.database.php';
    
    class DatabasePDO extends PDO{
        
        public function __construct($dsn) {

            //$this->dsn = (!isset($dsn)?DBDSN_MESSAGES : $dsn);
            
            if (isset($dsn)){
                parent::__construct($dsn);
                //echo 'connected.<br/>';
            }
            
        }
        
        public function fetchAllPDO($str_Query){

            $arr_Data = array();
            
            foreach ($this->query($str_Query) as $row) {
                 $arr_Data[] = $row;
            }
            
            return $arr_Data;
   
            //return $this->query($str_Query)->fetchAll(PDO::FETCH_BOTH);
            
        }	
    }

?>
