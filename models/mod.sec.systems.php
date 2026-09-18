<?php

include_once '../libs/model.php';

class ModelSecurityMstSystems extends Model
{

    public function __construct()
    {

        parent::__construct(DB_HOST, DB_USER, DB_PASS, 'utf8');

        $this->action = (isset($_GET["ACTION"]) ? $_GET["ACTION"] : null);
        $this->params = (isset($_GET["GETPARAM"]) ? $_GET["GETPARAM"] : null);
        $this->postparams = (isset($_POST["POSTPARAM"]) ? $_POST["POSTPARAM"] : null);
        $this->type = (isset($_GET["TYPE"]) ? $_GET["TYPE"] : null);
        $this->limit = (isset($_GET["LIMIT"]) ? $_GET["LIMIT"] : null);

        if ($this->action == 'getSystemsList') {
            echo $this->getSystemList($this->params, $this->type);
        } else if ($this->action == 'getSystemsModule') {
            echo $this->getSystemModules($this->params["SystemID"], $this->params["Search"], $this->type);
        } else if ($this->action == 'verifyModuleAccess') {
            echo $this->verifyModuleAccess($this->params["ModuleID"], $this->params["AccessRights"]);
        } else if ($this->action == 'verifyAuthorizedUser') {
            echo $this->verifyAuthorizedUser($this->postparams["UserName"], $this->postparams["Password"], $this->postparams["ModuleID"], $this->postparams["AccessRights"]);
        }

    }

    public function  getSystemList($strSearchKey = '', $isJQGrid = false)
    {

        $strSQL =
            "SELECT
                sys.program_id as ID,
                md5(sys.program_id) as GUID,
                sys.program_name as SystemNameEn,
                sys.jap_name as SystemNameJap
            FROM nkym_security.m_programs sys
            WHERE CONCAT_WS('',sys.jap_name,sys.program_name)
            LIKE '%" . $strSearchKey . "%' ";

        if ($isJQGrid) {
            return $this->getJSonJQGridPagingResponse($strSQL, "ID");
        } else {
            return json_encode(array('rows' => $this->db->fetchAll($strSQL)));
        }
    }

    public function  getSystemModules($lngID, $strSearchKey = '', $isJQGrid = false)
    {

        $strSQL =
            "SELECT
                sysmod.module_id as ID,
                md5(sysmod.module_id) as GUID,
                sysmod.module_name as ModuleNameEn,
                sysmod.module_name_japanese as ModuleNameJap
            FROM nkym_security.m_modules sysmod
            WHERE sysmod.program_id = '" . $lngID . "' AND CONCAT_WS('',sysmod.module_name,sysmod.module_name_japanese)
        LIKE '%" . $strSearchKey . "%'";

        if ($isJQGrid) {
            return $this->getJSonJQGridPagingResponse($strSQL, "ID");
        } else {
            return json_encode(array('rows' => $this->db->fetchAll($strSQL)));
        }
    }

    public function verifyAuthorizedUser($strUserName, $strPassword, $strModuleID, $strAccessRights)
    {
        /**
        $strSQL = "SELECT user.trans_id as UserNameID,
        emp.emp_id as EmpID,
        MD5(emp.emp_id) as EmpGUID,
        MD5(emp.br_id) as EmpBranchGUID,
        emp.emp_name as Employee
        FROM nkym_security.m_user  user
        INNER JOIN hrms.m_employee emp ON (user.user_id = emp.emp_id)
        WHERE user.username = '" . $strUserName . "' " .
        " AND user.password = MD5('" . $strPassword . "')";
         **/

        $strSQL = "SELECT user.trans_id as UserNameID,
                        emp.person_code as EmpID,
                        MD5(emp.person_code) as EmpGUID,
                        MD5(5) as EmpBranchGUID,
                        CONCAT(emp.`l_name`,', ', emp.`f_name`, ' ', LEFT(emp.`m_name`,1)) as Employee
                    FROM nkym_security.m_user  user
                    INNER JOIN " . DB_NAME . ".person emp ON (user.user_id = emp.person_code)
                    WHERE user.username = '" . $strUserName . "' " .
            " AND user.password = MD5('" . $strPassword . "')";

        $rs = $this->db->fetchAll($strSQL);

        if (sizeof($rs) > 0) {

            return $this->verifyModuleAccess($strModuleID, $strAccessRights, $rs[0]["UserNameID"]);

        } else {
            return json_encode('INVALID_USERNAME_PASSWORD');
        }

    }

    public function  verifyModuleAccess($strModuleID, $strAccessRights, $lngUserNameID = 0)
    {
        //print_r($_COOKIE);

        if ($lngUserNameID == 0) {
            $lngUserNameID = (isset($_COOKIE["loginUserNameID"]) ? $_COOKIE["loginUserNameID"] : 0);
        }

        //check admin.
        $isOk = $this->isUserAdmin($lngUserNameID);

        if ($isOk) {
            return json_encode($isOk);
        }

        //check on group assigned access.
        $isOk = $this->isUserGroupHasAccess($strModuleID, $strAccessRights, $lngUserNameID);

        if ($isOk) {
            return json_encode($isOk);
        }

        //check on user assigned access.
        $isOk = $this->isUserHasAccess($strModuleID, $strAccessRights, $lngUserNameID);

        return json_encode($isOk);

    }

    private function isUserAdmin($lngUserNameID = 0)
    {

        $strSQL =
            "SELECT admin
            FROM nkym_security.m_accesstrans
            WHERE username_id = " . $lngUserNameID . "
        AND admin = 1";

        $rs = $this->db->fetchAll($strSQL);

        return (sizeof($rs) > 0);
    }

    private function isUserGroupHasAccess($strModuleID, $strAccessRights, $lngUserNameID = 0)
    {

        $strSQL =
            "SELECT *
            FROM (
                SELECT  arhs.access_id
                FROM nkym_security.m_group_acess_modules gams
                INNER JOIN nkym_security.m_modules mods ON (gams.module_id = mods.module_id)
                INNER JOIN nkym_security.m_group_access gacs ON (gams.group_access_id = gacs.trans_id)
                INNER JOIN nkym_security.m_accesstrans tacs ON (tacs.group_id = gacs.group_id AND tacs.username_id = " . $lngUserNameID . ")
            INNER JOIN nkym_security.m_accessrights arhs ON (gams.acess_id = arhs.access_id)
            WHERE MD5(mods.module_id) = '" . $strModuleID . "'
            AND arhs." . $strAccessRights . " = 1 
            LIMIT 1
        ) a";

        $rs = $this->db->fetchAll($strSQL);

        return (sizeof($rs) > 0);
    }

    private function isUserHasAccess($strModuleID, $strAccessRights, $lngUserNameID = 0)
    {

        $strSQL =
            "SELECT *
            FROM(
                SELECT arhs.access_id
                FROM nkym_security.m_individual_access_modules iams
                INNER JOIN nkym_security.m_modules mods ON (iams.module_id = mods.module_id)
                INNER JOIN nkym_security.m_individual_access iacs ON (iams.individual_access_id = iacs.trans_id)
                INNER JOIN nkym_security.m_accessrights arhs ON (iams.access_id = arhs.access_id)
                WHERE iacs.username_id = " . $lngUserNameID . "
            AND MD5(mods.module_id) = '" . $strModuleID . "'
            AND arhs." . $strAccessRights . " = 1 
            LIMIT 1
        )a";

        $rs = $this->db->fetchAll($strSQL);

        return (sizeof($rs) > 0);

    }


}

$model = new ModelSecurityMstSystems();
?>


