<?php
include('dbconnection.php');
$reportfor=$_GET['repfor'];

if($reportfor=="Daily"){
    $m=$_GET['month'];
    $y=$_GET['year'];
    $y_m1=$y."-".$m;
     $data = mysqli_query($con, "select * from petty_cash ts where ts.type like '%other%' and ts.date like '$y_m1%' ORDER BY ts.date DESC");
     
     $arrr=array();
     while ($da_re1= mysqli_fetch_array($data)){
         array_push($arrr, $da_re1['date'])  ;
     }
     
     $res=array();
     foreach (array_unique($arrr) as $key => $value){
         array_push($res,$value);
     }
     
     echo json_encode($res);
     
}else if($reportfor=="Monthly") {
    
    $y1=$_GET['year'];
    $y_m2=$y1;
     $dat = mysqli_query($con, "select * from petty_cash ts where ts.type like '%other%' and ts.date like '$y_m2%' ORDER BY ts.date DESC");
   
     $arrr1=array();
         
     while ($da_re1= mysqli_fetch_array($dat)){
        $mmm=  explode("-", $da_re1['date'])[0];
            $mmm1=     explode("-", $da_re1['date'])[1];
            $mm2=$mmm."-".$mmm1;
         array_push($arrr1,$mm2)  ;
     }
     
     $res1=array();
     foreach (array_unique($arrr1) as $key => $value){
         array_push($res1,$value);
     }
     
     echo json_encode($res1);
    
}else if($reportfor=="Yearly"){
     $dat = mysqli_query($con, "select * from petty_cash ts where ts.type like '%other%'  ORDER BY ts.date DESC");
     
     $arrr1=array();
         
     while ($da_re1= mysqli_fetch_array($dat)){
        $mmm=  explode("-", $da_re1['date'])[0];
            
         array_push($arrr1,$mmm)  ;
     }
    
     $res1=array();
     foreach (array_unique($arrr1) as $key => $value){
         array_push($res1,$value);
     }
     
     echo json_encode($res1);
}

?>