<?php


include_once '../libs/modelpdo.php';
include_once 'mod.system.config.php';


class ModelSystemMessages extends ModelPDO
{

    public function __construct($dsn)
    {
        //$dsn
        parent::__construct($dsn);

        $this->action = (isset($_GET["ACTION"]) ? $_GET["ACTION"] : null);
        $this->getparams = (isset($_GET["GETPARAM"]) ? $_GET["GETPARAM"] : null);
        $this->postparams = (isset($_POST["POSTPARAM"]) ? $_POST["POSTPARAM"] : null);
        $this->type = (isset($_GET["TYPE"]) ? $_GET["TYPE"] : null);
        $this->limit = (isset($_GET["LIMIT"]) ? $_GET["LIMIT"] : null);


        if ($this->action != null) {
            parent::__construct(DBDSN_MESSAGES);
        }

        if ($this->action == 'getMessage') {
            echo json_encode($this->getMessage($this->getparams["Lang"], $this->getparams["ModuleID"], $this->getparams["MessageID"]));
        } elseif ($this->action == 'getModuleMessageList') {
            echo $this->getModuleMessageList($this->getparams["Lang"], $this->getparams["SystemID"], $this->getparams["ModuleID"], $this->getparams["SearchKey"], $this->type);
        } elseif ($this->action == 'InsertUpdateMessageDialog') {
            echo $this->InsertUpdateMessageDialog($this->getparams["Lang"], $this->getparams["SystemID"], $this->getparams["ModuleID"], $this->postparams);
        } elseif ($this->action == 'getMessageDialogDetail') {
            echo $this->getMessageDialogDetail($this->getparams);
        }


    }

    public function getMessage($lang, $strModuleID, $strMessageID)
    {

        //$strLangCode = (isset($_COOKIE["lang"])? $_COOKIE["lang"] : "jp");
        $strSQL =
            "SELECT
                msg.Code,
                msg.Message
            FROM MstMessages msg
            INNER JOIN  MstLanguage lng ON (msg.LanguageID = lng.ID)
            WHERE msg.ModuleID = '" . $strModuleID . "'
            AND msg.MessageID = '" . $strMessageID . "'
            AND lng.Code = '" . $lang . "'
            LIMIT 1";
        //return   $strSQL;
        return $this->db->fetchAllPDO($strSQL);
    }

    public function getModuleMessageList($lang, $strSystemID, $strModuleID, $strSearchKey = '', $isJQGrid = false)
    {

        //$strLangCode = isset($_COOKIE["lang"])?$_COOKIE["lang"]:"jp";
        // $strLangCode =  $_COOKIE["lang"];

        // if ($strLangCode == ""){
        // $strLangCode = "jp";
        // }
        //$strLangCode = (isset($_COOKIE["lang"])? $_COOKIE["lang"] : "jp");

        $strSQL =
            "SELECT 
                    msg.ID,
                    msg.Code,
                    msg.MessageID,
                    msg.Message,
                    msg.SystemID,
                    msg.ModuleID,
                    msg.ModifiedByID,
                    msg.Remarks,
                    msg.LastModified
            FROM MstMessages msg
            INNER JOIN  MstLanguage lng ON (msg.LanguageID = lng.ID)
            WHERE (msg.SystemID = '" . md5($strSystemID) . "' AND msg.ModuleID = '" . md5($strModuleID) . "' AND lng.Code = '" . $lang . "') OR (msg.ModuleID = '" . SystemModules::ID_COMMON . "'  AND lng.Code = '" . $lang . "')
            AND (msg.Code || ' ' || msg.MessageID || ' ' || msg.Message) 
            LIKE '%" . $strSearchKey . "%'";


//            return $strSQL;
        if ($isJQGrid) {
            return $this->getJSonJQGridPagingResponse($strSQL, "msg.Code");
        } else {
            return json_encode($this->db->fetchAllPDO($strSQL));
        }
    }

    public function  getMessageDialogDetail($strID)
    {

        $strSQL =
            "SELECT 
                    msg.ID,
                    msg.Code,
                    msg.MessageID,
                    msg.Message,
                    msg.Remarks,
                    msg.ModifiedByID,
                    msg.LastModified
            FROM MstMessages msg
            WHERE msg.ID = '" . $strID . "'";

        return json_encode($this->db->fetchAllPDO($strSQL));

    }


    public function  InsertUpdateMessageDialog($strLangCode, $strSystemID, $strModuleID, $jsonDetails)
    {

        $strNewID = ($jsonDetails["ID"] == "" ? uniqid() : $jsonDetails["ID"]);
        //$strLangCode = (isset($_COOKIE["lang"])? $_COOKIE["lang"] : "jp");
        $sql = "SELECT ID FROM MstLanguage WHERE Code='$strLangCode'";
        $rowID = $this->db->fetchAllPDO($sql);
        $langID = $rowID[0]['ID'];


        //Insert Header
        if ($jsonDetails["ID"] == "") {

            $strSQL =
                "INSERT INTO MstMessages
                (`ID`,
                `Code`,
                `MessageID`,
                `LanguageID`,
                `SystemID`,
                `ModuleID`,
                `Message`,
                `Remarks`,
                `ModifiedByID`,
                `LastModified`)
                VALUES
                ('" . md5($strNewID) . "',
             '" . $jsonDetails["Code"] . "',
             '" . $jsonDetails["MessageID"] . "',
             '" . $langID . "',
             '" . md5($strSystemID) . "', 
             '" . md5($strModuleID) . "', 
             '" . $jsonDetails["Message"] . "',
             '" . $jsonDetails["Remarks"] . "',
             '" . $_COOKIE['loginUserGUID'] . "',
             CURRENT_TIMESTAMP)";

        } else {

            $strSQL =
                "UPDATE MstMessages SET
                `Code` = '" . $jsonDetails["Code"] . "',
            `MessageID` = '" . $jsonDetails["MessageID"] . "',
            `Message` = '" . $jsonDetails["Message"] . "',
            `Remarks` = '" . $jsonDetails["Remarks"] . "',
            `ModifiedByID` = '" . $_COOKIE['loginUserGUID'] . "',
            `LastModified` = CURRENT_TIMESTAMP 
            WHERE `ID` = '" . $strNewID . "'";
        }


        $strResult = $this->db->exec($strSQL) or die($this->db->error());
        return ($strResult ? "Success" : "Failed");

    }


}

$model = new ModelSystemMessages();

?>
