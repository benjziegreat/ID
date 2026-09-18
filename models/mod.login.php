<?php

include_once '../libs/model.php';
include_once '../config/cons.paths.php';

class ModelMainLogin extends Model {

    public function __construct() {

        parent::__construct('', '', '', '');

        $this->action = (isset($_GET["ACTION"]) ? $_GET["ACTION"] : null);
        $this->getparams = (isset($_GET["GETPARAM"]) ? $_GET["GETPARAM"] : null);
        $this->postparams = (isset($_POST["POSTPARAM"]) ? $_POST["POSTPARAM"] : null);
        $this->type = (isset($_GET["TYPE"]) ? $_GET["TYPE"] : null);

        switch ($this->action) {
            case 'logOut':
                echo $this->logOut($this->getparams);
                break;
            case 'logIn':
                echo $this->logIn($this->postparams);
                break;
            case 'RegisterAccount':
                echo $this->RegisterAccount($this->postparams);
                break;
            default:
                break;
        }
    }

    public function logIn($data) {
//        $this->db = new Database(DB_HOST, DB_USER, DB_PASS, DB_CHARSET);
        $strSQL = "SELECT
                      usr.`transid` as UserNameID,
                      usr.`userid` as EmpID,
                      usr.`Name`,
                      usr.`username`,
                      usr.`email`,
                      usr.`password`,
                      usr.`usertype`,
                      usr.`datecreated`,
                      usr.`lastmodified`,
                      md5(SHA1(CONCAT(usr.usertype,'RSPS'))) as type
                    FROM
                      recruitment.`user` usr WHERE usr.username = '{$data["Username"]}'
                     AND usr.password = MD5('{$data["Password"]}')";
        $loginData = $this->db->fetchAll($strSQL);
        if (sizeof($loginData) > 0) {
            setcookie('loginUserNameID', $loginData[0]["UserNameID"], 0, '/');
            setcookie('loginUserID', $loginData[0]["username"], 0, '/');
            setcookie('loginUserName', $loginData[0]["Name"], 0, '/');
            setcookie('type',$loginData[0]['type'],0,'/');
            setcookie('lang', (isset($_COOKIE["lang"])? $_COOKIE["lang"]: CURRENT_LANGUAGE), 0, '/');
            return json_encode($this->db->fetchAll($strSQL));
        }
    }

    public function logOut() {

        if (setcookie('loginUserNameID', '', time(), '/') &&
                setcookie('loginUserID', '', time(), '/') &&
                setcookie('loginUserName', '', time(), '/') &&
                setcookie('type', '', time(), '/') &&
                setcookie('lang', '', time(), '/')
        ) {
            header('location: ../redirectindex');
        } else {
            echo "wala";
        }
    }

    public function RegisterAccount($param) {
//        print_r($param);
        foreach ($param as $key => $value)
            $$key = $value;

        $this->db->autocommit(false);

        $TRANSID = $TRANSID == "" ? 'NULL' : $TRANSID;

        $strSQL = "
            INSERT INTO recruitment.user SET              
              `transid`={$TRANSID},              
              `name`='{$Name}',
              `username`='{$username}',
              `email`='{$email}',
              `password`=MD5('{$password}'),
              `usertype`='{$usertype}',
              `datecreated`=NOW(),
              `lastmodified`=NOW()

              ON DUPLICATE KEY UPDATE
              
              `name`='{$Name}',
              `username`='{$username}',
              `email`='{$email}',
              `password`=MD5('{$password}'),
              `usertype`='{$usertype}',
              `datecreated`=NOW(),
              `lastmodified`=NOW()

             
        ";

//        echo $strSQL;
        if ($this->db->query($strSQL)) {
            $this->db->commit();
            setcookie('loginUserNameID', 0, 0, '/');
            setcookie('loginUserID', $username, 0, '/');
            setcookie('loginUserName', $Name, 0, '/');
            return $TRANSID;
        } else {
            $this->db->rollback();
            return '';
        }
    }

}

$model = new ModelMainLogin();
?>