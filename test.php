<?php
# Fill our vars and run on cli
# $ php -f db-connect-test.php

$dbhost = 'localhost:3306';
## $dbhost = '127.0.0.1';
$dbname = 'db_hc3';
$dbuser = 'root';
$dbpass = 'P@ssw0rd';


$link = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname) or die("Unable to Connect to '$dbhost'");

echo $link;

if($link) { echo "DB Connected successfully"; }

mysqli_select_db($link, $dbname) or die("Could not open the db '$dbname'");

$test_query = "SHOW TABLES FROM $dbname";
$result = mysqli_query($link, $test_query);

$tblCnt = 0;
while($tbl = mysqli_fetch_array($result)) {
  $tblCnt++;
  #echo $tbl[0]."<br />\n";
}

if (!$tblCnt) {
  echo "There are no tables<br />\n";
} else {
  echo "There are $tblCnt tables<br />\n";
} 

?>

