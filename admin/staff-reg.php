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
        $adname = $_POST['adname'];
        $username = $_POST['username'];
        $mobile = $_POST['mobile'];
        $email = $_POST['email'];
        $type = $_POST['type'];
        $basicsalary = $_POST['basicsalary'];
        $pass = md5($_POST['pass']);

        $find = mysqli_query($con, "Select * from tbladmin where MobileNumber='$mobile' and Email= '$email' ");
        $find1 = mysqli_query($con, "Select * from tbladmin where AdminuserName='$username'");
        $msgw = mysqli_num_rows($find);
        $msgw1 = mysqli_num_rows($find1);
        $msg = $msgw;
        if (!$msgw) {
//     $msg="empty find";
            if (!$msgw1) {
//         $msg="Empty username";
                $query = mysqli_query($con, "insert into  tbladmin(AdminName,AdminuserName,MobileNumber,Email,Password,type,status,BasicSalary) value('$adname','$username','$mobile','$email','$pass','$type','Enabled','$basicsalary')");
                if ($query) {
                    $msg = "Staff has been registered.";
                    header("location:staff-reg.php");
                } else {
                    $msg = "Something Went Wrong. Please try again";
                }
            } else {
                $msg = "Try with different User Name";
            }
        } else {
            $msg = "This Number and Mail ID already associated with another ID. Please choose different one.";
        }
    } else if (isset($_POST['status'])) {
        //Enable disable user
        $useid = $_POST['userid'];
        $findUser = mysqli_query($con, "select * from  tbladmin where ID=$useid");
        $findUser_row = mysqli_fetch_array($findUser);

        if ($findUser_row['status'] == "Disabled") {

//       enable 
            $upq = mysqli_query($con, "update tbladmin set status='Enabled' where ID=$useid");
            if ($upq) {
                $msg = "Update has been registered.";
                header("location:staff-reg.php");
            } else {
                $msg = "Error while Enable.";
            }
        } else {
//        disable
            $upq = mysqli_query($con, "update tbladmin set status='Disabled' where ID=$useid");
            if ($upq) {
                $msg = "Update has been registered.";
                header("location:staff-reg.php");
            } else {
                $msg = "Error while Disable.";
            }
        }
    } else if (isset($_POST['updtall'])) {
        $useid = $_POST['userid'];
        $adname = $_POST['adname'];
        $username = $_POST['username'];
        $mobile = $_POST['mobile'];
        $email = $_POST['email'];

        $basicsalary = $_POST['basicsalary'];

        $upq = mysqli_query($con, "update tbladmin set AdminName='$adname',AdminuserName='$username',MobileNumber='$mobile',Email='$email',BasicSalary='$basicsalary' where ID='$useid'");
        if ($upq) {
            $msg = "Update has been registered.";
            header("location:staff-reg.php");
        } else {
            $msg = "Error while Updating....";
        }
    }
    ?>
    <!doctype html>
    <html lang="en">

        <head>
            <meta charset="utf-8" />
            <title>Staff Registration</title>
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
                                        <h4 class="m-t-0 header-title">Staff Registration</h4>
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
                                                    <form class="form-horizontal" role="form" method="post" name="submit">

                                                        <div class="form-group row">
                                                            <label class="col-2 col-form-label" for="Admin_Name">Staff Name</label>
                                                            <div class="col-10">
                                                                <input type="text" id="Admin_Name" name="adname" class="form-control"  required="true">
                                                            </div>
                                                        </div>

                                                        <div class="form-group row">
                                                            <label class="col-2 col-form-label" for="username">User Name</label>
                                                            <div class="col-10">
                                                                <input type="text" id="username" name="username" class="form-control" maxlength="10" required="true">
                                                            </div>
                                                        </div>

                                                        <div class="form-group row">
                                                            <label class="col-2 col-form-label" for="mobile">Phone Number</label>
                                                            <div class="col-10">
                                                                <input type="text" id="mobile" name="mobile" class="form-control" maxlength="10"  required="true">
                                                            </div>
                                                        </div>
                                                        <div class="form-group row">
                                                            <label class="col-2 col-form-label" for="basicsalary">Basic Salary</label>
                                                            <div class="col-10">
                                                                <input type="number" min="0" id="basicsalary" name="basicsalary" class="form-control" maxlength="10"  required="true">
                                                            </div>
                                                        </div>

                                                        <div class="form-group row">
                                                            <label class="col-2 col-form-label" for="email">Email</label>
                                                            <div class="col-10">
                                                                <input type="email" id="email" name="email" class="form-control"  required="true">
                                                            </div>
                                                        </div>

                                                        <div class="form-group row">
                                                            <label class="col-2 col-form-label" for="">Password</label>
                                                            <div class="col-10">
                                                                <input type="text" id="pass" name="pass" class="form-control" readonly="true" value="123456789" required="true">
                                                            </div>
                                                        </div>
                                                        <div class="form-group row">
                                                            <label class="col-2 col-form-label" for="type">User Type</label>
                                                            <div class="col-10">
                                                                <select name="type" id="type" class="form-control">
                                                                    <option  >Staff</option>
                                                                    <option  >Admin</option>
                                                                </select>
                                                            </div>
                                                        </div>

                                                        <div class="form-group row">

                                                            <div class="col-12">
                                                                <p style="text-align: center;"> <button type="submit" name="submit" class="btn btn-info btn-min-width mr-1 mb-1">Register</button></p>
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


                            <div class="row">
                                <div class="col-12">
                                    <div class="card-box">
                                        <h4 class="m-t-0 header-title">Manage Staff</h4>
                                        <p class="text-muted m-b-30 font-14">

                                        </p>

                                        <div class="row">
                                            <div class="col-12">
                                                <div class="p-20">
                                                    <table class="table mb-0">
                                                        <thead>
                                                            <tr>
                                                                <th>S.NO</th>
                                                                <th>Name</th>
                                                                <th>User Name</th>
                                                                <th>Mobile Number</th>
                                                                <th>Email</th>
                                                                <th>Type</th>
                                                                <th>B.Salary</th>
                                                                <th>Status</th>

                                                                <th>Action</th>
                                                            </tr>
                                                        </thead>
                                                        <?php
                                                        $rno = mt_rand(10000, 99999);
                                                        $ret = mysqli_query($con, "select * from  tbladmin ");
                                                        $cnt = 1;

                                                        while ($row = mysqli_fetch_array($ret)) {
                                                            if ($row['AdminuserName'] != "Developer") {
                                                                ?>

                                                                <tr>
                                                                <form method="POST">
                                                                    <td><?php echo $cnt; ?></td>

                                                                    <td><input type="text" id="adname" name="adname" class="form-control form-control-sm"  required="true" value="<?php echo $row['AdminName']; ?>"></td>
                                                                    <td><input type="text" id="username" name="username" class="form-control form-control-sm"  required="true" value="<?php echo $row['AdminuserName']; ?>"</td>
                                                                    <td><input type="number" id="mobile" name="mobile" class="form-control form-control-sm"  required="true" value="<?php echo $row['MobileNumber']; ?>"</td>
                                                                    <td><input type="email" id="email" name="email" class="form-control form-control-sm"  required="true" value="<?php echo $row['Email']; ?>"</td>
                                                                    <td><?php echo $row['type']; ?></td>
                                                                    <td><input type="number" id="basicsalary" name="basicsalary" class="form-control form-control-sm"  required="true" value="<?php echo $row['BasicSalary']; ?>"</td>
                                                                    <td><?php echo $row['status']; ?></td>
                                                                    <td>
                                                                        <input type="hidden" value="<?php echo $row['ID']; ?>" name="userid">
                                                                        <input type="submit" value="Update" name="updtall" class="btn btn-sm btn-info">
                                                                        <?php if ($row['ID'] != $_SESSION['adid']) { ?>
                                                                                                <!--<a href="staff-reg-update.php?mecid=<?php // echo base64_encode($row['ID'] . $rno);            ?>">Edit Details</a>-->
                                                                            <?php if ($row['status'] == "Enabled") { ?>
                                                                                <input type="submit" value="Disable" name="status" class="btn btn-sm btn-danger">
                                                                            <?php } else { ?>
                                                                                <input type="submit" value="Enable" name="status" class="btn btn-sm btn-success">
                                                                            <?php }
                                                                        } ?>
                                                                    </td>
                                                                </form>
                                                                </tr>
                                                                <?php
                                                                $cnt = $cnt + 1;
                                                            }
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