<?php

function BASE_URL()
{
    return $_SERVER['REQUEST_SCHEME'].'://'.$_SERVER['SERVER_NAME'].'/';
}

function BASE_TITLE()
{
    return "Event Places";
}

function DIR_Upload()
{
    return str_replace("\\", "/", str_replace("libs", "", dirname(__FILE__))) . 'assets/uploads/';
}

function DIR_Upload_Folder($subFolder = "others")
{
    return str_replace("\\", "/", str_replace("libs", "", dirname(__FILE__))) . 'assets/uploads/' . $subFolder . '/';
}

function GUID()
{
    if (function_exists('com_create_guid')) {
        return com_create_guid();
    } else {
        mt_srand((float)microtime() * 10000);
        $charV = strtoupper(md5(uniqid(rand(), true)));
        $hyphen = chr(45);
        $uuid = substr($charV, 0, 8) . $hyphen . substr($charV, 8, 4) . $hyphen . substr($charV, 12, 4) . $hyphen . substr($charV, 16, 4) . $hyphen . substr($charV, 20, 12);
        return $uuid;
    }
}

?>
