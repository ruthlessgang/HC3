<?php 
require 'core/init.php';
$general->logged_out_protect();
$users->log_users($_SESSION['loginid'],"Logout Helpdesk System");
//session_start(); //Jika versinya lama bisa diaktifkan
session_destroy();
header('Location:index.php');
?>
