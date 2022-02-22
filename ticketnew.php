<?php 
date_default_timezone_set('Asia/Jakarta');
require 'core/init.php';
/*$general->logged_out_protect();
$changeby = $_SESSION['loginid'];
$documentedby = $_SESSION['loginid'];
*/
$changeby = 27;
$documentedby =27;

if (isset($_POST['submit']))
{	$lastticket 	= $tickets->get_last_ticket();
	$id				= $lastticket['id'] + 1;
	$ticketnumber 	= $id . '/HC3/'.date("M").'/'.date("Y"); //format nomor tiket
	//$sla 			= $_POST['sla'];
	$sla 			= 4;// 4 is low
	$cat 			= $_POST['cat'];
	$emp_id			= $_POST['emp_id'];
	$emp_name		= $_POST['emp_name'];
	$idcustomer		= $_POST['idcustomer'];
	$entity			= $_POST['entity'];
	$emp_posisi		= $_POST['emp_posisi'];
	//$emp_telp		= $_POST['emp_telp'];
	$emp_telp		= '';
	$reporteddate 	= strtotime($_POST['reporteddate']);
	//$reportedby		= $_POST['reportedby'];
	$reportedby		= $emp_name;
	$telp 			= $_POST['telp'];
	$email 			= $_POST['email'];
	$problemsummary	= $_POST['problemsummary'];
	$problemdetail	= $_POST['problemdetail'];
	$ticketstatus	= 'Open'; //ketika pertama kali dibuat, status="Assigned" ke salah satu teknisi
	$assignee		= $_POST['idassignee'];
	$user_assignee	= $users->userdata($assignee);
	$email_assignee = $user_assignee['email'];
	$changes		= 'Create New Ticket';
	$emailcc		= $_POST['email'];
	$emailbcc		= '';
	$fullname_assignee = $user_assignee['fullname'];
	if($sla == '1')
	{	$managers = $users->get_user_by_level("Manager");
		$i=0;
		foreach ($managers as $manager)
		{	$manageremail[$i] = $manager['email'];
			$emailcc .= $manageremail[$i] . ', ';		
			$i++;
		}
	}
	$emailstatus='New';
	$senddate = time();
	$datasla=$slas->sla_data($sla);
	$resolutiontime=$datasla['resolutiontime'];
	$slasenddate=strtotime("+$resolutiontime hours",$senddate);
	//ditambahkan untuk kebutuhan email baru push notification	
	$emailsubject= "HC3 Ticket No: $ticketnumber";
	$message	 = "Dear $emp_name, <br/><br/>
					Terimakasih sebelumnya atas pertanyaan yang diberikan,<br/>
					No Tiket : $ticketnumber <br/>
					Nama 	: $emp_name <br/>
					NIK 	: $emp_id <br/>
					Pertanyaan : $problemsummary <br/>
					Detail : $problemdetail <br/><br/>								
					Mohon untuk dapat menunggu konfirmasi selanjutnya.<br/><br/><br/>
					Link tracking ticket --> http://10.9.71.12:5212/ticketreademp.php?id=$id"." \r\n <br/><br/>						
					Human Capital Contact Center (HC3)</br>
					Melayani dengan solusi<br/>";
	/*$emailsubject = "Ticket No: $ticketnumber has assigned to you";
	$message = 
				"Dear $fullname_assignee, \r\n
				You are currently assign for this ticket.\r\n
				Please follow this link to resolved the ticket --> http://localhost/helpdesk/ticketedit.php?id=$id"." \r\n
				Thank you. \r\n
				Regards, \r\n
				Helpdesk";
	*/
	
	include 'email/smtp.php';	
	$tickets->add_ticket($ticketnumber,$sla,$emp_id,$cat,$idcustomer,$entity,$emp_name,$emp_posisi,$emp_telp,$reportedby,$reporteddate,$telp,$email,$problemsummary,$problemdetail,$ticketstatus,$assignee,$documentedby);
	$assigneddate='';$pendingby='';$pendingdate='';$resolution='';$resolvedby='';$resolveddate='';$closedby='';$closeddate='';
	$tickets->log_tickets($id,$sla,$reporteddate,$reportedby,$telp,$email,$problemsummary,$problemdetail,$ticketstatus,$assignee,$assigneddate,$pendingby, $pendingdate, $resolution,$resolvedby,$resolveddate,$closedby,$closeddate,$changes,$changeby);
	$emails->add_email($id,$senddate,$email_assignee,$emailcc,$emailbcc,$emailsubject,$message,$emailstatus);
	$emails->add_sla_remainder($id,$ticketnumber,$slasenddate,$email_assignee,$emailcc,$emailbcc,$emailsubject,$message);
	//include 'email/smtp_adm.php';
	//$result=$emails->send_new_ticket();	
	//echo $result;
	//header ("Location: ticketread.php?id=$id");	
	header ("Location: ticketreademp.php?id=$id");
	echo $senddate."<br>".$resolutiontime."<br>".$slasenddate;
}

