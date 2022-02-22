<?php 
require '../core/init.php';
$general->logged_out_protect();
?>
<!DOCTYPE HTML>
<html>
<head>
	<title>Summary Report List</title>
	<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
	<style type="text/css">
		body{background-image:url('../images/corner.jpg');background-repeat:no-repeat;background-attachment:fixed;font:12px arial,sans-serif;}
		.breadcrumb{font-size:12px;color:#0000A0;font-family: Arial, Helvetica, sans-serif;}
		a{text-decoration:none;}
		a:hover{text-decoration:underline;}
	</style>
</head>
<body>
	<div class="breadcrumb"> >> Helpdesk Ststistic >> Summary Report List</div>
	<hr/>
	<h2>Helpdesk Statistic Summary Report List</h2>
	<ol>
		<li><a href="rpt_ticket.php">[Ticket] Ticket Received</li><br/>
		<!--<li><a href="RPT001.php">[RPT001] Ticket Received by Date, Category and Technical Support </a></li><br/>
		<li><a href="RPT002.php">[RPT002] Ticket Received by Date, Category and Customer </li><br/>
		<li><a href="RPT003.php">[RPT003] Ticket Received by Support Team and Period </li><br/>
		<li><a href="RPT004.php">[RPT004] Ticket Summary by Date, Personnel and Status </li><br/>
		<li><a href="RPT005.php">[RPT005] Overdue Ticket Summary by Date, Personnel and Status </li><br/>
		<li><a href="RPT005.php">[RPT006] Unsolved Ticket by Category, Priority and Period </li><br/>
		-->
	</ol>
	<p>&nbsp;</p>
</body>
</html>