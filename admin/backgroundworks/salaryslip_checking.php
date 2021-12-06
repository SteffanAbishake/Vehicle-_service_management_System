<?php
include('dbconnection.php');
$id=$_GET['id'];
$type=$_GET['type'];
$month=$_GET['month'];

$queryy= mysqli_query($con, "Select * from salary where month like '$month' and ".$type."_ID = '$id'");

if($t=mysqli_fetch_array($queryy)){
//    $v=array_unique($t);
//    array_push($v,$t['ot']);
//    echo json_encode($v);
////    foreach ($v as $key => $value){
////        print_r($value ) ;
////    }
    $arr=array();
    $arr['basicsalary']=$t['basicsalary'];
    $arr['allowance']=$t['allowance'];
    $arr['ot']=$t['ot'];
    $arr['grosssalary']=$t['grosssalary'];
    $arr['epf_empl']=$t['epf_empl'];
    $arr['pettycash']=$t['pettycash'];
    $arr['tdeduction']=$t['tdeduction'];
    $arr['netsalary']=$t['netsalary'];
    $arr['paidby']=$t['paidby'];
    $arr['chequeno']=$t['chequeno'];
    $arr['nameofbank']=$t['nameofbank'];
    $arr['chequedate']=$t['chequedate'];
    echo json_encode($arr);
  
}else{
    echo 'empty';
}


?>