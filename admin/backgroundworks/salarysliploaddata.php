<?php
include('dbconnection.php');
$id=$_GET['id'];
$type=$_GET['type'];

if($type==="tbladmin"){
    $vr=array();
   $queryx= mysqli_query($con, "SELECT * FROM tbladmin where ID= ".$id);
  $my= mysqli_fetch_array($queryx);
  $BasicSalary=$my['BasicSalary'];
  $vr['basicsalary']= $BasicSalary;
  $epf=($BasicSalary/100)*8;
  $vr['epf']= $epf;
  $pett= mysqli_query($con, "SELECT * FROM petty_cash pc where  pc.department LIKE '$type' AND pc.".$type."_ID ='$id' AND pc.claimed like'No' ORDER BY pc.idpetty_cash DESC ");
  $pettycash=0;
  while ($qr= mysqli_fetch_array($pett)){
      $pettycash=$pettycash+intval($qr['amount']);
  }
  $vr['pettycash']= $pettycash;
  $totaldeduction=intval($pettycash)+intval($epf);
  $vr['totaldeduction']= $totaldeduction ;
  $vr['GrossSalary']=$BasicSalary;
  $vr['Netsalary']= intval($BasicSalary)-intval($totaldeduction);
  echo json_encode($vr);
  
   
}else if($type==="tblmechanics"){
     $vr=array();
   $queryx= mysqli_query($con, "SELECT * FROM tblmechanics where ID= ".$id);
  $my= mysqli_fetch_array($queryx);
  $BasicSalary=$my['BasicSalary'];
  $vr['basicsalary']= $BasicSalary;
  $epf=($BasicSalary/100)*8;
  $vr['epf']= $epf;
  $pett= mysqli_query($con, "SELECT * FROM petty_cash pc where  pc.department LIKE '$type' AND pc.".$type."_ID ='$id' AND pc.claimed like'No' ORDER BY pc.idpetty_cash DESC ");
  $pettycash=0;
  while ($qr= mysqli_fetch_array($pett)){
      $pettycash=$pettycash+intval($qr['amount']);
  }
  $vr['pettycash']= $pettycash;
  $totaldeduction=intval($pettycash)+intval($epf);
  $vr['totaldeduction']= $totaldeduction ;
  $vr['GrossSalary']=$BasicSalary;
  $vr['Netsalary']= intval($BasicSalary)-intval($totaldeduction);
  echo json_encode($vr);
}

?>