<?php

include_once '../libs/model.php';

class ModelMainLogin extends Model {

    public function __construct() {

        parent::__construct(DB_HOST,DB_USER,DB_PASS,DB_CHARSET);

        $this->action = (isset($_GET["ACTION"]) ? $_GET["ACTION"] : null);
        $this->params = (isset($_GET["PARAM"]) ? $_GET["PARAM"] : null);
        $this->type = (isset($_GET["TYPE"]) ? $_GET["TYPE"] : null);
        $this->limit = (isset($_GET["LIMIT"]) ? $_GET["LIMIT"] : null);


        if ($this->action == 'logOut') {
            $this->logOut();
        } else if ($this->action == 'logIn') {
            echo $this->logIn($this->params);
        }
    }

    public function logIn($data) {       
        $this->db = new Database(DB_HOST, DB_USER, DB_PASS, DB_CHARSET);
         echo $strSQL = "SELECT 
                      `transid` UserNameID,
                      `userid` EmpID,
                      `username`,
                      `email`,
                      `password`,
                      `usertype`,
                      `Country`,
                      `datecreated`,
                      `lastmodified`
                    FROM 
                      recruitment.`user` WHERE username = '{$data["Username"]}' 
                     AND password = MD5('{$data["Password"]}')";
        $loginData = $this->db->fetchAll($strSQL);
       $loginData[0]["UserNameID"]."naa";
        if (sizeof($loginData) > 0) {
           
            setcookie('loginUserNameID', $loginData[0]["UserNameID"], 0, '/');
            setcookie('loginUserID', $loginData[0]["username"], 0, '/');
            setcookie('loginUserName', $loginData[0]["email"], 0, '/');
            return json_encode($this->db->fetchAll($strSQL));
        }
              
    }

    public function logOut() {

        if (setcookie('loginUserNameID', '', time(), '/') &&
                setcookie('loginUserID', '', time(), '/') &&
                setcookie('loginUserName', '', time(), '/') &&
                setcookie('lang', '', time(), '/')
        ) {
            header('location: ../Recruitment/');
        } else {
            echo "wala";
        }
    }

}

$model = new ModelMainLogin();
?>