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
                                <div class="col-12">
                                    <div class="card-box">
                                        <h4 class="m-t-0 header-title">Balance Sheet</h4>
                                        <p class="text-muted m-b-30 font-14">

                                        </p>

                                        <div class="row" id="reportforrow">
                                            <div class="col-md-3">
                                                <label>Report For:&nbsp;</label>
                                                <select id="reportfor" onchange="reportfor();">


                                                    <option value="Monthly">Monthly</option>
                                                    <option value="Yearly">Yearly</option>
                                                </select>
                                            </div>
                                            <div class="col-6" id="selmonth">
                                                <?php
                                                $thmx = date("m");
                                                $thyx = date("Y");
                                                $y_mx = $thy . "-" . $thm;
                                                $dam = mysqli_query($con, "select * from grn g where g.date like '$thyx%' ");
                                                $dam1 = mysqli_query($con, "select * from grn g where g.date  ");

                                                $mon_arrx = array();
                                                $y_arrx = array();
                                                while ($monn = mysqli_fetch_array($dam)) {
                                                    array_push($mon_arrx, explode("-", $monn['date'])[1]);
                                                }
                                                while ($monn = mysqli_fetch_array($dam1)) {

                                                    array_push($y_arrx, explode("-", $monn['date'])[0]);
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

                                        <div class="row">
                                            <div class="col" id="main">

                                            </div>
                                        </div>

                                        <!-- end row -->

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

                                                    function reportfor() {
                                                        var reportfor = document.getElementById("reportfor").value;
                                                        var selmonth = document.getElementById("selmonth");
                                                        var month = document.getElementById("month");
                                                        var year = document.getElementById("year");
                                                        var slce = document.getElementById("slce");
                                                        var main = document.getElementById("main");
                                                        if (reportfor == "Monthly") {
                                                            selmonth.style = "display:inline;";
                                                            month.style = "display:inline;";
                                                            slce.style = "display:inline;";
                                                            main.innerHTML = "";


                                                        } else if (reportfor == "Yearly") {
                                                            selmonth.style = "display:inline;";
                                                            month.style = "display:none;";
                                                            slce.style = "display:none;";
                                                            main.innerHTML = "";

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
                                                                //alert(req.responseText);
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
                                                        req.open("GET", "backgroundworks/balsheet_yr_change.php?repfor=" + reportfor + "&year=" + m, true);
                                                        req.send();
                                                    }

                                                    function view() {

                                                        var main = document.getElementById("main");
                                                        main.innerHTML = "";
                                                        var reportfor = document.getElementById("reportfor").value;
                                                        var selmonth = document.getElementById("selmonth");
                                                        var month = document.getElementById("month");
                                                        var year = document.getElementById("year");
                                                        var slce = document.getElementById("slce");
                                                        var main = document.getElementById("main");
                                                        if (reportfor == "Monthly") {
                                                            var req = new XMLHttpRequest();
                                                            req.onreadystatechange = function () {
                                                                if (req.readyState === 4 && req.status === 200) {
                                                                    //alert(req.responseText);

                                                                    var json = JSON.parse(req.responseText);

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
                                                                    table_head_title_Product.innerHTML = "";
                                                                    table_head_row.appendChild(table_head_title_Product);
                                                                    var table_head_title_OpeningStockQty = document.createElement("th");
                                                                    table_head_title_OpeningStockQty.innerHTML = "";
                                                                    table_head_row.appendChild(table_head_title_OpeningStockQty);

                                                                    var table_head_title_PurchasedQty = document.createElement("th");
                                                                    table_head_title_PurchasedQty.innerHTML = "";
                                                                    table_head_row.appendChild(table_head_title_PurchasedQty);
    //                                                        var table_head_title_TotalQty = document.createElement("th");
    //                                                        table_head_title_TotalQty.innerHTML = "Total Qty";
    //                                                        table_head_row.appendChild(table_head_title_TotalQty);
    //                                                        var table_head_title_PurchasedAmount = document.createElement("th");
    //                                                        table_head_title_PurchasedAmount.innerHTML = "Purchased Amount";
    //                                                        table_head_row.appendChild(table_head_title_PurchasedAmount);
                                                                    //                                                           tablehead
                                                                    //                                                           
                                                                    //                                                            tablebody
                                                                    var tbody = document.createElement("tbody");
                                                                    table.appendChild(tbody);
                                                                    var pur = 0;
                                                                    var sna = 0;
                                                                    for (var i = 0; i < json.length; i++) {

                                                                        var tbody_tr1 = document.createElement("tr");
                                                                        tbody.appendChild(tbody_tr1);
                                                                        var tbody_td_no1 = document.createElement("td");
                                                                        tbody_tr1.appendChild(tbody_td_no1);
                                                                        tbody_td_no1.innerHTML = i + 1;
                                                                        var tbody_td_product1 = document.createElement("th");
                                                                        tbody_tr1.appendChild(tbody_td_product1);
                                                                        tbody_td_product1.innerHTML = json[i].Name;
                                                                        var tbody_td_osq1 = document.createElement("td");
                                                                        tbody_tr1.appendChild(tbody_td_osq1);
                                                                        tbody_td_osq1.innerHTML = "";
                                                                        var tbody_td_pq1 = document.createElement("td");
                                                                        tbody_tr1.appendChild(tbody_td_pq1);
                                                                        tbody_td_pq1.innerHTML = "";

                                                                        var tbody_tr2 = document.createElement("tr");
                                                                        tbody.appendChild(tbody_tr2);
                                                                        var tbody_td_no2 = document.createElement("td");
                                                                        tbody_tr2.appendChild(tbody_td_no2);
                                                                        tbody_td_no2.innerHTML = "";
                                                                        var tbody_td_product2 = document.createElement("td");
                                                                        tbody_tr2.appendChild(tbody_td_product2);
                                                                        tbody_td_product2.innerHTML = "Purchased";
                                                                        var tbody_td_osq2 = document.createElement("td");
                                                                        tbody_tr2.appendChild(tbody_td_osq2);
                                                                        tbody_td_osq2.innerHTML = "";
                                                                        var tbody_td_pq2 = document.createElement("td");
                                                                        tbody_tr2.appendChild(tbody_td_pq2);
                                                                        tbody_td_pq2.innerHTML = json[i].total;

                                                                        var tbody_tr3 = document.createElement("tr");
                                                                        tbody.appendChild(tbody_tr3);
                                                                        var tbody_td_no3 = document.createElement("td");
                                                                        tbody_tr3.appendChild(tbody_td_no3);
                                                                        tbody_td_no3.innerHTML = "";
                                                                        var tbody_td_product3 = document.createElement("td");
                                                                        tbody_tr3.appendChild(tbody_td_product3);
                                                                        tbody_td_product3.innerHTML = "Sold";
                                                                        var tbody_td_osq3 = document.createElement("td");
                                                                        tbody_tr3.appendChild(tbody_td_osq3);
                                                                        tbody_td_osq3.innerHTML = json[i].sold;
                                                                        var tbody_td_pq3 = document.createElement("td");
                                                                        tbody_tr3.appendChild(tbody_td_pq3);
                                                                        tbody_td_pq3.innerHTML = "";

                                                                        var tbody_tr4 = document.createElement("tr");
                                                                        tbody.appendChild(tbody_tr4);
                                                                        var tbody_td_no4 = document.createElement("td");
                                                                        tbody_tr4.appendChild(tbody_td_no4);
                                                                        tbody_td_no4.innerHTML = "";
                                                                        var tbody_td_product4 = document.createElement("td");
                                                                        tbody_tr4.appendChild(tbody_td_product4);
                                                                        tbody_td_product4.innerHTML = "Available";
                                                                        var tbody_td_osq4 = document.createElement("td");
                                                                        tbody_tr4.appendChild(tbody_td_osq4);
                                                                        tbody_td_osq4.innerHTML = json[i].available;
                                                                        var tbody_td_pq4 = document.createElement("td");
                                                                        tbody_tr4.appendChild(tbody_td_pq4);
                                                                        tbody_td_pq4.innerHTML = "";
                                                                        pur = pur + Number(json[i].total);
                                                                        sna = sna + Number(json[i].sold) + Number(json[i].available);

                                                                    }
                                                                    //                                                            tablebody

                                                                    //                                                               tablefooter
                                                                    var tfooter = document.createElement("tfoot");
                                                                    table.appendChild(tfooter);
                                                                    var tfooter_row = document.createElement("tr");
                                                                    tfooter.appendChild(tfooter_row);
                                                                    var tfooter_row_td_total = document.createElement("td");
                                                                    tfooter_row_td_total.setAttribute("class", "text-right");
                                                                    tfooter_row_td_total.setAttribute("colspan", "2");
                                                                    tfooter_row_td_total.innerHTML = "Final:";
                                                                    tfooter_row.appendChild(tfooter_row_td_total);

                                                                    var tfooter_row_td_total_val = document.createElement("td");
                                                                    tfooter_row_td_total_val.innerHTML = sna;
                                                                    tfooter_row.appendChild(tfooter_row_td_total_val);

                                                                    var tfooter_row_td_total_val1 = document.createElement("td");
                                                                    tfooter_row_td_total_val1.innerHTML = pur;
                                                                    tfooter_row.appendChild(tfooter_row_td_total_val1);
                                                                    //                                                               tablefooter
                                                                    main.appendChild(table_row_main);

                                                                }
                                                            };
                                                            req.open("GET", "backgroundworks/balsheet_data.php?reportfor=" + reportfor + "&mon=" + month.value + "&yea=" + year.value, true);
                                                            req.send();
                                                        } else if (reportfor == "Yearly") {
                                                            var req = new XMLHttpRequest();
                                                            req.onreadystatechange = function () {
                                                                if (req.readyState === 4 && req.status === 200) {
//                                                                    //alert(req.responseText);
                                                                    var json = JSON.parse(req.responseText);

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
                                                                    table_head_title_Product.innerHTML = "";
                                                                    table_head_row.appendChild(table_head_title_Product);
                                                                    var table_head_title_OpeningStockQty = document.createElement("th");
                                                                    table_head_title_OpeningStockQty.innerHTML = "";
                                                                    table_head_row.appendChild(table_head_title_OpeningStockQty);

                                                                    var table_head_title_PurchasedQty = document.createElement("th");
                                                                    table_head_title_PurchasedQty.innerHTML = "";
                                                                    table_head_row.appendChild(table_head_title_PurchasedQty);
    //                                                        var table_head_title_TotalQty = document.createElement("th");
    //                                                        table_head_title_TotalQty.innerHTML = "Total Qty";
    //                                                        table_head_row.appendChild(table_head_title_TotalQty);
    //                                                        var table_head_title_PurchasedAmount = document.createElement("th");
    //                                                        table_head_title_PurchasedAmount.innerHTML = "Purchased Amount";
    //                                                        table_head_row.appendChild(table_head_title_PurchasedAmount);
                                                                    //                                                           tablehead
                                                                    //                                                           
                                                                    //                                                            tablebody
                                                                    var tbody = document.createElement("tbody");
                                                                    table.appendChild(tbody);
                                                                    var pur = 0;
                                                                    var sna = 0;
                                                                    for (var i = 0; i < json.length; i++) {

                                                                        var tbody_tr1 = document.createElement("tr");
                                                                        tbody.appendChild(tbody_tr1);
                                                                        var tbody_td_no1 = document.createElement("td");
                                                                        tbody_tr1.appendChild(tbody_td_no1);
                                                                        tbody_td_no1.innerHTML = i + 1;
                                                                        var tbody_td_product1 = document.createElement("th");
                                                                        tbody_tr1.appendChild(tbody_td_product1);
                                                                        tbody_td_product1.innerHTML = json[i].Name;
                                                                        var tbody_td_osq1 = document.createElement("td");
                                                                        tbody_tr1.appendChild(tbody_td_osq1);
                                                                        tbody_td_osq1.innerHTML = "";
                                                                        var tbody_td_pq1 = document.createElement("td");
                                                                        tbody_tr1.appendChild(tbody_td_pq1);
                                                                        tbody_td_pq1.innerHTML = "";

                                                                        var tbody_tr2 = document.createElement("tr");
                                                                        tbody.appendChild(tbody_tr2);
                                                                        var tbody_td_no2 = document.createElement("td");
                                                                        tbody_tr2.appendChild(tbody_td_no2);
                                                                        tbody_td_no2.innerHTML = "";
                                                                        var tbody_td_product2 = document.createElement("td");
                                                                        tbody_tr2.appendChild(tbody_td_product2);
                                                                        tbody_td_product2.innerHTML = "Purchased";
                                                                        var tbody_td_osq2 = document.createElement("td");
                                                                        tbody_tr2.appendChild(tbody_td_osq2);
                                                                        tbody_td_osq2.innerHTML = "";
                                                                        var tbody_td_pq2 = document.createElement("td");
                                                                        tbody_tr2.appendChild(tbody_td_pq2);
                                                                        tbody_td_pq2.innerHTML = json[i].total;

                                                                        var tbody_tr3 = document.createElement("tr");
                                                                        tbody.appendChild(tbody_tr3);
                                                                        var tbody_td_no3 = document.createElement("td");
                                                                        tbody_tr3.appendChild(tbody_td_no3);
                                                                        tbody_td_no3.innerHTML = "";
                                                                        var tbody_td_product3 = document.createElement("td");
                                                                        tbody_tr3.appendChild(tbody_td_product3);
                                                                        tbody_td_product3.innerHTML = "Sold";
                                                                        var tbody_td_osq3 = document.createElement("td");
                                                                        tbody_tr3.appendChild(tbody_td_osq3);
                                                                        tbody_td_osq3.innerHTML = json[i].sold;
                                                                        var tbody_td_pq3 = document.createElement("td");
                                                                        tbody_tr3.appendChild(tbody_td_pq3);
                                                                        tbody_td_pq3.innerHTML = "";

                                                                        var tbody_tr4 = document.createElement("tr");
                                                                        tbody.appendChild(tbody_tr4);
                                                                        var tbody_td_no4 = document.createElement("td");
                                                                        tbody_tr4.appendChild(tbody_td_no4);
                                                                        tbody_td_no4.innerHTML = "";
                                                                        var tbody_td_product4 = document.createElement("td");
                                                                        tbody_tr4.appendChild(tbody_td_product4);
                                                                        tbody_td_product4.innerHTML = "Available";
                                                                        var tbody_td_osq4 = document.createElement("td");
                                                                        tbody_tr4.appendChild(tbody_td_osq4);
                                                                        tbody_td_osq4.innerHTML = json[i].available;
                                                                        var tbody_td_pq4 = document.createElement("td");
                                                                        tbody_tr4.appendChild(tbody_td_pq4);
                                                                        tbody_td_pq4.innerHTML = "";
                                                                        pur = pur + Number(json[i].total);
                                                                        sna = sna + Number(json[i].sold) + Number(json[i].available);

                                                                    }
                                                                    //                                                            tablebody

                                                                    //                                                               tablefooter
                                                                    var tfooter = document.createElement("tfoot");
                                                                    table.appendChild(tfooter);
                                                                    var tfooter_row = document.createElement("tr");
                                                                    tfooter.appendChild(tfooter_row);
                                                                    var tfooter_row_td_total = document.createElement("td");
                                                                    tfooter_row_td_total.setAttribute("class", "text-right");
                                                                    tfooter_row_td_total.setAttribute("colspan", "2");
                                                                    tfooter_row_td_total.innerHTML = "Final:";
                                                                    tfooter_row.appendChild(tfooter_row_td_total);

                                                                    var tfooter_row_td_total_val = document.createElement("td");
                                                                    tfooter_row_td_total_val.innerHTML = sna;
                                                                    tfooter_row.appendChild(tfooter_row_td_total_val);

                                                                    var tfooter_row_td_total_val1 = document.createElement("td");
                                                                    tfooter_row_td_total_val1.innerHTML = pur;
                                                                    tfooter_row.appendChild(tfooter_row_td_total_val1);
                                                                    //                                                               tablefooter
                                                                    main.appendChild(table_row_main);
                                                                }
                                                            };
                                                            req.open("GET", "backgroundworks/balsheet_data.php?reportfor=" + reportfor + "&yea=" + year.value, true);
                                                            req.send();

                                                        }
                                                    }
            </script>

        </body>
    </html>
<?php } ?>