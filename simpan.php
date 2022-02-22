<?php 
mysql_connect('localhost','root',''); 
mysql_select_db('ajaxbeforesend');

$nama = $_POST['nama'];
$alamat = $_POST['alamat'];

$query = mysql_query("insert into biodata (nama,alamat) values ('$nama', '$alamat')");

if($query){
 echo '<div class="alert alert-success alert-dismissible" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button><strong>Sukses </strong> data berhasil di tambahkan </div>';
}else{
 echo '<div class="alert alert-danger alert-dismissible" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button><strong>Gagal </strong> terjadi kesalahan </div>';
}
?>