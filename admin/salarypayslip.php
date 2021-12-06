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
            <title>Pay Slip</title>
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

        </head>


        <body onload="checking();">

            <input type="hidden" id="idtype" value="<?php echo base64_decode($_GET['emplo']); ?>">
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
                                    <div class="card-box ">

          

                                        <div class="row" id="header">
                                            <div class="col">
                                                <h3 class="text-center">Company Name</h3>
                                                <h5 class="text-center">Address</h5>
                                                <h6 class="text-center text-black-50">Salary Slip</h6>
                                                <hr>
                                            </div>
                                        </div>
                                        <?php
                                        $idtype = base64_decode($_GET['emplo']);
                                        $idz = explode("|", $idtype)[0];
                                        $typez = explode("|", $idtype)[1];
                                        $name = "";
                                        $desi = "";

                                        if ($typez == "tbladmin") {
                                            $query_l = mysqli_query($con, "Select * from tbladmin where ID=" . $idz);
                                            while ($qt = mysqli_fetch_array($query_l)) {
                                                $name = $qt['AdminName'];
                                                $desi = $qt['type'];
                                            }
                                        } else if ($typez === "tblmechanics") {
                                            $query_l1 = mysqli_query($con, "Select * from tblmechanics where ID=" . $idz);
                                            while ($qt1 = mysqli_fetch_array($query_l1)) {
                                                $name = $qt1['FullName'];
                                                $desi = "Mechanics";
                                            }
                                        }
                                        ?>
                                        <div class="row" style="padding-top: 5px;padding-left: 100px;">
                                            <div class="col">
                                                <div class="row" style="height: 28px;">
                                                    <div class="col"><label style="height: 28px;">Name:</label><label style="height: 28px;padding-left: 10px;" id="name"><?php echo $name; ?></label></div>
                                                </div>
                                                <div class="row">
                                                    <div class="col" style="height: 28px;"><label style="height: 28px;">Designation:</label><label style="height: 28px;padding-left: 10px;" id="designation"><?php echo $desi; ?></label></div>
                                                </div>
                                                <div class="row" id="monthselection">
                                                    <div class="col-md-6" style="height: 28px;"><label style="height: 28px;">Month/Year:</label>
                                                        <select class="form-control-sm" style="width: 119px;" id="month" onchange="checking();">
                                                            <?php
                                                            $mo = date('m');
                                                            for ($m = 1; $m < 13; $m++) {
                                                                if ($m == $mo) {
                                                                    ?>
                                                                    <option selected="" ><?php echo $m; ?></option>
                                                                <?php } else {
                                                                    ?>
                                                                    <option ><?php echo $m; ?></option>

                                                                    <?php
                                                                }
                                                            }
                                                            ?>
                                                        </select>
                                                        /
                                                        <label
                                                            style="height: 28px;padding-left: 10px;" id="year"><?php echo date('Y'); ?></label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row d-lg-flex justify-content-lg-start align-items-lg-start" style="padding: 27px;margin: 1px;">
                                            <div class="col d-lg-flex align-items-lg-start">
                                                <div class="table-responsive table-borderless">
                                                    <table class="table table-striped table-bordered table-hover ">
                                                        <thead>
                                                            <tr>
                                                                <th>Earnings</th>
                                                                <th>LKR</th>
                                                                <th>Deductions</th>
                                                                <th>LKR</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <tr>
                                                                <td>Basic Salary</td>
                                                                <td>
                                                                    <div class="d-table-cell"><label id="basic">15000</label></div>
                                                                </td>
                                                                <td>EPF</td>
                                                                <td>
                                                                    <div class="d-table-cell"><label id="epf">15000</label></div>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td>Allowance</td>
                                                                <td>
                                                                    <div class="d-table-cell"><input class="bg-light border rounded border-primary form-control-sm d-table-cell" type="number" autocomplete="on" required="" min="0" value="0" id="allowance" onkeyup ="alot();"></div>
                                                                </td>
                                                                <td>Petty Cash</td>
                                                                <td>
                                                                    <div class="d-table-cell"><label id="pettycash">15000</label></div>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td>O/T</td>
                                                                <td>
                                                                    <div class="d-table-cell"><input class="bg-light border rounded border-primary form-control-sm d-table-cell" type="number" autocomplete="on" min="0" required="" value="0" id="ot" onkeyup="alot();"></div>
                                                                </td>
                                                                <td></td>
                                                                <td></td>
                                                            </tr>
                                                            <tr>
                                                                <td></td>
                                                                <td></td>
                                                                <td>Total Deduction</td>
                                                                <td>
                                                                    <div class="d-table-cell"  ><label id="tdeduct">15000</label></div>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td>Gross Salary</td>
                                                                <td>
                                                                    <div class="d-table-cell"><label id="grosssalary">15000</label>
                                                                        <input type="hidden" id="grosssalary1">
                                                                    </div>
                                                                </td>
                                                                <td></td>
                                                                <td></td>
                                                            </tr>
                                                            <tr>
                                                                <td></td>
                                                                <td></td>
                                                                <td></td>
                                                                <td></td>
                                                            </tr>
                                                            <tr>
                                                                <td></td>
                                                                <td></td>
                                                                <td>Net Salary</td>
                                                                <td>
                                                                    <div class="d-table-cell"><label id="netsalary">15000</label>
                                                                        <input type="hidden" id="netsalary1">
                                                                    </div>
                                                                </td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div><br>
                                        <div class="row d-lg-flex" style="margin-left: 10px;">
                                            <div class="row" id="paid">

                                            </div>
                                            <div class="col" id="paybyselect">

                                                <div class="row">
                                                    <div class="col-md-2">
                                                        <div class="form-check"><input class="form-check-input" type="radio" id="cash" onclick="payby();" name="givenby" value="cash" checked=""><label class="form-check-label" for="cash">By Cash</label></div>
                                                    </div>
                                                    <div class="col">
                                                        <div class="form-check"><input class="form-check-input" type="radio" id="cheque" onclick="payby();" name="givenby" value="cheque"><label class="form-check-label" for="cheque">By Cheque</label></div>
                                                    </div>
                                                </div><br>
                                                <div class="row" id="chequedetail" style="display: none;">
                                                    <div class="col-md-2 col-lg-4 d-lg-flex justify-content-lg-start align-items-lg-center"><label>Cheque No: &nbsp;</label><input type="text" id="chequeno"></div>
                                                    <div class="col-lg-4 d-lg-flex justify-content-lg-start align-items-lg-center"><label class="d-lg-flex justify-content-lg-start">Name Of Bank:</label><input type="text" id="nameofbank"></div>
                                                    <div class="col-lg-4 d-lg-flex justify-content-lg-start align-items-lg-center"><label>Cheque Date:&nbsp;</label><input type="date" id="chequedate"></div>
                                                </div><br>
                                                <div class="row" id="signpart">
                                                    <div class="col-lg-3"><label>Date:&nbsp;</label><label><?php echo date('Y-m-d'); ?></label></div>
                                                    <div class="col-lg-5"><label>Signature of Employee:&nbsp;</label><label>&nbsp;___________________________</label></div>
                                                    <div class="col-lg-3"><label>Director:&nbsp;</label><label>&nbsp;_______________________</label></div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row  align-items-lg-end justify-content-lg-end d-print-none" style="margin-right: 80px;">
                                            <input class="btn btn-danger" type="button" id="relsal"  value="Release Salary" onclick="release();">
                                            <input class="btn btn-danger" type="button" id="refresh" style="margin-left: 5px; display: none;" value="Refresh" onclick="refresh();">
                                            <button class="btn btn-danger" type="button" id="printing" style="margin-left: 5px; display: inline;" onclick="window.print();" value=""><i class="fi-printer"></i></button>

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
                                                function refresh(){
                                                    location.reload();
                                                }

                                                function checking() {
                                                    var idtype = document.getElementById("idtype").value;
                                                    var basic = document.getElementById("basic");
                                                    var pettycash = document.getElementById("pettycash");
                                                    var epf = document.getElementById("epf");
                                                    var tdeduct = document.getElementById("tdeduct");
                                                    var grosssalary = document.getElementById("grosssalary");
                                                    var netsalary = document.getElementById("netsalary");
                                                    var allowance = document.getElementById("allowance");
                                                    var ot = document.getElementById("ot");
                                                    var month = document.getElementById("month").value;
                                                    var year = document.getElementById("year").innerHTML;
                                                    var relsal = document.getElementById("relsal");
                                                    var printing = document.getElementById("printing");
                                                    var refresh = document.getElementById("refresh");
                                                    var yearmonth = year + "-" + month;

                                                    var id = idtype.split("|")[0];
                                                    var type = idtype.split("|")[1];

                                                    var cash = document.getElementById("cash");
                                                    var cheque = document.getElementById("cheque");

                                                    var chequeno = document.getElementById("chequeno");
                                                    var chequedate = document.getElementById("chequedate");
                                                    var nameofbank = document.getElementById("nameofbank");

                                                    var req = new XMLHttpRequest();
                                                    req.onreadystatechange = function () {
                                                        if (req.status === 200 && req.readyState === 4) {
//                                                                alert(this.responseText);
                                                            if (this.responseText == "empty") {
                                                                relsal.style="display:inline";
                                                                refresh.style="display:none";
                                                                 printing.style = "display : none;";
                                                              ot.disabled=false;
                                                              ot.value=0;
                                                              allowance.disabled=false;
                                                              allowance.value=0;
                                                               chequeno.value= "";
                                                               nameofbank.value= "";
                                                               chequedate.value= "";
                                                               chequedate.disabled=false;
                                                               nameofbank.disabled=false;
                                                               chequeno.disabled=false;
                                                                loading();
                                                            }else{
                                                                relsal.style="display:none";
                                                                
                                                                printing.style = "display : inline;";
//                                                               alert('checking');
//                                                               alert(this.responseText);
                                                                var o=JSON.parse(this.responseText);
                                                                
                                                               basic.innerHTML= o['basicsalary'];
                                                             allowance.value=   o['allowance'];
                                                             
                                                              allowance.disabled=true;
                                                              ot.value=  o['ot'];
                                                              
                                                              ot.disabled=true;
                                                               
                                                               grosssalary.innerHTML= o['grosssalary'];
                                                              
                                                                epf.innerHTML= o['epf_empl'];
                                                                 
                                                               
                                                              pettycash.innerHTML=  o['pettycash'];
                                                               
                                                              tdeduct.innerHTML=   o['tdeduction'];
                                                               
                                                               netsalary.innerHTML= o['netsalary'];
                                                                
                                                                document.getElementById(o['paidby']).click();
                                                               chequeno.value= o['chequeno'];
                                                               nameofbank.value= o['nameofbank'];
                                                               chequedate.value= o['chequedate'];
                                                               chequedate.disabled=true;
                                                               nameofbank.disabled=true;
                                                               chequeno.disabled=true;
                                                               
                                                                
                                                            }

                                                        }
                                                    };
                                                    req.open("GET", "backgroundworks/salaryslip_checking.php?id="+id+"&type="+type+"&month="+yearmonth, true);
                                                    req.send();



                                                }

                                                function release() {
                                                    var idtype = document.getElementById("idtype").value;
                                                    var basic = document.getElementById("basic").innerHTML;
                                                    var pettycash = document.getElementById("pettycash").innerHTML;
                                                    var epf = document.getElementById("epf").innerHTML;
                                                    var tdeduct = document.getElementById("tdeduct").innerHTML;
                                                    var grosssalary = document.getElementById("grosssalary").innerHTML;
                                                    var netsalary = document.getElementById("netsalary").innerHTML;
                                                    var allowance = document.getElementById("allowance").value;
                                                    var ot = document.getElementById("ot").value;
                                                    var month = document.getElementById("month").value;
                                                    var year = document.getElementById("year").innerHTML;
                                                    var relsal = document.getElementById("relsal");
                                                    var refresh = document.getElementById("refresh");
                                                    var yearmonth = year + "-" + month;



                                                    var id = idtype.split("|")[0];
                                                    var type = idtype.split("|")[1];
                                                    var printing = document.getElementById("printing");

                                                    var cash = document.getElementById("cash");
                                                    var cheque = document.getElementById("cheque");

                                                    var jsons = "";
                                                    if (cash.checked) {
                                                        var json = {"id": id, "type": type, "basic": basic, "pettycash": pettycash, "epf": epf, "tdeduct": tdeduct, "grosssalary": grosssalary, "netsalary": netsalary, "allowance": allowance, "ot": ot, "yearmonth": yearmonth, "paidby": "cash", "chequeno": "null", "chequedate": "null", "nameofbank": "null"};
                                                        jsons = JSON.stringify(json);

                                                    } else if (cheque.checked) {
                                                        var chequeno = document.getElementById("chequeno").value;
                                                        var chequedate = document.getElementById("chequedate").value;
                                                        var nameofbank = document.getElementById("nameofbank").value;
                                                        var json = {"id": id, "type": type, "basic": basic, "pettycash": pettycash, "epf": epf, "tdeduct": tdeduct, "grosssalary": grosssalary, "netsalary": netsalary, "allowance": allowance, "ot": ot, "yearmonth": yearmonth, "paidby": "cheque", "chequeno": chequeno, "chequedate": chequedate, "nameofbank": nameofbank};
                                                        jsons = JSON.stringify(json);

                                                    }

                                                    var req = new XMLHttpRequest();
                                                    req.onreadystatechange = function () {
                                                        if (req.status === 200 && req.readyState === 4) {
                                                                checking();
                                                            if (this.responseText == "success") {
                                                                relsal.style = "display : none;";
                                                                printing.style = "display : inline;";
                                                            }
                                                        }
                                                    };
                                                    req.open("GET", "backgroundworks/salaryslip_release.php?json=" + jsons, true);
                                                    req.send();
                                                }

                                                function payby() {
                                                    var cash = document.getElementById("cash");
                                                    var cheque = document.getElementById("cheque");
                                                    var chequedetail = document.getElementById("chequedetail");

                                                    if (cash.checked) {
                                                        chequedetail.style = "display: none";
                                                    } else if (cheque.checked) {
                                                        chequedetail.removeAttribute("style");

                                                    }
                                                }

                                                function loading() {
                                                    var idtype = document.getElementById("idtype").value;
                                                    var basic = document.getElementById("basic");
                                                    var pettycash = document.getElementById("pettycash");
                                                    var epf = document.getElementById("epf");
                                                    var tdeduct = document.getElementById("tdeduct");
                                                    var grosssalary = document.getElementById("grosssalary");
                                                    var netsalary = document.getElementById("netsalary");
                                                    var grosssalary1 = document.getElementById("grosssalary1");
                                                    var netsalary1 = document.getElementById("netsalary1");

                                                    var id = idtype.split("|")[0];
                                                    var type = idtype.split("|")[1];



                                                    var req = new XMLHttpRequest();

                                                    req.onreadystatechange = function () {

                                                        if (req.status === 200 && req.readyState === 4) {
//                                                             alert('loading');
//                                                               alert(this.responseText);
                                                            var o = JSON.parse(this.responseText);
                                                            basic.innerHTML = o.basicsalary;
                                                            pettycash.innerHTML = o.pettycash;
                                                            epf.innerHTML = o.epf;
                                                            tdeduct.innerHTML = o.totaldeduction;
                                                            grosssalary.innerHTML = o.GrossSalary;
                                                            netsalary.innerHTML = o.Netsalary;
                                                            grosssalary1.value = o.GrossSalary;
                                                            netsalary1.value = o.Netsalary;
                                                        }
                                                    };

                                                    req.open("GET", "backgroundworks/salarysliploaddata.php?id=" + id + "&type=" + type, true);
                                                    req.send();

                                                }

                                                function alot() {
                                                    var grosssalary = document.getElementById("grosssalary");
                                                    var netsalary = document.getElementById("netsalary");
                                                    var grosssalary1 = document.getElementById("grosssalary1");
                                                    var netsalary1 = document.getElementById("netsalary1");
                                                    var allowance = document.getElementById("allowance").value;
                                                    var ot = document.getElementById("ot").value;

                                                    var ngr = Number(grosssalary1.value) + Number(allowance) + Number(ot);
                                                    var nns = Number(netsalary1.value) + Number(allowance) + Number(ot);
                                                    grosssalary.innerHTML = ngr;
                                                    netsalary.innerHTML = nns;


                                                }
            </script>

        </body>
    </html>
<?php } ?>