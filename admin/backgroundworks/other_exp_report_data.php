<?php
include('dbconnection.php');

$y_m3=$_GET['date'];
 $dat = mysqli_query($con, "select * from petty_cash ts where ts.date like '$y_m3%' AND ts.type like '%other%' ORDER BY ts.date DESC");
    
     $arrr1=array();
        $total_PC=0;
        
        
     while ($da_re1= mysqli_fetch_array($dat)){
       $bill=$da_re1['department'];
       $PC=$da_re1['amount'];
       $SC=$da_re1['date'];
       $total_SC=$da_re1['addedtomonth'];
        $total_PC=$total_PC+intval($PC) ;
       
        
        $va=array();
        $va['department']=$bill;
        $va['amount']=$PC;
        $va['date']=$SC;
        $va['month']=$total_SC;
        $va['total_PC']=$total_PC;
        
         array_push($arrr1,$va)  ;
            
     }
    
     
     echo json_encode($arrr1);
?>
