<?php 
$host	=getenv('DB_HOSTNAME');
$username=getenv('DB_USERNAME');
$password 	= getenv('DB_PASSWORD');
$dbname 	= getenv('DB_DATABASE');
$db = new PDO(
  'mysql:unix_socket=/cloudsql/'.$host.';dbname='.$dbname.';charset=utf8',  
  '$username',
  '$password'
);
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
/*
$con = array(
	'host'		=> getenv('DB_HOSTNAME'),
	'username' 	=> getenv('DB_USERNAME'),
	'password' 	=> getenv('DB_PASSWORD'),
	'dbname' 	=> getenv('DB_DATABASE')
);

 'mysql' => [
            'driver' => 'mysql',
            'database' => env('DB_DATABASE', 'forge'),
            'username' => env('DB_USERNAME', 'forge'),
            'password' => env('DB_PASSWORD', ''),
            'unix_socket' => env('DB_SOCKET', ''),
            'charset' => 'utf8mb4',
            'collation' => 'utf8mb4_unicode_ci',
            'prefix' => '',
            'prefix_indexes' => true,
            'strict' => true,
            'engine' => null,
            'options' => extension_loaded('pdo_mysql') ? array_filter([
                PDO::MYSQL_ATTR_SSL_CA => env('MYSQL_ATTR_SSL_CA'),
            ]) : [],
*/
/*
$db = new mysqli($con['host'], $con['username'], $con['password'], $con['dbname']);
if (mysqli_connect_errno()) {
	printf("MySQLi connection failed: ", mysqli_connect_error());
	exit();
}

// Change character set to utf8
if (!$db->set_charset('utf8')) {
	printf('Error loading character set utf8: %s\n', $db->error);
}


$db = new PDO('mysql:host=' . $config['host'] . ';dbname=' . $config['dbname'], $config['username'], $config['password']);
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
*/



?>
