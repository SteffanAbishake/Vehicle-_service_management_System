<?php
session_start();
error_reporting(0);
include('includes/dbconnection.php');
if (strlen($_SESSION['adid'] == 0)) {
    header('location:logout.php');
} else {
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
                                        <h4 class="m-t-0 header-title">Complete Services</h4>
                                        <p class="text-muted m-b-30 font-14">

                                        </p>

                                        <div class="row">
                                            <div class="col-12">
                                                <div class="p-20">
                                                    <table class="table mb-0">
                                                        <thead>
                                                            <tr>
                                                                <th>S.NO</th>
                                                                <th>Vehicle Number</th>
                                                                <th>Vehicle Category</th>
                                                                <th>Full Name</th>
                                                                <th>Mobile Number</th>
                                                                <th>Bill Generate</th>


                                                                <th>Print Bill</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <?php
                                                            $sid123 = substr(base64_decode($_GET['udid']), 0, -5);
                                                            $ret = mysqli_query($con, "select * from  tblservicerequest tr  join tbluser tu on tu.ID=tr.UserId where tr.AdminStatus ='3' and tr.vehicle_id='$sid123' ORDER BY tr.ID DESC");
                                                            $ret1 = mysqli_query($con, "select * from  tblservicerequest_quotation tq  join tbluser tu on tu.ID=tq.UserId where tq.AdminStatus ='4' and tq.vehicle_id='$sid123' ORDER BY tq.ID DESC");
                                                            $cnt = 1;
                                                            while ($row = mysqli_fetch_array($ret)) {
                                                                ?>

                                                                <tr>
                                                                    <td><?php echo $cnt; ?></td>
                                                                    <td><?php echo $row['VehicleRegno']; ?></td>
                                                                    <td><?php echo $row['Category']; ?></td>

                                                                    <td><?php echo $row['FullName']; ?></td>
                                                                    <td><?php echo $row['MobileNo']; ?></td>
                                                                    <td><?php echo $row['ServiceDate']; ?></td>



                                                                    <td><a href="invoice_Receipt.php?aticid=<?php echo $row['ID']; ?>">View Receipt</a></td>
                                                                </tr>
        <?php
        $cnt = $cnt + 1;
    }
    ?>
                                                            <?php
                                                            while ($row1 = mysqli_fetch_array($ret1)) {
                                                                ?>

                                                                <tr>
                                                                    <td><?php echo $cnt; ?></td>
                                                                    <td><?php echo $row1['VehicleRegno']; ?></td>
                                                                    <td><?php echo $row1['Category']; ?></td>

                                                                    <td><?php echo $row1['FullName']; ?></td>
                                                                    <td><?php echo $row1['MobileNo']; ?></td>
                                                                    <td><?php echo $row1['ServiceDate']; ?></td>



                                                                    <td><a href="print_quotation_bill.php?aticid=<?php echo $row1['ID']; ?>">View Receipt</a></td>
                                                                </tr>
        <?php
        $cnt = $cnt + 1;
    }
    ?>
                                                        </tbody>


                                                    </table>


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