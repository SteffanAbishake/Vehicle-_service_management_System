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


        <body>

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
                                        <h4 class="m-t-0 header-title">Purchased Reports</h4>
                                        <p class="text-muted m-b-30 font-14">

                                        </p>
                                        <!--<button onclick="template();">template</button>-->
                                        <div class="row">
                                            <div class="col-md-3">
                                                <label>Report For:&nbsp;</label>
                                                <select onchange="reportby();" id="reportby">
                                                    <option value="Today" selected="">Today</option>
                                                    <option value="Daily">Daily</option>
                                                    <option value="Monthly">Monthly</option>
                                                    <option value="Yearly">Yearly</option>
                                                </select>
                                            </div>
                                            <div class="col" style="display: none;" id="viewby">
                                                <label>Select:&nbsp;</label>
                                                <select id="month" onchange="mc();">
                                                    <?php
                                                    $months = array();
                                                    $cuurnt_month = date("m");
                                                    $cuurnt_year = date("Y");
                                                    $grn_dates = mysqli_query($con, "Select * from grn");
                                                    while ($grn_date = mysqli_fetch_array($grn_dates)) {
                                                        if (explode("-", $grn_date['date'])[0] === $cuurnt_year) {
                                                            $month = explode("-", $grn_date['date'])[1];
                                                            array_push($months, $month);
                                                        }
                                                    }
                                                    foreach (array_unique($months) as $amonth) {
                                                        if ($amonth === $cuurnt_month) {
                                                            ?>
                                                            <option value="<?php echo $amonth; ?>" selected=""><?php echo $amonth; ?></option>
                                                        <?php } else {
                                                            ?>
                                                            <option value="<?php echo $amonth; ?>" ><?php echo $amonth; ?></option>

                                                            <?php
                                                        }
                                                    }
                                                    ?>
                                                </select>
                                                <label id="slce">&nbsp;/&nbsp;</label>
                                                <select style="padding-right: 0px;margin-right: 10px;" id="year" onchange="yearchng('from');">
                                                    <?php
                                                    $current_year = date("Y");
                                                    $years = array();
                                                    $grn_dates = mysqli_query($con, "Select * from grn");
                                                    while ($grn_date = mysqli_fetch_array($grn_dates)) {
                                                        $year = explode("-", $grn_date['date'])[0];
                                                        array_push($years, $year);
                                                    }
                                                    foreach (array_unique($years) as $ayear) {
                                                        if ($ayear === $current_year) {
                                                            ?>
                                                            <option value="<?php echo $ayear; ?>" selected=""><?php echo $ayear; ?></option>
                                                        <?php } else {
                                                            ?>
                                                            <option value="<?php echo $ayear; ?>"><?php echo $ayear; ?></option>

                                                            <?php
                                                        }
                                                    }
                                                    ?>
                                                </select>
                                                <button class="btn btn-secondary btn-sm" type="button" onclick="view();" id="view">View</button>
                                            </div>
                                        </div>
                                        <div id="main">

                                        </div>
                                        <div id="today">
                                            <div class="row" >
                                                <div class="col">
                                                    <div class="alert alert-danger border rounded d-md-flex justify-content-md-start align-items-md-center" role="alert" style="height: 29px;">
                                                        <?php
                                                        $today = date('Y-m-d');
                                                        $grn_fetch = array();
                                                        $grn_dates = mysqli_query($con, "Select * from grn g JOIN stock s ON g.stock_id=s.id JOIN supplier su ON s.supplier_id = su.id ");
                                                        while ($grn_date = mysqli_fetch_array($grn_dates)) {
                                                            $day = explode(" ", $grn_date['date'])[0];
                                                            if ($today === $day) {
                                                                array_push($grn_fetch, $grn_date);
                                                            }
                                                        }
                                                        ?>
                                                        <span><?php echo $today; ?></span>
                                                        <i class="typcn typcn-arrow-sorted-up d-md-flex justify-content-md-end align-items-md-start"></i>
                                                    </div>
                                                </div>
                                            </div>
                                            <?php
                                            if (count($grn_fetch) > 0) {
                                                ?>
                                                <div class="row">
                                                    <div class="col">
                                                        <div class="table-responsive">
                                                            <table class="table table-striped table-hover table-sm">
                                                                <thead>
                                                                    <tr>
                                                                        <th>No</th>
                                                                        <th>Supplier</th>
                                                                        <th>Product</th>
                                                                        <th>Opening Stock Qty</th>
                                                                        <th>Purchased Qty</th>
                                                                        <th>Purchased unit price</th>
                                                                        <th>Total Qty</th>
                                                                        <!--<th>Available Qty</th>-->
                                                                        <th>Purchased Amount</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                    <?php
                                                                    $count = 1;
                                                                    $total = 0;

                                                                    foreach ($grn_fetch as $tdygrn) {
                                                                        ?>
                                                                        <tr>
                                                                            <td><?php echo $count; ?></td>
                                                                            <td><?php echo $tdygrn['fullname']; ?></td>
                                                                            <td><?php echo $tdygrn['itemname']; ?></td>
                                                                            <td><?php echo $tdygrn['grnopenstock']; ?></td>
                                                                            <td><?php echo $tdygrn['qtyg']; ?></td>
                                                                            <td><?php echo $tdygrn['buyingprice']; ?></td>
                                                                            <td><?php echo intval($tdygrn['qtyg']) + intval($tdygrn['grnopenstock']); ?></td>
                                                                            <!--<td><?php // echo $tdygrn['availabe_qty'];      ?></td>-->
                                                                            <td><?php echo $tdygrn['total']; ?></td>
                                                                        </tr>
                                                                        <?php
                                                                        $total = intval($total) + intval($tdygrn['total']);
                                                                        $count = intval($count) + 1;
                                                                    }
                                                                    ?>
                                                                </tbody>
                                                                <tfoot>
                                                                    <tr>
                                                                        <td class="text-right" colspan="7">Total:</td>
                                                                        <td><?php echo $total; ?></td>
                                                                    </tr>
                                                                </tfoot>
                                                            </table>
                                                        </div>
                                                    </div>
                                                </div>
                                                <?php
                                            } else {
                                                ?>
                                                <div class="row">
                                                    <div class="col">
                                                        <h1 class="display-4">You didn't purchase any items yet... </h1>
                                                    </div>

                                                </div>

                                                <?php
                                            }
                                            ?>
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

                                                    function show(s) {
                                                        var reportby = document.getElementById("reportby").value;
                                                        var view = s;
                                                        var icon = document.getElementById("icon" + view);
                                                        var holdtable = document.getElementById("holdtable" + view);
                                                        var hidden = document.getElementById("hidden" + view);

                                                        if (hidden.value === "hidden") {
                                                            hidden.value = "shown";
                                                            if (reportby === "Daily") {
                                                                var req = new XMLHttpRequest();

                                                                req.onreadystatechange = function () {
                                                                    if (req.readyState === 4 && req.status === 200) {
                                                                        //                                                                        alert(this.responseText);

                                                                        icon.removeAttribute("class");
                                                                        icon.setAttribute("class", "typcn typcn-arrow-sorted-up d-md-flex justify-content-md-end align-items-md-start");

                                                                        var jsonarray = JSON.parse(this.responseText);
                                                                        var megatotal = 0;
                                                                        //                                                                        table
                                                                        var table_row_main = document.createElement("div");
                                                                        table_row_main.setAttribute("class", "row");
                                                                        table_row_main.setAttribute("id", "tablemainrow" + view);
                                                                        //                                                                        hold_all.appendChild(table_row_main);
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
                                                                        var table_head_title_Supplier = document.createElement("th");
                                                                        table_head_title_Supplier.innerHTML = "Supplier";
                                                                        table_head_row.appendChild(table_head_title_Supplier);
                                                                        var table_head_title_Product = document.createElement("th");
                                                                        table_head_title_Product.innerHTML = "Product";
                                                                        table_head_row.appendChild(table_head_title_Product);
                                                                        var table_head_title_OpeningStockQty = document.createElement("th");
                                                                        table_head_title_OpeningStockQty.innerHTML = "Opening Stock Qty";
                                                                        table_head_row.appendChild(table_head_title_OpeningStockQty);
                                                                        var table_head_title_PurchasedQty = document.createElement("th");
                                                                        table_head_title_PurchasedQty.innerHTML = "Purchased Qty";
                                                                        table_head_row.appendChild(table_head_title_PurchasedQty);
                                                                        var table_head_title_unitprice = document.createElement("th");
                                                                        table_head_title_unitprice.innerHTML = "Purchased Unit Price";
                                                                        table_head_row.appendChild(table_head_title_unitprice);
                                                                        var table_head_title_TotalQty = document.createElement("th");
                                                                        table_head_title_TotalQty.innerHTML = "Total Qty";
                                                                        table_head_row.appendChild(table_head_title_TotalQty);
                                                                        var table_head_title_PurchasedAmount = document.createElement("th");
                                                                        table_head_title_PurchasedAmount.innerHTML = "Purchased Amount";
                                                                        table_head_row.appendChild(table_head_title_PurchasedAmount);
                                                                        //                                                           tablehead
                                                                        //                                                            tablebody
                                                                        var tbody = document.createElement("tbody");
                                                                        table.appendChild(tbody);

                                                                        for (var i = 0; i < jsonarray.length; i++) {

                                                                            var tbody_tr = document.createElement("tr");
                                                                            tbody.appendChild(tbody_tr);
                                                                            var tbody_td_no = document.createElement("td");
                                                                            tbody_tr.appendChild(tbody_td_no);
                                                                            tbody_td_no.innerHTML = jsonarray[i].count;
                                                                            var tbody_td_supplier = document.createElement("td");
                                                                            tbody_tr.appendChild(tbody_td_supplier);
                                                                            tbody_td_supplier.innerHTML = jsonarray[i].fullname;
                                                                            var tbody_td_product = document.createElement("td");
                                                                            tbody_tr.appendChild(tbody_td_product);
                                                                            tbody_td_product.innerHTML = jsonarray[i].itemname;
                                                                            var tbody_td_osq = document.createElement("td");
                                                                            tbody_tr.appendChild(tbody_td_osq);
                                                                            tbody_td_osq.innerHTML = jsonarray[i].grnopenstock;
                                                                            var tbody_td_pq = document.createElement("td");
                                                                            tbody_tr.appendChild(tbody_td_pq);
                                                                            tbody_td_pq.innerHTML = jsonarray[i].qtyg;
                                                                            var tbody_td_up = document.createElement("td");
                                                                            tbody_tr.appendChild(tbody_td_up);
                                                                            tbody_td_up.innerHTML = jsonarray[i].buyingprice;
                                                                            var tbody_td_tq = document.createElement("td");
                                                                            tbody_tr.appendChild(tbody_td_tq);
                                                                            tbody_td_tq.innerHTML = jsonarray[i].TotalQty;
                                                                            var tbody_td_pa = document.createElement("td");
                                                                            tbody_tr.appendChild(tbody_td_pa);
                                                                            tbody_td_pa.innerHTML = jsonarray[i].total;
                                                                            megatotal = jsonarray[i].mtotal;
                                                                            //                                                            tablebody
                                                                        }
                                                                        //                                                               tablefooter
                                                                        var tfooter = document.createElement("tfoot");
                                                                        table.appendChild(tfooter);
                                                                        var tfooter_row = document.createElement("tr");
                                                                        tfooter.appendChild(tfooter_row);
                                                                        var tfooter_row_td_total = document.createElement("td");
                                                                        tfooter_row_td_total.setAttribute("class", "text-right");
                                                                        tfooter_row_td_total.setAttribute("colspan", "7");
                                                                        tfooter_row_td_total.innerHTML = "Total:";
                                                                        tfooter_row.appendChild(tfooter_row_td_total);

                                                                        var tfooter_row_td_total_val = document.createElement("td");
                                                                        tfooter_row_td_total_val.innerHTML = megatotal;
                                                                        tfooter_row.appendChild(tfooter_row_td_total_val);
                                                                        //                                                               tablefooter

                                                                        //                                                        table
                                                                        holdtable.appendChild(table_row_main);

                                                                    }
                                                                };
                                                                req.open("GET", "backgroundworks/reportexpand.php?reportby=" + reportby + "&to=" + view, true);
                                                                req.send();
                                                            } else if (reportby === "Monthly") {

                                                                var req = new XMLHttpRequest();

                                                                req.onreadystatechange = function () {
                                                                    if (req.readyState === 4 && req.status === 200) {


                                                                        icon.removeAttribute("class");
                                                                        icon.setAttribute("class", "typcn typcn-arrow-sorted-up d-md-flex justify-content-md-end align-items-md-start");

                                                                        var jsonarray = JSON.parse(this.responseText);
                                                                        var megatotal = 0;
                                                                        //                                                                        table
                                                                        var table_row_main = document.createElement("div");
                                                                        table_row_main.setAttribute("class", "row");
                                                                        table_row_main.setAttribute("id", "tablemainrow" + view);
                                                                        //                                                                        hold_all.appendChild(table_row_main);
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
                                                                        var table_head_title_Supplier = document.createElement("th");
                                                                        table_head_title_Supplier.innerHTML = "Supplier";
                                                                        table_head_row.appendChild(table_head_title_Supplier);
                                                                        var table_head_title_Product = document.createElement("th");
                                                                        table_head_title_Product.innerHTML = "Product";
                                                                        table_head_row.appendChild(table_head_title_Product);
                                                                        var table_head_title_OpeningStockQty = document.createElement("th");
                                                                        table_head_title_OpeningStockQty.innerHTML = "Opening Stock Qty";
                                                                        table_head_row.appendChild(table_head_title_OpeningStockQty);
                                                                        var table_head_title_PurchasedQty = document.createElement("th");
                                                                        table_head_title_PurchasedQty.innerHTML = "Purchased Qty";
                                                                        table_head_row.appendChild(table_head_title_PurchasedQty);
                                                                        var table_head_title_unitprice = document.createElement("th");
                                                                        table_head_title_unitprice.innerHTML = "Purchased Unit Price";
                                                                        table_head_row.appendChild(table_head_title_unitprice);
                                                                        var table_head_title_TotalQty = document.createElement("th");
                                                                        table_head_title_TotalQty.innerHTML = "Total Qty";
                                                                        table_head_row.appendChild(table_head_title_TotalQty);
                                                                        var table_head_title_PurchasedAmount = document.createElement("th");
                                                                        table_head_title_PurchasedAmount.innerHTML = "Purchased Amount";
                                                                        table_head_row.appendChild(table_head_title_PurchasedAmount);
                                                                        //                                                           tablehead
                                                                        //                                                            tablebody
                                                                        var tbody = document.createElement("tbody");
                                                                        table.appendChild(tbody);

                                                                        for (var i = 0; i < jsonarray.length; i++) {

                                                                            var tbody_tr = document.createElement("tr");
                                                                            tbody.appendChild(tbody_tr);
                                                                            var tbody_td_no = document.createElement("td");
                                                                            tbody_tr.appendChild(tbody_td_no);
                                                                            tbody_td_no.innerHTML = jsonarray[i].count;
                                                                            var tbody_td_supplier = document.createElement("td");
                                                                            tbody_tr.appendChild(tbody_td_supplier);
                                                                            tbody_td_supplier.innerHTML = jsonarray[i].fullname;
                                                                            var tbody_td_product = document.createElement("td");
                                                                            tbody_tr.appendChild(tbody_td_product);
                                                                            tbody_td_product.innerHTML = jsonarray[i].itemname;
                                                                            var tbody_td_osq = document.createElement("td");
                                                                            tbody_tr.appendChild(tbody_td_osq);
                                                                            tbody_td_osq.innerHTML = jsonarray[i].grnopenstock;
                                                                            var tbody_td_pq = document.createElement("td");
                                                                            tbody_tr.appendChild(tbody_td_pq);
                                                                            tbody_td_pq.innerHTML = jsonarray[i].qtyg;
                                                                            var tbody_td_up = document.createElement("td");
                                                                            tbody_tr.appendChild(tbody_td_up);
                                                                            tbody_td_up.innerHTML = jsonarray[i].buyingprice;
                                                                            var tbody_td_tq = document.createElement("td");
                                                                            tbody_tr.appendChild(tbody_td_tq);
                                                                            tbody_td_tq.innerHTML = jsonarray[i].TotalQty;
                                                                            var tbody_td_pa = document.createElement("td");
                                                                            tbody_tr.appendChild(tbody_td_pa);
                                                                            tbody_td_pa.innerHTML = jsonarray[i].total;
                                                                            megatotal = jsonarray[i].mtotal;
                                                                            //                                                            tablebody
                                                                        }
                                                                        //                                                               tablefooter
                                                                        var tfooter = document.createElement("tfoot");
                                                                        table.appendChild(tfooter);
                                                                        var tfooter_row = document.createElement("tr");
                                                                        tfooter.appendChild(tfooter_row);
                                                                        var tfooter_row_td_total = document.createElement("td");
                                                                        tfooter_row_td_total.setAttribute("class", "text-right");
                                                                        tfooter_row_td_total.setAttribute("colspan", "7");
                                                                        tfooter_row_td_total.innerHTML = "Total:";
                                                                        tfooter_row.appendChild(tfooter_row_td_total);

                                                                        var tfooter_row_td_total_val = document.createElement("td");
                                                                        tfooter_row_td_total_val.innerHTML = megatotal;
                                                                        tfooter_row.appendChild(tfooter_row_td_total_val);
                                                                        //                                                               tablefooter

                                                                        //                                                        table
                                                                        holdtable.appendChild(table_row_main);

                                                                    }
                                                                };
                                                                req.open("GET", "backgroundworks/reportexpand.php?reportby=" + reportby + "&to=" + view, true);
                                                                req.send();

                                                            } else if (reportby === "Yearly") {

                                                                var req = new XMLHttpRequest();

                                                                req.onreadystatechange = function () {
                                                                    if (req.readyState === 4 && req.status === 200) {


                                                                        icon.removeAttribute("class");
                                                                        icon.setAttribute("class", "typcn typcn-arrow-sorted-up d-md-flex justify-content-md-end align-items-md-start");

                                                                        var jsonarray = JSON.parse(this.responseText);
                                                                        var megatotal = 0;
                                                                        //                                                                        table
                                                                        var table_row_main = document.createElement("div");
                                                                        table_row_main.setAttribute("class", "row");
                                                                        table_row_main.setAttribute("id", "tablemainrow" + view);
                                                                        //                                                                        hold_all.appendChild(table_row_main);
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
                                                                        var table_head_title_Supplier = document.createElement("th");
                                                                        table_head_title_Supplier.innerHTML = "Supplier";
                                                                        table_head_row.appendChild(table_head_title_Supplier);
                                                                        var table_head_title_Product = document.createElement("th");
                                                                        table_head_title_Product.innerHTML = "Product";
                                                                        table_head_row.appendChild(table_head_title_Product);
                                                                        var table_head_title_OpeningStockQty = document.createElement("th");
                                                                        table_head_title_OpeningStockQty.innerHTML = "Opening Stock Qty";
                                                                        table_head_row.appendChild(table_head_title_OpeningStockQty);
                                                                        var table_head_title_PurchasedQty = document.createElement("th");
                                                                        table_head_title_PurchasedQty.innerHTML = "Purchased Qty";
                                                                        table_head_row.appendChild(table_head_title_PurchasedQty);
                                                                        var table_head_title_unitprice = document.createElement("th");
                                                                        table_head_title_unitprice.innerHTML = "Purchased Unit Price";
                                                                        table_head_row.appendChild(table_head_title_unitprice);
                                                                        var table_head_title_TotalQty = document.createElement("th");
                                                                        table_head_title_TotalQty.innerHTML = "Total Qty";
                                                                        table_head_row.appendChild(table_head_title_TotalQty);
                                                                        var table_head_title_PurchasedAmount = document.createElement("th");
                                                                        table_head_title_PurchasedAmount.innerHTML = "Purchased Amount";
                                                                        table_head_row.appendChild(table_head_title_PurchasedAmount);
                                                                        //                                                           tablehead
                                                                        //                                                            tablebody
                                                                        var tbody = document.createElement("tbody");
                                                                        table.appendChild(tbody);

                                                                        for (var i = 0; i < jsonarray.length; i++) {

                                                                            var tbody_tr = document.createElement("tr");
                                                                            tbody.appendChild(tbody_tr);
                                                                            var tbody_td_no = document.createElement("td");
                                                                            tbody_tr.appendChild(tbody_td_no);
                                                                            tbody_td_no.innerHTML = jsonarray[i].count;
                                                                            var tbody_td_supplier = document.createElement("td");
                                                                            tbody_tr.appendChild(tbody_td_supplier);
                                                                            tbody_td_supplier.innerHTML = jsonarray[i].fullname;
                                                                            var tbody_td_product = document.createElement("td");
                                                                            tbody_tr.appendChild(tbody_td_product);
                                                                            tbody_td_product.innerHTML = jsonarray[i].itemname;
                                                                            var tbody_td_osq = document.createElement("td");
                                                                            tbody_tr.appendChild(tbody_td_osq);
                                                                            tbody_td_osq.innerHTML = jsonarray[i].grnopenstock;
                                                                            var tbody_td_pq = document.createElement("td");
                                                                            tbody_tr.appendChild(tbody_td_pq);
                                                                            tbody_td_pq.innerHTML = jsonarray[i].qtyg;
                                                                            var tbody_td_up = document.createElement("td");
                                                                            tbody_tr.appendChild(tbody_td_up);
                                                                            tbody_td_up.innerHTML = jsonarray[i].buyingprice;
                                                                            var tbody_td_tq = document.createElement("td");
                                                                            tbody_tr.appendChild(tbody_td_tq);
                                                                            tbody_td_tq.innerHTML = jsonarray[i].TotalQty;
                                                                            var tbody_td_pa = document.createElement("td");
                                                                            tbody_tr.appendChild(tbody_td_pa);
                                                                            tbody_td_pa.innerHTML = jsonarray[i].total;
                                                                            megatotal = jsonarray[i].mtotal;
                                                                            //                                                            tablebody
                                                                        }
                                                                        //                                                               tablefooter
                                                                        var tfooter = document.createElement("tfoot");
                                                                        table.appendChild(tfooter);
                                                                        var tfooter_row = document.createElement("tr");
                                                                        tfooter.appendChild(tfooter_row);
                                                                        var tfooter_row_td_total = document.createElement("td");
                                                                        tfooter_row_td_total.setAttribute("class", "text-right");
                                                                        tfooter_row_td_total.setAttribute("colspan", "7");
                                                                        tfooter_row_td_total.innerHTML = "Total:";
                                                                        tfooter_row.appendChild(tfooter_row_td_total);

                                                                        var tfooter_row_td_total_val = document.createElement("td");
                                                                        tfooter_row_td_total_val.innerHTML = megatotal;
                                                                        tfooter_row.appendChild(tfooter_row_td_total_val);
                                                                        //                                                               tablefooter

                                                                        //                                                        table
                                                                        holdtable.appendChild(table_row_main);

                                                                    }
                                                                };
                                                                req.open("GET", "backgroundworks/reportexpand.php?reportby=" + reportby + "&to=" + view, true);
                                                                req.send();

                                                            }
                                                        } else {
                                                            hidden.value = "hidden";
                                                            icon.removeAttribute("class");
                                                            icon.setAttribute("class", "typcn typcn-arrow-sorted-down d-md-flex justify-content-md-end align-items-md-start");
                                                            holdtable.removeChild(document.getElementById("tablemainrow" + view));

                                                        }
                                                    }
                                                    function mc() {
                                                        document.getElementById("main").innerHTML = "";
                                                    }

                                                    function yearchng(y) {
                                                        var yr = document.getElementById("year");
                                                        var reportby = document.getElementById("reportby").value;

                                                        var viewb = document.getElementById("view");
                                                        var month = document.getElementById("month");
                                                        var today = new Date();
                                                        var cu_month = today.getMonth() + 1;
                                                        var cu_year = today.getFullYear();
                                                        if (y === "from" || y === "method") {
                                                            document.getElementById("main").innerHTML = "";

                                                            if (reportby === "Daily") {
                                                                var req = new XMLHttpRequest();
                                                                req.onreadystatechange = function () {
                                                                    if (req.readyState === 4 && req.status === 200) {
                                                                        if (this.responseText === "no months") {
                                                                            month.innerHTML = "";
                                                                            viewb.setAttribute("style", "display:none;");
                                                                        } else {
                                                                            viewb.setAttribute("style", "display:inline;");
                                                                            var json = JSON.parse(this.responseText);
                                                                            month.innerHTML = "";
                                                                            //                                                                                alert(y + "0"+cu_month + cu_year);
                                                                            for (var i = 0; i < json.length; i++) {
                                                                                var opt = document.createElement("option");
                                                                                opt.value = json[i];
                                                                                opt.innerHTML = json[i];

                                                                                if (json[i] == "0" + cu_month) {
                                                                                    opt.setAttribute("selected", "");
                                                                                }

                                                                                month.appendChild(opt);
                                                                            }
                                                                        }
                                                                    }
                                                                };

                                                                req.open("GET", "backgroundworks/changingyear.php?from=yr&y=" + yr.value, true);
                                                                req.send();
                                                            }
                                                        } else {

                                                            if (reportby === "Monthly") {
                                                                var req = new XMLHttpRequest();
                                                                req.onreadystatechange = function () {
                                                                    if (req.readyState === 4 && req.status === 200) {
                                                                        if (this.responseText === "no years") {
                                                                            yr.innerHTML = "";
                                                                            viewb.setAttribute("style", "display:none;");
                                                                        } else {
                                                                            //                                                                alert(this.responseText);
                                                                            viewb.setAttribute("style", "display:inline;");
                                                                            var json = JSON.parse(this.responseText);
                                                                            yr.innerHTML = "";
                                                                            for (var i = 0; i < json.length; i++) {
                                                                                var opt1 = document.createElement("option");
                                                                                opt1.value = json[i];
                                                                                opt1.innerHTML = json[i];
                                                                                if (yr.value === cu_year) {

                                                                                    opt1.setAttribute("selected", "");

                                                                                }
                                                                                yr.appendChild(opt1);
                                                                            }
                                                                        }
                                                                    }
                                                                };

                                                                req.open("GET", "backgroundworks/changingyear.php?viewby=monthly", true);
                                                                req.send();
                                                            }

                                                        }
                                                    }

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



                                                    }

                                                    function reportby() {
                                                        var reportby = document.getElementById("reportby").value;
                                                        var viewby = document.getElementById("viewby");
                                                        var today = document.getElementById("today");
                                                        var main = document.getElementById("main");
                                                        var month = document.getElementById("month");
                                                        var slce = document.getElementById("slce");
                                                        var year = document.getElementById("year");
                                                        if (reportby === "Today") {
                                                            location.reload();
                                                        } else {
                                                            viewby.removeAttribute("style");
                                                            today.setAttribute("style", "display:none;");
                                                            if (reportby === "Daily") {
                                                                month.setAttribute("style", "display:d-inline;");
                                                                slce.setAttribute("style", "display:d-inline;");
                                                                year.setAttribute("style", "display:d-inline;");

                                                                viewby.removeAttribute("style");

                                                                yearchng('method');
                                                                view();

                                                            } else if (reportby === "Monthly") {
                                                                month.setAttribute("style", "display:none;");
                                                                slce.setAttribute("style", "display:none;");
                                                                year.setAttribute("style", "display:d-inline;");

                                                                viewby.removeAttribute("style");
                                                                yearchng('x');
                                                                view();

                                                            } else if (reportby === "Yearly") {
                                                                month.setAttribute("style", "display:none;");
                                                                slce.setAttribute("style", "display:none;");
                                                                year.setAttribute("style", "display:none;");
                                                                viewby.setAttribute("style", "display:none;");
                                                                var req = new XMLHttpRequest();

                                                                req.onreadystatechange = function () {
                                                                    if (this.readyState === 4 && this.status === 200) {
                                                                        main.innerHTML = "";
                                                                        //                                                                        alert(req.responseText);
                                                                        if (req.responseText !== "nomatch") {
                                                                            var json = JSON.parse(req.responseText);
                                                                            var date = "";
                                                                            for (var i = 0; json.length > i; i++) {
                                                                                //                alert bar
                                                                                if (date != json[i]) {
                                                                                    date = json[i];
                                                                                    var hold_all = document.createElement("div");
                                                                                    var alert_row_main = document.createElement("div");
                                                                                    alert_row_main.setAttribute("class", "row");
                                                                                    hold_all.appendChild(alert_row_main);
                                                                                    hold_all.setAttribute("onclick", "show('" + json[i] + "')");
                                                                                    var alert_col_main = document.createElement("div");
                                                                                    alert_col_main.setAttribute("class", "col");
                                                                                    var alert_div_main = document.createElement("div");
                                                                                    alert_div_main.setAttribute("class", "alert alert-danger border rounded d-md-flex justify-content-md-start align-items-md-center");
                                                                                    alert_div_main.setAttribute("role", "alert");
                                                                                    alert_div_main.setAttribute("style", "height: 29px;");

                                                                                    var span_date = document.createElement("span");
                                                                                    span_date.innerHTML = json[i];
                                                                                    alert_div_main.appendChild(span_date);
                                                                                    var drop_icon = document.createElement("i");
                                                                                    drop_icon.setAttribute("id", "icon" + json[i]);
                                                                                    drop_icon.setAttribute("class", "typcn typcn-arrow-sorted-down d-md-flex justify-content-md-end align-items-md-start");
                                                                                    alert_div_main.appendChild(drop_icon);

                                                                                    alert_col_main.appendChild(alert_div_main);
                                                                                    alert_row_main.appendChild(alert_col_main);

                                                                                    var hold_table = document.createElement("div");
                                                                                    hold_table.setAttribute("id", "holdtable" + json[i]);
                                                                                    hold_all.appendChild(hold_table);

                                                                                    var hidden = document.createElement("input");
                                                                                    hidden.type = "hidden";
                                                                                    hidden.value = "hidden";
                                                                                    hidden.setAttribute("id", "hidden" + json[i]);
                                                                                    hold_table.appendChild(hidden);

                                                                                    //                                                        alert bar
                                                                                    main.appendChild(hold_all);
                                                                                }
                                                                            }
                                                                        } else {
                                                                            //nomatch
                                                                            //                                                    Nothing Puchased
                                                                            main.innerHTML = "";
                                                                            var nprow = document.createElement("div");
                                                                            var npcol = document.createElement("div");
                                                                            npcol.setAttribute("class", "col");
                                                                            nprow.appendChild(npcol);
                                                                            var nph1 = document.createElement("h1");
                                                                            nph1.setAttribute("class", "display-4");
                                                                            nph1.innerHTML = "You didn't purchase anything";
                                                                            npcol.appendChild(nph1);
                                                                            main.appendChild(nprow);
                                                                            //                                                    Nothing Puchased
                                                                        }



                                                                    }
                                                                };

                                                                req.open("GET", "backgroundworks/purchasereport.php?reportby=" + reportby, true);
                                                                req.send();
                                                            }
                                                        }
                                                    }

                                                    function view() {
                                                        var reportby = document.getElementById("reportby").value;
                                                        var viewby = document.getElementById("viewby");
                                                        var today = document.getElementById("today");
                                                        var main = document.getElementById("main");
                                                        var month = document.getElementById("month");
                                                        var slce = document.getElementById("slce");
                                                        var year = document.getElementById("year");

                                                        viewby.removeAttribute("style");
                                                        today.setAttribute("style", "display:none;");
                                                        if (reportby === "Daily") {
                                                            month.setAttribute("style", "display:d-inline;");
                                                            slce.setAttribute("style", "display:d-inline;");
                                                            year.setAttribute("style", "display:d-inline;");
                                                            var s_month = month.value;
                                                            var s_year = year.value;
                                                            viewby.removeAttribute("style");

                                                            var req = new XMLHttpRequest();

                                                            req.onreadystatechange = function () {
                                                                if (this.readyState === 4 && this.status === 200) {
                                                                    main.innerHTML = "";
                                                                    //                                                                    alert(req.responseText);
                                                                    if (req.responseText !== "nomatch") {
                                                                        var json = JSON.parse(req.responseText);
                                                                        var date = "";
                                                                        for (var i = 0; json.length > i; i++) {
                                                                            //                alert bar
                                                                            if (date != json[i]) {
                                                                                date = json[i];
                                                                                var hold_all = document.createElement("div");
                                                                                var alert_row_main = document.createElement("div");
                                                                                alert_row_main.setAttribute("class", "row");
                                                                                hold_all.appendChild(alert_row_main);
                                                                                hold_all.setAttribute("onclick", "show('" + json[i] + "')");
                                                                                var alert_col_main = document.createElement("div");
                                                                                alert_col_main.setAttribute("class", "col");
                                                                                var alert_div_main = document.createElement("div");
                                                                                alert_div_main.setAttribute("class", "alert alert-danger border rounded d-md-flex justify-content-md-start align-items-md-center");
                                                                                alert_div_main.setAttribute("role", "alert");
                                                                                alert_div_main.setAttribute("style", "height: 29px;");

                                                                                var span_date = document.createElement("span");
                                                                                span_date.innerHTML = json[i];
                                                                                alert_div_main.appendChild(span_date);
                                                                                var drop_icon = document.createElement("i");
                                                                                drop_icon.setAttribute("id", "icon" + json[i]);
                                                                                drop_icon.setAttribute("class", "typcn typcn-arrow-sorted-down d-md-flex justify-content-md-end align-items-md-start");
                                                                                alert_div_main.appendChild(drop_icon);

                                                                                alert_col_main.appendChild(alert_div_main);
                                                                                alert_row_main.appendChild(alert_col_main);

                                                                                var hold_table = document.createElement("div");
                                                                                hold_table.setAttribute("id", "holdtable" + json[i]);
                                                                                hold_all.appendChild(hold_table);

                                                                                var hidden = document.createElement("input");
                                                                                hidden.type = "hidden";
                                                                                hidden.value = "hidden";
                                                                                hidden.setAttribute("id", "hidden" + json[i]);
                                                                                hold_table.appendChild(hidden);

                                                                                //                                                        alert bar
                                                                                main.appendChild(hold_all);
                                                                            }
                                                                        }
                                                                    } else {
                                                                        //nomatch
                                                                        //                                                    Nothing Puchased
                                                                        main.innerHTML = "";
                                                                        var nprow = document.createElement("div");
                                                                        var npcol = document.createElement("div");
                                                                        npcol.setAttribute("class", "col");
                                                                        nprow.appendChild(npcol);
                                                                        var nph1 = document.createElement("h1");
                                                                        nph1.setAttribute("class", "display-4");
                                                                        nph1.innerHTML = "You didn't purchase anything";
                                                                        npcol.appendChild(nph1);
                                                                        main.appendChild(nprow);
                                                                        //                                                    Nothing Puchased
                                                                    }

                                                                }
                                                            };

                                                            req.open("GET", "backgroundworks/purchasereport.php?reportby=" + reportby + "&s_month=" + s_month + "&s_year=" + s_year, true);
                                                            req.send();

                                                        } else if (reportby === "Monthly") {
                                                            var s_year = year.value;
                                                            month.setAttribute("style", "display:none;");
                                                            slce.setAttribute("style", "display:none;");
                                                            year.setAttribute("style", "display:d-inline;");

                                                            viewby.removeAttribute("style");
                                                            var req = new XMLHttpRequest();

                                                            req.onreadystatechange = function () {
                                                                if (this.readyState === 4 && this.status === 200) {
                                                                    main.innerHTML = "";
                                                                    if (req.responseText !== "nomatch") {
                                                                        var json = JSON.parse(req.responseText);
                                                                        var date = "";
                                                                        for (var i = 0; json.length > i; i++) {
                                                                            //                alert bar
                                                                            if (date != json[i]) {
                                                                                date = json[i];
                                                                                var hold_all = document.createElement("div");
                                                                                var alert_row_main = document.createElement("div");
                                                                                alert_row_main.setAttribute("class", "row");
                                                                                hold_all.appendChild(alert_row_main);
                                                                                hold_all.setAttribute("onclick", "show('" + s_year + "-" + json[i] + "')");
                                                                                var alert_col_main = document.createElement("div");
                                                                                alert_col_main.setAttribute("class", "col");
                                                                                var alert_div_main = document.createElement("div");
                                                                                alert_div_main.setAttribute("class", "alert alert-danger border rounded d-md-flex justify-content-md-start align-items-md-center");
                                                                                alert_div_main.setAttribute("role", "alert");
                                                                                alert_div_main.setAttribute("style", "height: 29px;");

                                                                                var span_date = document.createElement("span");
                                                                                span_date.innerHTML = s_year + "-" + json[i];
                                                                                alert_div_main.appendChild(span_date);
                                                                                var drop_icon = document.createElement("i");
                                                                                drop_icon.setAttribute("id", "icon" + s_year + "-" + json[i]);
                                                                                drop_icon.setAttribute("class", "typcn typcn-arrow-sorted-down d-md-flex justify-content-md-end align-items-md-start");
                                                                                alert_div_main.appendChild(drop_icon);

                                                                                alert_col_main.appendChild(alert_div_main);
                                                                                alert_row_main.appendChild(alert_col_main);

                                                                                var hold_table = document.createElement("div");
                                                                                hold_table.setAttribute("id", "holdtable" + s_year + "-" + json[i]);
                                                                                hold_all.appendChild(hold_table);

                                                                                var hidden = document.createElement("input");
                                                                                hidden.type = "hidden";
                                                                                hidden.value = "hidden";
                                                                                hidden.setAttribute("id", "hidden" + s_year + "-" + json[i]);
                                                                                hold_table.appendChild(hidden);

                                                                                //                                                        alert bar
                                                                                main.appendChild(hold_all);
                                                                            }
                                                                        }
                                                                    } else {
                                                                        //nomatch
                                                                        //                                                    Nothing Puchased
                                                                        main.innerHTML = "";
                                                                        var nprow = document.createElement("div");
                                                                        var npcol = document.createElement("div");
                                                                        npcol.setAttribute("class", "col");
                                                                        nprow.appendChild(npcol);
                                                                        var nph1 = document.createElement("h1");
                                                                        nph1.setAttribute("class", "display-4");
                                                                        nph1.innerHTML = "You didn't purchase anything";
                                                                        npcol.appendChild(nph1);
                                                                        main.appendChild(nprow);
                                                                        //                                                    Nothing Puchased
                                                                    }



                                                                }
                                                            };

                                                            req.open("GET", "backgroundworks/purchasereport.php?reportby=" + reportby + "&s_year=" + s_year, true);
                                                            req.send();
                                                        } else if (reportby === "Yearly") {
                                                            month.setAttribute("style", "display:none;");
                                                            slce.setAttribute("style", "display:none;");
                                                            year.setAttribute("style", "display:none;");
                                                            viewby.setAttribute("style", "display:none;");

                                                        }

                                                    }

            </script>



        </body>
    </html>
<?php } ?>