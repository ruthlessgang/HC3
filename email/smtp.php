<?php
include 'pengirim.php';
$to	=$_POST['email'];
$to2	=$email_assignee;
$to3	=$email_assignee2;
$to4	=$email_assignee3;
$emailcc	='hc3@sahabat-ukm.com';
require 'PHPmailer/class.phpmailer.php';
$mail = new PHPMailer;

// Konfigurasi SMTP
$mail->isSMTP(true);
$mail->Host = '10.9.71.2';
//$mail->Host = 'smtp.gmail.com'; //smtp gmail
//$mail->Host = 'smtp.mailgun.org'; //mailgun
$mail->SMTPAuth = true;
$mail->Username = $username;
$mail->Password = $password;
//$mail->SMTPSecure = 'tls'; //secure google
$mail->SMTPSecure = ''; //untuk  exchange kosongin, untuk google tls,
//$mail->Port = 587; //ini port untuk Gmail
$mail->Port = 25;

$mail->setFrom($username, $alias);
$mail->addReplyTo($username, $alias);

// Menambahkan penerima
$mail->addAddress($to);

// Menambahkan beberapa penerima
$mail->addAddress($to2);
$mail->addAddress($to3);
$mail->addAddress($to4);
//$mail->addAddress('penerima3@contoh.com');

// Menambahkan cc atau bcc 
$mail->addCC($emailcc);
//$mail->addBCC($emailbcc);

// Subjek email
$mail->Subject =$emailsubject;

// Mengatur format email ke HTML
$mail->isHTML(true);

// Konten/isi email
$mail->Body = $message;

// Menambahakn lampiran
//$mail->addAttachment('lmp/file1.pdf');
//$mail->addAttachment('lmp/file2.png', 'nama-baru-file2.png'); //atur nama baru

// Kirim email
if(!$mail->send()){
	//echo 'Ticket Number '.$ticketnumber.' Simpan no ticket tersebut untuk mentracking pertanyaan anda.<br>';
	echo 'Mailer Error: ' . $mail->ErrorInfo;
	$info_error_mailer='Mailer Error: ' . $mail->ErrorInfo;
}else{
	//echo 'Pesan telah terkirim dengan no ticket dibawah ini. <br>';
	echo 'Ticket Number '.$ticketnumber;
}
?>