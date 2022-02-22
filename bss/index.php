<?php 
date_default_timezone_set('Asia/Jakarta');
require '../core/init.php';
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
	$email_assignee2 = $user_assignee['email2'];
	$email_assignee3 = $user_assignee['email3'];
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
					Link tracking ticket Jaringan KSP --> https://hc3.sahabat-ukm.com:8088/ticketreademp.php?id=$id"." \r\n <br/>	
					Link tracking ticket Jaringan BSS --> https://hc3.banksampoerna.com:8088/ticketreademp.php?id=$id"." \r\n <br/><br/>		
					Human Capital Contact Center (HC3)</br>
					Melayani dengan solusi<br/>";
	/*$emailsubject = "Ticket No: $ticketnumber has assigned to you";
	$message = 
				"Dear $fullname_assignee, \r\n
				You are currently assign for this ticket.\r\n
				Please follow this link to resolved the ticket --> https://hc3.sahabat-ukm:8088/ticketedit.php?id=$id"." \r\n
				Thank you. \r\n
				Regards, \r\n
				Helpdesk";
	
	
	//include '../email/smtp.php';	
	include '../email/smtp.php';	*/
	//include'http://10.50.234.34:8080/email/smtp.php';
	
	if(!empty($_FILES['iuploadfile']['name'])){     
    $uploadDir = "../uploads/";
	$filename = date("ymd").'-'.$_FILES['iuploadfile']['name'];
    $iFileName = $_FILES['iuploadfile']['name'];
    $uploadedFile = $uploadDir.$filename;  
	$uploadtime=date("Y-m-d H:i:s");
	$tickets_id=$id;
	$uploads->add_upload($filename,$uploadtime,$tickets_id);
    move_uploaded_file($_FILES['iuploadfile']['tmp_name'],$uploadedFile);
	}
	
	
	$tickets->add_ticket($ticketnumber,$sla,$emp_id,$cat,$idcustomer,$entity,$emp_name,$emp_posisi,$emp_telp,$reportedby,$reporteddate,$telp,$email,$problemsummary,$problemdetail,$ticketstatus,$assignee,$documentedby);
	$assigneddate='';$pendingby='';$pendingdate='';$resolution='';$resolvedby='';$resolveddate='';$closedby='';$closeddate='';
	$tickets->log_tickets($id,$sla,$reporteddate,$reportedby,$telp,$email,$problemsummary,$problemdetail,$ticketstatus,$assignee,$assigneddate,$pendingby, $pendingdate, $resolution,$resolvedby,$resolveddate,$closedby,$closeddate,$changes,$changeby);
	$emails->add_email($id,$senddate,$email_assignee,$emailcc,$emailbcc,$emailsubject,$message,$emailstatus);
	$emails->add_sla_remainder($id,$ticketnumber,$slasenddate,$email_assignee,$emailcc,$emailbcc,$emailsubject,$message);
	//include 'email/smtp_adm.php';
	//$result=$emails->send_new_ticket();	
	//echo $result;
	//header ("Location: ticketread.php?id=$id");	
	header ("Location: ../ticketreademp.php?id=$id");
	echo $senddate."<br>".$resolutiontime."<br>".$slasenddate;
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>E-FORM HC3</title>
	<link rel="icon" href="../images/hc3favicon.ico" type="image/x-icon">
    <!-- Font Icon 
    <link rel="stylesheet" href="fonts/material-icon/css/material-design-iconic-font.min.css">

    <!-- Main css -->
    <link rel="stylesheet" href="css/style.css">
	<!-- Drop zone 
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css"> -->
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
	<link rel="stylesheet" type="text/css" href="dropzone/dropzone.css" />
	<script type="text/javascript" src="dropzone/dropzone.js"></script>
	<script type="text/javascript" src="js/upload.js"></script>

