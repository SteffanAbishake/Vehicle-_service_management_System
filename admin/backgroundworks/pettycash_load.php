<?php
include('dbconnection.php');

$type=$_GET['type'];
if($type==="employee"){
$employees=$_GET['employees'];

 $department= explode("|",$employees )[0];
    $id= explode("|",$employees )[1];

$loa=mysqli_query($con,"SELECT * FROM petty_cash pc where pc.type LIKE '$type' AND pc.department LIKE '$department' AND pc.".$department."_ID ='$id' ORDER BY pc.idpetty_cash DESC ");
$final_re=array();
$counts=0;
while($loader= mysqli_fetch_array($loa)){
    $counts=$counts+1;
    $vf=array();
    $vf[]=$counts;
    $vf[]=$loader['date'];
    $vf[]=$loader['amount'];
    $vf[]=$loader['addedtomonth'];
    $vf[]=$loader['claimed'];
    
    array_push($final_re, $vf);
}

echo json_encode($final_re);
}else if($type==="other"){
    $day=$_GET['today'];
    $atm1 = explode("-", $day)[0] . "-" . explode("-", $day)[1];
    $loa1=mysqli_query($con,"SELECT * FROM petty_cash pc where pc.type LIKE '$type' AND pc.addedtomonth LIKE '$atm1' AND pc.claimed LIKE 'other' ORDER BY pc.idpetty_cash DESC ");
$final_re1=array();
$counts1=0;
while($loader1= mysqli_fetch_array($loa1)){
    $counts1=$counts1+1;
    $vf1=array();
    $vf1[]=$counts1;
    $vf1[]=$loader1['date'];
    $vf1[]=$loader1['amount'];
    $vf1[]=$loader1['addedtomonth'];
//    $vf1[]=$loader1['claimed'];
    
    array_push($final_re1, $vf1);
}

echo json_encode($final_re1);
}
?>
