<?php

include('dbconnection.php');
if (isset($_GET['from'])) {
    $months = array();
    $result = array();
    $cuurnt_month = date("m");
    $cuurnt_year = $_GET['y'];
    $grn_dates = mysqli_query($con, "Select * from grn");
    while ($grn_date = mysqli_fetch_array($grn_dates)) {
        if (explode("-", $grn_date['date'])[0] === $cuurnt_year) {
            $month = explode("-", $grn_date['date'])[1];
            array_push($months, $month);
        }
    }
    foreach (array_unique($months) as $amonth) {

        array_push($result, $amonth);
    }

    if (count($result) > 0) {
        echo json_encode($result);
    } else {
        echo 'no months';
    }
} else {
    if ($_GET['viewby'] === "monthly") {
        
        $years = array();
        $grn_dates = mysqli_query($con, "Select * from grn");
        while ($grn_date = mysqli_fetch_array($grn_dates)) {
            $year = explode("-", $grn_date['date'])[0];
            array_push($years, $year);
        }
        foreach (array_unique($years) as $ayear) {
            array_push($years, $ayear);
            
            
        }
         if (count($years) > 0) {
        echo json_encode($result);
    } else {
        echo 'no years';
    }
            }
        }
?>
