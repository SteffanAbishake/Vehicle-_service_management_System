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

    if (isset($_POST['v'])) {
//        $xy=$_GET($_POST['v'];
//        echo $xy;
//        return $xy;

        $yy = $_POST['update'];
        $yy1 = $_POST['id'];
        $yy2 = $_POST['sellp'];
        $yy3 = $_POST['buyp'];

        $stock_up = mysqli_query($con, "SELECT * from stock where id=$yy1");
        if ($stock_row = mysqli_fetch_array($stock_up)) {
            $sto_id = $stock_row['id'];
//            $sto_up = $stock_row['up'];
            $sto_qty = $stock_row['qty'];
            $t_qty = intval($sto_qty) + intval($yy);
            $t_price = intval($yy) * intval($yy3);
            $update_stock = mysqli_query($con, "Update stock set qty=$t_qty , unitprice=$yy3 , sellingprice=$yy2 where id=$sto_id");
            if ($update_stock) {
                $grn_query = mysqli_query($con, "Insert into grn(buyingprice,qtyg,total,grnopenstock,availabe_qty,stock_id) value('$yy3','$yy','$t_price','$sto_qty','$yy','$sto_id')");
//                       $xy= $grn_query;
                if ($grn_query) {
                    $xy = "Saved Successfully";
                    header("location:update-stock.php");
                } else {
//                         $msg2 = "Error on save";
                }
            } else {
                
            }
        } else {
            $xy = "Item Not found";
        }
//        echo "$xy";
//        return;
    }
    ?>
    <!doctype html>
    <html lang="en">

        <head>
            <meta charset="utf-8" />
            <title>Update Stock</title>
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
                                        <h4 class="m-t-0 header-title">UPDATE STOCK</h4>
                                        <p class="text-muted m-b-30 font-14">

                                        </p>
                                        <div style="font-size:16px; color:red" align="center">
                                            <?php
                                            if ($xy) {
                                                echo $xy;
                                            }
                                            ?>
                                        </div>
                                        <div class="row">
                                            <div class="col-12">
                                                <div class="p-20">
                                                    <table class="table mb-0">
                                                        <thead>
                                                            <tr>
                                                                <th>S.NO</th>
                                                                <th>Supplier</th>
                                                                <th>Item</th>
                                                                <th>Selling Price</th>
                                                                <th>Quantity</th>
                                                                <th>New Entry</th>
                                                                <!--<th>Selling Price</th>-->
                                                                <th>Buying Price</th>
                                                                <th></th>
                                                            </tr>
                                                        </thead>
                                                        <?php
                                                        $rno = mt_rand(10000, 99999);
                                                        $ret = mysqli_query($con, "select * from stock s JOIN supplier g ON s.supplier_id = g.id");
                                                        $cnt = 1;
                                                        while ($row = mysqli_fetch_array($ret)) {
                                                            ?>

                                                            <form method="POST">
                                                                <tr>
                                                                    <td><?php echo $cnt; ?></td>

                                                                    <td><?php echo $row['fullname']; ?></td>
                                                                    <td><?php echo $row['itemname']; ?></td>
                                                                    <td><input  type="number" class="form-control" min=0  name="sellp"  required="" readonly="true" value=<?php echo $row['sellingprice']; ?>></td>
                                                                    <td><?php echo $row['qty']; ?></td>
                                                                <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                                                                <td><input type="number" class="form-control" min=0 name="update" id="update-<?php echo $row['id']; ?>" required=""></td>
                                                                <td><input type="number" class="form-control" min=0 name="buyp" required="" ></td>
                                                                <td><input type="submit" class="btn btn-outline-info" value="update" name="v" ></td>
                                                            </form>
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

            <script type="text/javascript">
                function m(x) {
                    var update = document.getElementById("update-" + x).value;

                    var req = new XMLHttpRequest();
                    req.onreadystatechange = function () {
                        if (req.readyState === 4 && req.status === 200) {
                            alert(req.responseText);
                        }
                    };
                    req.open("POST", "update-stock.php", true);
                    req.send("v=" + update);

                }


            </script>

        </body>
    </html>
<?php } ?>