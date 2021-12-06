<?php

include('dbconnection.php');

$reportby = $_GET['reportby'];
$to = $_GET['to'];
if ($reportby === "Daily") {
    $dataset = array();
    $count = 0;
    $megatotal = 0;
    $grn_dates = mysqli_query($con, "Select * from grn g JOIN stock s ON g.stock_id=s.id JOIN supplier su ON s.supplier_id = su.id where g.date like '%" . $to . "%'");
   
    while ($fet = mysqli_fetch_array($grn_dates)) {
        $data = array();
        $count = $count + 1;
        $data['count'] = $count;
        $data['fullname'] = $fet['fullname'];
        $data['itemname'] = $fet['itemname'];
        $data['grnopenstock'] = $fet['grnopenstock'];
        $data['qtyg'] = $fet['qtyg'];
        $data['buyingprice'] = $fet['buyingprice'];
        $data['TotalQty'] = intval($fet['qtyg']) + intval($fet['grnopenstock']);
        $data['total'] = $fet['total'];
        $megatotal = intval($megatotal) + intval($fet['total']);
        $data['mtotal'] = $megatotal;

        array_push($dataset, $data);
    }
     echo json_encode($dataset);
} else if ($reportby === "Monthly") {
    
    $dataset = array();
    $count = 0;
    $megatotal = 0;
    $grn_dates = mysqli_query($con, "Select * from grn g JOIN stock s ON g.stock_id=s.id JOIN supplier su ON s.supplier_id = su.id where g.date like '%" . $to . "%'");
   
    while ($fet = mysqli_fetch_array($grn_dates)) {
        $data = array();
        $count = $count + 1;
        $data['count'] = $count;
        $data['fullname'] = $fet['fullname'];
        $data['itemname'] = $fet['itemname'];
        $data['grnopenstock'] = $fet['grnopenstock'];
        $data['qtyg'] = $fet['qtyg'];
        $data['buyingprice'] = $fet['buyingprice'];
        $data['TotalQty'] = intval($fet['qtyg']) + intval($fet['grnopenstock']);
        $data['total'] = $fet['total'];
        $megatotal = intval($megatotal) + intval($fet['total']);
        $data['mtotal'] = $megatotal;

        array_push($dataset, $data);
    }
     echo json_encode($dataset);
    
} else if ($reportby === "Yearly") {
    
    $dataset = array();
    $count = 0;
    $megatotal = 0;
    $grn_dates = mysqli_query($con, "Select * from grn g JOIN stock s ON g.stock_id=s.id JOIN supplier su ON s.supplier_id = su.id where g.date like '%" . $to . "%'");
   
    while ($fet = mysqli_fetch_array($grn_dates)) {
        $data = array();
        $count = $count + 1;
        $data['count'] = $count;
        $data['fullname'] = $fet['fullname'];
        $data['itemname'] = $fet['itemname'];
        $data['grnopenstock'] = $fet['grnopenstock'];
        $data['qtyg'] = $fet['qtyg'];
        $data['buyingprice'] = $fet['buyingprice'];
        $data['TotalQty'] = intval($fet['qtyg']) + intval($fet['grnopenstock']);
        $data['total'] = $fet['total'];
        $megatotal = intval($megatotal) + intval($fet['total']);
        $data['mtotal'] = $megatotal;

        array_push($dataset, $data);
    }
     echo json_encode($dataset);
}
?>

