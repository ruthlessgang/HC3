
    <?php
    require '../core/init.php';
	// koneksi ke database ada pada file conn.php
    header("Content-Type: application/force-download");
    header("Cache-Control: no-cache, must-revalidate");
 	$date=date('d-m-Y');
    header("content-disposition: attachment;filename=Data_All_ticket.$date.xls");
	$general->logged_out_protect();
	$user = $users->userdata($_SESSION['loginid']);
	$tickets 		= $tickets->get_tickets($_SESSION['loginid']);
	$tickets_count 	= count($tickets);
    ?>


    <center><h2>Rekap All Ticket<h2></center>
    <table border='1'>
    <h3>
    <thead><tr>
    <td align=center width=150>No Tickets.</td>
    <td align=center width=150>Employee NIK</td>
    <td align=center width=200>Nama</td>
	<td align=center width=200>Report For</td>
    <td align=center width=300>Entitas</td>
	<td align=center width=100>Report Date</td>
	<td align=center width=150>Category</td>
    <td align=center width=200>Problem Summary</td>
    <td align=center width=500>Question</td>
	<td align=center width=150>Ticket Status</td>
	<td align=center width=150>Assignee</td>
	<td align=center width=100>Assignee Date</td>
	<td align=center width=150>Pending By</td>
	<td align=center width=100>Pending Date</td>
    <td align=center width=250>Resolved</td>
    <td align=center width=150>Resolved By</td>
	<td align=center width=100>Resolved date</td>
	<td align=center width=250>Closed By</td>
	<td align=center width=100>Closed Date</td>
	<td align=center width=150>SLA</td>
	<td align=center width=150>User</td>
	
		 
     </tr></thead>
    <h6><tbody>

 
   <?php 
		foreach ($tickets as $ticket) {
			$sla = $slas->sla_data($ticket['sla']);
			$cat = $cats->cat_data($ticket['cat']);
			$customer = $customers->customer_data($ticket['idcustomer']);
			$user = $users->userdata($ticket['assignee']);
			$user2 = $users->userdata($ticket['documentedby']);
			
			
			echo '<td>'.$ticket['ticketnumber'].'</td>'.					 
				  '<td>'.$ticket['emp_id'].'</td>'.
				  '<td>'.$ticket['emp_name'].'</td>'.
				  '<td>'.$ticket['reportedby'].'</td>'.
				  '<td>'.$ticket['entity'].'</td>'.
				  '<td>'.date('d-M-Y',$ticket['reporteddate']).'</td>'.
				  '<td>'.$cat['namacat'].'</td>'.
				  '<td>'.$ticket['problemsummary'].'</td>'.
				  '<td>'.$ticket['problemdetail'].'</td>'.
				  '<td>'.$ticket['ticketstatus'].'</td>'.				  
				  '<td>'.$user['fullname'].'</td>'.
				  '<td>'.date('d-M-Y',$ticket['assigneddate']).'</td>'.
				  '<td>'.$ticket['pendingby'].'</td>'.
				  '<td>'.date('d-M-Y',$ticket['pendingdate']).'</td>'.
				  '<td>'.$ticket['resolution'].'</td>'.
				  '<td>'.$ticket['resolvedby'].'</td>'.
				  '<td>'.date('d-M-Y',$ticket['resolveddate']).'</td>'.
				  '<td>'.$ticket['closedby'].'</td>'.
				  '<td>'.date('d-M-Y',$ticket['closeddate']).'</td>'.
				  '<td>'.$sla['namasla'].'</td>'.
				 '<td>'.$user2['fullname'].'</td></tr>';
				 
		}
		?>
		
    </tbody></h6></table>
