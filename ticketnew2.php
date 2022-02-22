<?php 
date_default_timezone_set('Asia/Jakarta');
require 'core/init.php';
$general->logged_out_protect();
$changeby = $_SESSION['loginid'];
$documentedby = $_SESSION['loginid'];
if (isset($_POST['submit']))
{	$lastticket 	= $tickets->get_last_ticket();
	$id				= $lastticket['id'] + 1;
	$ticketnumber 	= $id . '/SR/'.date("M").'/'.date("Y"); //format nomor tiket
	$sla 			= $_POST['sla'];
	$emp_id			= $_POST['emp_id'];
	$emp_name		= $_POST['emp_name'];
	$reportedby		= $_POST['reportedby'];
	$reporteddate 	= strtotime($_POST['reporteddate']);
	$telp 			= $_POST['telp'];
	$email 			= $_POST['email'];
	$problemsummary	= $_POST['problemsummary'];
	$problemdetail	= $_POST['problemdetail'];
	$ticketstatus	= 'Assigned'; //ketika pertama kali dibuat, status="Assigned" ke salah satu teknisi
	$assignee		= $_POST['idassignee'];
	$user_assignee	= $users->userdata($assignee);
	$email_assignee = $user_assignee['email'];
	$changes		= 'Create New Ticket';
	$emailcc		= '';
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
	$emailsubject = "Ticket No: $ticketnumber has assigned to you";
	$message = 
"Dear $fullname_assignee, \r\n
You are currently assign for this ticket.\r\n
Please follow this link to resolved the ticket --> http://localhost/helpdesk/ticketedit.php?id=$id"." \r\n
Thank you. \r\n
Regards, \r\n
Helpdesk";
	$tickets->add_ticket($ticketnumber,$sla,$emp_id,$emp_name,$reportedby,$reporteddate,$email,$problemsummary,$telp,$problemdetail,$ticketstatus,$assignee,$documentedby);
	$assigneddate='';$pendingby='';$pendingdate='';$resolution='';$resolvedby='';$resolveddate='';$closedby='';$closeddate='';
	$tickets->log_tickets($id,$sla,$reporteddate,$reportedby,$telp,$email,$problemsummary,$problemdetail,$ticketstatus,$assignee,$assigneddate,$pendingby, $pendingdate, $resolution,$resolvedby,$resolveddate,$closedby,$closeddate,$changes,$changeby);
	$emails->add_email($id,$senddate,$email_assignee,$emailcc,$emailbcc,$emailsubject,$message,$emailstatus);
	$emails->add_sla_remainder($id,$ticketnumber,$slasenddate,$email_assignee,$emailcc,$emailbcc,$emailsubject,$message);
	$result=$emails->send_new_ticket();
	//echo $result;
	header("Location: ticketread.php?id=$id");
	//echo $senddate."<br>".$resolutiontime."<br>".$slasenddate;
}
?>
<!DOCTYPE HTML>
<html>
<head>
	<title>New Ticket</title>
	<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
	<style type="text/css">
		body{font-size:12px;background-image:url('images/corner.jpg');background-repeat:no-repeat;background-attachment:fixed;font-family: Arial, Helvetica, sans-serif;}
		.breadcrumb{font-size:12px;color:#0000A0;}
		.formtable {text-align:left; font-size:12px;color:#000000; background-color:#f0f0f0;padding:10px;width:600px; }
		.errormsg {font-size:10pt;color:#ff0000;text-align:left;}
		button.ui-button-icon-only{margin-left:0.5em;}
	</style>
	<link rel="stylesheet" href="css/jquery-ui.css" />
	<script type="text/javascript" src="js/jquery.js"></script>
	<script src="js/jquery-ui.js"></script>
	<script type="text/javascript"> 
	
		$(document).ready(function(){
			$("#reporteddate").datepicker
			({dateFormat:"dd-M-yy",changeMonth:true,changeYear:true,showOn:'button',
			buttonImage:"images/calendar2.gif",buttonImageOnly:true})
			//.next('button').text('.').button({icons:{primary:'ui-icon-calendar'},text:false});
		});
		
	</script>
	
	<script type="text/javascript">
	function cekData()
	{	if (ticketform.empid.value == "")
		{	alert("Please choose the Employee ID/NIK!");
			ticketform.empid.focus();
			return false;
		}
		if (ticketform.category.value == "")
		{	alert("Input Category Case!");
			ticketform.category.focus();
			return false;
		}
		if (ticketform.subcategory.value == "")
		{	alert("Input Sub Category Case!");
			ticketform.subcategory.focus();
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
		else
			return true;   
	}
	</script>
	
<link rel="stylesheet" href="css/colorbox.css" />
 <script src="js/jquery.min.js"></script>
		<script src="js/jquery.colorbox.js"></script>
		<script>
			$(document).ready(function(){
				//Examples of how to assign the ColorBox event to elements

				$(".ajax").colorbox({width:'650px',height:'450px'});
 
				
			});
		</script>
		


<!-- new -->
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
	<form name="ticketform" method="post" action="" onsubmit="return cekData();">
	<fieldset style="display: inline-block;">

	</table><br/>
	
	<table class="formtable">
	
		<!--<tr>
			<td> No Urut* </td><td> : </td>
			<td> <input type='text' id="no_int" size='8' name='no_int' maxlength="8"> 
			<a href="daftar_pegawai.php" class="ajax" onClick="my_variable[0]='no_int,emp_id,emp_name,entity,posisi'">
			<img src="images/button_search.png" border="0" /></a></td>
			
		</tr>
		-->
		<tr>
			<td> Employee ID </td><td> : </td>
			<td> <input type='text' id="emp_id" size='8' name='emp_id' maxlength="8" readonly>
			<a href="daftar_pegawai.php" class="ajax" onClick="my_variable[0]='no_int,emp_id,emp_name,entity,posisi,telp'">
			<img src="images/button_search.png" border="0" /></a></td>
			
		</tr>
		<tr>
			<td> Entity </td><td> : </td>
			<td> <input type='text' id="entity" size='20' name='entity' maxlength="20" readonly> </td>
		</tr>
		<tr>
			<td> Employee Name </td><td> : </td>
			<td> <input type='text' id="emp_name" size='30' name='emp_name' maxlength="30" readonly> </td>
		</tr>
		<tr>
			<td> Posisi </td><td> : </td>
			<td> <input type='text' id="posisi" size='60' name='posisi' maxlength="60" readonly> </td>
		</tr>
		<tr>
			<td> Telp </td><td> : </td>
			<td> <input type='text' id="telp" size='10' name='telp' maxlength="10" readonly> </td>
		</tr>

 <!-- semua element anchor dengan class="thickbox" akan otomatis menampilkan dialog thickbox, 
 	  isi href bisa dimasukan setting thickbox berupa width dan height dari dialog thickbox -->
 
 
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
			<td><input type="text" id="reporteddate" name="reporteddate" maxlength="11" value="<?php echo date('d-M-Y',time()); ?>"> </td>
		</tr>
	
		<tr>
			<td> Reported By* </td><td> : </td>
			<td> <input type='text' size='50' name='reportedby' maxlength="50"> </td>
		</tr>
		
	<!--		<tr>
			<td>Case Category*</td><td> : </td>
			<td><select name="cat">
				<?php 
					$cat = $cat->get_cat();
					echo '<option value="'.$catval['catid'].'" selected="selected">'.$catval['cat'].'</option>';
					foreach ($sla as $slaval) 
					{	echo '<option value="'.$catval['catid'].'">'.$catval['cat'].'</option>';
					}
				?>
				</select>
			</td>
		</tr>
	-->	<tr>
			<td> Category*</td><td> : </td>
			<td> <input type="text" size="8" name="category" maxlength="8"> </td>
		</tr>
		<tr>
			<td> Sub Category* </td><td> : </td>
			<td> <input type="text" size="10" name="subcategory" maxlength="10"> </td>
		</tr>
		<tr>
			<td> Problem Summary* </td><td> : </td>
			<td> <input type="text" size="50" name="problemsummary" maxlength="60"> </td>
		</tr>
		<tr>
		<tr>
			<td> Quetion* </td><td> : </td>
			<td> <textarea name="problemdetail" rows="4" cols="50"></textarea> </td>
		</tr>
		<tr>
			<td> Urgency (SLA)*</td><td> : </td>
			<td><select name="sla">
				<?php 
					$sla = $slas->get_sla();
					echo '<option value="'.$slaval['slaid'].'" selected="selected">'.$slaval['namasla'].'</option>';
					foreach ($sla as $slaval) 
					{	echo '<option value="'.$slaval['slaid'].'">'.$slaval['namasla'].'</option>';
					}
				?>
				</select>
			</td>
		</tr>
		<tr>
			<td> Assign to* </td><td> : </td>
			<td> <select name="idassignee">
				<option> </option>
			<?php
				$Asignees = $users->get_users();
				foreach ($Asignees as $user)
				{	
					echo '<option value=' . $user['id'] . '>' .  $user['fullname'] . '</option>';
				}
			?>
			</select> </td>
		</tr>
<!--		
		<tr>
			<td> Telephone </td><td> : </td>
			<td> <input type='text' size='20' name='telp' maxlength="20"> </td>
	-->	</tr>
		<tr>
			<td> Email </td><td> : </td>
			<td> <input type='email' size='50' name='email' maxlength="50"> </td>
		</tr>

		<tr>
			<td> </td>
			<td> </td>
			<td> <br/>
				<input type='submit' name='submit' value=' Submit '>  &nbsp;&nbsp;&nbsp;
				<input type='reset' name='reset' value=' Reset '> 
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
</body>
</html>