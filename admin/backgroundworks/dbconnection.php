<?php
date_default_timezone_set("Asia/Colombo");
//$con=mysqli_connect("localhost", "root", "1234", "vsmsdb");
$con=mysqli_connect("localhost", "root", "", "vsmsdb");
//$con=mysqli_connect("localhost","id12299500_root", "0758426433", "id12299500_vsms_db");
//$con=mysqli_connect("localhost","vsms", "0758426433_Sm", "sdrsoft_vsmsdb");
if(mysqli_connect_errno()){
echo "Connection Fail".mysqli_connect_error();
}

  ?>
