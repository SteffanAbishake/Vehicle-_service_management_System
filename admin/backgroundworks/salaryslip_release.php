<?php
include('dbconnection.php');

$jsons= json_decode($_GET['json'],true);

$id=$jsons['id'];
$type=$jsons['type'];
$basic=$jsons['basic'];
$pettycash=$jsons['pettycash'];
$epf=$jsons['epf'];
$tdeduct=$jsons['tdeduct'];
$grosssalary=$jsons['grosssalary'];
$netsalary=$jsons['netsalary'];
$allowance=$jsons['allowance'];
$ot=$jsons['ot'];
$yearmonth=$jsons['yearmonth'];
$paidby=$jsons['paidby'];
$chequeno=$jsons['chequeno'];
$chequedate=$jsons['chequedate'];
$nameofbank=$jsons['nameofbank'];

$epf_c= (intval($basic)/100)*12;
$etf= (intval($basic)/100)*3;
$date= date("Y-m-d");

$quer="Insert into salary(type,basicsalary,allowance,ot,month,date,grosssalary,epf_empl,epf_comp,etf,pettycash,tdeduction,netsalary,paidby,chequeno,nameofbank,chequedate,".$type."_ID) values('$type','$basic','$allowance','$ot','$yearmonth','$date','$grosssalary','$epf','$epf_c','$etf','$pettycash','$tdeduct','$netsalary','$paidby','$chequeno','$nameofbank','$chequedate','$id')";

$app=mysqli_query($con,$quer);
if($app){
    $pett= mysqli_query($con, "SELECT * FROM petty_cash pc where  pc.department LIKE '$type' AND pc.".$type."_ID ='$id' AND pc.claimed like'No' ORDER BY pc.idpetty_cash DESC ");
    while($xc= mysqli_fetch_array($pett)){
        mysqli_query($con, "update petty_cash set claimed='Yes' where idpetty_cash = '".$xc['idpetty_cash']."'");
    }
    echo 'success';
}else{
    echo 'error';
}
?>

