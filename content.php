<?php 
require 'core/init.php';
$general->logged_out_protect();
$user = $users->userdata($_SESSION['loginid']);
$ticket1 			= $tickets->get_tickets_by_requester($_SESSION['loginid']);
$tickets_requested 	= count($ticket1);
$ticket2 			= $tickets->get_tickets_by_assignee($_SESSION['loginid']);
$tickets_assigned 	= count($ticket2);
$ticket3 			= $tickets->get_tickets_by_resolver($user['username']);
$tickets_resolved 	= count($ticket3);
?>
<!DOCTYPE HTML>
<html>
<head>
	<title>HC3 Welcome</title>
	<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
	<link rel="stylesheet" type="text/css" href="css/style.css" />
	<style type="text/css">
		body{margin:10px;background-image:url('https://storage.googleapis.com/portalhc-statics-1/images/corner.jpg');background-repeat:no-repeat;background-attachment:fixed;}
	</style>
</head>
<body>
	<div class="breadcrumb"> >> Home</div>
	<hr/>
	<table>
	<tr>
		<td><img src="https://storage.googleapis.com/portalhc-statics-1/images/helpdesk.png" alt="Helpdesk Welcome" width="300px" height="173px" align="top" title="Helpdesk Welcome"></td>
		<td><h1 class="content">Welcome to HC3 System</h1>
		<ul>
		<?php
		echo "<li><p>Currently you have requested: $tickets_requested tickets. </p></li>";
		echo "<li><p>Number of ticket that assigned to you: $tickets_assigned tickets.</p></li> ";
		echo "<li><p>You have resolved $tickets_resolved tickets.</p></li>";
		echo "<li><a href='ticketnew.php' target='blank' <span>New Ticket</span></a></li>";
		?>
		</ol><br/>
		</td>
	</tr>
	</table>
	<h2 class="content">HC3 Breaking News</h2>
	<table id="table-a">
	<thead>
		<tr><th width="100">Post Date</th><th>Headline News</th></tr>
	</thead>
	<tbody>
	<?php 
		$news = $hdnews->get_headline_news();
		foreach ($news as $thenews)
		{	echo '<tr><td>'.date('d-M-Y',$thenews['newsdate']).'</td>'.
				 '<td><a href=hdnewsread.php?id='.$thenews['id']. '>'.$thenews['title'].'</a></td></tr>';
		}
	?>
	</tbody>
	</table>
	<p>&nbsp;</p>
</body>
</html>
