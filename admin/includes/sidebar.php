<!-- ========== Left Sidebar Start ========== -->
<div class="left side-menu">

    <div class="slimscroll-menu" id="remove-scroll">

        <!-- LOGO -->
        <div class="topbar-left">
            <h3>VSMS | Admin  </h3>
            <hr />                    </div>

        <!-- User box -->
        <div class="user-box">
            <div class="user-img">
                <img src="assets/images/user.png" alt="user-img" title="Mat Helme" class="rounded-circle img-fluid">
            </div>

            <?php
            $adid = $_SESSION['adid'];
            $ret = mysqli_query($con, "select * from tbladmin where ID='$adid'");
            $row = mysqli_fetch_array($ret);
            $name = $row['AdminName'];
            $type = $row['type'];
            ?>
            <h5><?php echo $name; ?></a> </h5>
            <p class="text-muted">VSMS Admin</p>
        </div>
        <?php if ($type == 'Admin') { ?>
        <!--Admin-->
            <!--- Sidemenu -->
            <div id="sidebar-menu">

                <ul class="metismenu" id="side-menu">

                    <!--<li class="menu-title">Navigation</li>-->

                    <li>
                        <a href="dashboard.php">
                            <i class="fi-air-play"></i><span class="badge badge-danger badge-pill float-right"></span> <span> Dashboard </span>
                        </a>
                    </li>



                    <li>
                        <a href="javascript: void(0);"><i class="fi-layers"></i><span> Mechanics </span> <span class="menu-arrow"></span></a>
                        <ul class="nav-second-level" aria-expanded="false">
                            <li><a href="add-mechanics.php">Add Mechanics</a></li>
                            <li><a href="manage-mechanics.php">Manage Mechanics</a></li>
                        </ul>
                    </li>

                    <li>
                        <a href="javascript: void(0);"><i class="fi-layers"></i><span> Vehicle </span> <span class="menu-arrow"></span></a>
                        <ul class="nav-second-level" aria-expanded="false">
                            <li><a href="add-category.php">Add Vehicle Category</a></li>
                            <li><a href="manage-category.php">Manage Vehicle Category</a></li>
                            <li><a href="view_all_vehicles.php">View Registered Vehicle </a></li>
                        </ul>
                    </li>
                    <li>
                        <a href="javascript: void(0);"><i class="icon-user"></i><span>Users </span> <span class="menu-arrow"></span></a>
                        <ul class="nav-second-level" aria-expanded="false">
                            <li><a href="reg-user.php">Registered Customers</a></li>
                            <li><a href="staff-reg.php">Staff Registration</a></li>
                        </ul>
                    </li>





                    <!--                <li>
                                        <a href="reg-user.php">
                                            <i class="icon-people"></i> <span> Register Users </span>
                                        </a>
                                        <a href="javascript: void(0);"><i class="icon-user" ></i><span>Users  </span> <span class="menu-arrow"></span></a>;
                                         <ul class="nav-second-level" aria-expanded="false">
                                            <li><a href="reg-user.php">Registered Users</a></li>
                                            <li><a href="#">Staff Registration</a></li>
                                        </ul>
                                    </li>-->


                    <!--                <li>
                                        <a href="javascript: void(0);"><i class="fi-paper"></i><span> Service Request </span> <span class="menu-arrow"></span></a>
                                        <ul class="nav-second-level" aria-expanded="false">
                                            <li><a href="pending-service.php"> New </a></li>
                                            <li><a href="rejected-services.php">Rejected</a></li>
                                        </ul>
                                    </li>-->
                    <li>
                        <a href="javascript: void(0);"><i class="fi-paper"></i><span> Servicing </span> <span class="menu-arrow"></span></a>
                        <ul class="nav-second-level" aria-expanded="false">
                            <li><a href="service-add.php"> Add to Service </a></li>
                            <li><a href="rejected-services.php">Deleted Services</a></li>
                            <li><a href="pending-servicing.php"> Pending Services</a></li>
                            <li><a href="completed-service.php"> Completed Services</a></li>
                        </ul>
                    </li>
                    <li>
                        <a href="javascript: void(0);"><i class="fi-paper"></i><span> Quotation </span> <span class="menu-arrow"></span></a>
                        <ul class="nav-second-level" aria-expanded="false">
                            <li><a href="quotation-add.php"> New Quotation </a></li>
                            <li><a href="rejected-quotations.php">Deleted Quotations</a></li>
                            <li><a href="pending-quotations.php"> Pending Quotations</a></li>
                            <li><a href="completed-quotations.php"> Completed Quotations</a></li>
                            <li><a href="service-completed-quotations.php">Service Completed Quotations</a></li>
                        </ul>
                    </li>


                    <!--                <li>
                                        <a href="javascript: void(0);"><i class="fi-paper"></i><span> Customer Enquiry </span> <span class="menu-arrow"></span></a>
                                        <ul class="nav-second-level" aria-expanded="false">
                                            <li><a href="notrespond-enquiry.php"> Not Respond Enquiry</a></li>
                    
                                            <li><a href="respond-enquiry.php"> Respond Enquiry </a></li>
                                        </ul>
                                    </li>-->

                    <li>
                        <a href="javascript: void(0);"><i class="fi-bag"></i><span> Stock </span> <span class="menu-arrow"></span></a>
                        <ul class="nav-second-level" aria-expanded="false">
                            <li><a href="stock_add.php"> Add Stock</a></li>
                            <li><a href="view-stock.php"> View Stock </a></li>
                            <li><a href="update-stock.php"> Update Stock </a></li>
                        </ul>
                    </li>

                    <li>
                        <a href="javascript: void(0);"><i class="fi-paper"></i><span> Finance </span> <span class="menu-arrow"></span></a>
                        <ul class="nav-second-level" aria-expanded="false">
                            <li><a href="employee_list_for_salary.php"> Salary</a></li>
                            <li><a href="other_expanses.php">Other Expanses </a></li>
                           
                        </ul>
                    </li>
                    <li>
                        <a href="javascript: void(0);"><i class="fi-paper"></i><span> Reports </span> <span class="menu-arrow"></span></a>
                        <ul class="nav-second-level" aria-expanded="false">
                            <li><a href="stock_report.php"> Stock Report </a></li>
                            <li><a href="purchased_report.php"> Purchased Reports </a></li>
                            <li><a href="sales_report.php"> Sales Report</a></li>
                            <li><a href="other_exp_report.php"> Other Expanses Report </a></li>
                            <li><a href="profitloss.php"> Profit and Loss Report </a></li>
                            <li><a href="balsheet.php"> Balance Sheet </a></li>
                           
                        </ul>
                    </li>


                    <!--                <li>
                                         <a href="search-enquiry.php">
                                            <i class="fi-air-play"></i><span class="badge badge-danger badge-pill float-right"></span> <span> Enquiry Search </span>
                                        </a>
                                    </li>-->

                    <li>
                        <a href="search-service.php">
                            <i class="fi-air-play"></i><span class="badge badge-danger badge-pill float-right"></span> <span> Service Search </span>
                        </a>
                    </li>






                </ul>

            </div>
            <!-- Sidebar -->
        <?php } else { ?>
            <!--Staff-->
<!--- Sidemenu -->
            <div id="sidebar-menu">

                <ul class="metismenu" id="side-menu">

                    <!--<li class="menu-title">Navigation</li>-->

                    <li>
                        <a href="dashboard.php">
                            <i class="fi-air-play"></i><span class="badge badge-danger badge-pill float-right"></span> <span> Dashboard </span>
                        </a>
                    </li>



<!--                    <li>
                        <a href="javascript: void(0);"><i class="fi-layers"></i><span> Mechanics </span> <span class="menu-arrow"></span></a>
                        <ul class="nav-second-level" aria-expanded="false">
                            <li><a href="add-mechanics.php">Add Mechanics</a></li>
                            <li><a href="manage-mechanics.php">Manage Mechanics</a></li>
                        </ul>
                    </li>-->

                    <li>
                        <a href="javascript: void(0);"><i class="fi-layers"></i><span> Vehicle </span> <span class="menu-arrow"></span></a>
                        <ul class="nav-second-level" aria-expanded="false">
                               <!--<li><a href="add-category.php">Add Vehicle Category</a></li>-->
                            <!--<li><a href="manage-category.php">Manage Vehicle Category</a></li>-->
                            <li><a href="view_all_vehicles.php">View Registered Vehicle </a></li>
                        </ul>
                    </li>
                    <li>
                        <a href="javascript: void(0);"><i class="icon-user"></i><span>Users </span> <span class="menu-arrow"></span></a>
                        <ul class="nav-second-level" aria-expanded="false">
                            <li><a href="reg-user.php">Registered Customers</a></li>
                            <!--<li><a href="staff-reg.php">Staff Registration</a></li>-->
                        </ul>
                    </li>





                    <!--                <li>
                                        <a href="reg-user.php">
                                            <i class="icon-people"></i> <span> Register Users </span>
                                        </a>
                                        <a href="javascript: void(0);"><i class="icon-user" ></i><span>Users  </span> <span class="menu-arrow"></span></a>;
                                         <ul class="nav-second-level" aria-expanded="false">
                                            <li><a href="reg-user.php">Registered Users</a></li>
                                            <li><a href="#">Staff Registration</a></li>
                                        </ul>
                                    </li>-->


                    <!--                <li>
                                        <a href="javascript: void(0);"><i class="fi-paper"></i><span> Service Request </span> <span class="menu-arrow"></span></a>
                                        <ul class="nav-second-level" aria-expanded="false">
                                            <li><a href="pending-service.php"> New </a></li>
                                            <li><a href="rejected-services.php">Rejected</a></li>
                                        </ul>
                                    </li>-->
                    <li>
                        <a href="javascript: void(0);"><i class="fi-paper"></i><span> Servicing </span> <span class="menu-arrow"></span></a>
                        <ul class="nav-second-level" aria-expanded="false">
                            <li><a href="service-add.php"> Add to Service </a></li>
                            <li><a href="rejected-services.php">Deleted Services</a></li>
                            <li><a href="pending-servicing.php"> Pending Services</a></li>
                            <li><a href="completed-service.php"> Completed Services</a></li>
                        </ul>
                    </li>
                    <li>
                        <a href="javascript: void(0);"><i class="fi-paper"></i><span> Quotation </span> <span class="menu-arrow"></span></a>
                        <ul class="nav-second-level" aria-expanded="false">
                           <li><a href="quotation-add.php"> New Quotation </a></li>
                            <li><a href="rejected-quotations.php">Deleted Quotations</a></li>
                            <li><a href="pending-quotations.php"> Pending Quotations</a></li>
                            <li><a href="completed-quotations.php"> Completed Quotations</a></li>
                             <li><a href="service-completed-quotations.php">Service Completed Quotations</a></li>
                        </ul>
                    </li>


                    <!--                <li>
                                        <a href="javascript: void(0);"><i class="fi-paper"></i><span> Customer Enquiry </span> <span class="menu-arrow"></span></a>
                                        <ul class="nav-second-level" aria-expanded="false">
                                            <li><a href="notrespond-enquiry.php"> Not Respond Enquiry</a></li>
                    
                                            <li><a href="respond-enquiry.php"> Respond Enquiry </a></li>
                                        </ul>
                                    </li>-->

                    <li>
                        <a href="javascript: void(0);"><i class="fi-bag"></i><span> Stock </span> <span class="menu-arrow"></span></a>
                        <ul class="nav-second-level" aria-expanded="false">
                            <!--<li><a href="stock_add.php"> Add Stock</a></li>-->
                            <li><a href="view-stock.php"> View Stock </a></li>
                            <!--<li><a href="update-stock.php"> Update Stock </a></li>-->
                        </ul>
                    </li>


                    <!--                <li>
                                        <a href="search-enquiry.php">
                                            <i class="fi-air-play"></i><span class="badge badge-danger badge-pill float-right"></span> <span> Enquiry Search </span>
                                        </a>
                                    </li>-->

                    <li>
                        <a href="search-service.php">
                            <i class="fi-air-play"></i><span class="badge badge-danger badge-pill float-right"></span> <span> Service Search </span>
                        </a>
                    </li>






                </ul>

            </div>
            <!-- Sidebar -->
        <?php } ?>
        <div class="clearfix"></div>

    </div>
    <!-- Sidebar -left -->

</div>
<!-- Left Sidebar End -->

