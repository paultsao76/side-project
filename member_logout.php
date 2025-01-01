<?php 
include_once('./application.php');
session_start(); 

//登出執行
unset($_SESSION['member']);
$url = $CFG->wwwroot."/member/";
header("Location:".$url);
?>