<?php 
require '../core/init.php';
$general->logged_out_protect();
?>
<!DOCTYPE html>
<html>
<head>
<title>Helpdesk Pivot</title>
<style type="text/css">
	body{background-image:url('../images/corner.jpg');background-repeat:no-repeat;background-attachment:fixed;font:12px arial,sans-serif;}
	.breadcrumb{font-size:12px;color:#0000A0;font-family: Arial, Helvetica, sans-serif;}
</style>
<link rel="stylesheet" type="text/css" href="pivot.css">
<script type="text/javascript" src="jquery-1.8.3.min.js"></script>
<script type="text/javascript" src="jquery-ui-1.9.2.custom.min.js"></script>
<script type="text/javascript" src="pivot.js"></script>
</head>
</style>
<body >
	<div class="breadcrumb"> >> Helpdesk Statistic >> Pivot Table</div>
	<hr />
	<h2>Helpdesk Statistic Pivot Table</h2>
    <div id="output" style="margin: 10px;"></div>
	
    <script type="text/javascript">
        $(function(){
            var derivers = $.pivotUtilities.derivers;
            $.getJSON("json.php", function(mps) {
                $("#output").pivotUI(mps, {
                    derivedAttributes: {
                       // "Warranty Period": derivers.bin("Warranty", 10)
                    },
                    rows: ["Company"],
                    cols: ["Status"],
                    //effectsName: "None"
                });
            });
         });
    </script>

</body>
</html>
