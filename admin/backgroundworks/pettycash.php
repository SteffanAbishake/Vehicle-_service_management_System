<?php

include('dbconnection.php');
$type = $_GET['type'];
if ($type === "employee") {
    $employees = $_GET['employees'];
    $today = $_GET['today'];
    $atm = $_GET['atm'];
    $amount = $_GET['amount'];
    $claimed = $_GET['claimed'];
    $department = explode("|", $employees)[0];
    $id = explode("|", $employees)[1];

    $putto = mysqli_query($con, "Insert into petty_cash(type,department,addedtomonth,date,amount,claimed," . $department . "_ID) values('$type','$department','$atm','$today','$amount','$claimed','$id') ");

    if ($putto) {
        echo 'done';
    } else {
        echo 'error';
    }
//  echo "Insert into petty_cash(type,department,addedtomonth,date,amount,claimed,".$department."_ID) values('$type','$department','$atm','$today','$amount','$claimed','$id') ";
} else if ($type === "other") {
    $amount = $_GET['amount'];
    $reason = $_GET['reason'];
    $today = $_GET['today'];
    $atm = explode("-", $today)[0] . "-" . explode("-", $today)[1];

    $putto1 = mysqli_query($con, "Insert into petty_cash(type,department,addedtomonth,date,amount,claimed) values('$type','$reason','$atm','$today','$amount','$type') ");
    if ($putto1) {
        echo 'done';
    } else {
        echo 'error';
    }
}
?>

