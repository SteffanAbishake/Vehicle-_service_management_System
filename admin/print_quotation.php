<?php
session_start();
error_reporting(0);
include('includes/dbconnection.php');
if (strlen($_SESSION['adid'] == 0)) {
    header('location:logout.php');
} else {
//
//    if (isset($_POST['updateparts'])) {
//        $sr_id1 = $_GET['aticid'];
//        $invoice_id1 = $_POST['invo_id']; //
//        $up_qty = $_POST['qtyupdate']; //
//        $query_up = mysqli_query($con, "Select * from invoice where stock_id='$invoice_id1' and tblservicerequest_ID='$sr_id1'");
//        $row0 = mysqli_fetch_array($query_up);
//        $pri = $row0['price'];
//        $upd_tprice = $pri * $up_qty; //
//        $update_query = mysqli_query($con, "Update invoice set invo_qty='$up_qty' , total='$upd_tprice' where stock_id='$invoice_id1' and tblservicerequest_ID='$sr_id1' ");
////    $err="Total".$upd_tprice.'invo'.$invoice_id1.'qty'.$up_qty."PRI".$pri;
//    } if (isset($_POST['partsqty1'])) {
//        //Add parts to bill
//        $tsr_id = $_GET['aticid'];
//        $qty = $_POST['partsqty'];
//        $p_id = $_POST['parts'];
//        $p_id_query = mysqli_query($con, "Select * from stock where id='$p_id'");
//        if ($p_id_row = mysqli_fetch_array($p_id_query)) {
//            if ($p_id_row['qty'] >= $qty) {
//                $price = $p_id_row['sellingprice'];
//                $total1 = $qty * $price;
//                $invoice_query = mysqli_query($con, "select * from invoice where stock_id='$p_id' and tblservicerequest_ID='$tsr_id' ");
//                $count_invoice = mysqli_num_rows($invoice_query);
//                if ($count_invoice == 0) {
//                    // everything fine for enter to the invoice table 
//                    $que = mysqli_query($con, "Insert into invoice(tblservicerequest_ID,stock_id,invo_qty,price,total) value('$tsr_id','$p_id','$qty','$price','$total1')");
//                    if ($que) {
//                        $p_id = "";
//                    } else {
//                        $err = "Something error while on adding";
//                    }
//                } else {
//                    //item found
//                    $err = "This item in the list please update it!";
//                }
//            } else {
//                $err = "You have entered Quantity Exceeded than available quantity";
//            }
//        } else {
//            //no id found 
//            $err = "Item not found";
//        }
//    } else if (isset($_POST['removeparts'])) {
//        //remove from service 2
//        $sr_id = $_GET['aticid'];
//        $invoice_id = $_POST['invo_id'];
//        $q = mysqli_query($con, "DELETE FROM invoice WHERE stock_id = '$invoice_id' and tblservicerequest_ID='$sr_id' ");
//        if ($q) {
//            $err = "ok";
//        }
////        $err = $invoice_id;
////        header("location:view-service.php?aticid=$a");
//    } elseif (isset($_POST['addservice'])) {
////         "addservice";
//        $sr_idx = $_GET['aticid'];
//        $service1 = $_POST['service1'];
//        $servicecharge1 = $_POST['servicecharge1'];
//
//        $addservice_query = mysqli_query($con, "Select * from servicecharge where tblservicerequest_ID='$sr_idx' and servicename='$service1'");
//        if ($addservice_ro = mysqli_fetch_array($addservice_query)) {
//            $error_from_addservice = "Already in the list please update it!";
//        } else {
//            $addservice_insert = mysqli_query($con, "Insert into servicecharge(servicename,charge,tblservicerequest_ID) value('$service1','$servicecharge1','$sr_idx')");
//            if ($addservice_insert) {
//                
//            } else {
//                $error_from_addservice = "Error while entering data";
//            }
//        }
//    } else if (isset($_POST['updateservice'])) {
//        //Update Service charge
//
//        $ser_id = $_POST['service_id'];
//        $ser_update = $_POST['serviceupdate'];
//        $ser_charge_update = $_POST['servicechargeupdate'];
//        $serv_query = mysqli_query($con, "Update servicecharge set servicename='$ser_update',charge='$ser_charge_update' where sc_id=$ser_id  ");
//    } else if (isset($_POST['removeservice'])) {
//        //removeservice
//        $ser_id_remove = $_POST['service_id'];
//        $remove_service = mysqli_query($con, "Delete from servicecharge where sc_id=$ser_id_remove ");
//    } elseif (isset($_POST['discounts'])) {
//        // discounts application
//        $sr_id_disc = $_GET['aticid'];
//        $disc = $_POST['discount'];
//        $disc_query = mysqli_query($con, "Update tblservicerequest set service_discount='$disc' where ID='$sr_id_disc'");
//    } else 
//    
    if (isset($_POST['generate'])) {
//        $msg = "generate";
        $cid_gen = $_GET['aticid'];
//        $admrmk = $_POST['AdminRemark']; //
//        $admsta = 3;
//        $sercharge = $_POST['servicetotal'];
//        $addcharge = 0;
//        $partcharge = $_POST['partsgrandtotal'];
//        $serviceby = $_POST['serper'];
//        if ($admrmk) {
//            
//        } else {
//            $admrmk = "Service Complete";
//        }
//        $msg="cid=".$cid_gen." admrmk=".$admrmk." admsta=".$admsta." sercharge=".$sercharge." addcharge=".$addcharge." partcharge=".$partcharge." serviceby=".$serviceby;
//        $query = mysqli_query($con, "update  tblservicerequest set AdminRemark='$admrmk',AdminStatus='$admsta', ServiceCharge='$sercharge',OtherCharge='$addcharge', PartsCharge='$partcharge', ServiceBy='$serviceby' where ID='$cid_gen'");
//        if ($query) {
        $date_ser = date("Y-m-d");
         $paidby = $_POST['payments'];
        if($paidby=="notpaid"){ 
         $paidby = $_POST['paidby'];
         $totalcharge = $_POST['total_charges'];
            $receiveamount = $_POST['receiveamount'];
            $balanceamount1 = $_POST['balanceamount1'];
            if ($paidby == "cash") {
//                $msg = "Insert into payment_details(date,paidby,receiveamount,balanceamount1,tblservicerequest_ID) values('$date_ser','$paidby','$receiveamount','$balanceamount1','$cid_gen')";
                $querypd1 = mysqli_query($con, "Insert into payment_details_quota(date,paidby,receiveamount,balanceamount1,totalcharge,tblservicerequest_quotation_ID) values('$date_ser','$paidby','$receiveamount','$balanceamount1','$totalcharge','$cid_gen')");
            } else if ($paidby == "cheque") {
                $chequeno = $_POST['chequeno'];
                $chequebank = $_POST['chequebank'];
                $chequedate = $_POST['chequedate'];
//                $msg = "Insert into payment_details(date,paidby,chequeno,chequebank,chequedate,receiveamount,balanceamount1,tblservicerequest_ID) values('$date_ser','$paidby','$chequeno','$chequebank','$chequedate','$receiveamount','$balanceamount1','$cid_gen')";
                $querypd2 = mysqli_query($con, "Insert into payment_details_quota(date,paidby,chequeno,chequebank,chequedate,receiveamount,balanceamount1,totalcharge,tblservicerequest_quotation_ID) values('$date_ser','$paidby','$chequeno','$chequebank','$chequedate','$receiveamount','$balanceamount1',$totalcharge,'$cid_gen')");
            } else if ($paidby == "card") {
                $cardno = $_POST['cardno'];
//                $msg = "Insert into payment_details(date,paidby,cardno,receiveamount,balanceamount1,tblservicerequest_ID) values('$date_ser','$paidby','$cardno','$receiveamount','$balanceamount1','$cid_gen')";
                $querypd3 = mysqli_query($con, "Insert into payment_details_quota(date,paidby,cardno,receiveamount,balanceamount1,totalcharge,tblservicerequest_quotation_ID) values('$date_ser','$paidby','$cardno','$receiveamount','$balanceamount1','$totalcharge','$cid_gen')");
            }
        }
        
        $query = mysqli_query($con, "update  tblservicerequest_quotation set ServiceDate='$date_ser',AdminStatus='4' where ID='$cid_gen'");
        $removestock_q = mysqli_query($con, "select * from invoice_quotation where tblservicerequest_ID='$cid_gen'");
        $count_remove = mysqli_num_rows($removestock_q);
        if ($count_remove > 0) {
            //partschanged

            while ($rem_invo = mysqli_fetch_array($removestock_q)) {
                // remove parts from stock
                $stock_id_r = $rem_invo['stock_id'];
                $invo_qty = $rem_invo['invo_qty'];
                $print_status = $rem_invo['print_status'];
                $invo_id = $rem_invo['id'];
                $invo_price = $rem_invo['price'];
                $date_ser = date("Y-m-d");
                if ($print_status != "printed") {
                    $store_update = mysqli_query($con, "Select * from stock where id='$stock_id_r'");
                    if ($store_update_row = mysqli_fetch_array($store_update)) {

                        //pasted 

                        $stock_qty = $store_update_row['qty'];
                        $stock_change = $stock_qty - $invo_qty;
                        $new_update_invo = mysqli_query($con, "Update invoice_quotation set print_status='printed' where tblservicerequest_ID='$cid_gen'");
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
                                        $profit = mysqli_query($con, "Insert into profit_quotaion(grn_id,invoice_quotation_id,date,profit_amount,sold_qty) values('$grn_id','$invo_id','$date_ser','$profit_amount','$grn_available_qty')");
                                        $invo_qty = intval($invo_qty) - $grn_available_qty;
                                        $new_update_grn = mysqli_query($con, "Update grn set availabe_qty='0' where id='$grn_id'");
                                    } else if ($grn_available_qty_val >= 0) {
                                        $profit_amount1 = (intval($invo_price) - intval($grn_price)) * intval($invo_qty);
                                        $profit1 = mysqli_query($con, "Insert into profit_quotaion(grn_id,invoice_quotation_id,date,profit_amount,sold_qty) values('$grn_id','$invo_id','$date_ser','$profit_amount1','$invo_qty')");
                                        $new_update_grn1 = mysqli_query($con, "Update grn set availabe_qty='$grn_available_qty_val' where id='$grn_id'");
                                        break;
                                    }
                                }
                            }
                        }



                        //pasted
                    }
                }
            }
            $removestock_q = "";
            //Report Generation
            header("location:print_quotation_bill.php?aticid=$cid_gen");
        } else {
            //no parts
            //Report Generation
            header("location:print_quotation_bill.php?aticid=$cid_gen");
        }
