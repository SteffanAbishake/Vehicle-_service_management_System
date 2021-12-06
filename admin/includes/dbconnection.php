<?php
// date_default_timezone_set("Asia/Colombo");
// $con=mysqli_connect("sql200.epizy.com", "epiz_30495961","3VUwPdzkTg", "epiz_30495961_vsmsdatabase");
// if(mysqli_connect_errno()){
// echo "Connection Fail".mysqli_connect_error();
// $output="Connection Fail ".mysqli_connect_error();
// echo "<script>console.log('Debug Objects: " . $output . "' );</script>";
// }
date_default_timezone_set("Asia/Colombo");
$con=new mysqli("127.0.0.1", "root","", "vsmsdb");

if($con->connect_error) {
  var_dump($con->connect_error);
  exit;
}

G

  ?>

