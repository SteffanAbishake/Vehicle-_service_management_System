<?php
include('dbconnection.php');
$reportfor=$_GET['repfor'];
 $y1=$_GET['year'];
 if($reportfor=="Daily"){
    $y_m2=$y1;
     $dat = mysqli_query($con, "select * from tblservicerequest ts where ts.ServiceDate like '$y_m2%' AND ts.AdminStatus like '3' ORDER BY ts.ServiceDate DESC");
     $dat1 = mysqli_query($con, "select * from tblservicerequest_quotation ts where ts.ServiceDate like '$y_m2%' AND ts.AdminStatus like '3' ORDER BY ts.ServiceDate DESC");
     $arrr1=array();
         
     while ($da_re1= mysqli_fetch_array($dat)){
       
            $mmm1=     explode("-", $da_re1['ServiceDate'])[1];
            
         array_push($arrr1,$mmm1)  ;
     }
     while ($da_re2= mysqli_fetch_array($dat1)){
       
               $yyyy1=         explode("-", $da_re2['ServiceDate'])[1];
              
          array_push($arrr1,$yyyy1 )  ;
     }
     $res1=array();
     foreach (array_unique($arrr1) as $key => $value){
         array_push($res1,$value);
     }
     if(count($res1)>0){
         
     echo json_encode($res1);
     }else{
         echo 'nomonths';
     }
 }
    
?>
