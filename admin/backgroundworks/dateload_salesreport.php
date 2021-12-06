<?php
include('dbconnection.php');
$reportfor=$_GET['repfor'];

if($reportfor=="Daily"){
    $m=$_GET['month'];
    $y=$_GET['year'];
    $y_m1=$y."-".$m;
     $data = mysqli_query($con, "select * from tblservicerequest ts where ts.ServiceDate like '$y_m1%' AND ts.AdminStatus like '3' ORDER BY ts.ServiceDate DESC");
     $data1 = mysqli_query($con, "select * from tblservicerequest_quotation ts where ts.ServiceDate like '$y_m1%' AND ts.AdminStatus like '3' ORDER BY ts.ServiceDate DESC");
     $arrr=array();
     while ($da_re1= mysqli_fetch_array($data)){
         array_push($arrr, $da_re1['ServiceDate'])  ;
     }
     while ($da_re2= mysqli_fetch_array($data1)){
         array_push($arrr, $da_re2['ServiceDate'])  ;
     }
     $res=array();
     foreach (array_unique($arrr) as $key => $value){
         array_push($res,$value);
     }
     
     echo json_encode($res);
     
}else if($reportfor=="Monthly") {
    
    $y1=$_GET['year'];
    $y_m2=$y1;
     $dat = mysqli_query($con, "select * from tblservicerequest ts where ts.ServiceDate like '$y_m2%' AND ts.AdminStatus like '3' ORDER BY ts.ServiceDate DESC");
     $dat1 = mysqli_query($con, "select * from tblservicerequest_quotation ts where ts.ServiceDate like '$y_m2%' AND ts.AdminStatus like '3' ORDER BY ts.ServiceDate DESC");
     $arrr1=array();
         
     while ($da_re1= mysqli_fetch_array($dat)){
        $mmm=  explode("-", $da_re1['ServiceDate'])[0];
            $mmm1=     explode("-", $da_re1['ServiceDate'])[1];
            $mm2=$mmm."-".$mmm1;
         array_push($arrr1,$mm2)  ;
     }
     while ($da_re2= mysqli_fetch_array($dat1)){
       $yyyy=  explode("-", $da_re2['ServiceDate'])[0];
               $yyyy1=         explode("-", $da_re2['ServiceDate'])[1];
               $yyyy2= $yyyy ."-".$yyyy1;
          array_push($arrr1,$yyyy2 )  ;
     }
     $res1=array();
     foreach (array_unique($arrr1) as $key => $value){
         array_push($res1,$value);
     }
     
     echo json_encode($res1);
    
}else if($reportfor=="Yearly"){
     $dat = mysqli_query($con, "select * from tblservicerequest ts where  ts.AdminStatus like '3' ORDER BY ts.ServiceDate DESC");
     $dat1 = mysqli_query($con, "select * from tblservicerequest_quotation ts where ts.AdminStatus like '3' ORDER BY ts.ServiceDate DESC");
     $arrr1=array();
         
     while ($da_re1= mysqli_fetch_array($dat)){
        $mmm=  explode("-", $da_re1['ServiceDate'])[0];
            
         array_push($arrr1,$mmm)  ;
     }
     while ($da_re2= mysqli_fetch_array($dat1)){
       $yyyy=  explode("-", $da_re2['ServiceDate'])[0];
              
          array_push($arrr1,$yyyy )  ;
     }
     $res1=array();
     foreach (array_unique($arrr1) as $key => $value){
         array_push($res1,$value);
     }
     
     echo json_encode($res1);
}

?>