</head>
<body style="background-image: url('images/bg-01.jpg');">
	
    <div class="main" >	
        <div class="container">
            <div class="signup-content">
               
                <div class="signup-form">
                    <form method="POST" class="register-form" id="register-form" enctype="multipart/form-data">
                        <h2>Input E-Form HC3</h2>
                        <div class="form-row">
                            <div class="form-group">
                                <label for="emp_id">NIK Karyawan :</label>
								<input type="text" name="emp_id" onkeyup="isi_otomatis()" id="emp_id" placeholder="Nomor Induk Karyawan" maxlength=8 required/>                               
                            </div>
                            <div class="form-group">
                                <label for="emp_name">Nama Karyawan :</label>
								<input type="text" name="emp_name" placeholder="Nama Karyawan" id="emp_name" required/>                            
                            </div>
                        </div>						
                        <div class="form-group">
                            <label for="emp_posisi">Posisi Karyawan :</label>
                            <input type="text" name="emp_posisi" placeholder="Posisi Karyawan (Auto)" id="emp_posisi" required/>
                        </div>
						<input type='hidden' name='idassignee' value='25'>
						<input type="hidden" name="idcustomer" placeholder="idcustomer" id="idcustomer"/>
						<input type="hidden" name="entity" placeholder="entity" id="entity"/>
						<input type="hidden" id="reporteddate" name="reporteddate" readonly value="<?php echo date('d-M-Y',time()); ?>"> </td>
						<!--
                        <div class="form-radio">
                            <label for="gender" class="radio-label">Gender :</label>
                            <div class="form-radio-item">
                                <input type="radio" name="gender" id="male" checked>
                                <label for="male">Male</label>
                                <span class="check"></span>
                            </div>
                            <div class="form-radio-item">
                                <input type="radio" name="gender" id="female">
                                <label for="female">Female</label>
                                <span class="check"></span>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group">
                                <label for="state">State :</label>
                                <div class="form-select">
                                    <select name="state" id="state">
                                        <option value=""></option>
                                        <option value="us">America</option>
                                        <option value="uk">English</option>
                                    </select>
                                    <span class="select-icon"><i class="zmdi zmdi-chevron-down"></i></span>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="city">City :</label>
                                <div class="form-select">
                                    <select name="city" id="city">
                                        <option value=""></option>
                                        <option value="losangeles">Los Angeles</option>
                                        <option value="washington">Washington</option>
                                    </select>
                                    <span class="select-icon"><i class="zmdi zmdi-chevron-down"></i></span>
                                </div>
                            </div>
                        </div>
						-->
						<div class="form-row">
                        <div class="form-group">
                            <label for="telp">Phone :</label>
                            <input type="text" name="telp" placeholder="Ext / Phone Number" id="telp"/>
                        </div>
						<div class="form-group">
                            <label for="email">Email :</label>
                            <input type="text" name="email" placeholder="Employee Email" id="email" required/>
                        </div>
						</div>
                        <div class="form-row">
                        <div class="form-group">
                            <label for="cat">Kategori Pertanyaan:</label>
                            <div class="form-select">
                                <select name="cat" id="cat" required/>
                                    <option value="">Pilih Kategori</option>
                                    <?php
										$cat = $cats->get_cat();
										foreach ($cat as $catval) 
										{	
											echo '<option value="'.$catval['catid'].'">'.$catval['namacat'].'</option>';
										}
										?>
                                </select>
                                <span class="select-icon"><i class="zmdi zmdi-chevron-down"></i></span>
                            </div>
                        </div>
						</div>
						<div class="form-group">
                            <label for="problemsummary">Subject Pertanyaan:</label>
                            <input type="text" name="problemsummary" placeholder="Subject Pertanyaan" class="form-control" required/>
                        </div>
						<div class="form-group">
                            <label for="problemdetail">Pertanyaan:</label>
							
							<!--<input type="text" name="problemdetail" placeholder="Pertanyaan Detail" class="form-control" required/>		-->					
							<textarea class="textarea" name="problemdetail" placeholder="Pertanyaan Detail" required/></textarea> 
                        </div>	
						<div class="form-group col-lg-6">
							<label for="fileUpload">Upload File</label>
							<input class="form-control" name="iuploadfile" type="file">
						</div>
												
                        <div class="form-submit">
                            <input type="submit" value="Cancel" class="submit" name="reset" id="reset" />
                            <input type="submit" value="Submit Form" class="submit" name="submit" id="submit" />
                        </div>
                    </form>
                </div>
				 <div class="signup-img">
					<img src="images/1.jpg" alt="slide1">		
					
                </div> 
            </div>
        </div>

    </div>
	<!--
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="js/main.js"></script>
	
	<!-- JScrip Otomatis field -->
		<script src="js/jquery.min.js"></script> 
        <script type="text/javascript">
		 
  
			$('#uploadFile').click(function(){
			   myDropzone.processQueue();
			});
 		var $j = jQuery.noConflict();
            function isi_otomatis(){
                var emp_id = $j("#emp_id").val();
                $j.ajax({
                    url: 'proses-ajax.php',
                    data:"emp_id="+emp_id ,
                }).success(function (data) {
                    var json = data,
                    obj = JSON.parse(json);
                    $j('#emp_name').val(obj.emp_name);
                    $j('#emp_posisi').val(obj.emp_posisi);
                    $j('#entity').val(obj.entity);	
					$j('#idcustomer').val(obj.idcustomer);						
                });
            }
		
        </script>
</body><!-- This templates was made by Colorlib (https://colorlib.com) -->
</html>