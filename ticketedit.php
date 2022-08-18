<?php 
require 'core/init.php';
$general->logged_out_protect();
$changeby = $_SESSION['loginid'];
$user 	= $users->userdata($_SESSION['loginid']);
$id		= $_GET['id'];
$ticket	= $tickets->ticket_data($id);
if ($ticket['ticketstatus']=="Closed")
{	header("Location: ticketread.php?id=$id");
	exit();
}
if (isset($_POST['submit']))
{	
	
	$sla 			= $_POST['sla'];
	$cat 			= $_POST['cat'];
	$reporteddate 	= strtotime($_POST['reporteddate']);
	$reportedby		= $_POST['reportedby'];
	$telp 			= $_POST['telp'];
	$email 			= $_POST['email'];
	//$emailcc		= $_POST['email'];
	//$emailbcc		= '';	

	$problemsummary	= $_POST['problemsummary'];
	$problemdetail	= $_POST['problemdetail'];
	$assignee		= $_POST['idassignee'];
	$user_assignee	= $users->userdata($assignee);
	$fullname_assignee = $user_assignee['fullname'];
	$email_assignee		= $user_assignee['email'];
	$email_assignee2	= $user_assignee['email2'];
	$email_assignee3	= $user_assignee['email3'];
	$assigneddate	= strtotime('now');
	$ticketstatus	= $_POST['ticketstatus'];
	$resolution		= $_POST['resolution'];
	$pendingby		= $_POST['pendingby'];
	$pendingdate 	= $_POST['pendingdate'];
	$resolvedby		= $_POST['resolvedby'];
	$resolveddate 	= $_POST['resolveddate'];
	$closedby		= $_POST['closedby'];
	$closeddate		= $_POST['closeddate'];
	$changes		= "Re-assigned the ticket.";
	
	if(!empty($_FILES['iuploadfile']['name'])){     
    $uploadDir = "uploads/";
	$filename = date("ymd").'-'.'HC'.$_FILES['iuploadfile']['name'];
    $iFileName = $_FILES['iuploadfile']['name'];
    $uploadedFile = $uploadDir.$filename;  
	$uploadtime=date("Y-m-d H:i:s");
	$tickets_id=$id;
	$uploads->add_upload($filename,$uploadtime,$tickets_id);
    move_uploaded_file($_FILES['iuploadfile']['tmp_name'],$uploadedFile);
	}
	
	if ($ticketstatus=="Pending")
	{	$pendingby		= $user['username'];
		$pendingdate 	= strtotime('now');
		$changes		= "Change Status to Pending.";
		//ditambahkan untuk kebutuhan email push notification	
		$ticketnumber	= $ticket['ticketnumber'];
		$emp_name		=$ticket['emp_name'];
		$emailsubject= "HC3 Ticket No: $ticketnumber";
		$message	 = "Dear $emp_name, <br/>
						perihal pertanyaan bapak/ibu sudah kami teruskan ke bagian terkait, <br/>
						mohon untuk dapat menunggu konfirmasi dari bagian terkait.<br/><br/>
						
						Link tracking ticket Jaringan KSP --> https://hc3.sahabat-ukm.com:8088/ticketreademp.php?id=$id"." \r\n <br/>	
						Link tracking ticket Jaringan BSS --> https://hc3.banksampoerna.com:8088/ticketreademp.php?id=$id"." \r\n <br/><br/>
						Human Capital Contact Center (HC3)</br>
						Melayani dengan solusi<br/>";
	}
	if ($ticketstatus=="Resolved")
	{	$resolvedby		= $user['username'];
		$resolveddate 	= strtotime('now');
		$changes		= "Change Status to Resolved.";
		//ditambahkan untuk kebutuhan email push notification	
		$ticketnumber	= $ticket['ticketnumber'];
		$emp_name		=$ticket['emp_name'];
		$emailsubject= "HC3 Ticket No: $ticketnumber";
		$message	 = "Dear $emp_name, <br/>
						Terimakasih sebelumnya atas email yang diberikan berikut jawaban dari pertanyaan bapak/ibu:<br/><br/>
						<i>$resolution </i><br/><br/>
						Human Capital Contact Center (HC3)</br>
						Melayani dengan solusi<br/>
						";
	}
	if ($ticketstatus=="Closed")
	{	$closedby		= $user['username'];
		$closeddate		= strtotime('now');
		$changes		= "Change Status to Closed.";
		$ticketnumber	= $ticket['ticketnumber'];
		$emp_name		=$ticket['emp_name'];
		$emailsubject= "HC3 Ticket No: $ticketnumber";
		$message	 = "Dear $emp_name, <br/>
						Terkait case nomor tiket dibawah ini dengan keterangan sebagai berikut: <br/><br/>
						No Ticket : $ticketnumber </br>
						Solusi		: <i>$resolution </i></br>
						Status		: Done.<br/><br/>
						Link tracking ticket Jaringan KSP --> https://hc3.sahabat-ukm.com:8088/ticketreademp.php?id=$id"." \r\n <br/>	
						Link tracking ticket Jaringan BSS --> https://hc3.banksampoerna.com:8088/ticketreademp.php?id=$id"." \r\n <br/><br/>	
						Human Capital Contact Center (HC3)</br>
						Melayani dengan solusi<br/>
						";
	}
		if ($ticketstatus=="Assigned")
	{	$closedby		= $user['username'];
		$closeddate		= strtotime('now');
		$changes		= "Assigned Edit.";
		$ticketnumber	= $ticket['ticketnumber'];
		$emp_name		=$ticket['emp_name'];
		$emailsubject= "HC3 Ticket No: $ticketnumber";
		$message = 
				"Dear $fullname_assignee, \r\n </br>
				You are currently assign for this ticket.\r\n </br>				
				Please follow this link to resolved the ticket KSP Network --> https://hc3.sahabat-ukm.com:8088/ticketedit.php?id=$id"." \r\n </br>
				Please follow this link to resolved the ticket BSS Network --> https://hc3.banksampoerna.com:8088/ticketedit.php?id=$id"." \r\n </br></br>
				No Ticket : $ticketnumber </br>
				Pertanyaan : $problemsummary <br/>
				Solusi		: <i>$resolution </i></br></br>
				Thank you. \r\n
				Regards, \r\n
				Helpdesk";
	}
	
	
	
	
	
	$tickets->update_ticket($id,$sla,$cat,$reporteddate,$reportedby,$telp,$email,$problemsummary,$problemdetail,$ticketstatus,$assignee,$assigneddate,$pendingby, $pendingdate, $resolution,$resolvedby,$resolveddate,$closedby,$closeddate);
	$tickets->log_tickets($id,$sla,$reporteddate,$reportedby,$telp,$email,$problemsummary,$problemdetail,$ticketstatus,$assignee,$assigneddate,$pendingby, $pendingdate, $resolution,$resolvedby,$resolveddate,$closedby,$closeddate,$changes,$changeby);
	if ($user['level'] == "Admin")
	{	header('Location: ticketlist.php');
		include 'email/smtp.php';
	}
	else
	{	header('Location: myticketbyassignee.php');
		include 'email/smtp.php';
	}
}
?>
<!DOCTYPE HTML>
<html>
<head>
	<title>Update Ticket</title>
	<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
	<style type="text/css">
		body{font-size:12px;background-image:url('images/corner.jpg');background-repeat:no-repeat;background-attachment:fixed;font-family: Arial, Helvetica, sans-serif;}
		.breadcrumb{font-size:12px;color:#0000A0;}
		.formtable {text-align:left; font-size:12px;color:#000000; background-color:#f0f0f0;padding:10px;width:600px; }
		.errormsg {font-size:10pt;color:#ff0000;text-align:left;}
	</style>
	<link rel="stylesheet" href="css/jquery-ui.css" />
	<script type="text/javascript" src="js/jquery.js"></script>
	<script src="js/jquery-ui.js"></script>
	<script type="text/javascript"> 
		$(document).ready(function(){
			$("#reporteddate").datepicker
			({dateFormat:"dd-M-yy",changeMonth:true,changeYear:true,});
		});
	</script>
	<script type="text/javascript">
	function cekData()
	{	if (ticketform.idassignee.value == "")
		{	alert("Please choose assign to!");
			ticketform.idassignee.focus();
			return false;
		}
		if (ticketform.problemsummary.value == "")
		{	alert("Problem summary must be filled!");
			ticketform.problemsummary.focus();
			return false;
		}
		if (ticketform.problemdetail.value == "")
		{	alert("Problem detail must be filled!");
			ticketform.problemdetail.focus();
			return false;
		}
		if (ticketform.reportedby.value == "")
		{	alert("Reported By must be filled!");
			ticketform.reportedby.focus();
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
		
		if (ticketform.ticketstatus.value == "Closed")
		{	if(ticketform.oldticketstatus.value != "Resolved")
			{	alert("You must set status to resolved before closed!");
				ticketform.ticketstatus.focus();
				return false;
			}
			
		}
		else
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
</head>
<body>	
	<div class="breadcrumb"> >> Home >> Update Ticket</div>
	<hr/>
	<form name="ticketform" method="post" action="" onsubmit="return cekData();">
	<fieldset style="display: inline-block;">
	<?php echo '<legend> Ticket No: '.$ticket['ticketnumber'].'</legend>'; ?>
	<div class="breadcrumb">*) Field Required</div> 
<!--	<table class="formtable">
		<tr>
			<td width="120"> Customer </td><td> : </td>
			<td> 
			<?php 
				$customer=$customers->customer_data($ticket['idcustomer']);
				echo $customer['namacustomer'];
			?> </td>
		</tr>
		<tr>
			<td> Customer Product</td><td> : </td>
			<td> <?php echo $customer['customerproduct']; ?> </td>
		</tr>
		<tr>
			<td> Warranty Period</td><td> : </td>
			<td> 
			<?php 
				$project=$projects->get_project_customer($customer['idcustomer']);
				echo $project['warrantyperiod'].' Year';
			?> </td>
		</tr>
		<tr>
			<td> Contract Period</td><td> : </td>
			<td>
			<?php
				echo $project['contractperiod'].' Month';
			?>
			</td>
		</tr>
	</table>
	<br/>
-->

	<table class="formtable">
			<tr>
			<td width="120">Employee ID:</td><td> : </td>	
			<td><?php echo $ticket['emp_id']; ?>
			<input type="hidden" size='20' name='emp_id' value="">
			</td>
		</tr>
		<tr>
			<td> Entity:</td><td> : </td>
			<td><?php echo $ticket['entity']; ?>
		</tr>
		<tr>
			<td> Nama Karyawan </td><td> : </td>
			<td> <?php echo $ticket['emp_name']; ?> </td>
		</tr>
		<tr>
			<td>Posisi </td><td> : </td>
			<td> <?php echo $ticket['emp_posisi']; ?> </td>
		</tr>
		<tr>
			<td>Telp Karyawan </td><td> : </td>
			<td> <?php echo $ticket['emp_telp']; ?> </td>
		</tr>
	</table>
	
	<table class="formtable">
		<tr>
			<td width="120">Ticket No:</td><td> : </td>	
			<td><?php echo $ticket['ticketnumber']; ?>
			<input type="hidden" size='20' name='ticketnumber' value="">
			</td>
		</tr>
		<tr>
			<td> Reported Date*</td><td> : </td>
			<td><input type="text" id="reporteddate" name="reporteddate" readonly="readonly" value="<?php echo date('d-M-Y',$ticket['reporteddate']); ?>"></td>
		</tr>
		<tr>
			<td> Reported By* </td><td> : </td>
			<td> <input type='text' size='50' name='reportedby' maxlength="50" value='<?php echo $ticket['reportedby']; ?>'> </td>
		</tr>
		<tr>
			<td> Urgency (SLA)*</td><td> : </td>
			<td><select name="sla">
				<?php 
					$sladata = $slas->sla_data($ticket['sla']);
					echo '<option value="'.$ticket['sla'].'" selected="selected">'.$sladata['namasla'].'</option>';
					$sla = $slas->get_sla();
					foreach ($sla as $slaval) 
					{	echo '<option value="'.$slaval['slaid'].'">'.$slaval['namasla'].'</option>';
					}
				?>
				</select>
			</td>
		</tr>
		<tr>
			<td> Category*</td><td> : </td>
			<td><select name="cat">
				<?php 
					$catdata = $cats->cat_data($ticket['cat']);
					echo '<option value="'.$ticket['cat'].'" selected="selected">'.$catdata['namacat'].'</option>';
					$cat = $cats->get_cat();
					foreach ($cat as $catval) 
					{	echo '<option value="'.$catval['catid'].'">'.$catval['namacat'].'</option>';
					}
				?>
				</select>
			</td>
		</tr>
		<tr>
			<td> Problem Summary* </td><td> : </td>
			<td> <input type="text" size="60" name="problemsummary" maxlength="60" value='<?php echo $ticket['problemsummary']; ?>'> </td>
		</tr>
		<tr valign="top">
			<td> Problem Detail* </td><td> : </td>
			<td> <textarea name="problemdetail" rows="3" cols="38"><?php echo $ticket['problemdetail']; ?></textarea> </td>
		</tr>
		<tr>
			<td> Telephone </td><td> : </td>
			<td> <input type='text' size='20' name='telp' maxlength="20" value='<?php echo $ticket['telp']; ?>'> </td>
		</tr>
		<tr>
			<td> Email </td><td> : </td>
			<td> <input type='text' size='50' name='email' maxlength="50" value='<?php echo $ticket['email']; ?>'> </td>
		</tr>
		<?php
		if (!empty($ticket['file_name'])){
			?>
		<tr>
			<td> Attacment </td><td> : </td>
			
			<td><a href="uploads/<?php echo $ticket['file_name']?>" class="btn btn-primary" target="_blank"><span class="glyphicon glyphicon-download" ></span> Download</a></td>
			<td align="center"><?php echo "<img src='uploads/$ticket[file_name]' width='70' height='70' />";?> <?php echo $ticket['filename']?></td> 
		</tr>
		<?php }?>
	</table>
	<br/>
	<table class="formtable">
		<tr>
			<td width="120"> Assign to* </td><td> : </td>
			<td> <select name="idassignee">
			<?php
				$userassignee = $users->userdata($ticket['assignee']);
				echo '<option value=' . $ticket['assignee']. ' selected="selected">'. $userassignee['fullname'] . '</option>';
				$listusers = $users->get_users_assign();
				foreach ($listusers as $user)
				{	
					echo '<option value=' . $user['id'] . '>' .  $user['fullname'] . '</option>';
				}
			?>
			</select> </td>
		</tr>
		<tr>
			<td> Status* </td><td> : </td>
			<td> <input type="hidden" name="oldticketstatus" value="<?php echo $ticket['ticketstatus']; ?>"> 
			<select name="ticketstatus">
				<?php
					echo '<option value=' . $ticket['ticketstatus']. ' selected="selected">'.  $ticket['ticketstatus'] . '</option>';
				?>
				<option value="Assigned"> Assigned </option>
				<option value="Resolved"> Resolved </option>
				<option value="Pending"> Pending </option>
				<option value="Closed"> Closed </option>
			</select> 
			</td>
		</tr>
		<tr valign="top">
			<td> Resolution* </td><td> : </td>
			<td> <textarea name="resolution" rows="3" cols="38"><?php echo $ticket['resolution']; ?></textarea> </td>
		</tr>
		<tr>
			<td> </td><td> </td>
			<td> <input type="hidden" name="pendingby" value="<?php echo $ticket['pendingby']; ?>"> 
				 <input type="hidden" name="pendingdate" value="<?php echo $ticket['pendingdate']; ?>"> 
				 <input type="hidden" name="resolvedby" value="<?php echo $ticket['resolvedby']; ?>"> 
				 <input type="hidden" name="resolveddate" value="<?php echo $ticket['resolveddate']; ?>"> 
				 <input type="hidden" name="closedby" value="<?php echo $ticket['closedby']; ?>"> 
				 <input type="hidden" name="closeddate" value="<?php echo $ticket['closeddate']; ?>"> 
			</td>
		</tr>

		<tr>
		</tr>
		<tr>
			<td> </td> <td> </td>
			<td> 
				<div id="formsubmitbutton">
				<input type='submit' name='submit' value=' Submit '>  &nbsp;&nbsp;&nbsp;
				</div>
				<!-- <input type='reset' name='reset' value=' Reset '>  -->
				<div id="buttonreplacement" style="margin-left:30px; display:none;" >
				<img src="images/loading2.gif" alt="loading..." height="100px" width="100px">
				<p>Mohon menunggu untuk proses ticket dan notifikasi Email</p>
				</div>	
			</td>
		</tr>
	</table>
	</fieldset>
	</form>
	<br/>
	<fieldset style="display: inline-block;">
	<legend> Ticket Audit Trail</legend>
	<table class="formtable">
	<tr bgcolor="#e0e0e0" ><td width="150">Updated On</td><td width="150">Updated By</td><td>Description</td></tr>
	<?php
		$list_log_tickets = $tickets->get_audit_trail($id);
		foreach ($list_log_tickets as $log_ticket)
		{	$changed_by = $users->userdata($log_ticket['changeby']);
			echo '<tr><td>'.date('d-M-Y H:i:s',$log_ticket['changedate']).'</td>'.
				 '<td>'.$changed_by['fullname'].'</td>'.
				 '<td>'.$log_ticket['changes'].'</td></tr>';
		}
	?>
	</table>
	</fieldset>
	<br/><br/>
</body>
</html>