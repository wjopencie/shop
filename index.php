<?php
session_start();
include_once "./load.php";
include_once "./config/config.php";
if(!empty($_SERVER['PATH_INFO'])){
    $strData = $_SERVER['PATH_INFO'];
    $arrData = explode("/",$strData);
    $m = empty($arrData[1]) ? M :$arrData[1];
    $c = empty($arrData[2]) ? C :$arrData[2];
    $a = empty($arrData[3]) ? A :$arrData[3];
}else{
    $m =  M ;
    $c =  C ;
    $a =  A ;
}
$str = "\\$m\\controller\\$c";
$obj = new $str();
$obj->$a();
