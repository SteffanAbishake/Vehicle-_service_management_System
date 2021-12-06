<?php

include('dbconnection.php');


$reportfor = $_GET['reportfor'];
if ($reportfor == "Monthly") {
    $year = $_GET['year'];
    $month = $_GET['month'];
    $yea_mon_0 = $year . "-" . "0" . $month;
    $yea_mon = $year . "-" . $month;

    $pl = mysqli_query($con, "Select * from profit p where p.date like '$yea_mon_0%' ");
    $pro = 0;
    while ($pl_ro = mysqli_fetch_array($pl)) {
        $pro = $pro + intval($pl_ro['profit_amount']);
    }
    $pl1 = mysqli_query($con, "Select * from profit_quotaion p where p.date like '$yea_mon_0%' ");

    while ($pl_ro = mysqli_fetch_array($pl1)) {
        $pro = $pro + intval($pl_ro['profit_amount']);
    }

    $ser_ch = mysqli_query($con, "SELECT * FROM tblservicerequest tr  WHERE tr.AdminStatus LIKE '3' AND tr.ServiceDate LIKE '$yea_mon_0%' ");
    $servi = 0;
    while ($ser_ch_ro = mysqli_fetch_array($ser_ch)) {
        $servi = $servi + intval($ser_ch_ro['ServiceCharge']);
    }
    $ser_ch1 = mysqli_query($con, "SELECT * FROM tblservicerequest_quotation tr  WHERE tr.AdminStatus LIKE '4' AND tr.ServiceDate LIKE '$yea_mon_0%' ");

    while ($ser_ch_ro = mysqli_fetch_array($ser_ch1)) {
        $servi = $servi + intval($ser_ch_ro['ServiceCharge']);
    }

    $sal = mysqli_query($con, "SELECT * from salary s where s.month like '$yea_mon%'");
    $Salary = 0;
    $epfco = 0;
    $etff = 0;
    while ($salr = mysqli_fetch_array($sal)) {
        $Salary = $Salary + intval($salr['grosssalary']);
        $epfco = $epfco + intval($salr['epf_comp']);
        $etff = $etff + intval($salr['etf']);
    }

    $oth = mysqli_query($con, "Select * from petty_cash p where p.type like 'other' and p.addedtomonth like '$yea_mon_0%' ");
    $oth_a = 0;
    while ($othr = mysqli_fetch_array($oth)) {
        $oth_a = $oth_a + intval($othr['amount']);
    }

    $totincom = $pro + $servi;
    $totout = $Salary + $epfco + $etff + $oth_a;

    $summ = $totincom - $totout;
    $stat = "";
    if ($summ < 0) {
        $stat = "Loss";
    } else if ($summ > 0) {
        $stat = "Profit";
    } else {
        $stat = "Equal";
    }
     
        $sett = array();
        $sett['Profit'] = $pro;
        $sett['Service'] = $servi;
        $sett['Salary'] = $Salary;
        $sett['Epfcom'] = $epfco;
        $sett['Etf'] = $etff;
        $sett['Summary'] = $summ;
        $sett['Status'] = $stat;

        echo json_encode($sett);
    
} else if ($reportfor == "Yearly") {
    $yea_mon_0 = $_GET['year'];
    $yea_mon = $_GET['year'];

    $pl = mysqli_query($con, "Select * from profit p where p.date like '$yea_mon_0%' ");
    $pro = 0;
    while ($pl_ro = mysqli_fetch_array($pl)) {
        $pro = $pro + intval($pl_ro['profit_amount']);
    }
    $pl1 = mysqli_query($con, "Select * from profit_quotaion p where p.date like '$yea_mon_0%' ");

    while ($pl_ro = mysqli_fetch_array($pl1)) {
        $pro = $pro + intval($pl_ro['profit_amount']);
    }

    $ser_ch = mysqli_query($con, "SELECT * FROM tblservicerequest tr  WHERE tr.AdminStatus LIKE '3' AND tr.ServiceDate LIKE '$yea_mon_0%' ");
    $servi = 0;
    while ($ser_ch_ro = mysqli_fetch_array($ser_ch)) {
        $servi = $servi + intval($ser_ch_ro['ServiceCharge']);
    }
    $ser_ch1 = mysqli_query($con, "SELECT * FROM tblservicerequest_quotation tr  WHERE tr.AdminStatus LIKE '4' AND tr.ServiceDate LIKE '$yea_mon_0%' ");

    while ($ser_ch_ro = mysqli_fetch_array($ser_ch1)) {
        $servi = $servi + intval($ser_ch_ro['ServiceCharge']);
    }

    $sal = mysqli_query($con, "SELECT * from salary s where s.month like '$yea_mon%'");
    $Salary = 0;
    $epfco = 0;
    $etff = 0;
    while ($salr = mysqli_fetch_array($sal)) {
        $Salary = $Salary + intval($salr['grosssalary']);
        $epfco = $epfco + intval($salr['epf_comp']);
        $etff = $etff + intval($salr['etf']);
    }

    $oth = mysqli_query($con, "Select * from petty_cash p where p.type like 'other' and p.addedtomonth like '$yea_mon_0%' ");
    $oth_a = 0;
    while ($othr = mysqli_fetch_array($oth)) {
        $oth_a = $oth_a + intval($othr['amount']);
    }

    $totincom = $pro + $servi;
    $totout = $Salary + $epfco + $etff + $oth_a;

    $summ = $totincom - $totout;
    $stat = "";
    if ($summ < 0) {
        $stat = "Loss";
    } else if ($summ > 0) {
        $stat = "Profit";
    } else {
        $stat = "Equal";
    }
    
    $sett = array();
    $sett['Profit'] = $pro;
    $sett['Service'] = $servi;
    $sett['Salary'] = $Salary;
    $sett['Epfcom'] = $epfco;
    $sett['Etf'] = $etff;
    $sett['Summary'] = $summ;
    $sett['Status'] = $stat;

    echo json_encode($sett);
    
}
?>