?>

<!DOCTYPE HTML>
<html>
<head>	
	<title>New Ticket</title>	
	<link rel="icon" href="images/hc3favicon.ico" type="image/x-icon">
	<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
	<style type="text/css">
		body{font-size:12px;background-image:url('images/corner.jpg');background-repeat:no-repeat;background-attachment:fixed;font-family: Arial, Helvetica, sans-serif;}
		.breadcrumb{font-size:12px;color:#0000A0;}
		.formtable {text-align:left; font-size:12px;color:#000000; background-color:#f0f0f0;padding:10px;width:600px; }
		.errormsg {font-size:10pt;color:#ff0000;text-align:left;}
		button.ui-button-icon-only{margin-left:0.5em;}	
</style>


<script type="text/javascript">
function cekData()
	{	
		if (ticketform.emp_id.value == "")
		{	alert("Pilih NIK karyawan");
			ticketform.emp_id.focus();
			return false;
		}
		if (ticketform.cat.value == "")
		{	alert("Silahkan pilih kategori!");
			ticketform.cat.focus();
			return false;
		}
		if (ticketform.problemsummary.value == "")
		{	alert("Isi problem summary");
			ticketform.problemsummary.focus();
			return false;
		}
		if (ticketform.problemdetail.value == "")
		{	alert("Lengkapi problem detail");
			ticketform.problemdetail.focus();
			return false;
		}		
		if (ticketform.email.value == "")
		{	alert("Isi Email untuk notifikasi");
			ticketform.email.focus();
			return false;
		}
		var filter = new RegExp(
			"^[_A-Za-z0-9-\\+]+(\\.[_A-Za-z0-9-]+)*@" +
			"[A-Za-z0-9-]+(\\.[A-Za-z0-9]+)*(\\.[A-Za-z]{2,})$");
		if (!filter.test(ticketform.email.value) && ticketform.email.value != "")
		{	alert("Please enter a valid email address!");
			ticketform.email.focus();
			return false;
		}	   
		else //untuk loading button
			{
		   document.getElementById("formsubmitbutton").style.display = "none"; // to undisplay
		   document.getElementById("buttonreplacement").style.display = ""; // to display
		   return true;
		}
		var FirstLoading = true;
		function RestoreSubmitButton()
		{
		   if( FirstLoading )
		   {
			  FirstLoading = false;
			  return;
		   }
		   document.getElementById("formsubmitbutton").style.display = ""; // to display
		   document.getElementById("buttonreplacement").style.display = "none"; // to undisplay
		}
		// To disable restoring submit button, disable or delete next line.
		document.onfocus = RestoreSubmitButton;
		return true;
	}
	</script>

	

<!-- Untuk poopup Lookup -->	
<link rel="stylesheet" href="css/colorbox.css" />
 <script src="js/jquery.min.js"></script>
		<script src="js/jquery.colorbox.js"></script>
		<script>
			$(document).ready(function(){
				//Examples of how to assign the ColorBox event to elements
				$(".ajax").colorbox({width:'650px',height:'450px'});
				
			});
		</script>

<!-- untuk Close Saat Di klik hasil lookup -->
	<script type="text/javascript">
		var my_variable = new Array(); // for example		
		function passingToParent(){		
			arrayOfStrings = my_variable[0].split(',');			
			for (var i=1; i < my_variable.length; i++) {
				$('#' + arrayOfStrings[i-1]).val(my_variable[i]);
			}
			// single form
			//parent.$.fn.colorbox.close();
			// framework form
			jQuery.colorbox.close();;
		}
	</script>


</head>

<body>	

	<div class="breadcrumb"> >> Home >> New Ticket</div>
	<hr/>
	<!-- <form name="ticketform" method="post"  onsubmit="return cekData();"> -->
	<form name="ticketform" method="post"  onsubmit="return cekData();">
	<fieldset style="display: inline-block;">
	<legend> New Ticket </legend>
	<div class="breadcrumb">*) Field Required</div>		
	
	<table class="formtable">
		<tr>
			<td> Employee ID </td><td> : </td>
			<td> <input type='text' id="emp_id" size='8' name='emp_id' maxlength="8" readonly>
			<a href="daftar_pegawai.php" class="ajax" onClick="my_variable[0]='no_int,emp_id,emp_name,idcustomer,entity,emp_posisi,emp_telp'">
			<img src="images/button_search.png" border="0" /></a></td>			
		</tr>		
	<!--	<tr>
			<td>Entity Name </td><td> : </td> -->
			<td> <input type='hidden' id="idcustomer" size='2' name='idcustomer' maxlength="20" readonly>  <input type='hidden' id="entity" size='20' name='entity' maxlength="20" readonly> </td>
	<!--	</tr> -->
		<tr>
		<td> Employee Name </td><td> : </td>
			<td> <input type='text' id="emp_name" size='30' name='emp_name' maxlength="30" readonly> </td>
		</tr>
		<tr>
			<td> Posisi </td><td> : </td>
			<td> <input type='text' id="emp_posisi" size='60' name='emp_posisi' maxlength="60" readonly> </td>
		</tr>
		<tr>
			<td> Email* </td><td> : </td>
			<td> <input type='email' size='40' name='email' maxlength="40" required</td>
		</tr>
		<tr>
			<td> Telp / Ext </td><td> : </td>
			<td> <input type='text' size='20' name='telp'  maxlength="20"> </td>
		</tr>
  <small id="divAlertPegawai"></small>
	</table><br/>
	<table class="formtable">
		<tr>
			<td>Ticket No:</td><td> : </td>	
			<td>New Ticket Number
			<input type="hidden" size='20' name='ticketnumber' value="">
			</td>
		</tr>
		<tr>
			<td> Reported Date*</td><td> : </td>
			<td><input type="text" id="reporteddate" name="reporteddate" readonly value="<?php echo date('d-M-Y',time()); ?>"> </td>
		</tr>
		<tr>
			<td> Kategori to* </td><td> : </td>
			<td> <select name="cat">
				<option> </option>
			<?php
				$cat = $cats->get_cat();
				foreach ($cat as $catval) 
				{	
					echo '<option value="'.$catval['catid'].'">'.$catval['namacat'].'</option>';
				}
			?>
			</select> </td>
		</tr>
		
		<tr>
			<td> Problem Summary* </td><td> : </td>
			<td> <input type="text" size="50" name="problemsummary" maxlength="60"> </td>
		</tr>
		<tr>
			<td> Problem Detail* </td><td> : </td>
			<td> <textarea name="problemdetail" rows="3" cols="38"></textarea> </td>
		</tr>
		
		<!--
		<tr>
			<td> Assign to* </td><td> : </td>
			<td> <select name="idassignee" >
				<option value='25'>HC3</option>
			</select> </td>
		</tr>
		-->
		<input type='hidden' name='idassignee' value='25'>
		
		<tr>
			<td> </td>
			<td> </td>
			<td> <br/>
			<div id="formsubmitbutton">
			<input type='submit' name='submit' value=' Submit ' >  &nbsp;&nbsp;&nbsp;			
			</div>			
			<div id="buttonreplacement" style="margin-left:30px; display:none;" >
			<img src="images/loading2.gif" alt="loading..." height="100px" width="100px">
			<p>Mohon menunggu untuk create ticket dan notifikasi Email</p>
			</div>	
			
			</td>
		</tr>
	</table>
	</fieldset>
	</form>
	
	<?php 
	if(empty($errors) === false){
		echo '<p class=errormsg>' . implode('</p><p class=errormsg>', $errors) . '</p>';
	}
	?>

		

<!-- Live Chat Widget powered by https://keyreply.com/chat/ -->
<!-- Advanced options: -->
<!-- data-align="left" -->
<!-- data-overlay="true" -->
<!-- <script data-align="left" data-overlay="false" id="keyreply-script" src="//keyreply.com/chat/widget.js" data-color="#E4392B" data-apps="JTdCJTIyd2hhdHNhcHAlMjI6JTIyKzYyODE1MTkxMDA5MDglMjIlN0Q="></script>
-->
</body>
<?php
include "footer.php";
?>
</html>