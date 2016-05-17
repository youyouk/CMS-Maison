<?php 
ini_set('display_errors', 1); 
error_reporting(E_ALL); 
define("SECURE", FALSE);
include_once 'admin-config.php'; 
sec_session_start(); 
$EMAIL 	= $_POST['EMAIL'];
$MDP 	= $_POST['MDP'];
$IP 	= $_POST['IP'];
if ((isset($EMAIL, $MDP, $IP)) && ($IP != "")) {
    if (login($EMAIL, $MDP, $IP, $bdd) == true) {
        header('Location: ../admin/index.php?m=1');
    } 
} else { 
    header('Location: ../admin/login.php?e=2');
}