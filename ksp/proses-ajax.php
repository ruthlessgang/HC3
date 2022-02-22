<?php
// konfigurasi database
$host       =   "10.50.234.33";
$user       =   "root";
$password   =   "P@ssw0rd";
$database   =   "hc3";
// perintah php untuk akses ke database
$koneksi = mysqli_connect($host, $user, $password, $database);


$emp_id = $_GET['emp_id'];
$query = mysqli_query($koneksi, "select * from employee where emp_id='$emp_id'");
$employee = mysqli_fetch_array($query);
$data = array(
            'emp_name'      =>  $employee['emp_name'],
            'emp_posisi'   =>  $employee['emp_posisi'],
            'entity'    =>  $employee['entity'],
			'idcustomer'    =>  $employee['idcustomer'],);			
 echo json_encode($data);
?>