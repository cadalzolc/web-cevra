<?php

require_once('crypt.php');

function IsNullOrEmptyString($str)
{
    return ($str === null || trim($str) === '');
}

function ToBoolean($res)
{
    return $res ? 'true' : 'false';
}

function ToInteger($res)
{
    return intVal($res);
}

function GeneratePin()
{
    $characters = '0123456789';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < 6; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}

function GetUserFromEmail($email)
{
    return strstr($email, '@', true);
}

function IIF($value, $checkValue, $defaultValue) {
    return($value == $checkValue ? $defaultValue : $value);
}

function Encrypt($word) {
    $crypt = new Crypto();
    return $crypt->Encrypt($word);
}

function Decrypt($word) {
    $crypt = new Crypto();
    return $crypt->Decrypt($word);
}

?>