//        } else {
//            $msg = "Something Went Wrong. Please try again";
//        }
//    }
    }
//    
//    else if (isset($_POST['deleteform'])) {
//        //Remove Complete Form
//        $cid_delete = $_GET['aticid'];
//        $dele = mysqli_query($con, "Update tblservicerequest set AdminStatus='2' where ID='$cid_delete'");
//        if ($dele) {
//            header("location:rejected-services.php");
//        } else {
//            $msg = "Something Went Wrong on deleting service form. Please try again";
//        }
//    }
    ?>
    <!doctype html>
    <html lang="en">

        <head>
            <meta charset="utf-8" />
            <title>Quotation</title>
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
            <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Aclonica">
            <script src="assets/js/modernizr.min.js"></script>

        </head>


        <body onload="calculatebalancess();">

            <!-- Begin page -->
            <div id="wrapper">

                <?php include_once('includes/sidebar.php'); ?>

                <!-- ============================================================== -->
                <!-- Start right Content here -->
                <!-- ============================================================== -->

                <div class="content-page">

                    <?php include_once('includes/header.php'); ?>
                    <!--                    <button onclick="window.print();">Print Report</button>-->
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


                                        <div class="row">
                                            <div class="col-12">
                                                <div class="p-20">



                                                    <?php
                                                    $adid123 = $_SESSION['adid'];
                                                    $retter = mysqli_query($con, "select AdminName from tbladmin where ID='$adid123'");
                                                    $rower = mysqli_fetch_array($retter);
                                                    $admname = $rower['AdminName'];
                                                    ?>
                                                    <div class="row">
                                                        <div class="col">
                                                            <div class="row">
                                                                <div class="col">
                                                                    <h4 class="m-t-0 header-title">Quotation</h4>
                                                                    <h1 class="text-center" style="font-size: 31px;font-family: Aclonica, sans-serif;"><strong><em>Vehicle Service Management System</em></strong></h1>
                                                                    <h6 class="text-center" style="font-family: Aclonica, sans-serif;font-size: 14px;margin-top: -5px;">22A, Galle Road, Dehiwala.</h6>
                                                                    <h6 class="text-center" style="font-family: Aclonica, sans-serif;font-size: 14px;margin-top: -5px;margin-bottom: -8px;">TEL: 000 0000 000 / 000 000 0000</h6>
                                                                    <h5 class="text-right">Quotation Generated By: <?php echo $admname; ?></a> </h5>
                                                                    <hr style="border-top:1px dashed black;">
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <?php 
                                                    $cid = $_GET['aticid'];
                                                    $ret = mysqli_query($con, "select * from tblservicerequest_quotation join tbluser on tbluser.ID=tblservicerequest_quotation.UserId where tblservicerequest_quotation.ID='$cid'");
                                                    $cnt = 1;
                                                    $totally=0;
                                                    while ($row = mysqli_fetch_array($ret)) {
                                                        $vrn = $row['VehicleRegno'];
                                                        $times_q = mysqli_query($con, "Select * from tblservicerequest_quotation where VehicleRegno='$vrn' ");
                                                        $time = mysqli_num_rows($times_q);
                                                        ?>

                                                        <table  class="table table-sm">
                                                            <tr class="d-none">
                                                                <th>Number of Services done</th>
                                                                <td><?php echo $time; ?></td>
                                                            </tr>
                                                            <tr>
                                                                <th> Name</th>
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
                                                            <tr class="d-none">
                                                                <th>Service Date</th>
                                                                <td><?php echo $row['ServiceDate']; ?></td>
                                                            </tr>
                                                            <tr class="d-none">
                                                                <th>Service Time</th>
                                                                <td><?php echo $row['ServiceTime']; ?></td>
                                                            </tr>
                                                            <tr class="d-none">
                                                                <th>Delivery Type</th>
                                                                <td><?php echo $row['DeliveryType']; ?></td>
                                                            </tr>
                                                            <tr class="d-none">
                                                                <th>Drop Address</th>
                                                                <td><?php echo $row['PickupAddress']; ?></td>
                                                            </tr>
                                                            <tr>
                                                                <th>Quotation Request Date</th>
                                                                <td><?php echo $row['ServicerequestDate']; ?></td>
                                                            </tr>
                                                            <tr>
                                                                <th>Owner Type </th>
                                                                <td> <?php
                                                                    echo $row['ownertype'];
                                                                    ?></td>
                                                            </tr>
                                                            <tr class="d-none">
                                                                <th>Current Meter Reading </th>
                                                                <td> <?php
                                                                    echo $row['present_meter_reading'] . " km";
                                                                    ?></td>
                                                            </tr>                                              

                                                            <tr class="d-none">
                                                                <th>Service By</th>
                                                                <td><?php echo $row['ServiceBy']; ?></td>
                                                            </tr>
                                                            <?php
                                                            $ind = 1;
                                                            $print_invoice_query = mysqli_query($con, "SELECT * from invoice_quotation i  join stock s on i.stock_id=s.id  where  i.tblservicerequest_ID='$cid'");
                                                            while ($row_ser = mysqli_fetch_array($print_invoice_query)) {
                                                                if ($ind == 1) {
                                                                    ?>
                                                                    <tr>
                                                                        <th>Parts :</th>
                                                                        <td ><?php echo $ind . ". Item: " . $row_ser['itemname'] . "(" . $row_ser['type'] . ")" . "  Qty:" . $row_ser['invo_qty'] . "    X  Price: " . $row_ser['price'] . "/=       Total:" . $row_ser['total'] . "/="; ?></td>
                                                                    </tr>
                                                                    <?php
                                                                } else {
                                                                    ?>
                                                                    <tr>
                                                                        <th></th>
                                                                        <td ><?php echo $ind . ". Item: " . $row_ser['itemname'] . "(" . $row_ser['type'] . ")" . "  Qty:" . $row_ser['invo_qty'] . "    X  Price: " . $row_ser['price'] . "/=       Total:" . $row_ser['total'] . "/="; ?></td>
                                                                    </tr>
                                                                    <?php
                                                                }
                                                                $ind += 1;
                                                            }
                                                            ?>

                                                            <tr>
                                                                <th>Parts Total</th>
                                                                <td class="text-right"><?php
                                                                    $pchrg = $row['PartsCharge'];
                                                                    echo "LKR: " . $pchrg . "/=";
                                                                    ?>
                                                                    <input type="hidden" value="<?php echo $pchrg; ?>" id="parts_total">
                                                                </td>
                                                            </tr>
                                                            <?php
                                                            $indx = 1;
                                                            $print_service_query = mysqli_query($con, "SELECT * from quotation_service sc  where  sc.tblservicerequest_ID='$cid'");
                                                            while ($row_service = mysqli_fetch_array($print_service_query)) {
                                                                if ($indx == 1) {
                                                                    ?>
                                                                    <tr>
                                                                        <th>Services</th> 
                                                                        <td ><?php echo $indx . ". " . $row_service['servicename'] . "      Charge: " . $row_service['charge'] . "/=  "; ?></td>
                                                                    </tr>
                                                                    <?php
                                                                } else {
                                                                    ?>
                                                                    <tr>
                                                                        <th></th>
                                                                        <td ><?php echo $indx . ". " . $row_service['servicename'] . "      Charge: " . $row_service['charge'] . "/=  "; ?></td>
                                                                    </tr>
                                                                    <?php
                                                                }
                                                                $indx += 1;
                                                            }
                                                            ?>
                                                            <tr>
                                                                <th>Discount(%)</th>
                                                                <td ><?php echo $row['service_discount']; ?>%</td>
                                                            </tr> 
                                                            <tr>
                                                                <th>Total Service Charge</th>
                                                                <td class="text-right"><?php
                                                                    $schrg = $row['ServiceCharge'];
                                                                    echo "LKR: " . $schrg . "/=";
                                                                    ?>
                                                                <input type="hidden" value="<?php echo $schrg; ?>" id="servicecharge_total">
                                                                </td>
                                                            </tr>
                                                            <tr class="d-none">
                                                                <th>Admin Remark</th>
                                                                <td><?php echo $row['AdminRemark']; ?></td>
                                                            </tr>

                                                            <tr>
                                                                <th>Total Amount</th>
                                                                <td class="text-right"><?php
                                                                    $totally = $schrg + $pchrg;
                                                                    echo "LKR: " . $totally . "/=";
                                                                    ?></td>
                                                            </tr>



                                                            <tr>
                                                                <th>Date</th>
                                                                <td class="text-right"><?php echo $row['AdminRemarkdate']; ?>  </td>
                                                            </tr>








                                                        </table>

                                                    <?php } ?>
                                                    <br>
                                                    <br>
                                                    <div class="text-right">.............................................</div>
                                                    <div class="text-right">Signature / Rubber Stamp</div>

                                                </div>
                                            </div>

                                        </div>
                                        <!-- end row -->

                                    </div> <!-- end card-box -->
                                </div><!-- end col -->
                            </div>
                            <!-- end row -->
                            <div class="row">
                                <div class="col offset-lg d-print-none">
                                    <?php 
                                    $cid_gen = $_GET['aticid'];
                                     $removestock_q_nums = mysqli_query($con, "select * from invoice_quotation where print_status like 'printed' and tblservicerequest_ID='$cid_gen'");
                                     if(mysqli_num_rows($removestock_q_nums)>0){
                                    ?>
                                    <form method="post">
                                        <input type="hidden" name="payments" value="paid">
                                    <button type="submit" name="generate" class="btn btn-success" ><i class="fi-printer"></i> View Invoice for this Quotation</button>
                                    </form>
                                     <?php } else{?>
                                    <form method="post">
                                        <table class="table ">
                                            <tr >
                                                <input type="hidden" name="payments" value="notpaid">
                                                <input type="hidden" name="total_charges" value="<?php echo $totally; ?>" id="total_charges">
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
                                                    <input class="form-control" onkeyup="calculatebalancess();" onmousemove = "calculatebalancess1();" type="number" value="0" min="0" name="receiveamount" required="" id="receiveamount" name="receiveamount">
                                                </td>
                                            </tr>
                                            <tr>
                                                <th>Balance Amount:</th>
                                                <td >
                                                    <input type="hidden" value="0" name="balanceamount1" id="balanceamount1">
                                                    <label id="balanceamount"></label>  
                                                </td>
                                            </tr>

                                        </table>
                                        <button type="submit" name="generate" class="btn btn-success" ><i class="fi-printer"></i> Generate Invoice for this Quotation</button>

                                    </form>
                                     <?php } ?>
                                </div>
                            </div>





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
                                                        //                                                                                function scroll() {
                                                        //    //                                                                                    alert(x);
                                                        //                                                                                    x = 900;
                                                        //                                                                                    $(window).scrollTop(x);
                                                        //                                                                                }

            </script>

        </body>
    </html>
<?php } ?>