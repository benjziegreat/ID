<?php

include_once '../config/cons.database.php';
include_once 'passencryption.php';

class Database extends MySQLi {

    public function __construct($dbHost, $dbUser, $dbPass, $dbCharSet) {
        //   $encryption = new EncyptionCustomize();
        // $encrypted = $encryption->Newncrpting('mypassword', 'rootroot');
        // $decrypted = $encryption->Newdcryting('mypassword', substr($encrypted, 0, strlen($encrypted) - 1));
        // print_r(substr($encrypted, 0, strlen($encrypted) - 1) . '<br>' . trim($decrypted));        
        
         $user=DB_USER;
         $pass=DB_PASS;
         

        $this->dbHost = (!isset($dbHost) || empty($dbHost) ? DB_HOST : $dbHost);
        $this->dbUser = (!isset($dbUser) || empty($dbHost) ? $user : $dbUser);
        $this->dbPass = (!isset($dbPass) || empty($dbHost) ? $pass : $dbPass);
        $this->dbCharSet = (!isset($dbCharSet) || empty($dbHost) ? 'utf8' : $dbCharSet);

        parent::__construct($this->dbHost, $this->dbUser, $this->dbPass);
        $this->set_charset($this->dbCharSet);
    }

    public function fetchAll($str_Query) {

        $arr_Data = array();

        $rs = $this->query($str_Query) or die($this->error . " SQL Statement: $str_Query");

        while ($row = $rs->fetch_array(MYSQLI_ASSOC)) {
            $arr_Data[] = $row;
        }

        //free the resultset
        $rs->close();

        return $arr_Data;
    }

    public function fetchAllForSJIS($str_Query) {

        $arr_Data = array();

        $this->set_charset('sjis');

        $rs = $this->query($str_Query) or die($this->error . " SQL Statement: $str_Query");

        while ($row = $rs->fetch_array(MYSQLI_ASSOC)) {
            $arr_Data[] = $this->getEncodedValues($row);
        }

        //free the resultset
        $rs->close();

        return $arr_Data;
    }

    public function getEncodedValues($arr) {
        foreach ($arr as $n => $v) {
            if (is_array($v)) {
                $arr[$n] = $this->getEncodedValues($v);
            } else {
                $arr[$n] = mb_convert_encoding($v, "UTF-8", "SJIS-win");
            }
        }
        return $arr;
    }

    public function fetchAllForGrid($str_Query) {


        $rs = $this->query($str_Query) or die($this->error);
        $i = 0;
        while ($row = $rs->fetch_array(MYSQLI_ASSOC)) {
            $rows [$i]['id'] = $row['EmpID'];
            $rows [$i]['cell'] = $row;

            $i++;
        }

        //free the resultset
        $rs->close();

        return $rows;
    }

    public function clearStoredResults() {
        while ($this->next_result()) {
            if ($l_result = $this->store_result()) {
                $l_result->free();
            }
        }
    }

    public function changeServerSJIS($host, $user, $password) {
        parent::__construct($host, $user, $password);
        mysql_query("SET CHARACTER SET sjis", $this);
        mysql_query("SET NAMES 'sjis'", $this);
        mysql_select_db("mysql", $this);
    }

    public function changeDBname($host, $user, $password) {
        parent::__construct($host, $user, $password);
        mysql_select_db("hris", $this);
    }

}

?>