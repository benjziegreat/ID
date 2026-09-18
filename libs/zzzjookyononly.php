<?php

class EncyptionCustomize {
    public function Newncrpting($password, $data) {
        $salt = substr(md5(mt_rand(), true), 8);

        $key = md5($password . $salt, true);
        $iv = md5($key . $password . $salt, true);
        $ct = mcrypt_encrypt(MCRYPT_RIJNDAEL_128, $key, $data, MCRYPT_MODE_CBC, $iv);

        return base64_encode('Salted__' . $salt . $ct);
    }

    function Newdcryting($password, $data) {

        $data = base64_decode($data);
        $salt = substr($data, 8, 8);
        $ct = substr($data, 16);

        $key = md5($password . $salt, true);
        $iv = md5($key . $password . $salt, true);

        $pt = mcrypt_decrypt(MCRYPT_RIJNDAEL_128, $key, $ct, MCRYPT_MODE_CBC, $iv);

        return $pt;
    }

}
