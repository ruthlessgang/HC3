<?php
require '../core/init.php';
$general->logged_out_protect();
//$user = $users->userdata($_SESSION['id']);
//if($user['level'] != "Admin")
//{ 	exit("You don't have permission to access this page!"); }
$tickets 		= $tickets->get_tickets();
$json='[';
foreach ($tickets as $ticket) 
{	$customer=$customers->customer_data($ticket['idcustomer']);	
	$userassignee = $users->userdata($ticket['assignee']);
	$catdata = $cats->cat_data($ticket['cat']);
	$json.='{"Category": "'. $catdata['namacat'] . '",'.
	'"Company": "'.$customer['namacustomer']. '",'.
	'"Assignee": "'.$userassignee['fullname']. '",'.
	'"Status": "'.$ticket['ticketstatus']. '"},';
}
echo substr($json, 0, -1).']';

