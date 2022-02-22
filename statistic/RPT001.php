<?php 
require '../core/init.php';
$general->logged_out_protect();
?>
<!DOCTYPE HTML>
<html>
<head>
	<title>Summary Report</title>
	<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
	<style type="text/css">
		body{background-image:url('../images/corner.jpg');background-repeat:no-repeat;background-attachment:fixed;font:12px arial,sans-serif;}
		.breadcrumb{font-size:12px;color:#0000A0;}
		h1{font-size:14px;color:#000000;}
		#table-a a {text-decoration:none;}
		#table-a a:hover {text-decoration:underline;}
		#table-a
		{   font-family: "Lucida Sans Unicode", "Lucida Grande", Sans-Serif;
			font-size: 12px;
			width: 600px;
			text-align: center;
			border-collapse: collapse;
		}
		#table-a th
		{   font-size: 13px;
			font-weight: normal;
			padding: 8px;
			background: #b9c9fe;
			border-top: 4px solid #aabcfe;
			border-bottom: 1px solid #fff;
			color: #039;
		}
		#table-a td
		{   padding: 8px;
			background: #e8edff;
			border-bottom: 1px solid #fff;
			color: #669;
			border-top: 1px solid transparent;
		}
		#table-a tr:hover td
		{   background: #d0dafd;
			color: #339;
		}
	</style>
</head>
<body>
	<div class="breadcrumb"> >> Helpdesk Ststistic >> Summary Report</div>
	<hr/>
	<h1>[RPT001] Ticket Received by Date, Category and Technical Support</h1>
	<br/>
	<form name='form1' method='POST' action='' target=''>
		Report Period: 
			<select name="period1date">
			<script>
				for (var i=1;i<=31;i++)
				{	document.write("<option value=" + i + ">" + i + "</option>"); }
			</script>
			</select> 
			<select name="period1datemonth">
			<script>
				var bln=["Jan","Feb","Mar","Apr","May","Jun","Jul","Aug","Sep","Oct","Nov","Dec"];
				for (var i=1;i<=12;i++)
				{	document.write("<option value=" + i + ">" + bln[i-1] + "</option>"); }
			</script>
			</select>
			<select name="period1dateyear">
			<script>
				for (var i=2000;i<=2100;i++)
				{	document.write("<option value=" + i + ">" + i + "</option>"); }
			</script>
			</select>
		Until 
			<select name="period2date">
			<script>
				for (var i=1;i<=31;i++)
				{	document.write("<option value=" + i + ">" + i + "</option>"); }
			</script>
			</select> 
			<select name="period2datemonth">
			<script>
				var bln=["Jan","Feb","Mar","Apr","May","Jun","Jul","Aug","Sep","Oct","Nov","Dec"];
				for (var i=1;i<=12;i++)
				{	document.write("<option value=" + i + ">" + bln[i-1] + "</option>"); }
			</script>
			</select>
			<select name="period2dateyear">
			<script>
				for (var i=2000;i<=2100;i++)
				{	document.write("<option value=" + i + ">" + i + "</option>"); }
			</script>
			</select>
	<p><input type='submit' value='Go'></p>
	
	</form>
	<table id="table-a">
		<thead>
		<tr align="center">
			<th width="203" rowspan="2">Technical Support</th>
			<th colspan="3">Product Category</th>
		</tr>
			<tr align="center">
			<th width="58">Data</th>
			<th width="59">Voice</th>
			<th width="59">Data and Voice</th>
		</tr>
		</thead>
		<tbody>
			<?php 
			$news = $hdnews->get_headline_news();
			foreach ($news as $thenews)
			{	echo '<tr><td>Budi</td>'.
					 '<td>3</td>'.
					 '<td>5</td>',
					 '<td>7</td></tr>';
			}
			?>
		</tbody>
	</table>
	
	<p>&nbsp;</p>
</body>
</html>