<?php
include('dbconnection.php');
$reportfor=$_GET['repfor'];
 $y1=$_GET['year'];
 if($reportfor=="Monthly"){
    $y_m2=$y1;
     $dat = mysqli_query($con, "select * from grn g where g.date like '$y_m2%' ORDER BY g.date ASC");
   
     $arrr1=array();
         
     while ($da_re1= mysqli_fetch_array($dat)){
       
            $mmm1=     explode("-", $da_re1['date'])[1];
            
         array_push($arrr1,$mmm1)  ;
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
