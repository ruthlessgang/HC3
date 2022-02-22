<?php 
require 'core/init.php';
$general->logged_out_protect();
@$idemail=$_GET['id'];
$email 	= $emails->get_email_queue_by_id($idemail);
if (isset($_POST['submit']))
{	$emailstatus = $_POST['emailstatus'];
	if($emailstatus=="Sent")
	{	$errors[] = 'You have sent this email!';
	}else
	{	$to 	 = $_POST['emailto'];
		$cc 	 = substr($_POST['emailcc'], 0, -2);
		$subject = $_POST['emailsubject'];
		$message = $_POST['message'];
		
		//cript dari sini yang dirubah mulato menjadi phpmailer
		require "email/engine_phpmailer.php";
		
		//script dibawah ini ganti karena script tersebut menggunakan x-mailer windows
		/*
		$headers   = array();
		$headers[] = "MIME-Version: 1.0";
		$headers[] = "Content-type: text/plain; charset=iso-8859-1";
		$headers[] = "From: Helpdesk System <mulatopluto@yahoo.com>";
		$headers[] = "Cc: $cc";
		$headers[] = "Bcc:";
		$headers[] = "Reply-To: Helpdesk System <mulatopluto@yahoo.com>";
		$headers[] = "X-Mailer: PHP/".phpversion();
		//echo $to."<br>".$cc."<br>".$subject."<br>".$message;
		//echo $emailstatus;
		
		$ok = mail($to, $subject, $message, implode("\r\n", $headers));
		if ($ok)
		{	$emails->update_status_email($idemail,"Sent");
			header('Location: emailsend.php?success');
		} else {
			$emails->update_status_email($idemail,"Cannot Send");
			$errors[] = 'Sorry, email cannot send now! Please try again.';
		}
		*/
	}
}
?>
<!DOCTYPE HTML>
<html>
<head>
	<title>Send Email Queue</title>
	<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
	<style type="text/css">
		body{background-image:url('images/corner.jpg');background-repeat:no-repeat;background-attachment:fixed;font-family: Arial, Helvetica, sans-serif;}
		.breadcrumb{font-size:12px;color:#0000A0;}
		.formtable {font-size:12px;color:#000000; background-color:#f0f0f0;padding:10px;width:500px;}
		.errormsg {font-size:10pt;color:#ff0000;text-align:left;}
	</style>
</head>
<body>	
	<div class="breadcrumb"> >> Admin >> System >> Email Queue >> Send Email Queue</div>
	<hr/>
	<form method="post" action="">
	<fieldset style="display: inline-block;">
	<legend> Send Email Queue </legend>
	<table class="formtable">
		<tr align="left">
			<td> To </td><td> : </td>
			<td> <input type='hidden' name='emailto' value='<?php echo $email['emailto']; ?>'/><?php echo $email['emailto']; ?></td>
		</tr>
		<tr align="left">
			<td> CC </td><td> : </td>
			<td> <input type='hidden' name='emailcc' value='<?php echo $email['emailcc']; ?>'/><?php echo $email['emailcc']; ?></td>
		</tr>
		<tr align="left">
			<td> Subject </td><td> : </td>
			<td> <input type='hidden' name='emailsubject' value='<?php echo $email['emailsubject']; ?>'/><?php echo $email['emailsubject']; ?></td>
		</tr>
		<tr align="left">
			<td> Message </td><td> : </td>
				<td> <textarea rows="10" cols="50" disabled><?php echo $email['message']; ?></textarea>
					 <textarea style="display:none;" name="message" rows="10" cols="50"><?php echo $email['message']; ?></textarea>				</td>
		</tr>
		<tr align="left">
			<td> </td>
			<td> </td>
			<td> 
				<input type='hidden' name='emailstatus' value='<?php echo $email['emailstatus']; ?>'/>
				<input type='submit' name='submit' value=' Send Now '> 
			</td>
		</tr>
	</table>
	</fieldset>
	</form>
	<?php 
	if(empty($errors) === false){
		echo '<p class=errormsg>' . implode('</p><p class=errormsg>', $errors) . '</p>';
	}
	if (isset($_GET['success']) && empty($_GET['success'])) {
		echo 'Email has been sent!';
	}
	?>
</body>
</html>