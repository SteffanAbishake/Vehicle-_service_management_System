<?php 
session_start();
error_reporting(0);
include('includes/dbconnection.php');
if (strlen($_SESSION['adid']==0)) {
  header('location:logout.php');
  } else{
if(isset($_POST['submit']))
  {
    $sid=substr(base64_decode($_GET['udid']),0,-5);
    $fname=$_POST['fullname'];
    $mn=$_POST['mobilenumber'];
    
    
   

    $query=mysqli_query($con, "update tbluser set FullName='$fname',MobileNo='$mn' where ID='$sid'");


    if ($query) {
    $msg="User profile has been updated";
  }
  else
    {
      $msg="Something Went Wrong. Please try again";
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

          <?php include_once('includes/sidebar.php');?>

            <!-- ============================================================== -->
            <!-- Start right Content here -->
            <!-- ============================================================== -->

            <div class="content-page">

                 <?php include_once('includes/header.php');?>

                <!-- Start Page content -->
                <div class="content">
                    <div class="container-fluid">

                        <div class="row">
                            <div class="col-12">
                                <div class="card-box">
                                    <h4 class="m-t-0 header-title">Update Register User</h4>
                                    <p class="text-muted m-b-30 font-14">
                                       
                                    </p>

                                    <div class="row">
                                        <div class="col-12">
                                            <div class="p-20">
   
<p style="font-size:16px; color:red" align="center"> <?php if($msg){
    echo $msg;
  }  ?> </p>

                                               <form class="form-horizontal" role="form" method="post" name="submit">

                                                <?php
$sid=substr(base64_decode($_GET['udid']),0,-5);
$ret=mysqli_query($con,"select * from tbluser where ID='$sid'");
$cnt=1;
while ($row=mysqli_fetch_array($ret)) {

?>   
                                                   
                                                    <div class="form-group row">
                                                        <label class="col-2 col-form-label" for="example-email">Full Name</label>
                                                        <div class="col-10">
                                                            <input type="text" id="fullname" name="fullname" class="form-control"  required="true"  value="<?php echo $row['FullName'];?>">
                                                        </div>
                                                    </div>


                                                    <div class="form-group row">
                                                        <label class="col-2 col-form-label" for="example-email">Mobile Number</label>
                                                        <div class="col-10">
                                                            <input type="text" id="mobilenumber" name="mobilenumber" class="form-control"  required="true"   value="<?php echo $row['MobileNo'];?>">
                                                        </div>
                                                    </div>

<!--                                                     <div class="form-group row">
                                                        <label class="col-2 col-form-label" for="example-email">Email</label>
                                                        <div class="col-10">
                                                            <input type="email" id="email" name="mobilenumber" class="form-control"  required="true"   value="<?php // echo $row['Email'];?>">
                                                        </div>
                                                    </div>-->
                                                     <div class="form-group row">
                                                        <label class="col-2 col-form-label" for="example-email">Registration Date</label>
                                                        <div class="col-10">
                                                            <input type="regdate" id="regdate" name="regdate" class="form-control"  required="true"  readonly='true' value="<?php echo $row['RegDate'];?>">
                                                        </div>
                                                    </div>
                                                   
<?php } ?>
                                                    
                                                    
                                                    

                                                    
                                              
                                                 
                                              
           <div class="form-group row">
                                                    
                                                        <div class="col-12">
                                                           <p style="text-align: center;">  <button type="submit" name="submit" class="btn btn-info btn-min-width mr-1 mb-1">Update</button></p>
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


        



                        <!-- end row -->

    <div class="row">
                                <div class="col-12">
                                    <div class="card-box">
                                        <h4 class="m-t-0 header-title">Vehicles of this Customer</h4>
                                        <p class="text-muted m-b-30 font-14">

                                        </p>

                                        <div class="row">
                                            <div class="col-12">
                                                <div class="p-20">
                                                    <table class="table mb-0">
                                                        <thead>
                                                            <tr>
                                                                <th>S.NO</th>
                                                                <th>Brand</th>
                                                                <th>Vehicle Name</th>
                                                                 <th>Model</th>
                                                                <th>Registration Number</th>
                                                                <th>Ownertype</th>

                                                                <th>View Services</th>
                                                            </tr>
                                                        </thead>
                                                        <?php
                                                        $rno = mt_rand(10000, 99999);
                                                        $ret = mysqli_query($con, "select * from vehicle where tbluser_ID='$sid'");
                                                        $cnt = 1;
                                                        while ($row = mysqli_fetch_array($ret)) {
                                                            ?>

                                                            <tr>
                                                                <td><?php echo $cnt; ?></td>

                                                                <td><?php echo $row['vehiclebrand']; ?></td>
                                                                <td><?php echo $row['vehiclename']; ?></td>
                                                                <td><?php echo $row['vehiclemodel']; ?></td>
                                                                <td><?php echo $row['Vehiclenumber']; ?></td>
                                                                <td><?php echo $row['ownertype']; ?></td>


                                                                <td><a href="done_services.php?udid=<?php echo base64_encode($row['id'] . $rno); ?>" title="View Services"><i class="la la-edit"> View</i></a>
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







                    </div> <!-- container -->

                </div> <!-- content -->

             <?php include_once('includes/footer.php');?>
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
<?php }  ?>