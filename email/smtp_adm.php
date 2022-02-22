<?php
include 'pengirim.php';
$to	=$_POST['email'];
require 'PHPmailer/class.phpmailer.php';
$mail = new PHPMailer;

// Konfigurasi SMTP
$mail->isSMTP(true);
$mail->Host = 'smtp.gmail.com';
$mail->SMTPAuth = true;
$mail->Username = $username;
$mail->Password = $password;
$mail->SMTPSecure = 'tls';
$mail->Port = 587;

$mail->setFrom($username, $alias);
$mail->addReplyTo($username, $alias);

// Menambahkan penerima
$mail->addAddress($to);

// Menambahkan beberapa penerima
$mail->addAddress($email_assignee);
//$mail->addAddress('penerima3@contoh.com');

// Menambahkan cc atau bcc 
$mail->addCC($emailcc);
//$mail->addBCC('bcc@contoh.com');

// Subjek email
$mail->Subject = $emailsubject;

// Mengatur format email ke HTML
$mail->isHTML(true);

// Konten/isi email
$mailContent=$message;
$mail->Body = $mailContent;

// Menambahakn lampiran
//$mail->addAttachment('lmp/file1.pdf');
//$mail->addAttachment('lmp/file2.png', 'nama-baru-file2.png'); //atur nama baru

// Kirim email
if(!$mail->send()){
	echo 'Mailer Error: ' . $mail->ErrorInfo;
}else{
	echo 'Pesan telah terkirim';
}
?>