<?php
session_start();
error_reporting(0);
include('includes/dbconnection.php');
if (strlen($_SESSION['adid'] == 0)) {
    header('location:logout.php');
} else {
    //privilage setup
    $pr_id = $_SESSION['adid'];
    $pr_ret = mysqli_query($con, "select * from tbladmin where ID='$pr_id'");
    $pr_row = mysqli_fetch_array($pr_ret);
    $pr_name = $pr_row['AdminName'];
    $pr_type = $pr_row['type'];
    if ($pr_type == "Admin") {
        
    } else {
        header("location:dashboard.php");
    }
    //privilage setup
    ?>
    <!doctype html>
    <html lang="en">

        <head>
            <meta charset="utf-8" />
            <title>Vehicle Service Managment System</title>
            <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
            <meta content="A fully featured admin theme which can be used to build CRM, CMS, etc." name="description" />
            <meta content="Coderthemes" name="author" />
            <meta http-equiv="X-UA-Compatible" content="IE=edge" />

            <!-- App favicon -->
            <link rel="shortcut icon" href="assets/images/favicon.ico">

            <!-- App css -->
            <link href="assets/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
            <link href="assets/css/icons.css" rel="stylesheet" type="text/css" />
            <link href="assets/css/metismenu.min.css" rel="stylesheet" type="text/css" />
            <link href="assets/css/style.css" rel="stylesheet" type="text/css" />
            <link rel="stylesheet" href="assets/fonts/typicons.min.css">
            <script src="assets/js/modernizr.min.js"></script>
            <script src="assets/printJs/print.min.js"></script>
            <script src="assets/printJs/print.min.js"></script>
        </head>


        <body onload="reportfor();">

            <!-- Begin page -->
            <div id="wrapper">

    <?php include_once('includes/sidebar.php'); ?>

                <!-- ============================================================== -->
                <!-- Start right Content here -->
                <!-- ============================================================== -->

                <div class="content-page">

    <?php include_once('includes/header.php'); ?>

                    <!-- Start Page content -->
                    <div class="content">
                        <div class="container-fluid">
                            <div class="row">
                                <div class="col offset-lg-11 d-print-none">
                                    <button class="btn btn-danger" onclick="window.print();"><i class="fi-printer"></i></button>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12">
                                    <div class="card-box">
                                        <h4 class="m-t-0 header-title">Other Expanses Report</h4>
                                        <p class="text-muted m-b-30 font-14">
 
                                        </p>
                                        <div class="row" id="reportforrow">
                                            <div class="col-md-3">
                                                <label>Report For:&nbsp;</label>
                                                <select id="reportfor" onchange="reportfor();">

                                                    <option value="Daily" selected="">Daily</option>
                                                    <option value="Monthly">Monthly</option>
                                                    <option value="Yearly">Yearly</option>
                                                </select>
                                            </div>
                                            <div class="col-6" id="selmonth">
    <?php
    $thmx = date("m");
    $thyx = date("Y");
    $y_mx = $thy . "-" . $thm;
    $dam = mysqli_query($con, "select * from petty_cash ts where ts.type like '%other%' ");

    $mon_arrx = array();
    $y_arrx = array();
    while ($monn = mysqli_fetch_array($dam)) {
        array_push($mon_arrx, explode("-", $monn['addedtomonth'])[1]);
        array_push($y_arrx, explode("-", $monn['addedtomonth'])[0]);
    }
    ?>
                                                <label>Select:&nbsp;</label>
                                                <select id="month" onchange="chang();">
                                                <?php
                                                foreach (array_unique($mon_arrx) as $key => $value) {
                                                    if ($value == $thmx) {
                                                        ?>
                                                            <option selected="" value="<?php echo $value; ?>"><?php echo $value; ?></option>
                                                            <?php
                                                        } else {
                                                            ?>

                                                            <option  value="<?php echo $value; ?>"><?php echo $value; ?></option>

                                                            <?php
                                                        }
                                                    }
                                                    ?>

                                                </select>
                                                <label id="slce">&nbsp;/&nbsp;</label>
                                                <select id="year" onchange=" yrchang();">
    <?php
    foreach (array_unique($y_arrx) as $key => $value) {
        if ($value == $thyx) {
            ?>
                                                            <option selected="" value="<?php echo $value; ?>"><?php echo $value; ?></option>
                                                            <?php
                                                        } else {
                                                            ?>

                                                            <option  value="<?php echo $value; ?>"><?php echo $value; ?></option>

                                                            <?php
                                                        }
                                                    }
                                                    ?>
                                                </select>
                                                <button class="btn btn-secondary btn-sm" type="button" onclick="view();" id="buttonview">View</button>
                                            </div>
                                        </div>

                                        <br>

                                        <div class="row" id="main">


                                        </div>



                                    </div> <!-- end card-box -->
                                </div><!-- end col -->
                            </div>
                            <!-- end row -->






                            <!-- end row -->





                        </div> <!-- container -->

                    </div> <!-- content -->

    <?php include_once('includes/footer.php'); ?>
                </div>


                <!-- ============================================================== -->
                <!-- End Right content here -->
                <!-- ============================================================== -->


            </div>
            <!-- END wrapper -->



            <!-- jQuery  -->
            <script src="assets/js/jquery.min.js"></script>
            <script src="assets/js/bootstrap.bundle.min.js"></script>
            <script src="assets/js/metisMenu.min.js"></script>
            <script src="assets/js/waves.js"></script>
            <script src="assets/js/jquery.slimscroll.js"></script>


            <!-- App js -->
            <script src="assets/js/jquery.core.js"></script>
            <script src="assets/js/jquery.app.js"></script>

            <script type="text/javascript">

                                                    function template() {
                                                        var hold_all = document.createElement("div");
                                                        //                                                        alert bar
                                                        var alert_row_main = document.createElement("div");
                                                        alert_row_main.setAttribute("class", "row");
                                                        hold_all.appendChild(alert_row_main);
                                                        var alert_col_main = document.createElement("div");
                                                        alert_col_main.setAttribute("class", "col");
                                                        var alert_div_main = document.createElement("div");
                                                        alert_div_main.setAttribute("class", "alert alert-danger border rounded d-md-flex justify-content-md-start align-items-md-center");
                                                        alert_div_main.setAttribute("role", "alert");
                                                        alert_div_main.setAttribute("style", "height: 29px;");

                                                        var span_date = document.createElement("span");
                                                        alert_div_main.appendChild(span_date);
                                                        var drop_icon = document.createElement("i");
                                                        drop_icon.setAttribute("class", "typcn typcn-arrow-sorted-down d-md-flex justify-content-md-end align-items-md-start");
                                                        alert_div_main.appendChild(drop_icon);

                                                        alert_col_main.appendChild(alert_div_main);
                                                        alert_row_main.appendChild(alert_col_main);

                                                        //                                                        alert bar


                                                        //                                                        table
                                                        var table_row_main = document.createElement("div");
                                                        table_row_main.setAttribute("class", "row");
                                                        hold_all.appendChild(table_row_main);
                                                        var table_col_main = document.createElement("div");
                                                        table_col_main.setAttribute("class", "col");
                                                        table_row_main.appendChild(table_col_main);
                                                        var table_holder = document.createElement("div");
                                                        table_holder.setAttribute("class", "table-responsive");
                                                        table_col_main.appendChild(table_holder);
                                                        var table = document.createElement("table");
                                                        table.setAttribute("class", "table table-striped table-hover table-sm");
                                                        table_holder.appendChild(table);
                                                        //                                                           tablehead
                                                        var table_head = document.createElement("thead");
                                                        table.appendChild(table_head);
                                                        var table_head_row = document.createElement("tr");
                                                        table_head.appendChild(table_head_row);

                                                        var table_head_title_No = document.createElement("th");
                                                        table_head_title_No.innerHTML = "No.";
                                                        table_head_row.appendChild(table_head_title_No);
                                                        var table_head_title_Product = document.createElement("th");
                                                        table_head_title_Product.innerHTML = "Product";
                                                        table_head_row.appendChild(table_head_title_Product);
                                                        var table_head_title_OpeningStockQty = document.createElement("th");
                                                        table_head_title_OpeningStockQty.innerHTML = "Opening Stock Qty";
                                                        table_head_row.appendChild(table_head_title_OpeningStockQty);
                                                        var table_head_title_PurchasedQty = document.createElement("th");
                                                        table_head_title_PurchasedQty.innerHTML = "Purchased Qty";
                                                        table_head_row.appendChild(table_head_title_PurchasedQty);
                                                        var table_head_title_TotalQty = document.createElement("th");
                                                        table_head_title_TotalQty.innerHTML = "Total Qty";
                                                        table_head_row.appendChild(table_head_title_TotalQty);
                                                        var table_head_title_PurchasedAmount = document.createElement("th");
                                                        table_head_title_PurchasedAmount.innerHTML = "Purchased Amount";
                                                        table_head_row.appendChild(table_head_title_PurchasedAmount);
                                                        //                                                           tablehead
                                                        //                                                           
                                                        //                                                            tablebody
                                                        var tbody = document.createElement("tbody");
                                                        table.appendChild(tbody);
                                                        var tbody_tr = document.createElement("tr");
                                                        tbody.appendChild(tbody_tr);
                                                        var tbody_td_no = document.createElement("td");
                                                        tbody_tr.appendChild(tbody_td_no);
                                                        tbody_td_no.innerHTML = "01";
                                                        var tbody_td_product = document.createElement("td");
                                                        tbody_tr.appendChild(tbody_td_product);
                                                        tbody_td_product.innerHTML = "OIL";
                                                        var tbody_td_osq = document.createElement("td");
                                                        tbody_tr.appendChild(tbody_td_osq);
                                                        tbody_td_osq.innerHTML = "0";
                                                        var tbody_td_pq = document.createElement("td");
                                                        tbody_tr.appendChild(tbody_td_pq);
                                                        tbody_td_pq.innerHTML = "10";
                                                        var tbody_td_tq = document.createElement("td");
                                                        tbody_tr.appendChild(tbody_td_tq);
                                                        tbody_td_tq.innerHTML = "10";
                                                        var tbody_td_pa = document.createElement("td");
                                                        tbody_tr.appendChild(tbody_td_pa);
                                                        tbody_td_pa.innerHTML = "7000";

                                                        //                                                            tablebody

                                                        //                                                               tablefooter
                                                        var tfooter = document.createElement("tfoot");
                                                        table.appendChild(tfooter);
                                                        var tfooter_row = document.createElement("tr");
                                                        tfooter.appendChild(tfooter_row);
                                                        var tfooter_row_td_total = document.createElement("td");
                                                        tfooter_row_td_total.setAttribute("class", "text-right");
                                                        tfooter_row_td_total.setAttribute("colspan", "5");
                                                        tfooter_row_td_total.innerHTML = "Total:";
                                                        tfooter_row.appendChild(tfooter_row_td_total);

                                                        var tfooter_row_td_total_val = document.createElement("td");
                                                        tfooter_row_td_total_val.innerHTML = "7000";
                                                        tfooter_row.appendChild(tfooter_row_td_total_val);
                                                        //                                                               tablefooter

                                                        //                                                        table

                                                        //                                                    Nothing Puchased

                                                        var nprow = document.createElement("div");
                                                        var npcol = document.createElement("div");
                                                        npcol.setAttribute("class", "col");
                                                        nprow.appendChild(npcol);
                                                        var nph1 = document.createElement("h1");
                                                        nph1.setAttribute("class", "display-4");
                                                        nph1.innerHTML = "You didn't purchase anything";
                                                        //                                                    Nothing Puchased


                                                        document.getElementById("main").appendChild(hold_all);
                                                        var req = new XMLHttpRequest();
                                                        req.onreadystatechange = function () {
                                                            if (req.status === 200 && req.readyState === 4) {

                                                            }
                                                        };
                                                        req.open("GET", "", true);
                                                        req.send();


                                                    }

                                                    function reportfor() {
                                                        var reportfor = document.getElementById("reportfor").value;
                                                        var selmonth = document.getElementById("selmonth");
                                                        var month = document.getElementById("month");
                                                        var year = document.getElementById("year");
                                                        var slce = document.getElementById("slce");
                                                        var main = document.getElementById("main");
                                                        if (reportfor == "Daily") {
                                                            selmonth.style = "display:inline;";
                                                            month.style = "display:inline;";
                                                            slce.style = "display:inline;";
                                                            main.innerHTML = "";
                                                            var smonth = month.value;
                                                            var syear = year.value;
                                                            var req = new XMLHttpRequest();
                                                            req.onreadystatechange = function () {
                                                                if (req.status === 200 && req.readyState === 4) {

                                                                    var o = JSON.parse(req.responseText);
                                                                    var hold_all = document.createElement("div");
                                                                    hold_all.setAttribute("class", "col");
                                                                    for (var o1 = 0; o1 < o.length; o1++) {
                                                                        //                                                                        alert(o[o1]);
                                                                        //                                                        alert bar
                                                                        var alert_row_main = document.createElement("div");
                                                                        alert_row_main.setAttribute("class", "row");
                                                                        alert_row_main.setAttribute("onclick", "show('" + o[o1] + "')");
                                                                        hold_all.appendChild(alert_row_main);
                                                                        var alert_col_main = document.createElement("div");
                                                                        alert_col_main.setAttribute("class", "col");
                                                                        var alert_div_main = document.createElement("div");
                                                                        alert_div_main.setAttribute("class", "alert alert-danger border rounded d-md-flex justify-content-md-start align-items-md-center");
                                                                        alert_div_main.setAttribute("role", "alert");
                                                                        alert_div_main.setAttribute("style", "height: 29px;");


                                                                        var span_date = document.createElement("span");
                                                                        span_date.innerHTML = o[o1];
                                                                        alert_div_main.appendChild(span_date);
                                                                        var drop_icon = document.createElement("i");
                                                                        drop_icon.setAttribute("id", "i" + o[o1]);
                                                                        drop_icon.setAttribute("class", "typcn typcn-arrow-sorted-down d-md-flex justify-content-md-end align-items-md-start");
                                                                        alert_div_main.appendChild(drop_icon);

                                                                        alert_col_main.appendChild(alert_div_main);
                                                                        alert_row_main.appendChild(alert_col_main);

                                                                        var hidden = document.createElement("input");
                                                                        hidden.setAttribute("id", "hidden" + o[o1]);
                                                                        hidden.setAttribute("type", "hidden");
                                                                        hidden.setAttribute("value", "hidden");
                                                                        alert_row_main.appendChild(hidden);

                                                                        var alert_row_main1 = document.createElement("div");
                                                                        alert_row_main1.setAttribute("class", "col");
                                                                        alert_row_main1.setAttribute("id", "tablemain" + o[o1]);
                                                                        hold_all.appendChild(alert_row_main1);

                                                                        main.appendChild(hold_all);


                                                                    }
                                                                }
                                                            };
                                                            req.open("GET", "backgroundworks/dateload_other_exp_report.php?repfor=" + reportfor + "&month=" + smonth + "&year=" + syear, true);
                                                            req.send();


                                                        } else if (reportfor == "Monthly") {
                                                            selmonth.style = "display:inline;";
                                                            month.style = "display:none;";
                                                            slce.style = "display:none;";
                                                            main.innerHTML = "";

                                                            var syear = year.value;
                                                            var req = new XMLHttpRequest();
                                                            req.onreadystatechange = function () {
                                                                if (req.status === 200 && req.readyState === 4) {

                                                                    var o = JSON.parse(req.responseText);
                                                                    var hold_all = document.createElement("div");
                                                                    hold_all.setAttribute("class", "col");
                                                                    for (var o1 = 0; o1 < o.length; o1++) {
                                                                        //                                                                        alert(o[o1]);
                                                                        //                                                        alert bar
                                                                        var alert_row_main = document.createElement("div");
                                                                        alert_row_main.setAttribute("class", "row");
                                                                        alert_row_main.setAttribute("onclick", "show('" + o[o1] + "')");
                                                                        hold_all.appendChild(alert_row_main);
                                                                        var alert_col_main = document.createElement("div");
                                                                        alert_col_main.setAttribute("class", "col");
                                                                        var alert_div_main = document.createElement("div");
                                                                        alert_div_main.setAttribute("class", "alert alert-danger border rounded d-md-flex justify-content-md-start align-items-md-center");
                                                                        alert_div_main.setAttribute("role", "alert");
                                                                        alert_div_main.setAttribute("style", "height: 29px;");


                                                                        var span_date = document.createElement("span");
                                                                        span_date.innerHTML = o[o1];
                                                                        alert_div_main.appendChild(span_date);
                                                                        var drop_icon = document.createElement("i");
                                                                        drop_icon.setAttribute("id", "i" + o[o1]);
                                                                        drop_icon.setAttribute("class", "typcn typcn-arrow-sorted-down d-md-flex justify-content-md-end align-items-md-start");
                                                                        alert_div_main.appendChild(drop_icon);

                                                                        alert_col_main.appendChild(alert_div_main);
                                                                        alert_row_main.appendChild(alert_col_main);

                                                                        var hidden = document.createElement("input");
                                                                        hidden.setAttribute("id", "hidden" + o[o1]);
                                                                        hidden.setAttribute("type", "hidden");
                                                                        hidden.setAttribute("value", "hidden");
                                                                        alert_row_main.appendChild(hidden);

                                                                        var alert_row_main1 = document.createElement("div");
                                                                        alert_row_main1.setAttribute("class", "col");
                                                                        alert_row_main1.setAttribute("id", "tablemain" + o[o1]);
                                                                        hold_all.appendChild(alert_row_main1);

                                                                        main.appendChild(hold_all);


                                                                    }
                                                                }
                                                            };
                                                            req.open("GET", "backgroundworks/dateload_other_exp_report.php?repfor=" + reportfor + "&year=" + syear, true);
                                                            req.send();

                                                        } else if (reportfor == "Yearly") {
                                                            selmonth.style = "display:none;";
                                                            main.innerHTML = "";

                                                            var req = new XMLHttpRequest();
                                                            req.onreadystatechange = function () {
                                                                if (req.status === 200 && req.readyState === 4) {

                                                                    var o = JSON.parse(req.responseText);
                                                                    var hold_all = document.createElement("div");
                                                                    hold_all.setAttribute("class", "col");
                                                                    for (var o1 = 0; o1 < o.length; o1++) {
                                                                        //                                                                        alert(o[o1]);
                                                                        //                                                        alert bar
                                                                        var alert_row_main = document.createElement("div");
                                                                        alert_row_main.setAttribute("class", "row");
                                                                        alert_row_main.setAttribute("onclick", "show('" + o[o1] + "')");
                                                                        hold_all.appendChild(alert_row_main);
                                                                        var alert_col_main = document.createElement("div");
                                                                        alert_col_main.setAttribute("class", "col");
                                                                        var alert_div_main = document.createElement("div");
                                                                        alert_div_main.setAttribute("class", "alert alert-danger border rounded d-md-flex justify-content-md-start align-items-md-center");
                                                                        alert_div_main.setAttribute("role", "alert");
                                                                        alert_div_main.setAttribute("style", "height: 29px;");


                                                                        var span_date = document.createElement("span");
                                                                        span_date.innerHTML = o[o1];
                                                                        alert_div_main.appendChild(span_date);
                                                                        var drop_icon = document.createElement("i");
                                                                        drop_icon.setAttribute("id", "i" + o[o1]);
                                                                        drop_icon.setAttribute("class", "typcn typcn-arrow-sorted-down d-md-flex justify-content-md-end align-items-md-start");
                                                                        alert_div_main.appendChild(drop_icon);

                                                                        alert_col_main.appendChild(alert_div_main);
                                                                        alert_row_main.appendChild(alert_col_main);

                                                                        var hidden = document.createElement("input");
                                                                        hidden.setAttribute("id", "hidden" + o[o1]);
                                                                        hidden.setAttribute("type", "hidden");
                                                                        hidden.setAttribute("value", "hidden");
                                                                        alert_row_main.appendChild(hidden);

                                                                        var alert_row_main1 = document.createElement("div");
                                                                        alert_row_main1.setAttribute("class", "col");
                                                                        alert_row_main1.setAttribute("id", "tablemain" + o[o1]);
                                                                        hold_all.appendChild(alert_row_main1);

                                                                        main.appendChild(hold_all);


                                                                    }
                                                                }
                                                            };
                                                            req.open("GET", "backgroundworks/dateload_other_exp_report.php?repfor=" + reportfor + "&year=" + syear, true);
                                                            req.send();


                                                        }
                                                    }

                                                    function show(x) {
                                                        var hidee = document.getElementById("hidden" + x);
                                                        var ico = document.getElementById("i" + x);
                                                        var tablemain = document.getElementById("tablemain" + x);

                                                        if (hidee.value == "hidden") {
                                                            hidee.value = "shown";
                                                            ico.class = "typcn typcn-arrow-sorted-up d-md-flex justify-content-md-end align-items-md-start";
                                                            tablemain.innerHTML = "";
                                                            var req = new XMLHttpRequest();
                                                            req.onreadystatechange = function () {
                                                                if (req.status === 200 && req.readyState === 4) {
                                                                    var o = JSON.parse(req.responseText);

                                                                    //                                                                    alert(req.responseText);
                                                                    //                                                        table
                                                                    var table_row_main = document.createElement("div");
                                                                    table_row_main.setAttribute("class", "row");

                                                                    var table_col_main = document.createElement("div");
                                                                    table_col_main.setAttribute("class", "col");
                                                                    table_row_main.appendChild(table_col_main);
                                                                    var table_holder = document.createElement("div");
                                                                    table_holder.setAttribute("class", "table-responsive");
                                                                    table_col_main.appendChild(table_holder);
                                                                    var table = document.createElement("table");
                                                                    table.setAttribute("class", "table table-striped table-hover table-sm");
                                                                    table_holder.appendChild(table);
                                                                    //                                                           tablehead
                                                                    var table_head = document.createElement("thead");
                                                                    table.appendChild(table_head);
                                                                    var table_head_row = document.createElement("tr");
                                                                    table_head.appendChild(table_head_row);

                                                                    var table_head_title_No = document.createElement("th");
                                                                    table_head_title_No.innerHTML = "No.";
                                                                    table_head_row.appendChild(table_head_title_No);
                                                                    var table_head_title_Product = document.createElement("th");
                                                                    table_head_title_Product.innerHTML = "Date";
                                                                    table_head_row.appendChild(table_head_title_Product);
                                                                    var table_head_title_OpeningStockQty = document.createElement("th");
                                                                    table_head_title_OpeningStockQty.innerHTML = "Month";
                                                                    table_head_row.appendChild(table_head_title_OpeningStockQty);
                                                                    var table_head_title_PurchasedQty = document.createElement("th");
                                                                    table_head_title_PurchasedQty.innerHTML = "Reason";
                                                                    table_head_row.appendChild(table_head_title_PurchasedQty);
                                                                    var table_head_title_PurchasedAmount = document.createElement("th");
                                                                    table_head_title_PurchasedAmount.innerHTML = "Amount(LKR)";
                                                                    table_head_row.appendChild(table_head_title_PurchasedAmount);

                                                                    //                                                           tablehead
                                                                    var tbody = document.createElement("tbody");
                                                                    table.appendChild(tbody);
                                                                    var tpc = "";

                                                                    for (var i = 0; i < o.length; i++) {
                                                                        var i1 = i;
                                                                        //                                                           
                                                                        //                                                            tablebody
                                                                        var tbody_tr = document.createElement("tr");
                                                                        tbody.appendChild(tbody_tr);
                                                                        var tbody_td_no = document.createElement("td");
                                                                        tbody_tr.appendChild(tbody_td_no);
                                                                        tbody_td_no.innerHTML = i1 + 1;
                                                                        var tbody_td_product = document.createElement("td");
                                                                        tbody_tr.appendChild(tbody_td_product);
                                                                        tbody_td_product.innerHTML = o[i].date;
                                                                        var tbody_td_osq = document.createElement("td");
                                                                        tbody_tr.appendChild(tbody_td_osq);
                                                                        tbody_td_osq.innerHTML = o[i].month;
                                                                        var tbody_td_pq = document.createElement("td");
                                                                        tbody_tr.appendChild(tbody_td_pq);
                                                                        tbody_td_pq.innerHTML = o[i].department;
                                                                        var tbody_td_am = document.createElement("td");
                                                                        tbody_tr.appendChild(tbody_td_am);
                                                                        tbody_td_am.innerHTML = o[i].amount;
                                                                        tpc = o[i].total_PC;


                                                                        //                                                            tablebody

                                                                    }
                                                                    //                                                               tablefooter
                                                                    var tfooter = document.createElement("tfoot");
                                                                    table.appendChild(tfooter);
                                                                    var tfooter_row = document.createElement("tr");
                                                                    tfooter.appendChild(tfooter_row);
                                                                    var tfooter_row_td_total = document.createElement("td");
                                                                    tfooter_row_td_total.setAttribute("class", "text-right");
                                                                    tfooter_row_td_total.setAttribute("colspan", "4");
                                                                    tfooter_row_td_total.innerHTML = "Total:";
                                                                    tfooter_row.appendChild(tfooter_row_td_total);


                                                                    var tfooter_row_td_total_val1 = document.createElement("td");
                                                                    tfooter_row_td_total_val1.innerHTML = tpc;
                                                                    tfooter_row.appendChild(tfooter_row_td_total_val1);
                                                                    //                                                               tablefooter
                                                                    tablemain.appendChild(table_row_main);
                                                                    //                                                        table
                                                                }
                                                            };
                                                            req.open("GET", "backgroundworks/other_exp_report_data.php?date=" + x, true);
                                                            req.send();
                                                        } else {
                                                            hidee.value = "hidden";
                                                            tablemain.innerHTML = "";
                                                            ico.class = "typcn typcn-arrow-sorted-down d-md-flex justify-content-md-end align-items-md-start";
                                                        }
                                                    }

                                                    function chang() {
                                                        var main = document.getElementById("main");
                                                        main.innerHTML = "";
                                                    }
                                                    function yrchang() {
                                                        var main = document.getElementById("main");
                                                        main.innerHTML = "";
                                                        var reportfor = document.getElementById("reportfor").value;
                                                        var selmonth = document.getElementById("selmonth");
                                                        var month = document.getElementById("month");
                                                        var year = document.getElementById("year");
                                                        var slce = document.getElementById("slce");
                                                        var main = document.getElementById("main");
                                                        var btnv = document.getElementById("buttonview");
                                                        var m = year.value;
                                                        var req = new XMLHttpRequest();
                                                        req.onreadystatechange = function () {
                                                            if (req.status === 200 && req.readyState === 4) {
                                                                //                                                                alert(req.responseText);
                                                                if (req.responseText == "nomonths") {
                                                                    month.innerHTML = "";
                                                                    btnv.style = "display:none;";
                                                                    chang();
                                                                } else {
                                                                    btnv.style = "display:inline;";
                                                                    month.innerHTML = "";
                                                                    var o = JSON.parse(req.responseText);
                                                                    for (var o1 = 0; o1 < o.length; o1++) {
                                                                        var opt = document.createElement("option");
                                                                        opt.value = o[o1];
                                                                        opt.innerHTML = o[o1];
                                                                        month.appendChild(opt);
                                                                        chang();
                                                                    }
                                                                }
                                                            }
                                                        };
                                                        req.open("GET", "backgroundworks/other_report_yr_change.php?repfor=" + reportfor + "&year=" + m, true);
                                                        req.send();
                                                    }

                                                    function view() {
                                                        reportfor();
                                                    }



            </script>

        </body>
    </html>
<?php } ?>