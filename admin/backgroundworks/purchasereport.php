<?php
include('dbconnection.php');
$reportby = $_GET['reportby'];


if ($reportby == "Daily") {
    $s_month = $_GET['s_month'];
    $s_year = $_GET['s_year'];


    $todo = $s_year."-".$s_month;
    $grn_fetch = array();
     $grn_fetch1 = array();
   
    $grn_dates = mysqli_query($con, "Select * from grn g JOIN stock s ON g.stock_id=s.id JOIN supplier su ON s.supplier_id = su.id ");
    while ($grn_date = mysqli_fetch_array($grn_dates)) {
        $wholedate = explode(" ", $grn_date['date'])[0];
        $Y_M= explode("-", $grn_date['date'])[0]."-".explode("-", $grn_date['date'])[1];
        if ($todo === $Y_M) {
            array_push($grn_fetch, explode(" ", $grn_date['date'])[0]);
        }
    }
    
  $grn_fetch_u=array_unique($grn_fetch);
    
    foreach ($grn_fetch_u as $key => $value) {
        array_push($grn_fetch1, $value);
    }
    
    if(count($grn_fetch_u)>0){
        
        echo json_encode($grn_fetch1);
    }else{
        echo "nomatch";
    }
    
    
    
    
} else if ($reportby == "Monthly") {
    
    $s_year = $_GET['s_year'];


    $todo = $s_year;
    $grn_fetch = array();
    $grn_fetch1 = array();
    
    $grn_dates = mysqli_query($con, "Select * from grn g JOIN stock s ON g.stock_id=s.id JOIN supplier su ON s.supplier_id = su.id ");
    while ($grn_date = mysqli_fetch_array($grn_dates)) {
        $wholedate = explode(" ", $grn_date['date'])[0];
        $Y= explode("-", $grn_date['date'])[0];
        if ($todo === $Y) {
            array_push($grn_fetch, explode("-", $grn_date['date'])[1]);
        }
    }
    
    $grn_fetch_u=array_unique($grn_fetch);
    
    foreach ($grn_fetch_u as $key => $value) {
        array_push($grn_fetch1, $value);
    }
    
    if(count($grn_fetch_u)>0){
        
        echo json_encode($grn_fetch1);
    }else{
        echo "nomatch";
    }
} else if ($reportby == "Yearly") {
      $grn_fetch = array();
      $grn_fetch1 = array();
   
    $grn_dates = mysqli_query($con, "Select * from grn g JOIN stock s ON g.stock_id=s.id JOIN supplier su ON s.supplier_id = su.id ");
    while ($grn_date = mysqli_fetch_array($grn_dates)) {
        $wholedate = explode(" ", $grn_date['date'])[0];
        $Y= explode("-", $grn_date['date'])[0];
      
            array_push($grn_fetch, explode("-", $grn_date['date'])[0]);
       
    }
    
    $grn_fetch_u=array_unique($grn_fetch);
    
    foreach ($grn_fetch_u as $key => $value) {
        array_push($grn_fetch1, $value);
    }
    
    if(count($grn_fetch_u)>0){
        
        echo json_encode($grn_fetch1);
    }else{
        echo "nomatch";
    }
}

?>
