<?php
include('dbconnection.php');

$y_m3=$_GET['date'];
 $dat = mysqli_query($con, "select * from tblservicerequest ts where ts.ServiceDate like '$y_m3%' AND ts.AdminStatus like '3' ORDER BY ts.ServiceDate DESC");
     $dat1 = mysqli_query($con, "select * from tblservicerequest_quotation ts where ts.ServiceDate like '$y_m3%' AND ts.AdminStatus like '4' ORDER BY ts.ServiceDate DESC");
     $arrr1=array();
        $total_PC=0;
        $total_SC=0;
        
     while ($da_re1= mysqli_fetch_array($dat)){
       $bill=$da_re1['ServiceNumber'];
       $PC=$da_re1['PartsCharge'];
       $SC=$da_re1['ServiceCharge'];
        $total_PC=$total_PC+intval($PC) ;
        $total_SC=$total_SC+intval($SC) ;
        $link="invoice_Receipt.php?aticid=".$da_re1['ID'];
        $va=array();
        $va['bill']=$bill;
        $va['PC']=$PC;
        $va['SC']=$SC;
        $va['total_PC']=$total_PC;
        $va['total_SC']=$total_SC;
        $va['link']=$link;
        
         array_push($arrr1,$va)  ;
            
     }
     while ($da_re2= mysqli_fetch_array($dat1)){
       $bill=$da_re2['ServiceNumber'];
       $PC=$da_re2['PartsCharge'];
       $SC=$da_re2['ServiceCharge'];
        $total_PC=$total_PC+intval($PC) ;
        $total_SC=$total_SC+intval($SC) ;
        $link="print_quotation_bill.php?aticid=".$da_re2['ID'];
        $va=array();
        $va['bill']=$bill;
        $va['PC']=$PC;
        $va['SC']=$SC;
        $va['total_PC']=$total_PC;
        $va['total_SC']=$total_SC;
        $va['link']=$link;
         array_push($arrr1,$va)  ;
             
     }
     
     echo json_encode($arrr1);
?>
