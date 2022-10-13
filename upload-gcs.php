<?php
error_reporting(1);
include "storage.php";
include "core/connect/databaseGCP.php";
require_once "vendor/autoload.php";
use Google\Cloud\Storage\StorageClient;
/*$gcpath =  getenv('GOOGLE_APPLICATION_CREDENTIALS'); echo "JASON_FILEPATH: ".$gcpath."<br>";*/

function cleanFileName($file_name)
{
    $file_ext = pathinfo($file_name, PATHINFO_EXTENSION);
    $file_name_str = pathinfo($file_name, PATHINFO_FILENAME);

    // Replaces all spaces with hyphens.
    $file_name_str = str_replace(' ', '-', $file_name_str);
    // Removes special chars.
    $file_name_str = preg_replace('/[^A-Za-z0-9\-\_]/', '', $file_name_str);
    // Replaces multiple hyphens with single one.
    $file_name_str = preg_replace('/-+/', '-', $file_name_str);
    // adding unique md5 partial encryption
    $suffix = md5(mt_rand(5,1000));
    $clean_file_name = $file_name_str . '-'.substr($suffix,0,10). '.' . $file_ext;
    return $clean_file_name;
}

extract($_POST);
$fileName = $_FILES['datafile']['name'];

if(isset($_POST['button1'])) {

	/*if($fileName == ''){
           echo "<h3>Please select file to Upload</h3>"; exit(0);
	}*/

if ($fileName != ''){

try {
    $storage = new StorageClient([
        'keyFilePath' => 'bss-sandbox-portalhc-1-5e10f8065f99.json',
    ]);
 
    $bucketName = 'portalhc-statics-1';
    if ($fileName != ""){
   	 $clean_fileName=cleanFileName($fileName);
	 $fileName = $clean_fileName;
    }
    
    $bucket = $storage->bucket($bucketName);
   

if ($object =  $bucket->upload(
    fopen($_FILES['datafile']['tmp_name'], 'r'),
    ['name' => $fileName ]
)){
   $check_url = htmlentities("https://storage.googleapis.com/$bucketName/$fileName");
echo "<br><br>File uploaded successfully. File path is: <a href=".$check_url.">".$check_url."</a>";
}else{
    var_dump($object);
}


} catch(Exception $e) {
    echo $e->getMessage();
}// EOF try & catch

}// EOF $fileName!=''
else{
	echo "<h3>Please select file to Upload</h3>";
}

} // EOF of POST


?>

<!DOCTYPE html>
<html>
<head>
<script>
 
</script>
</head>
<body>
<h2> Upload File</h2>
<form id="upload_form" enctype="multipart/form-data" method="POST" action="upload-gcs.php">
   <input type="file" name="datafile" id="fileku"><br>
   <input type="submit" value="Upload File" name="button1">
   /*<progress id="progressBar" value="0" max="100" style="width:300px;"></progress>*/
   <h3 id="status"></h3>
   <p id="total"></p>
</form>
</body>
</html>
