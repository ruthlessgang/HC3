<?php 
require 'core/init.php';
$general->logged_out_protect();
$user = $users->userdata($_SESSION['loginid']);
if($user['level'] == "Admin" || $user['level'] == "Manager")
{$akses=true;}
else 
{$akses=false;}
if ($akses=False)
{exit("You don't have permission to access this page!");}
$ticket_list 		= $tickets->get_tickets();
$tickets_count 	= count($ticket_list);
$currenttime = time();
?>
<!DOCTYPE HTML>
<html>
<head>
	<title>List of Tickets</title>
	<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
	<style type="text/css">
		body{background-image:url('images/corner.jpg');background-repeat:no-repeat;background-attachment:fixed;}
		.breadcrumb{font-size:12px;color:#0000A0;font-family: Arial, Helvetica, sans-serif;}
		table#datatables.display tbody tr:hover{background-color:#6699FF;}
	</style>
  	<link rel="stylesheet" type="text/css" href="css/datatable.css" />
	<link rel="stylesheet" type="text/css" href="css/jquery-ui.css" />
	<script src="js/jquery.js" type="text/javascript"></script>
	<script src="js/jquery.dataTables.js" type="text/javascript"></script>
	<script type="text/javascript" charset="utf-8">
	$(document).ready(function(){
		$('#datatables').dataTable({
			"sScrollY": "400px",
			"sScrollX": "100%",
			"bScrollCollapse": true,
			"bPaginate": false,
			"bJQueryUI": true
		});			
	})
	function delete_confirm(link) {
		var msg = confirm('Are you sure to delete this user?');
		if(msg == false) {
			return false;
		}
	}
	</script>

</head>
<body>
	<div class="breadcrumb"> >> Admin >> List of All Tickets</div>
	<hr/>
	<h1>List of All Tickets</h1>
	<p>Number of tickets: <strong><?php echo $tickets_count; ?></strong> </p>
	<div style="background-color:#ff0000;color:#ffffff;display:inline-block;">&nbsp;Urgency Red = SLA missed of Resolution Goal Time&nbsp;</div><br /> 
	<div style="background-color:#ffff00;display:inline-block;">&nbsp;Urgency Yellow = SLA has reached 75% of Resolution Goal Time&nbsp;</div><br /> 
	<div style="background-color:#00ff00;display:inline-block;">&nbsp;Urgency Green = under SLA Resolution Goal Time&nbsp;</div><br/><br /> 
	<table id="datatables" class="display">
    <thead>
        <tr>
            <th>Ticket No.</th>
			<th>Urgency</th>
			<th>SLA Goal Time</th>
            <th>Customer</th>	
			<th>Category</th>			
            <th>Reported Date</th>
			<th>Documented Date</th>			 
            <th>Problem Summary</th>
			<th>Status</th>
			<th>Assignee</th>		
			<th><img src="images/delete.png" alt="Delete" width="20px" height="20px" align="middle" title="Delete Record"></th>
        </tr>
    </thead>
    <tbody>
		<?php 
		foreach ($ticket_list as $ticket) {
			$sla = $slas->sla_data($ticket['sla']);
			$cat = $cats->cat_data($ticket['cat']);
			$documenteddate=$ticket['documenteddate'];
			$resolutiontime=$sla['resolutiontime'];
			$slawarning=$sla['slawarning'];
			$slagoaltime=strtotime("+$resolutiontime hours",$documenteddate);
			$slawarningtime=strtotime("+$slawarning hours",$documenteddate);
			if ($currenttime > $slagoaltime)
			{$slabgcolor="#FF0000";$slatxtcolor="#ffffff";}
			else if ($currenttime >= $slawarningtime)
			{$slabgcolor="#FFFF00";$slatxtcolor="#000000";}
			else {$slabgcolor="#00FF00";$slatxtcolor="#000000";}
			//$customer = $customers->customer_data($ticket['idcustomer']);
			$user = $users->userdata($ticket['assignee']);
			echo '<tr><td><a href=ticketedit.php?id='.$ticket['id']. '>'.$ticket['ticketnumber'].'</a></td>'.
				 '<td style="background-color:'.$slabgcolor.';color:'.$slatxtcolor.';">'.$sla['namasla'].'</td>'.
				 '<td>'.date('d-M-Y H:i:s',$slagoaltime).'</td>'.
				 '<td>'.$ticket['emp_name'].'</td>'.
				 '<td>'.$cat['namacat'].'</td>'.
				 '<td>'.date('d-M-Y H:i:s',$ticket['reporteddate']).'</td>'.
				 '<td>'.date('d-M-Y H:i:s',$ticket['documenteddate']).'</td>'.
				 '<td>'.$ticket['problemsummary'].'</td>'.
				 '<td>'.$ticket['ticketstatus'].'</td>'.
				 '<td>'.$user['fullname'].'</td>'.
				 
				 '<td><a href=ticketdel.php?id='.$ticket['id']. ' onclick="return delete_confirm();">del</a></td></tr>';
		}
		?>
    </tbody>
	</table>
	<p>&nbsp;</p>
</body>
</html>