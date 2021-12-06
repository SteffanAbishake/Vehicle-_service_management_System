<?php
session_start();
error_reporting(0);
include('includes/dbconnection.php');
date_default_timezone_set("Asia/Colombo");
if (strlen($_SESSION['adid'] == 0)) {
    header('location:logout.php');
} else {

    if (isset($_POST['submit'])) {
        // put the vehicle to 
        $uid = $_SESSION['tbluser_ID'];
        $category = $_POST['category'];
        $PMR = $_POST['PMR'];
        $vehname = $_POST['vehiclename'];
        $vehmodel = $_POST['vehilemodel'];
        $vehbrand = $_POST['vehiclebrand'];
        $vehrego = $_POST['vehicleregno'];
        $vehservicedate = $_POST['servicedate'];
        $vehservicetime = $_POST['servicetime'];
        $deltype = $_POST['deltype'];
        $pickupadd = $_POST['pickupadd'];
        $ownertype = $_POST['ownertype'];
        $vehicleid = $_SESSION['vehicleid'];
        $sernumber = mt_rand(100000000, 999999999);

        $query = mysqli_query($con, "insert into tblservicerequest_quotation(UserId,Category,ServiceNumber,VehicleName,VehicleModel,VehicleBrand,VehicleRegno,ServiceDate,ServiceTime,DeliveryType,PickupAddress,vehicle_id,ownertype,AdminStatus,present_meter_reading,service_discount) value('$uid','$category','$sernumber','$vehname','$vehmodel','$vehbrand','$vehrego','$vehservicedate','$vehservicetime','$deltype','$pickupadd','$vehicleid','$ownertype','1','$PMR','0')");
        if ($query) {
            $msg = "Data has been added successfully.";
            $query="";
            header('location:quotation-estimation.php?aticid='.$sernumber);//here i should change
        } else {
            $msg = "Something Went Wrong. Please try again";
        }
    } elseif (isset($_POST['list'])) {
        $lst = $_POST['list'];
        $queryv = mysqli_query($con, "select * from vehicle v where v.Vehiclenumber = '" . $lst . "'");

        if ($r = mysqli_fetch_array($queryv)) {
            $vehicleid = $r['id'];
            $_SESSION['vehicleid'] = $r['id'];
            $vehicleid1 = "available";
        } else {
            $vehicleid = "empty";
        }
    } else if (isset($_POST['fullname'])) {
        //customer registration

        $fname = $_POST['fullname'];
        $mobno = $_POST['mobilenumber'];
//        $email = $_POST['email'];
        $password = md5('123456789');

        $ret = mysqli_query($con, "select Email from tbluser where MobileNo='$mobno'");
        $result = mysqli_fetch_array($ret);
        if ($result > 0) {
            $msg1 = "This Contact Number already associated with another account";
        } else {
            $query = mysqli_query($con, "insert into tbluser(FullName, MobileNo,  Password) value('$fname', '$mobno', '$password' )");
            if ($query) {
                $msg1 = "You have successfully registered";
            } else {
                $msg1 = "Something Went Wrong. Please try again";
            }
        }
        echo $msg1;
        return $msg1;
    } else if (isset($_POST['ownertype1'])) {
        $customernumber = $_POST['list1'];
        $category = $_POST['category1'];
        $vehname = $_POST['vehiclename1'];
        $vehmodel = $_POST['vehiclemodel1'];
        $vehbrand = $_POST['vehiclebrand1'];
        $vehrego = $_POST['vehicleregno1'];
        $ownertype = $_POST['ownertype1'];

        $queryregv = mysqli_query($con, "SELECT * FROM tbluser tu WHERE tu.MobileNo LIKE '" . $customernumber . "' ");
        if ($regv = mysqli_fetch_array($queryregv)) {
            $customernumber1 = $regv['ID'];
            $vehice = mysqli_query($con, "INSERT INTO vehicle(Vehiclenumber,vehiclename,vehiclemodel,vehiclebrand,tbluser_ID,ownertype,tblcategory_ID) value('$vehrego','$vehname','$vehmodel','$vehbrand','$customernumber1','$ownertype','$category')");
            if ($vehice) {
                
//                  $queryvx = mysqli_query($con, "select * from vehicle v where v.Vehiclenumber = '" .$vehrego. "'");
//
//        if ($rx = mysqli_fetch_array($queryvx)) {
//            $vehicleid = $rx['id'];
//            $_SESSION['vehicleid'] = $rx['id'];
//            $vehicleid1 = "available";
//        } else {
//            $vehicleid = "empty";
//        }
        $customernumber="";
                echo 'saved';
                return '';
            } else {
                echo "Couldn't save the vehicle";
                return '';
            }
        } else {

            echo "Something error with customer phone number";
            return '';
        }
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
        <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
        <script src="assets/js/modernizr.min.js"></script>
        <script type="text/javascript">
            $(document).ready(function () {
                $('#pickupaddress').hide();
                $('#deltype').change(function () {
                    var v = $("#deltype").val();


                    if (v === 'dropservice')
                    {
                        $('#pickupaddress').show();
                    }
                    if (v === "")
                    {
                        $('#pickupaddress').hide();
                    }

                    if (v === 'pickupservice')
                    {
                        $('#pickupaddress').hide();
                    }
                });
                $('#addnew').click(function () {
//                        alert("Clicked");
                    $('#userregist').modal('show');
                });
            });

        </script>

    </head>


    <body>

        <!-- Begin page -->
        <div id="wrapper">

            <?php include_once('includes/sidebar.php'); ?>

            <!--======================MODAL==================================-->
            <div class="modal fade" id="userregist" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLongTitle">Customer Registration</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <p style="font-size:16px; color:red" id="msg" align="center"> <?php
                                if ($msg1) {
                                    echo $msg1;
                                }
                                ?> </p>
                            <form class="form-horizontal" id="signup"  name="signup" method="post" >

                                <div class="form-group row m-b-20">
                                    <div class="col-12">
                                        <label for="username">Full Name</label>
                                        <input class="form-control" type="text" id="fullname" name="fullname" required="" placeholder="Enter Your Full Name">
                                    </div>
                                </div>

                                <div class="form-group row m-b-20">
                                    <div class="col-12">
                                        <label for="username">Mobile Number</label>
                                        <input class="form-control" type="number" id="mobilenumber" name="mobilenumber" required="" placeholder="Enter Your Mobile Number"  maxlength="10" pattern="[0-9]">
                                    </div>
                                </div>


                                <!--                                <div class="form-group row m-b-20">
                                                                    <div class="col-12">
                                                                        <label for="emailaddress">Email address</label>
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




            <!-- ============================================================== -->
            <!-- Start right Content here -->
            <!-- ============================================================== -->

            <div class="content-page">




                <?php include_once('includes/header.php'); ?>

                <!-- Start Page content -->
                <div class="content">


                    <div class="container-fluid">
                        <!--Vehicle Details--> 
                        <div class="row">
                            <div class="col-12">
                                <div class="card-box">
                                    <h4 class="m-t-0 header-title">Vehicle Details</h4>
                                    <p style="font-size:16px; color:red" align="center"> <?php
                                        if ($msg) {
                                            echo $msg;
                                        }
                                        ?> </p>
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="p-20">
                                                <form class="form-horizontal" method="POST" name="vehicles" id="vehicles">
                                                    <div class="form-group row">
                                                        <label class="col-2 col-form-label" for="list">Vehicle Number:</label>
                                                        <div class="col-10" >
                                                            <input id="list" list="B"  name="list" class="col-10 form-control" placeholder="CAR-1234">
                                                            <datalist id="B" class="col-10 form-group-lg"> 
                                                                <?php
                                                                $datax = mysqli_query($con, "select * from vehicle");
                                                                while ($row1 = mysqli_fetch_array($datax)) {
                                                                    ?>
                                                                    <option  value=<?php echo $row1['Vehiclenumber']; ?> ><?php echo $row1['Vehiclenumber']; ?></option>
                                                                    <?php
                                                                }
                                                                ?>

                                                            </datalist>
                                                        </div>
                                                    </div>

                                                    <div class="form-group row">

                                                        <div class="col-12">
                                                            <p style="text-align: center;">  <button type="submit" name="vehicles" class="btn btn-outline-info btn-lg btn-block btn-min-width mr-1 mb-1" id="vehiclesfind">Find</button></p>
                                                        </div>
                                                        <p id="vehiclelist" style="font-size:16px; color:red" align="center"></p>
                                                    </div>
                                                </form>
                                                <?php if ($vehicleid == "empty") { ?>
                                                    <hr>
                                                    <!--Enter Customer Details--> 
                                                    <form class="form-horizontal" method="POST" name="userdtls" id="userdtls">
                                                        <div class="form-group row">
                                                            <label class="col-2 col-form-label" for="list1">Customer:</label>
                                                            <div class="col-8" >
                                                                <input id="list1" list="A" name="list1" class="col-8 form-control" placeholder="Enter Customer Name or Phone Number" required="">
                                                                <datalist id="A" class="col-8"> 
                                                                    <?php
                                                                    $datau = mysqli_query($con, "select * from tbluser");
                                                                    while ($row2 = mysqli_fetch_array($datau)) {
                                                                        ?>
                                                                        <option value=<?php echo $row2['MobileNo']; ?> ><?php echo $row2['FullName']; ?></option>
                                                                        <?php
                                                                    }
                                                                    ?>

                                                                </datalist>
                                                            </div>
                                                            <div class="col-2">
                                                                <input type="button" id="addnew" value="Add a Customer" class="col btn btn-outline-info btn-min-width mr-1 mb-1">

                                                            </div>

                                                        </div>
                                                        <div class="form-group row">
                                                            <label class="col-2 col-form-label">Category</label>
                                                            <div class="col-10">
                                                                <select name='category1' id="category1" class="form-control" required="true">
                                                                    <option value="">Category</option>
                                                                    <?php
                                                                    $query = mysqli_query($con, "select * from tblcategory");
                                                                    while ($row = mysqli_fetch_array($query)) {
                                                                        ?>    
                                                                        <option value="<?php echo $row['ID']; ?>"><?php echo $row['VehicleCat']; ?></option>
                                                                    <?php } ?>  
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="form-group row">
                                                            <label class="col-2 col-form-label" for="example-email">Vehicle Name</label>
                                                            <div class="col-10">
                                                                <input type="text" id="vehiclename1" name="vehiclename1" class="form-control" placeholder="520i" required="true">
                                                            </div>
                                                        </div>
                                                        <div class="form-group row">
                                                            <label class="col-2 col-form-label">Vehicle Model</label>
                                                            <div class="col-10">
                                                                <input type="text" class="form-control"  name="vehiclemodel1" id="vehiclemodel1" placeholder="2017" required="true">
                                                            </div>
                                                        </div>

                                                        <div class="form-group row">
                                                            <label class="col-2 col-form-label">Vehicle Brand</label>
                                                            <div class="col-10">
                                                                <input type="text" class="form-control" placeholder="BMW" name="vehiclebrand1" id="vehiclebrand1" required="true">
                                                            </div>
                                                        </div>
                                                        <div class="form-group row">
                                                            <label class="col-2 col-form-label">Vehicle Registration Number</label>
                                                            <div class="col-10">
                                                                <input type="text" class="form-control" name="vehicleregno1" id="vehicleregno1" required="true" placeholder="CAR-0000">
                                                            </div>
                                                        </div>
                                                        <div class="form-group row">
                                                            <label class="col-2 col-form-label">Owner Type</label>
                                                            <div class="col-10 ">
                                                                <select name="ownertype1" id="ownertype1" class="form-control">
                                                                    <option value="">Choose the owner type</option>
                                                                    <option value="Private Vehicle">Private Vehicle</option>
                                                                    <option value="Government Vehicle">Government Vehicle</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="form-group row">

                                                            <div class="col-12">
                                                                <p style="text-align: center;">  <button type="button" onclick="funk();" name="submit" class="btn btn-info btn-min-width mr-1 mb-1">Next <i class="fi-arrow-right"></i></button></p>
                                                            </div>
                                                        </div>
                                                    </form>
                                                <?php } else if ($vehicleid1 == "available") { ?>

                                                    <!--Load Details-->
                                                    <table class="table mb-0">
                                                        <thead>
                                                            <tr>
                                                                <th>
                                                                    Name
                                                                </th>
                                                                <th>
                                                                    Mobile Number    
                                                                </th>
<!--                                                                <th>
                                                                    Email
                                                                </th>-->
                                                                <th>
                                                                    Regd Date
                                                                </th>
                                                            </tr>
                                                            <tr>

                                                                <?php
                                                                $v_id = $_SESSION['vehicleid'];
                                                                $v_id_query = mysqli_query($con, "SELECT * FROM vehicle v JOIN tbluser u ON v.tbluser_ID=u.ID JOIN tblcategory c ON v.tblcategory_ID=c.ID WHERE v.id=$v_id");

                                                                if ($v_id_row = mysqli_fetch_array($v_id_query)) {

                                                                    $_SESSION['tbluser_ID'] = $v_id_row['tbluser_ID'];
                                                                    ?>
                                                                    <td>
                                                                        <?php echo $v_id_row['FullName']; ?>
                                                                    </td>
                                                                    <td>
                                                                        <?php echo $v_id_row['MobileNo']; ?>
                                                                    </td>
<!--                                                                    <td>
                                                                        <?php // echo $v_id_row['Email']; ?>
                                                                    </td>-->
                                                                    <td>
                                                                        <?php echo $v_id_row['RegDate']; ?>
                                                                    </td>

                                                                </tr>
                                                            </thead>
                                                        </table>

                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!--Vehicle Details--> 



                                <!--Service Request Form-->
                                <div class="row">
                                    <div class="col-12">
                                        <div class="card-box">
                                            <h4 class="m-t-0 header-title">Quotation Request Form</h4>
                                            <p class="text-muted m-b-30 font-14">

                                            </p>

                                            <div class="row">
                                                <div class="col-12">
                                                    <div class="p-20">
                                                        <p style="font-size:16px; color:red" align="center"> <?php
                                                            if ($msg) {
                                                                echo $msg;
                                                            }
                                                            ?> </p>
                                                        <form class="form-horizontal" role="form" method="POST" action="" name="submit" action="service-add.php">
                                                            <div class="form-group row">
                                                                <label class="col-2 col-form-label">Category</label>
                                                                <div class="col-10">
                                                                    <select name='category' id="category" class="form-control" required="true" readonly>
                                                                        <option value='<?php echo $v_id_row['VehicleCat']; ?>'><?php echo $v_id_row['VehicleCat']; ?></option>

                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <div class="form-group row">
                                                                <label class="col-2 col-form-label" for="example-email">Vehicle Name</label>
                                                                <div class="col-10">
                                                                    <input type="text" id="vehiclename" name="vehiclename" class="form-control" placeholder="Vehicle Name" required="true" value="<?php echo $v_id_row['vehiclename']; ?> " readonly>
                                                                </div>
                                                            </div>
                                                            <div class="form-group row">
                                                                <label class="col-2 col-form-label">Vehicle Model</label>
                                                                <div class="col-10">
                                                                    <input type="text" class="form-control"  name="vehilemodel" id="vehilemodel" required="true" value="<?php echo $v_id_row['vehiclemodel']; ?>" readonly>
                                                                </div>
                                                            </div>

                                                            <div class="form-group row">
                                                                <label class="col-2 col-form-label">Vehicle Brand</label>
                                                                <div class="col-10">
                                                                    <input type="text" class="form-control" placeholder="Brand" name="vehiclebrand" id="vehiclebrand" required="true" value='<?php echo $v_id_row['vehiclebrand']; ?>' readonly>
                                                                </div>
                                                            </div>
                                                            <div class="form-group row">
                                                                <label class="col-2 col-form-label">Vehicle Registration Number</label>
                                                                <div class="col-10">
                                                                    <input type="text" class="form-control" name="vehicleregno" id="vehicleregno" required="true" value='<?php echo $v_id_row['Vehiclenumber']; ?> ' readonly>
                                                                </div>
                                                            </div>
                                                            <div class="form-group row">
                                                                <label class="col-2 col-form-label">Owner Type</label>
                                                                <div class="col-10 ">
                                                                    <select name="ownertype" id="ownertype" class="form-control" readonly>
                                                                        <option value=<?php echo $v_id_row['ownertype']; ?>><?php echo $v_id_row['ownertype']; ?></option>

                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <div class="form-group row">
                                                                <label class="col-2 col-form-label">Service Date</label>
                                                                <div class="col-10">
                                                                    <input readonly type="date" class="form-control" name="servicedate" id="servicedate" value=<?php echo date('Y-m-d'); ?> >
                                                                </div>
                                                            </div>

                                                            <div class="form-group row">
                                                                <label class="col-2 col-form-label">Service Time</label>
                                                                <div class="col-10">
                                                                    <input type="time" readonly class="form-control" name="servicetime" id="servicetime" value=<?php echo date('H:i '); ?> required="true">
                                                                </div>
                                                            </div>

                                                            <div class=" d-none ">
                                                                <label class="col-2 col-form-label">Delivery Type</label>
                                                                <div class="col-10">
                                                                    <select name="deltype" id="deltype"  class="form-control">
                                                                        <option value="">Select</option>
                                                                        <option value="pickupservice">Pickup Service</option> 
                                                                        <option value="dropservice">Drop Service</option> 
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <div class=" d-none " id="pickupaddress">
                                                                <label class="col-2 col-form-label">Drop Address</label>
                                                                <div class="col-10">
                                                                    <input type="text" class="form-control" name="pickupadd" id="pickupadd">
                                                                </div>
                                                            </div>
                                                            <div class=" d-none " id="pickupaddress">
                                                                <label class="col-2 col-form-label">Present Meter Reading:</label>
                                                                <div class="col-10">
                                                                    <input type="number" class="form-control" name="PMR" id="PMR">
                                                                </div>
                                                            </div>

                                                            <!--                                                            <div class="col-12">
                                                            
                                                                                                                            <div class="checkbox checkbox-custom">
                                                                                                                                <input id="remember" required="true" type="checkbox" checked="true">
                                                                                                                                <label for="remember">
                                                                                                                                    I accept <a href="terms-conditions.php" class="text-custom">Terms and Conditions</a>
                                                                                                                                </label>
                                                                                                                            </div>
                                                            
                                                                                                                        </div>-->
                                                            <div class="form-group row">

                                                                <div class="col-12">
                                                                    <p style="text-align: center;">  <button type="submit" name="submit" class="btn btn-info btn-min-width mr-1 mb-1">Next<i class="fi-arrow-right"></i></button></p>
                                                                </div>
                                                            </div>

                                                        </form>
                                                    </div>
                                                </div>

                                            </div>
                                            <!-- end row -->

                                        </div> <!-- end card-box -->
                                    </div><!-- end col -->
                                </div>
                                <!-- end row -->


                                <?php
                            }
                        }
                        ?>



                        <!-- end row -->





                    </div> <!-- container -->

                </div> <!-- content -->

            </div>


            <!-- ============================================================== -->
            <!-- End Right content here -->
            <!-- ============================================================== -->


        </div>
        <!-- END wrapper -->
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
                                                                    function sent() {
                                                                        var form = document.getElementById("signup");
//                                                var action = form.getAttribute("action");
                                                                        var data = new FormData(form);

                                                                        var xhr = new XMLHttpRequest();

                                                                        xhr.onreadystatechange = function () {
                                                                            if (xhr.readyState === 4 && xhr.status === 200) {
                                                                                if (xhr.responseText === "This email or Contact Number already associated with another account") {
                                                                                    document.getElementById("msg").innerHTML = "";
                                                                                    document.getElementById("msg").innerHTML = "This email or Contact Number already associated with another account";
                                                                                } else if (xhr.responseText === "Something Went Wrong. Please try again") {
                                                                                    document.getElementById("msg").innerHTML = "";
                                                                                    document.getElementById("msg").innerHTML = "Something Went Wrong. Please try again";
                                                                                } else if (xhr.responseText === "You have successfully registered") {
                                                                                    document.getElementById("msg").innerHTML = "";
                                                                                    alert('You have successfully registered');
                                                                                    $('#userregist').modal('hide');
                                                                                    window.location.reload();
                                                                                }
                                                                            }
                                                                        };
                                                                        xhr.open("POST", "quotation-add.php", true);
                                                                        xhr.send(data);
                                                                    }
                                                                    var v_no;
                                                                    function funk() {
                                                                        var list1 = document.getElementById("list1").value;
                                                                        var category1 = document.getElementById("category1").value;
                                                                        var vehiclename1 = document.getElementById("vehiclename1").value;
                                                                        var vehiclemodel1 = document.getElementById("vehiclemodel1").value;
                                                                        var vehiclebrand1 = document.getElementById("vehiclebrand1").value;
                                                                        var vehicleregno1 = document.getElementById("vehicleregno1").value;
                                                                        var ownertype1 = document.getElementById("ownertype1").value;

                                                                        if (list1 === "" || category1 === "" || vehiclename1 === "" || vehiclemodel1 === "" || vehiclebrand1 === "" || vehicleregno1 === "" || ownertype1 === "") {
                                                                            alert("Fill all the fields");
                                                                          
                                                                        } else {
                                                                                v_no=vehicleregno1;
                                                                            var form = document.getElementById("userdtls");
                                                                            var data = new FormData(form);
                                                                            var req = new XMLHttpRequest();

                                                                            req.onreadystatechange = function () {
                                                                                if (req.readyState === 4 && req.status === 200) {

                                                                                    if (req.responseText === "saved") {
                                                                                         document.getElementById("list").value=v_no;
                                                                                        document.getElementById("vehiclesfind").click();
//                                                                                        window.location.href = "quotation-add.php";
//                                                                                        window.location.reload();
//                                                                                        document.getElementById("list").value = v_no;
//                                                                                         document.getElementById("vehicles").submit();
//                                                                                         window.location.reload();
//                                                                                        var home1 = new FormData(home);
//                                                                                        var req2 = new XMLHttpRequest();
//                                                                                        req2.onreadystatechange = function () {
//                                                                                            if (req2.readyState === 4 && req2.status === 200){
//                                                                                                alert("ok");
//                                                                                            }
//                                                                                        };
//                                                                                        req2.open("POST", "service-add.php", true);
//                                                                                        req2.send(home1);

                                                                                    } else {
                                                                                        alert(req.responseText);
                                                                                    }
                                                                                }
                                                                            };

                                                                            req.open("POST", "quotation-add.php", true);
                                                                            req.send(data);
                                                                        }
                                                                    }

        </script>  


    </body>
</html>
