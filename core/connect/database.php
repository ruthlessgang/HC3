<?php 
$config = array(
	'host'		=> 'localhost',
	'username' 	=> 'root',
	'password' 	=> 'P@ssw0rd',
	'dbname' 	=> 'db_hc3'
);

$db = new PDO('mysql:host=' . $config['host'] . ';dbname=' . $config['dbname'], $config['username'], $config['password']);
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

?>
