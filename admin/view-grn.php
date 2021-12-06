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
            <title>View GRN</title>
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
                            <?php
                            $st_id = substr(base64_decode($_GET['editid']), 0, -5);
                            ?>
                            <div class="row">
                                <div class="col-12">
                                    <div class="card-box">
                                        <h4 class="m-t-0 header-title">GRN</h4>
                                        <hr>
                                        <p class="text   m-b-30 font-14">
                                        <h5 class="m-t-0 header-title">Supplier</h5>


                                            <?php
                                            $st_id = substr(base64_decode($_GET['editid']), 0, -5);
                                            $supp_q = mysqli_query($con, "SELECT * FROM stock s JOIN grn g ON s.id=g.stock_id JOIN supplier su ON su.id=s.supplier_id where s.id=$st_id");
                                            if ($supp_row = mysqli_fetch_array($supp_q)) {
                                                ?>
                                                <label class="label"><?php echo $supp_row['fullname']; ?></label><br>
                                                <label class="label"><?php echo $supp_row['mail']; ?></label><br>
                                                <label class="label"><?php echo $supp_row['phonenumber']; ?></label><br>
                                            <?php } ?>
                                        </p>
                                        <div class="row">
                                            <div class="col-12">
                                                <div class="p-20">
                                                    <table class="table mb-0">
                                                        <thead>
                                                            <tr>
                                                                <th>S.NO</th>
                                                                <th>Item</th>
                                                                <th>Purchased Date</th>
                                                                <th>Purchased Quantity</th>
                                                                <th>Available Quantity</th>
                                                                <th>Purchased Price</th>
                                                                <th>Total</th>
                                                                <!--<th>Expiry</th>-->
                                                            </tr>
                                                        </thead>
                                                        <?php
                                                        $rno = mt_rand(10000, 99999);
                                                        $retx = mysqli_query($con, "SELECT * FROM stock s JOIN grn g ON s.id=g.stock_id  where s.id=$st_id");
                                                        $cnt = 1;
                                                        while ($rowx = mysqli_fetch_array($retx)) {
                                                            ?>

                                                            <tr>
                                                                <td><?php echo $cnt; ?></td>

                                                                <td><?php echo $rowx['itemname']; ?></td>
                                                                <td><?php echo $rowx['date']; ?></td>
                                                                <td><?php echo $rowx['qtyg']; ?></td>
                                                                <td><?php echo $rowx['availabe_qty']; ?></td>
                                                                <td><?php echo $rowx['buyingprice']; ?></td>
                                                                <td><?php echo $rowx['total']; ?></td>
                                                                <!--<td><?php // echo $rowx['expiry']; ?></td>-->

                                                                
                                                            </tr>
                                                            <?php
                                                            $cnt = $cnt + 1;
                                                        }
                                                        ?>



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