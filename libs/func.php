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

function ToHash($word)
{
    return hash('sha1', $word);
}

function LimitString($word, $length)
{
    $len = strlen($word);
    return  substr($word, 0, $len <= 50 ? $len : $length);
}

function CirlceStatus($status)
{
    switch($status){
        case "RF": return "red-circle";
        case "PD": return "green-circle";
        case "FV": return "blue-circle";
        default: return "";
    }
}

function StatusName($status)
{
    switch($status){
        case "FV": return "For Verification";
        case "PD": return "Paid";
        case "RF": return "Refunded";
        default: return "";
    }
}

function GroupBy($array, $key) {
    $temp_array = [];
    foreach ($array as $init) {
        $temp_array[$init[$key]][] = $init;
    }
    $result = array();
    foreach ($temp_array as $name => $arr) {
        $obj = new stdClass;
        $obj->key = $name;
        $obj->value = $arr;
        array_push($result, $obj);
    }
    return $result;
}

?>