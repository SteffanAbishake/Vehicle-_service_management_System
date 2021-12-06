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

    if (isset($_POST['submit'])) {
        $macname = $_POST['macname'];
        $mobno = $_POST['mobilenumber'];
        $basicsalary = $_POST['basicsalary'];
        $address = $_POST['macadd'];
        $mid = substr(base64_decode($_GET['mecid']), 0, -5);

        $query = mysqli_query($con, "update  tblmechanics set FullName='$macname', MobileNumber='$mobno',Email= '$email', Address='$address',BasicSalary='$basicsalary' where ID=$mid");
        if ($query) {
            $msg = "Mechanic details has been update.";
        } else {
            $msg = "Couldn't Update the Mechanic Details, Something Went Wrong. Please try agains";
        }
    }
    if (isset($_POST['Dismiss'])) {
        
        $mid = substr(base64_decode($_GET['mecid']), 0, -5);

        $query = mysqli_query($con, "update  tblmechanics set status='Disabled' where ID=$mid");
        if ($query) {
            $msg = "Mechanic has been dismissed.";
        } else {
            $msg = "Couldn't Dismiss the Mechanic, Something Went Wrong. Please try again";
        }
    }
    if (isset($_POST['Re-Join'])) {
    
        $mid = substr(base64_decode($_GET['mecid']), 0, -5);

        $query = mysqli_query($con, "update  tblmechanics set status='Enabled' where ID=$mid");
        if ($query) {
            $msg = "Mechanic has been Re-joined.";
        } else {
            $msg = "Couldn't Re-join the Mechanic, Something Went Wrong. Please try again";
        }
    }
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
                                        <h4 class="m-t-0 header-title">Update Mechanic Details</h4>
                                        <p class="text-muted m-b-30 font-14">

                                        </p>

                                        <div class="row">
                                            <div class="col-12">
                                                <div class="p-20">
                                                    <?php
                                                    $mid = substr(base64_decode($_GET['mecid']), 0, -5);

//echo base64_decode($_GET['mecid']);
                                                    $ret = mysqli_query($con, "select * from tblmechanics where ID='$mid'");
                                                    $cnt = 1;
                                                    while ($row = mysqli_fetch_array($ret)) {
                                                        ?>
                                                        <p style="font-size:16px; color:red" align="center"> <?php
                                                            if ($msg) {
                                                                echo $msg;
                                                            }
                                                            ?> </p>

                                                        <form class="form-horizontal" role="form" method="post" name="submit">

                                                            <div class="form-group row">
                                                                <label class="col-2 col-form-label" for="macname">Mechanic Name</label>
                                                                <div class="col-10">
                                                                    <input type="text" id="macname" name="macname" class="form-control" placeholder="Full Name" required="true" value="<?php echo $row['FullName']; ?>" >
                                                                </div>
                                                            </div>

                                                            <div class="form-group row">
                                                                <label class="col-2 col-form-label" for="mobilenumber">Mechanic Contact Number</label>
                                                                <div class="col-10">
                                                                    <input type="text" id="mobilenumber" name="mobilenumber" class="form-control" maxlength="10" required="true" value="<?php echo $row['MobileNumber']; ?>" >
                                                                </div>
                                                            </div>

                                                            <div class="form-group row">
                                                                <label class="col-2 col-form-label" for="macadd">Mechanic Address</label>
                                                                <div class="col-10">
                                                                    <input type="text" id="macadd" name="macadd" class="form-control"  required="true" value="<?php echo $row['Address']; ?>" >
                                                                </div>
                                                            </div>
                                                            <div class="form-group row">
                                                                <label class="col-2 col-form-label" for="basicsalary">Basic Salary</label>
                                                                <div class="col-10">
                                                                    <input type="text" id="basicsalary" name="basicsalary" class="form-control"  required="true" value="<?php echo $row['BasicSalary']; ?>" >
                                                                </div>
                                                            </div>

                                                            <?php if ($row['status'] == "Enabled") { ?>
                                                                <div class="form-group row">

                                                                    <div class="col-12">
                                                                        <p style="text-align: center;">
                                                                            <button type="submit" name="submit" class="btn btn-info btn-min-width mr-1 mb-1">Update</button>
                                                                            <button type="submit" name="Dismiss" class="btn btn-danger btn-min-width mr-1 mb-1">Dismiss</button>
                                                                        </p>
                                                                    </div>
                                                                </div>
                                                            <?php }else{ ?>
                                                             <div class="form-group row">

                                                                    <div class="col-12">
                                                                        <p style="text-align: center;">
                                                                            <button type="submit" name="Re-Join" class="btn btn-info btn-min-width mr-1 mb-1">Re-Join</button>
                                                                          
                                                                        </p>
                                                                    </div>
                                                                </div>
                                                            <?php } ?>
                                                        </form>
                                                    <?php } ?>
                                                </div>
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

        </body>
    </html>
<?php } ?>