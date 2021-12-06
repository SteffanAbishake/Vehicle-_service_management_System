<?php
session_start();
error_reporting(0);
include('includes/dbconnection.php');
if (strlen($_SESSION['adid'] == 0)) {
    header('location:logout.php');
} else {

    if (isset($_POST['updateparts'])) {
        $sr_id1 = $_GET['aticid'];
        $invoice_id1 = $_POST['invo_id']; //
        $up_qty = $_POST['qtyupdate']; //
        $query_up = mysqli_query($con, "Select * from invoice where stock_id='$invoice_id1' and tblservicerequest_ID='$sr_id1'");
        $row0 = mysqli_fetch_array($query_up);
        $pri = $row0['price'];
        $upd_tprice = $pri * $up_qty; //
        $update_query = mysqli_query($con, "Update invoice set invo_qty='$up_qty' , total='$upd_tprice' where stock_id='$invoice_id1' and tblservicerequest_ID='$sr_id1' ");
        if($update_query){
              $cid_gen = $_GET['aticid'];
             header("location:view-service.php?aticid=$cid_gen");
        }
//    $err="Total".$upd_tprice.'invo'.$invoice_id1.'qty'.$up_qty."PRI".$pri;
    } if (isset($_POST['partsqty1'])) {
        //Add parts to bill
        $tsr_id = $_GET['aticid'];
        $qty = $_POST['partsqty'];
        $p_id = $_POST['parts'];
        $p_id_query = mysqli_query($con, "Select * from stock where id='$p_id'");
        if ($p_id_row = mysqli_fetch_array($p_id_query)) {
            if ($p_id_row['qty'] >= $qty) {
                $price = $p_id_row['sellingprice'];
                $total1 = $qty * $price;
                $invoice_query = mysqli_query($con, "select * from invoice where stock_id='$p_id' and tblservicerequest_ID='$tsr_id' ");
                $count_invoice = mysqli_num_rows($invoice_query);
                if ($count_invoice == 0) {
                    // everything fine for enter to the invoice table 
                    $que = mysqli_query($con, "Insert into invoice(tblservicerequest_ID,stock_id,invo_qty,price,total) value('$tsr_id','$p_id','$qty','$price','$total1')");
                    if ($que) {
                        $p_id = "";
                          $cid_gen = $_GET['aticid'];
             header("location:view-service.php?aticid=$cid_gen");
                    } else {
                        $err = "Something error while on adding";
                    }
                } else {
                    //item found
                    $err = "This item in the list please update it!";
                }
            } else {
                $err = "You have entered Quantity Exceeded than available quantity";
            }
        } else {
            //no id found 
            $err = "Item not found";
        }
    } else if (isset($_POST['removeparts'])) {
        //remove from service 2
        $sr_id = $_GET['aticid'];
        $invoice_id = $_POST['invo_id'];
        $q = mysqli_query($con, "DELETE FROM invoice WHERE stock_id = '$invoice_id' and tblservicerequest_ID='$sr_id' ");
        if ($q) {
            $err = "ok";
             $cid_gen = $_GET['aticid'];
             header("location:view-service.php?aticid=$cid_gen");
        }
//        $err = $invoice_id;
//        header("location:view-service.php?aticid=$a");
    } elseif (isset($_POST['addservice'])) {
//         "addservice";
        $sr_idx = $_GET['aticid'];
        $service1 = $_POST['service1'];
        $servicecharge1 = $_POST['servicecharge1'];

        $addservice_query = mysqli_query($con, "Select * from servicecharge where tblservicerequest_ID='$sr_idx' and servicename='$service1'");
        if ($addservice_ro = mysqli_fetch_array($addservice_query)) {
            $error_from_addservice = "Already in the list please update it!";
        } else {
            $addservice_insert = mysqli_query($con, "Insert into servicecharge(servicename,charge,tblservicerequest_ID) value('$service1','$servicecharge1','$sr_idx')");
            if ($addservice_insert) {
                   $cid_gen = $_GET['aticid'];
             header("location:view-service.php?aticid=$cid_gen");
            } else {
                $error_from_addservice = "Error while entering data";
            }
        }
    } else if (isset($_POST['updateservice'])) {
        //Update Service charge

        $ser_id = $_POST['service_id'];
        $ser_update = $_POST['serviceupdate'];
        $ser_charge_update = $_POST['servicechargeupdate'];
        $serv_query = mysqli_query($con, "Update servicecharge set servicename='$ser_update',charge='$ser_charge_update' where sc_id=$ser_id  ");
        if($serv_query){
            $cid_gen = $_GET['aticid'];
             header("location:view-service.php?aticid=$cid_gen");
        }
    } else if (isset($_POST['removeservice'])) {
        //removeservice
        $ser_id_remove = $_POST['service_id'];
        $remove_service = mysqli_query($con, "Delete from servicecharge where sc_id=$ser_id_remove ");
        if($remove_service){
             $cid_gen = $_GET['aticid'];
             header("location:view-service.php?aticid=$cid_gen");
        }
    } elseif (isset($_POST['discounts'])) {
        // discounts application
        $sr_id_disc = $_GET['aticid'];
        $disc = $_POST['discount'];
        $disc_query = mysqli_query($con, "Update tblservicerequest set service_discount='$disc' where ID='$sr_id_disc'");
        if($disc_query){
            $cid_gen = $_GET['aticid'];
             header("location:view-service.php?aticid=$cid_gen");
        }
    } else if (isset($_POST['generate'])) {
//        $msg = "generate";
        $cid_gen = $_GET['aticid'];
        $admrmk = $_POST['AdminRemark']; //
        $admsta = 3;
        $sercharge = $_POST['servicetotal'];
        $addcharge = 0;
        $partcharge = $_POST['partsgrandtotal'];
        $serviceby = $_POST['serper'];
        $totalcharge= intval($sercharge)+intval($partcharge);
        if ($admrmk) {
            
        } else {
            $admrmk = "Service Complete";
        }

//        $msg="cid=".$cid_gen." admrmk=".$admrmk." admsta=".$admsta." sercharge=".$sercharge." addcharge=".$addcharge." partcharge=".$partcharge." serviceby=".$serviceby;
        $date_ser = date("Y-m-d");
        $query = mysqli_query($con, "update  tblservicerequest set ServiceDate='$date_ser', AdminRemark='$admrmk',AdminStatus='$admsta', ServiceCharge='$sercharge',OtherCharge='$addcharge', PartsCharge='$partcharge', ServiceBy='$serviceby' where ID='$cid_gen'");
        if ($query) {
            $paidby = $_POST['paidby'];
            $receiveamount = $_POST['receiveamount'];
            $balanceamount1 = $_POST['balanceamount1'];
            if ($paidby == "cash") {
//                $msg = "Insert into payment_details(date,paidby,receiveamount,balanceamount1,tblservicerequest_ID) values('$date_ser','$paidby','$receiveamount','$balanceamount1','$cid_gen')";
                $querypd1 = mysqli_query($con, "Insert into payment_details(date,paidby,receiveamount,balanceamount1,totalcharge,tblservicerequest_ID) values('$date_ser','$paidby','$receiveamount','$balanceamount1','$totalcharge','$cid_gen')");
            } else if ($paidby == "cheque") {
                $chequeno = $_POST['chequeno'];
                $chequebank = $_POST['chequebank'];
                $chequedate = $_POST['chequedate'];
//                $msg = "Insert into payment_details(date,paidby,chequeno,chequebank,chequedate,receiveamount,balanceamount1,tblservicerequest_ID) values('$date_ser','$paidby','$chequeno','$chequebank','$chequedate','$receiveamount','$balanceamount1','$cid_gen')";
                $querypd2 = mysqli_query($con, "Insert into payment_details(date,paidby,chequeno,chequebank,chequedate,receiveamount,balanceamount1,totalcharge,tblservicerequest_ID) values('$date_ser','$paidby','$chequeno','$chequebank','$chequedate','$receiveamount','$balanceamount1',$totalcharge,'$cid_gen')");
            } else if ($paidby == "card") {
                $cardno = $_POST['cardno'];
//                $msg = "Insert into payment_details(date,paidby,cardno,receiveamount,balanceamount1,tblservicerequest_ID) values('$date_ser','$paidby','$cardno','$receiveamount','$balanceamount1','$cid_gen')";
                $querypd3 = mysqli_query($con, "Insert into payment_details(date,paidby,cardno,receiveamount,balanceamount1,totalcharge,tblservicerequest_ID) values('$date_ser','$paidby','$cardno','$receiveamount','$balanceamount1','$totalcharge','$cid_gen')");
            }
            $removestock_q = mysqli_query($con, "select * from invoice where tblservicerequest_ID='$cid_gen'");
            $count_remove = mysqli_num_rows($removestock_q);
            if ($count_remove > 0) {
                //partschanged

                while ($rem_invo = mysqli_fetch_array($removestock_q)) {
                    // remove parts from stock
                    $stock_id_r = $rem_invo['stock_id'];
                    $invo_qty = $rem_invo['invo_qty'];
                    $invo_id = $rem_invo['id'];
                    $invo_price = $rem_invo['price'];

                    $store_update = mysqli_query($con, "Select * from stock where id='$stock_id_r'");

                    if ($store_update_row = mysqli_fetch_array($store_update)) {
                        //stock update with removed items
                        $stock_qty = $store_update_row['qty'];
                        $stock_change = $stock_qty - $invo_qty;
                        $new_update_stock = mysqli_query($con, "Update stock set qty='$stock_change' where id='$stock_id_r'");
                        if ($new_update_stock) {
                            $grn_update = mysqli_query($con, "Select * from grn where stock_id='$stock_id_r'");

                            while ($grn_remove = mysqli_fetch_array($grn_update)) {
                                $grn_available_qty = intval($grn_remove['availabe_qty']);
                                $grn_id = $grn_remove['id'];
                                $grn_price = $grn_remove['buyingprice'];
                                if ($grn_available_qty > 0) {
                                    $grn_available_qty_val = $grn_available_qty - intval($invo_qty);
                                    $grn_id = $grn_remove['id'];
                                    if ($grn_available_qty_val <= 0) {
                                        $profit_amount = (intval($invo_price) - intval($grn_price)) * intval($grn_available_qty);
                                        $profit = mysqli_query($con, "Insert into profit(grn_id,invoice_id,date,profit_amount,sold_qty) values('$grn_id','$invo_id','$date_ser','$profit_amount','$grn_available_qty')");
                                        $invo_qty = intval($invo_qty) - $grn_available_qty;
                                        $new_update_grn = mysqli_query($con, "Update grn set availabe_qty='0' where id='$grn_id'");
                                    } else if ($grn_available_qty_val > 0) {
                                        $profit_amount1 = (intval($invo_price) - intval($grn_price)) * intval($invo_qty);
                                        $profit1 = mysqli_query($con, "Insert into profit(grn_id,invoice_id,date,profit_amount,sold_qty) values('$grn_id','$invo_id','$date_ser','$profit_amount1','$invo_qty')");
                                        $new_update_grn1 = mysqli_query($con, "Update grn set availabe_qty='$grn_available_qty_val' where id='$grn_id'");
                                        break;
                                    }
                                }
                            }
                        }
                    }
                }
                //Report Generation
           header("location:invoice_Receipt.php?aticid=$cid_gen");
            } else {
                //no parts
                //Report Generation
               header("location:invoice_Receipt.php?aticid=$cid_gen");
            }
        } else {
            $msg = "Something Went Wrong. Please try again";
        }
    } else if (isset($_POST['deleteform'])) {
        //Remove Complete Form
        $cid_delete = $_GET['aticid'];
        $dele = mysqli_query($con, "Update tblservicerequest set AdminStatus='2' where ID='$cid_delete'");
        if ($dele) {
            header("location:rejected-services.php");
        } else {
            $msg = "Something Went Wrong on deleting service form. Please try again";
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


        <body onload="scroll();">

            <!-- Begin page -->
            <div id="wrapper">

    <?php include_once('includes/sidebar.php'); ?>

                <!-- ============================================================== -->
                <!-- Start right Content here -->
                <!-- ============================================================== -->

                <div class="content-page">

    <?php include_once('includes/header.php'); ?>
                    <!--<button onclick="window.print();">Print Report</button>-->
                    <!-- Start Page content -->
                    <div class="content">
                        <div class="container-fluid">

                            <div class="row">
                                <div class="col-12">
                                    <div class="card-box">
                                        <h4 class="m-t-0 header-title">View Services</h4>
                                        <p class="text-muted m-b-30 font-14">

                                        </p>

                                        <div class="row">
                                            <div class="col-12">
                                                <div class="p-20">

                                                    <p style="font-size:16px; color:red" align="center"> <?php
    if ($msg) {
        echo $msg;
    }
    ?>
                                                    </p>


                                                        <?php
                                                        $cid = $_GET['aticid'];
                                                        $ret = mysqli_query($con, "select * from tblservicerequest join tbluser on tbluser.ID=tblservicerequest.UserId where tblservicerequest.ID='$cid'");
                                                        $cnt = 1;
                                                        while ($row = mysqli_fetch_array($ret)) {
                                                            $vrn = $row['VehicleRegno'];
                                                            $times_q = mysqli_query($con, "Select * from tblservicerequest where VehicleRegno='$vrn' ");
                                                            $time = mysqli_num_rows($times_q);
                                                            ?>

                                                        <table border="1" class="table table-bordered mg-b-0">
                                                            <tr>
                                                                <th>Number of Service</th>
                                                                <td><?php echo $time; ?></td>
                                                            </tr>
                                                            <tr>
                                                                <th>Full Name</th>
                                                                <td><?php echo $row['FullName']; ?></td>
                                                            </tr>

                                                            <tr>
                                                                <th>Vehicle Category</th>
                                                                <td><?php echo $row['Category']; ?></td>
                                                            </tr>
                                                            <tr>
                                                                <th>Vehicle Name</th>
                                                                <td><?php echo $row['VehicleName']; ?></td>
                                                            </tr>

                                                            <tr>
                                                                <th>Vehicle Model</th>
                                                                <td><?php echo $row['VehicleModel']; ?></td>
                                                            </tr>

                                                            <tr>
                                                                <th>Vehicle Brand</th>
                                                                <td><?php echo $row['VehicleBrand']; ?></td>
                                                            </tr>
                                                            <tr>
                                                                <th>  Vehicle Registration Number</th>
                                                                <td><?php echo $row['VehicleRegno']; ?></td>
                                                            </tr>
                                                            <tr>
                                                                <th>Service Date</th>
                                                                <td><?php echo $row['ServiceDate']; ?></td>
                                                            </tr>
                                                            <tr>
                                                                <th>Service Time</th>
                                                                <td><?php echo $row['ServiceTime']; ?></td>
                                                            </tr>
                                                            <tr>
                                                                <th>Delivery Type</th>
                                                                <td><?php echo $row['DeliveryType']; ?></td>
                                                            </tr>
                                                            <tr>
                                                                <th>Drop Address</th>
                                                                <td><?php echo $row['PickupAddress']; ?></td>
                                                            </tr>
                                                            <tr>
                                                                <th>Service Request Date</th>
                                                                <td><?php echo $row['ServicerequestDate']; ?></td>
                                                            </tr>
                                                            <tr>
                                                                <th>Owner Type </th>
                                                                <td> <?php
                                                echo $row['ownertype'];
                                                ?></td>
                                                            </tr>
                                                            <tr>
                                                                <th>Current Meter Reading </th>
                                                                <td> <?php
                                                echo $row['present_meter_reading'] . " km";
                                                ?></td>
                                                            </tr>
                                                        </table>




                                                        <table class="table mb-0">

        <?php if ($row['AdminRemark'] == "") { ?>




                                                                <tr>
                                                                    <th>Parts Charge: </th>
                                                                    <td>
                                                                        <div class="">
                                                                            <form method="POST" class="form-horizontal input-group">
                                                                                <select type="text" name="parts" id="parts"  class="form-control"  style="margin-right: 10px;"  >
            <?php
            $parts = mysqli_query($con, "Select * from stock");
            while ($parts_row = mysqli_fetch_array($parts)) {
                if ($parts_row['qty'] != "0") {
                    ?>
                                                                                            <option value="<?php echo $parts_row['id']; ?>"><?php echo $parts_row['itemname']; ?> | <?php echo "Rs:" . $parts_row['sellingprice']; ?> | <?php echo "Available " . $parts_row['qty']; ?> |  <?php echo $parts_row['type']; ?></option>
                                                                                            <?php
                                                                                        }
                                                                                    }
                                                                                    ?>
                                                                                </select>
                                                                                <input type="number" name="partsqty"   min="1" placeholder="Quantity" class="form-control" style="margin-right: 10px;" value="1"  >
                                                                                <input type="submit" name="partsqty1"   class="btn btn-success"  class="form-control"    value="Add" >
                                                                            </form>
                                                                        </div>
                                                                        <p style="font-size:16px; color:red" align="center"> <?php
                                                                                    if ($err) {
                                                                                        echo $err;
                                                                                    }
                                                                                    ?>
                                                                        </p>

                                                                    </td>
                                                                </tr>
            <?php
            $grandtotal = 0;
            $partx = mysqli_query($con, "Select * from invoice i join stock s on i.stock_id=s.id  where i.tblservicerequest_ID=$cid");

            while ($parts_rowx = mysqli_fetch_array($partx)) {
                ?>
                                                                    <tr>
                                                                        <th></th>
                                                                        <td>
                                                                            <div>
                                                                                <form method="post" class="form-horizontal input-group">
                                                                                    <input type="hidden" class="form-control" value="<?php echo $parts_rowx['id']; ?>" name="invo_id" style="width:0px; ">
                                                                                    <input type="text" name="partsupdate"   class="form-control" placeholder="parts1" readonly="" value="<?php echo $parts_rowx['itemname'] . " | " . $parts_rowx['type'] . " | RS." . $parts_rowx['sellingprice']; ?>"  style="margin-right: 10px;" >
                                                                                    <input type="number" name="qtyupdate"  min="1" placeholder="qtyupdate" value="<?php echo $parts_rowx['invo_qty']; ?>" class="form-control" style="margin-right: 10px;" max="<?php echo $parts_row['qty']; ?>" onkeydown="return false" >
                                                                                    <label class="label" style="margin-right: 10px;"><?php echo "Total(Rs.) " . $parts_rowx['total']; ?></label>
                                                                                    <input type="submit" name="updateparts"  class="btn btn-success"  class="form-control"   value="Update" style="margin-right: 10px;" >
                                                                                    <input type="submit" name="removeparts"  class="btn btn-danger"  class="form-control"   value="Remove" style="margin-right: 10px;" >
                                                                                </form>

                                                                            </div>
                                                                        </td>
                                                                    </tr>
<!--                                                                    <script>
//                                                                        $(document).ready(function () {
//                                                                            var scrl = document.body.scrollHeight / 2;
////                                                                            window.scrollTo(scrl, 0);
//                                                                            $(window).scroll((scrl));
//                                                                        });
                                                                    </script>-->
                <?php
                $grandtotal += $parts_rowx['total'];
            }
            ?>

                                                                <tr>
                                                                    <th > Parts Total(Rs) </th>
                                                                    <td style="align-items:  flex-end;">
                                                                        <input type="hidden" value="<?php echo $grandtotal; ?>" id="parts_total">
                                                                        <label  style="font-size:16px; color: green; align-items:  flex-end ;" >
            <?php echo $grandtotal; ?>
                                                                        </label>
                                                                    </td>
                                                                </tr>
                                                                <tr >                                                                       
                                                                    <th>Service Charge: </th>
                                                                    <td id="service">
                                                                        <div class="input-group">
                                                                            <form method="post" class="form-horizontal input-group" >

                                                                                <input type="text" name="service1" id="serviceamount"  class="form-control" placeholder="Service" style="margin-right: 10px;" >
                                                                                <input type="number" name="servicecharge1" id="servicecharge" min="0" placeholder="Charges" class="form-control" style="margin-right: 10px;"  >
                                                                                <input type="submit" name="addservice" id="addservice"  class="btn btn-success"  class="form-control"   value="Add" >
                                                                            </form>
                                                                        </div>
                                                                        <p style="font-size:16px; color:red" align="center"> <?php
            if ($error_from_addservice) {
                echo $error_from_addservice;
            }
            ?>
                                                                        </p>
                                                                    </td>

                                                                </tr>
            <?php
            $serv = mysqli_query($con, "Select * from servicecharge where tblservicerequest_ID='$cid'");
            $service_total = 0;
            while ($serv_row = mysqli_fetch_array($serv)) {
                ?>
                                                                    <tr>
                                                                        <th></th>
                                                                        <td>
                                                                            <div class="input-group">
                                                                                <form method="post" class="form-horizontal input-group">
                                                                                    <input type="hidden" name="service_id" value="<?php echo $serv_row['sc_id']; ?>" >
                                                                                    <input type="text" name="serviceupdate" value="<?php echo $serv_row['servicename']; ?>" class="form-control" placeholder="Service" style="margin-right: 10px;" >
                                                                                    <input type="number" name="servicechargeupdate" value="<?php echo $serv_row['charge']; ?>"  min="0" placeholder="Charges" class="form-control" style="margin-right: 10px;"  >
                                                                                    <input type="submit" name="updateservice"  class="btn btn-success"  class="form-control"   value="Update" style="margin-right: 10px;" >
                                                                                    <input type="submit" name="removeservice"  class="btn btn-danger"  class="form-control"   value="Remove" >

                                                                                </form>
                                                                            </div>
                                                                        </td>
                <!--                                                                        <script>
                                                                        $(document).ready(function () {

                                                                            $(window).scrollTop(800);
                                                                        });
                                                                    </script>-->
                                                                    </tr>
                <?php
                $service_total += $serv_row['charge'];
            }
            ?>

                                                                <tr>
                                                                <?php
                                                                $query_t = mysqli_query($con, "select * from tblservicerequest where ID=$cid");
                                                                $d_r = mysqli_fetch_array($query_t);
                                                                $discoun = $d_r['service_discount'];
                                                                ?>
                                                                    <th>Discount for Service Charge(%):</th>
                                                                    <td>
                                                                        <form class="form-group input-group" method="post">
                                                                            <input type="number" name="discount" min="0" class="form-control" value="<?php echo $d_r['service_discount']; ?>">
                                                                            <input name="discounts" value="Apply" class="btn btn-success" type="submit">
                                                                        </form>
                                                                    </td>                                                                                                                                                          
                                                                </tr>
                                                                <tr>
                                                                    <th>
                                                                        Total Service Charge with discount(RS.)
                                                                    </th>
                                                                    <td>
                                                                        <input type="hidden" value="<?php echo $service_total * ((100 - $discoun) / 100); ?>" id="servicecharge_total">
                                                                        <label style="font-size:16px; color: green; align-items:  flex-end ;" ><?php echo $service_total * ((100 - $discoun) / 100); ?></label> 
                                                                    </td>
                                                                </tr>
                                                                <form name="generate" method="post" >
                                                                    <tr>
                                                                        <th>Admin Remark :</th>
                                                                        <td>
                                                                            <input type="hidden" value="<?php echo $service_total * ((100 - $discoun) / 100); ?>"  name="servicetotal">
                                                                            <input type="hidden" value="<?php echo $grandtotal; ?>" name="partsgrandtotal">
                                                                            <textarea name="AdminRemark" placeholder="" rows="2" cols="14" class="form-control wd-450" ></textarea></td>
                                                                    </tr>

                                                <!--                                                                    <tr>
                                                                                                                        <th>Admin Status :</th>
                                                                                                                        <td>
                                                                                                                            <select name="status" class="form-control wd-450" required="true" >
                                                                                                                                <option value="3" selected="true">Completed</option>     
                                                                                                                            </select></td>
                                                                                                                    </tr>-->
                                                                    <tr>
                                                                        <th>Service By :</th>
                                                                        <td>
                                                                            <select name='serper' id="serper" class="form-control" required="" >
                                                                                <option value="">Service By</option>
            <?php
            $query = mysqli_query($con, "select * from tblmechanics where status like 'Enabled'");
            while ($row = mysqli_fetch_array($query)) {
                ?>    
                                                                                    <option value="<?php echo $row['FullName']; ?>"><?php echo $row['FullName']; ?></option>
                                                                                <?php } ?>  
                                                                            </select>
                                                                        </td>
                                                                    </tr>
                                                                    <tr >
                                                                        <th>Paid By:</th> 
                                                                        <td>
                                                                            <input type="hidden" name="paidby" value="cash" id="paidby">
                                                                            <select id="paymentmethod" onchange="methodss();" class="form-control">
                                                                                <option selected="" value="cash">Cash</option>
                                                                                <option  value="card">Card</option>
                                                                                <option  value="cheque">Cheque</option>
                                                                            </select>
                                                                        </td>
                                                                    </tr>
                                                                    <tr id="carddetails" style="display: none;">
                                                                        <th>Card Details: </th>
                                                                        <td>
                                                                            <input  name="cardno" id="cardno" type="number"  placeholder="Card No(Last 4 digits)">

                                                                        </td>

                                                                    </tr> 
                                                                    <tr id="chequedetails" style="display: none;" >
                                                                        <th>Cheque Details: </th>
                                                                        <td>
                                                                            <input name="chequeno" id="chequeno" type="number" placeholder="Cheque No"><br><br>
                                                                            <input name="chequebank" id="chequebank" type="text" placeholder="Name of the Bank"><br><br>
                                                                            <!--<input name="chequeamount" id="chequeamount" type="number" placeholder="Cheque Amount"><br><br>-->
                                                                            <input name="chequedate" id="chequedate" type="date" placeholder="Cheque Date">
                                                                        </td>

                                                                    </tr>
                                                                    <tr>
                                                                        <th>Recieving Amount:</th>
                                                                        <td >
                                                                            <input class="form-control" onkeyup="calculatebalancess();" onmousemove = "calculatebalancess1();" type="number" value="0" min="0" name="receiveamount" id="receiveamount" name="receiveamount">
                                                                        </td>
                                                                    </tr>
                                                                    <tr>
                                                                        <th>Balance Amount:</th>
                                                                        <td >
                                                                            <input type="hidden" value="0" name="balanceamount1" id="balanceamount1">
                                                                            <label id="balanceamount"></label>  
                                                                        </td>
                                                                    </tr>

                                                                    <tr align="center">
                                                                        <td colspan="">
                                                                            <button type="submit" name="generate" class="btn  btn-success" id="servicecomplete">Generate Report</button>
                                                                        </td>
                                                                </form> 

                                                                <td colspan="2">
                                                                    <form method="post" name="delete">
                                                                        <button type="submit" name="deleteform" class="btn btn-az-primary pd-x-20  btn-danger" id="servicedelete" >Delete</button>
                                                                    </form>
                                                                </td>
                                                                </tr>
                                                                <tr align="center">

                                                                </tr>
        <?php } else { ?>


                                                                <table border="1" class="table table-bordered mg-b-0">

                                                                    <tr>
                                                                        <th>Service Completion Date</th>
                                                                        <td><?php echo $row['ServiceDate']; ?>  </td></tr>
                                                                    <tr>
                                                                        <th>Admin Remark</th>
                                                                        <td><?php echo $row['AdminRemark']; ?></td>
                                                                    </tr>
                                                                    <tr>
                                                                    <tr>
                                                                        <th>Service By</th>
                                                                        <td><?php echo $row['ServiceBy']; ?></td>
                                                                    </tr>
                                                                    <tr>
                                                                        <th>Service Charge</th>
                                                                        <td><?php echo $schrg = $row['ServiceCharge']; ?></td>
                                                                    </tr>
                                                                    <tr>
                                                                        <th>Parts Charge</th>
                                                                        <td><?php echo $pchrg = $row['PartsCharge']; ?></td>
                                                                    </tr>
                                                                    <tr>
                                                                        <th>Other Charge(if any)</th>
                                                                        <td><?php echo $ochrg = $row['OtherCharge']; ?></td>
                                                                    </tr> 
                                                                    <tr>
                                                                        <th>Total Amount</th>
                                                                        <td><?php echo $ochrg + $schrg + $pchrg; ?></td>
                                                                    </tr>

                                                                </table>




        <?php } ?>




                                                        </table>

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
            <script type="text/javascript">
                                                                        function methodss() {
                                                                            var paymentmethod = document.getElementById("paymentmethod").value;
                                                                            var paidby = document.getElementById("paidby");
                                                                            var chequedetails = document.getElementById("chequedetails");
                                                                            var carddetails = document.getElementById("carddetails");

                                                                            if (paymentmethod == "cash") {
                                                                                paidby.value = "cash";
                                                                                chequedetails.removeAttribute("style");
                                                                                carddetails.removeAttribute("style");
                                                                                chequedetails.setAttribute("style", "display:none;");
                                                                                carddetails.setAttribute("style", "display:none;");

                                                                            } else if (paymentmethod == "cheque") {
                                                                                paidby.value = "cheque";
                                                                                chequedetails.removeAttribute("style");
                                                                                carddetails.setAttribute("style", "display:none;");

                                                                            } else if (paymentmethod == "card") {
                                                                                paidby.value = "card";

                                                                                carddetails.removeAttribute("style");
                                                                                chequedetails.setAttribute("style", "display:none;");
                                                                            }


                                                                        }

                                                                        function calculatebalancess() {
                                                                            var servicecharge_total = document.getElementById("servicecharge_total").value;
                                                                            var parts_total = document.getElementById("parts_total").value;
                                                                            var balanceamount = document.getElementById("balanceamount");
                                                                            var receiveamount = document.getElementById("receiveamount").value;
                                                                            var balanceamount1 = document.getElementById("balanceamount1");

                                                                            var balance = parseInt(receiveamount) - (parseInt(servicecharge_total) + parseInt(parts_total));
                                                                            if (balance < 0) {
                                                                                balanceamount.setAttribute("style", "font-size:16px; color: red; align-items:  flex-end ;");
                                                                                balanceamount.innerHTML = balance;
                                                                                balanceamount1.value = balance;
                                                                            } else if (balance >= 0) {
                                                                                balanceamount.setAttribute("style", "font-size:16px; color: green; align-items:  flex-end ;");
                                                                                balanceamount.innerHTML = balance;
                                                                                balanceamount1.value = balance;

                                                                            }

                                                                        }

                                                                        function calculatebalancess1() {
                                                                            var servicecharge_total = document.getElementById("servicecharge_total").value;
                                                                            var parts_total = document.getElementById("parts_total").value;
                                                                            var balanceamount = document.getElementById("balanceamount");
                                                                            var balanceamount1 = document.getElementById("balanceamount1");
                                                                            var receiveamount = document.getElementById("receiveamount").value;

                                                                            if (receiveamount == "") {
                                                                                receiveamount = 0;
                                                                            }

                                                                            var balance = parseInt(receiveamount) - (parseInt(servicecharge_total) + parseInt(parts_total));
                                                                            if (balance < 0) {
                                                                                balanceamount.setAttribute("style", "font-size:16px; color: red; align-items:  flex-end ;");
                                                                                balanceamount.innerHTML = balance;
                                                                                balanceamount1.value = balance;
                                                                            } else if (balance >= 0) {
                                                                                balanceamount.setAttribute("style", "font-size:16px; color: green; align-items:  flex-end ;");
                                                                                balanceamount.innerHTML = balance;
                                                                                balanceamount1.value = balance;

                                                                            }

                                                                        }


    //                                                                                var x;
    //                                                                                $(document).ready(function () {
    //                                                                                    $('#y').click(function () {
    //                                                                                        x = $(window).scrollTop();
    //    //                                                                                        alert(x);
    //    //                                                                                        window.location.href="view-service.php?aticid=9";
    //
    //                                                                                    });
    //                                                                                });
    //
                                                                        function scroll() {
                                                                            //                                                                                    alert(x);
                                                                            var scrl = document.body.scrollHeight / 2;
                                                                            window.scrollTo(scrl, 0);

                                                                        }

            </script>

        </body>
    </html>
<?php } ?>