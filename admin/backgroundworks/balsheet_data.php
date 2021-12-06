<?php
include('dbconnection.php');
$reportfor=$_GET['reportfor'];
 if($reportfor=="Monthly"){
 $y1=$_GET['yea'];
 $mon=$_GET['mon'];
    $y_m2=$y1."-".$mon;
     $dat = mysqli_query($con, "select * from grn g where g.date like '$y_m2%' ");
   
     $arrr1=array();
         
     while ($da_re1= mysqli_fetch_array($dat)){
       
            $mmm1=  $da_re1['stock_id'];  
            
         array_push($arrr1,$mmm1)  ;
     }
    $data=array();
     foreach (array_unique($arrr1) as $key => $value) {
         $setup=array();
         $sto= mysqli_query($con, "Select * from stock where id = '$value'");
         while ($sto_r = mysqli_fetch_array($sto)) {
             $setup['Name']=$sto_r['itemname'];
         }
         
         $gr=mysqli_query($con, "select * from grn g where g.date like '$y_m2%' and g.stock_id like '$value' ");
         
         $qtotal=0;
         $qava=0;
         $qsol=0;
         while($gr_r= mysqli_fetch_array($gr)){
             $total=$gr_r['total'];
             $bp=$gr_r['buyingprice'];
             $aq=$gr_r['availabe_qty'];
             
             $qtotal=$qtotal+intval($total);
             
             $ava= intval($aq)*intval($bp);
             $qava=$qava+intval($ava);
             $qsol=$qsol+(intval($total)- intval($ava));
             
         }
         $setup['total']=$qtotal;
         $setup['available']=$qava;
         $setup['sold']=$qsol;
         array_push($data,$setup);
     }
     
     echo json_encode($data);
 } elseif ($reportfor=="Yearly") {
    $y1=$_GET['yea'];
 
    $y_m2=$y1;
     $dat = mysqli_query($con, "select * from grn g where g.date like '$y_m2%' ");
   
     $arrr1=array();
         
     while ($da_re1= mysqli_fetch_array($dat)){
       
            $mmm1=  $da_re1['stock_id'];  
            
         array_push($arrr1,$mmm1)  ;
     }
    $data=array();
     foreach (array_unique($arrr1) as $key => $value) {
         $setup=array();
         $sto= mysqli_query($con, "Select * from stock where id = '$value'");
         while ($sto_r = mysqli_fetch_array($sto)) {
             $setup['Name']=$sto_r['itemname'];
         }
         
         $gr=mysqli_query($con, "select * from grn g where g.date like '$y_m2%' and g.stock_id like '$value' ");
         
         $qtotal=0;
         $qava=0;
         $qsol=0;
         while($gr_r= mysqli_fetch_array($gr)){
             $total=$gr_r['total'];
             $bp=$gr_r['buyingprice'];
             $aq=$gr_r['availabe_qty'];
             
             $qtotal=$qtotal+intval($total);
             
             $ava= intval($aq)*intval($bp);
             $qava=$qava+intval($ava);
             $qsol=$qsol+(intval($total)- intval($ava));
             
         }
         $setup['total']=$qtotal;
         $setup['available']=$qava;
         $setup['sold']=$qsol;
         array_push($data,$setup);
     }
     
     echo json_encode($data);
}
    
?>
