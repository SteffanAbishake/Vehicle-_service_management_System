
<?php
session_start();
error_reporting(0);
include('includes/dbconnection.php');
date_default_timezone_set("Asia/Colombo");
if (strlen($_SESSION['adid'] == 0)) {
    header('location:logout.php');
} else {
      //privilage setup
       $pr_id = $_SESSION['adid'];
    $pr_ret = mysqli_query($con, "select * from tbladmin where ID='$pr_id'");
    $pr_row = mysqli_fetch_array($pr_ret);
    $pr_name = $pr_row['AdminName'];
    $pr_type = $pr_row['type'];
    if($pr_type=="Admin"){
        
    }else{
        header("location:dashboard.php");
    }
    //privilage setup

    if (isset($_POST['FCName'])) {
        $name = $_POST['FCName'];
        $number = $_POST['mobilenumber'];
//        $mail = $_POST['email'];

        $check = mysqli_query($con, "Select * from supplier where fullname='" . $name . "' and phonenumber='" . $number . "'");
        $check_row_count = mysqli_num_rows($check);
        if ($check_row_count == '0') {
            $add_supplier_query = mysqli_query($con, "Insert into supplier(fullname,phonenumber) value('$name','$number')");
            if ($add_supplier_query) {

//                echo 'Saved Successfully';
                $msgy = "Saved Successfully";
            } else {
//                echo 'Failed to Register';
                $msgy = "Failed to Register";
            }
        } else {
//            echo "Already Registered ";
            $msgy = "Already Registered";
        }
        echo $msgy;
        return $msgy;
    } else if (isset($_POST['stock_submit'])) {

        $supply = $_POST['suppliernumber'];
        $in = $_POST['in'];
        $up = $_POST['up'];
        $sp = $_POST['sp'];
        $ed = "";
        $qty = $_POST['qty'];
        $qlty = $_POST['quality'];

        $stock_searc = mysqli_query($con, "Select * from stock where itemname='$in'");
        $stock_result = mysqli_num_rows($stock_searc);
        if ($stock_result == '0') {
            if ($supply) {
                $s_id_q = mysqli_query($con, "Select * from supplier where phonenumber='$supply'");
                if ($s_id_r = mysqli_fetch_array($s_id_q)) {
                    $s_id = $s_id_r['id'];
                    $stock_entry = mysqli_query($con, "Insert into stock(itemname,unitprice,sellingprice,qty,supplier_id,type) value('$in','$up','$sp','$qty','$s_id','$qlty')");
                    if ($stock_entry) {


//                    $stock_id_q= mysqli_query($con, "SELECT * from stock where itemname=$in and unitprice =$un and qty=$qty ");
                        $stock_id_q = mysqli_query($con, "SELECT * FROM stock ORDER BY id DESC LIMIT 1");
                        $stock_id_row = mysqli_fetch_array($stock_id_q);
                        $stock_id = $stock_id_row['id'];
//                    $datetdy= date('Y-m-d');
                        $total = intval($up) * intval($qty);
                        $grn_q = mysqli_query($con, "Insert into grn(buyingprice,qtyg,total,expiry,grnopenstock,availabe_qty,stock_id) value('$up','$qty','$total','$ed','0','$qty','$stock_id')");
//                        $msg2= $stock_id;
                        if ($grn_q) {
                            $msg2 = "Saved Successfully";
                            header("location:stock_add.php");
                        } else {
//                         $msg2 = "Error on save";
                        }
                    } else {
                        $msg2 = "Error while tried to save";
                    }
                } else {
                    $msg2 = "Supplier not found";
                }
            }else{
                //without supplier
                
                $stock_entry = mysqli_query($con, "Insert into stock(itemname,unitprice,sellingprice,qty,type) value('$in','$up','$sp','$qty','$qlty')");
                    if ($stock_entry) {


//                    $stock_id_q= mysqli_query($con, "SELECT * from stock where itemname=$in and unitprice =$un and qty=$qty ");
                        $stock_id_q = mysqli_query($con, "SELECT * FROM stock ORDER BY id DESC LIMIT 1");
                        $stock_id_row = mysqli_fetch_array($stock_id_q);
                        $stock_id = $stock_id_row['id'];
//                    $datetdy= date('Y-m-d');
                        $total = intval($up) * intval($qty);
                        $grn_q = mysqli_query($con, "Insert into grn(buyingprice,qtyg,total,expiry,grnopenstock,availabe_qty,stock_id) value('$up','$qty','$total','$ed','0','$qty','$stock_id')");
//                        $msg2= $stock_id;
                        if ($grn_q) {
                            $msg2 = "Saved Successfully";
                            header("location:stock_add.php");
                        } else {
//                         $msg2 = "Error on save";
                        }
                    } else {
                        $msg2 = "Error while tried to save";
                    }
                
            }
        } else {
            $msg2 = "Item Name Exist! Update your stock";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>Stock Add</title>

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

        <!--======================MODAL==================================-->
        <div class="modal fade" id="supplier_reg" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLongTitle">Supplier Registration</h5>
                        <button type="button" class="close" onclick="refresh();" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <p style="font-size:16px; color:red" id="msg" align="center"> <?php
if ($msgy) {
    echo $msgy;
}
?> </p>
                        <form class="form-horizontal" id="register_supplier"  name="signup" method="post" >

                            <div class="form-group row m-b-20">
                                <div class="col-12">
                                    <label for="username">Full Name/Company Name:</label>
                                    <input class="form-control" type="text" id="FCName" name="FCName" required="" placeholder="Enter Your Full Name">
                                </div>
                            </div>

                            <div class="form-group row m-b-20">
                                <div class="col-12">
                                    <label for="number">Mobile Number</label>
                                    <input class="form-control" type="number" id="number" name="mobilenumber" required="" placeholder="Enter Your Mobile Number"  maxlength="10" pattern="[0-9]">
                                </div>
                            </div>


                            <!--                            <div class="form-group row m-b-20">
                                                            <div class="col-12">
                                                                <label for="email">Email address</label>
                                                                <input class="form-control" type="email" id="email" name="email" required="" placeholder="abc@gmail.com">
                                                            </div>
                                                        </div>-->

                            <div class="form-group row text-center m-t-10">
                                <div class="col-12">
                                    <button class="btn btn-block btn-custom waves-effect waves-light" type="button" onclick="sent();" name="custregist">Register</button>
                                </div>
                            </div>

                        </form>

                    </div>

                </div>
            </div>
        </div>
        <!--======================MODAL==================================-->


        <!--sidebar-->
        <div id="wrapper">
            <?php include_once('includes/sidebar.php'); ?>
            <!--page content-->
            <div class="content-page">
                <?php include_once('includes/header.php'); ?>
                <div class="content">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-12">
                                <div class="card-box">
                                    <div class="card-title">
                                        <h4 class="m-t-0 header-title"> Stock Entry </h4>
                                    </div>
                                    <p style="font-size:16px; color:red" id="msg" align="center"> <?php
                if ($msg2) {
                    echo $msg2;
                }
                ?> </p>
                                    <form method="post" name="stock" class="form-horizontal ">
                                        <div class="form-group row">
                                            <label class="col-2 col-form-label" >Supplier Number:</label>
                                            <div class="col-8">
                                                <input class="form-control"  list="x" id="supplier" placeholder="Enter Supplier Name or Phone Number" name="suppliernumber" >
                                                <datalist id="x"  class="form-group-lg">
                                                    <?php
                                                    $supplier_query = mysqli_query($con, "SELECT * from supplier");
                                                    while ($supplier_row = mysqli_fetch_array($supplier_query)) {
                                                        ?>
                                                        <option value="<?php echo $supplier_row['phonenumber']; ?>"><?php echo $supplier_row['fullname']; ?></option>

                                                    <?php } ?>
                                                </datalist>
                                            </div>
                                            <div class="col-2">
                                                <input type="button" value="Add Supplier" class="btn btn-outline-info" onclick="modalcall();">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-2 col-form-label" >Item Name:</label>
                                            <div class="col-10">
                                                <input class="form-control" type="text" id="in" placeholder="Item Name" name="in" required="">

                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-2 col-form-label" >Unit Price:</label>
                                            <div class="col-10">
                                                <input class="form-control" type="number" id="up" placeholder="Unit Price/ Buying Price" name="up" required="">


                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-2 col-form-label" >Selling Price:</label>
                                            <div class="col-10">
                                                <input class="form-control" type="number" id="sp" placeholder="Selling Price" name="sp" required="" >


                                            </div>
                                        </div>
                                        <!--                                        <div class="form-group row">
                                                                                    <label class="col-2 col-form-label" >Expiry Date:</label>
                                                                                    <div class="col-10">
                                                                                        <input class="form-control" type="text"  id="ed" placeholder="Expiry Date of the product" name="ed" required="">
                                        
                                        
                                                                                    </div>
                                                                                </div>-->
                                        <div class="form-group row">
                                            <label class="col-2 col-form-label" >Quantity:</label>
                                            <div class="col-10">
                                                <input class="form-control" type="number"  id="qty" placeholder="Enter the Quantity" name="qty" required="">


                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-2 col-form-label" >Quality:</label>
                                            <div class="col-10">
                                                <input class="form-control" type="text"  id="quality" placeholder="Enter the Quality" name="quality" required="">


                                            </div>
                                        </div>
                                        <div class="form-group row">

                                            <div class="col-12">
                                                <p style="text-align: center;">  <button type="submit" name="stock_submit" class="btn btn-outline-info btn-lg btn-block btn-min-width mr-1 mb-1">Add to Stock</button></p>
                                            </div>
                                            <p id="vehiclelist" style="font-size:16px; color:red" align="center"></p>
                                        </div>

                                    </form>
                                </div>
                            </div>

                        </div>
                    </div>

                </div>
            </div>

            <?php include_once('includes/footer.php'); ?>

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
                                                    function modalcall() {
                                                        $('#supplier_reg').modal('show');
                                                    }
                                                    function refresh() {
                                                        window.location.href = "stock_add.php";
                                                    }
                                                    function sent() {
                                                        var fc = document.getElementById("FCName").value;
                                                        var num = document.getElementById("number").value;
//                                                        var mail = document.getElementById("email").value;
                                                        if (fc === "" || num === "") {
                                                            alert("Fill all the field");
                                                        } else {

                                                            var form = document.getElementById("register_supplier");
                                                            var data = new FormData(form);
                                                            var req = new XMLHttpRequest();

                                                            req.onreadystatechange = function () {
                                                                if (req.readyState === 4 && req.status === 200) {
                                                                    alert(req.responseText);
                                                                    refresh();
//                                                                   if(req.responseText === "x"){
//                                                                       $('#supplier_reg').modal('hide');
//                                                                       window.location.href="stock_add.php";
//                                                                   }else{
//                                                                       alert(req.responseText);
//                                                                   }
                                                                }
                                                            };

                                                            req.open("POST", "stock_add.php", true);
                                                            req.send(data);
                                                        }
                                                    }
            </script>

    </body>
</html>
