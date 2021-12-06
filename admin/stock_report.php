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
            <title>Stock Report</title>
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
                                <div class="col offset-lg-11 d-print-none">
                                    <button class="btn btn-danger" onclick="window.print();"><i class="fi-printer"></i></button>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12">
                                    <div class="card-box">
                                        <h4 class="m-t-0 header-title">Stock Report</h4>
                                        <p class="text-muted m-b-30 font-14">

                                        </p>

                                        <div class="row">
                                            <div class="col-12">
                                                <div class="row">
                                                    <div class="col">
                                                        <div class="table-responsive">
                                                            <table class="table table-striped table-hover table-sm">
                                                                <thead>
                                                                    <tr>
                                                                        <th>No</th>
                                                                        <th>Supplier</th>
                                                                        <th>Supplier Number</th>
                                                                        <th>Item Name</th>
                                                                        <th>Available Qty</th>
                                                                        <th>Selling Price</th>
                                                                        <th>Quality</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                    <?php
                                                                    $count = 1;
                                                                    $qu = mysqli_query($con, "SELECT * FROM stock s JOIN supplier su ON s.supplier_id=su.id");
                                                                    while ($st_r = mysqli_fetch_array($qu)) {
                                                                        ?>
                                                                        <tr>
                                                                            <td><?php echo $count; ?></td>
                                                                            <td><?php echo $st_r['fullname']; ?></td>
                                                                            <td><?php echo $st_r['phonenumber']; ?></td>
                                                                            <td><?php echo $st_r['itemname']; ?></td>
                                                                            <td><?php echo $st_r['qty']; ?></td>
                                                                            <td><?php echo $st_r['sellingprice']; ?></td>
                                                                            <td><?php echo $st_r['type']; ?></td>
                                                                        </tr>
        <?php
        $count = $count + 1;
    }
    ?>
                                                                </tbody>

                                                            </table>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
    <!--                                            <p style="text-align: center;"> <button type="button" name="submit" class="btn btn-info btn-min-width mr-1 mb-1" onclick="printJS('abc', 'html');">Add</button></p>-->

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