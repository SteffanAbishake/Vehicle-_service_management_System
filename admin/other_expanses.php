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


        <body onload="starter();">

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
                                        <h4 class="m-t-0 header-title">Other Expanses</h4>
                                        <p class="text-muted m-b-30 font-14">

                                        </p>



                                        <div class="row">
                                            <div class="col-md-4 d-md-flex justify-content-md-center align-items-md-center">
                                                <label>Petty Cash for:&nbsp;</label>
                                                <select class="border rounded d-inline" id="pcf" onchange="pcf();">
                                                    <option value="employee" selected="">Employee</option>
                                                    <option value="other">Other</option>
                                                </select>
                                            </div>
                                            <div class="col" id="paidto">
                                                <label>Paid To:&nbsp;</label>
                                                <select class="border rounded" id="employees" onchange="starter();">
                                                    <optgroup label="Administration">
                                                        <?php
                                                        $admins = mysqli_query($con, "SELECT * from tbladmin where status like 'Enabled'");
                                                        while ($admins_fetched = mysqli_fetch_array($admins)) {
                                                            if ($admins_fetched['AdminuserName'] != "Developer") {
                                                                ?>
                                                                <option value=<?php echo 'tbladmin|' . $admins_fetched['ID']; ?>><?php echo $admins_fetched['AdminName']; ?></option>
                                                                <?php
                                                            }
                                                        }
                                                        ?>

                                                    </optgroup>
                                                    <optgroup label="Mechanics">
                                                        <?php
                                                        $mech = mysqli_query($con, "SELECT * from tblmechanics where status like 'Enabled'");
                                                        while ($mechfetch = mysqli_fetch_array($mech)) {
                                                            ?>
                                                            <option value=<?php echo 'tblmechanics|' . $mechfetch['ID']; ?>><?php echo $mechfetch['FullName']; ?></option>
                                                        <?php }
                                                        ?>
                                                    </optgroup>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col">
                                                <hr>
                                            </div>
                                        </div>
                                        <div class="row" style="margin-left: 15px;padding: 10px; display: inline;" id="employee">
                                            <div class="col">
                                                <div class="row">
                                                    <div class="col-lg-3">
                                                        <label class="col-form-label">Date:&nbsp;</label>
                                                    </div>
                                                    <div class="col">
                                                        <label class="col-form-label" id="today"><?php echo date("Y-m-d"); ?></label>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-lg-3"><label class="col-form-label">Requested Amount(LKR):&nbsp;</label></div>
                                                    <div class="col"><input id="amount" class="border rounded" type="text" placeholder="LKR" style="width: 249px;"></div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-lg-3"><label class="col-form-label">Added to:&nbsp;</label></div>
                                                    <div class="col">
                                                        <select id="month">
                                                            <optgroup label="Select the month">
                                                                <?php
                                                                $m = date('m');
                                                                for ($x = $m; $x <= 12; $x++) {
                                                                    if ($m === $x) {
                                                                        ?>
                                                                        <option value=<?php echo $x; ?> selected=""><?php echo $x; ?></option>
                                                                    <?php } else {
                                                                        ?>

                                                                        <option value=<?php echo $x; ?> ><?php echo $x; ?></option>

                                                                        <?php
                                                                    }
                                                                }
                                                                ?>
                                                            </optgroup>
                                                        </select>
                                                        <label>/</label>
                                                        <label id="year"><?php echo date("Y"); ?></label>
                                                    </div>
                                                </div>
                                                <div class="row d-md-flex justify-content-md-end align-items-md-center">
                                                    <div class="col d-md-flex justify-content-md-end align-items-md-center">
                                                        <button class="btn btn-success" type="button" style="margin-right: 50px;" onclick="pay();">Pay</button>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col">
                                                        <h6>Petty Cash History</h6>
                                                        <div class="table-responsive">
                                                            <table class="table table-striped table-hover table-sm">
                                                                <thead>
                                                                    <tr>
                                                                        <th>No</th>
                                                                        <th>Date</th>
                                                                        <th>Amount</th>
                                                                        <th>Month</th>
                                                                        <th>Claimed from Salary</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody id="empl_tbody">
                                                                    <tr>
                                                                        <td>Cell 1</td>
                                                                        <td>Cell 2</td>
                                                                        <td>Cell 2</td>
                                                                        <td>Cell 2</td>
                                                                        <td>Cell 2</td>
                                                                    </tr>
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row" style="margin-left: 15px; padding: 10px; display: none;" id="other" >
                                            <div class="col">
                                                <div class="row">
                                                    <div class="col-lg-2"><label class="col-form-label">Date:&nbsp;</label></div>
                                                    <div class="col"><label class="col-form-label" id="today1"><?php echo date("Y-m-d "); ?></label></div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-lg-2"><label class="col-form-label">Amount(LKR):&nbsp;</label></div>
                                                    <div class="col"><input id="amount1" class="border rounded" type="text" placeholder="LKR" style="width: 250px;"></div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-lg-2"><label class="col-form-label">Reason:&nbsp;</label></div>
                                                    <div class="col"><input id="reason" class="border rounded" type="text" placeholder="Utility Bill" style="width: 250px;"></div>
                                                </div>
                                                <div class="row d-md-flex justify-content-md-end align-items-md-center">
                                                    <div class="col d-md-flex justify-content-md-end align-items-md-center"><button onclick="release();" class="btn btn-success" type="button" style="margin-right: 50px;">Release</button></div>
                                                </div>
                                                <div class="row">
                                                    <div class="col">
                                                        <h6>Petty Cash History</h6>
                                                        <div class="table-responsive">
                                                            <table class="table table-striped table-hover table-sm">
                                                                <thead>
                                                                    <tr>
                                                                        <th>No</th>
                                                                        <th>Date</th>
                                                                        <th>Amount</th>
                                                                        <th>Reason</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody id="tbody_other">
                                                                    <tr>
                                                                        <td>Cell 1</td>
                                                                        <td>Cell 2</td>
                                                                        <td>Cell 2</td>
                                                                        <td>Cell 2</td>
                                                                    </tr>
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
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

                                                        function release() {
                                                            var type = document.getElementById("pcf").value;
                                                            var amount1 = document.getElementById("amount1").value;
                                                            var reason = document.getElementById("reason").value;
                                                            var today = document.getElementById("today1").innerHTML;

                                                            var req = new XMLHttpRequest();

                                                            req.onreadystatechange = function () {
                                                                if (req.status === 200 && req.readyState === 4) {
                                                                    alert(req.responseText);
                                                                    reason.value = "";
                                                                    amount1.value = "";
                                                                    otherload();

                                                                }
                                                            };
                                                            req.open("GET", "backgroundworks/pettycash.php?type=" + type + "&amount=" + amount1 + "&reason=" + reason + "&today=" + today, true);
                                                            req.send();


                                                        }

                                                        function otherload() {
                                                            var type = document.getElementById("pcf").value;
                                                            var today = document.getElementById("today1").innerHTML;

                                                            var empl_tbody = document.getElementById("tbody_other");
                                                            empl_tbody.innerHTML = "";
                                                            var req = new XMLHttpRequest();

                                                            req.onreadystatechange = function () {
                                                                if (req.status === 200 && req.readyState === 4) {
                                                                    alert(this.responseText);
                                                                    var array1 = JSON.parse(this.responseText);
                                                                    for (var i = 0; i < array1.length; i++) {
                                                                        var tr = document.createElement("tr");
                                                                        var array2 = array1[i];
                                                                        for (var j = 0; j < array2.length; j++) {
                                                                            var td = document.createElement("td");
                                                                            td.innerHTML = array2[j];
                                                                            tr.appendChild(td);
                                                                        }
                                                                        empl_tbody.appendChild(tr);
                                                                    }

                                                                }
                                                            };

                                                            req.open("GET", "backgroundworks/pettycash_load.php?type=" + type + "&today=" + today, true);
                                                            req.send();
                                                        }

                                                        function starter() {
                                                            var type = document.getElementById("pcf").value;
                                                            var employees = document.getElementById("employees").value;
                                                            var empl_tbody = document.getElementById("empl_tbody");
                                                            empl_tbody.innerHTML = "";
                                                            var req = new XMLHttpRequest();

                                                            req.onreadystatechange = function () {
                                                                if (req.status === 200 && req.readyState === 4) {

                                                                    var array1 = JSON.parse(this.responseText);
                                                                    for (var i = 0; i < array1.length; i++) {
                                                                        var tr = document.createElement("tr");
                                                                        var array2 = array1[i];
                                                                        for (var j = 0; j < array2.length; j++) {
                                                                            var td = document.createElement("td");
                                                                            td.innerHTML = array2[j];
                                                                            tr.appendChild(td)
                                                                        }
                                                                        empl_tbody.appendChild(tr);
                                                                    }

                                                                }
                                                            };

                                                            req.open("GET", "backgroundworks/pettycash_load.php?type=" + type + "&employees=" + employees, true);
                                                            req.send();
                                                        }


                                                        function pay() {
                                                            var type = document.getElementById("pcf").value;
                                                            var employees = document.getElementById("employees").value;
                                                            var today = document.getElementById("today").innerHTML;
                                                            var month = document.getElementById("month").value;
                                                            var year = document.getElementById("year").innerHTML;
                                                            var atm = year + "-" + month;
                                                            var amount = document.getElementById("amount").value;
                                                            var claimed = "No";

                                                            var req = new XMLHttpRequest();

                                                            req.onreadystatechange = function () {
                                                                if (req.status === 200 && req.readyState === 4) {
                                                                    alert(req.responseText);
                                                                    location.reload();

                                                                }
                                                            };
                                                            req.open("GET", "backgroundworks/pettycash.php?type=" + type + "&employees=" + employees + "&today=" + today + "&atm=" + atm + "&amount=" + amount + "&claimed=" + claimed, true);
                                                            req.send();


                                                        }

                                                        function pcf() {
                                                            var pcf = document.getElementById("pcf").value;
                                                            var pt = document.getElementById("paidto");
                                                            var employee = document.getElementById("employee");
                                                            var other = document.getElementById("other");

                                                            if (pcf === "employee") {
                                                                pt.style = "display: inline;";
                                                                employee.removeAttribute("style");
                                                                other.removeAttribute("style");
                                                                other.style = "margin-left: 15px; padding: 10px; display: none;";
                                                                employee.style = "margin-left: 15px; padding: 10px; display: inline;";
                                                            } else if (pcf === "other") {
                                                                pt.style = "display: none;";
                                                                employee.removeAttribute("style");
                                                                other.removeAttribute("style");
                                                                employee.style = "margin-left: 15px; padding: 10px; display: none;";
                                                                other.style = "margin-left: 15px; padding: 10px; display: inline;";
                                                                otherload();
                                                            }

                                                        }

            </script>

        </body>
    </html>
<?php } ?>