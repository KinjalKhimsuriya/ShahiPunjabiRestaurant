<?php //session_start(); ?>
<div class="row border-bottom">
    <nav class="navbar navbar-static-top blue-bg" role="navigation" style="margin-bottom: 0; padding-top: 5px;">
        <!-- Reduced top margin here -->
        <div class="navbar-header">
            <a class="navbar-minimalize minimalize-styl-2 btn btn-primary " href="#"><i class="fa fa-bars"></i> </a>
        </div>
        <p style="font-size:20px;padding-top:1%;"><strong>Shahi Punjabi Restaurant</strong></p>

        <ul class="nav navbar-top-links navbar-right">
            <?php
            $ret1 = mysqli_query($con, "select tbluser.FirstName,tblorderaddresses.ID,tblorderaddresses.Ordernumber from tblorderaddresses join tbluser on tbluser.ID=tblorderaddresses.UserId where tblorderaddresses.OrderFinalStatus is null");
            $num = mysqli_num_rows($ret1);

            ?>
            <li class="dropdown">
                <a class="dropdown-toggle count-info" data-toggle="dropdown" href="#">
                    <i class="fa fa-bell"></i> <span class="label label-primary"><?php echo $num; ?></span>
                </a>

                <ul class="dropdown-menu dropdown-alerts">
                    <li>
                        <a href="mailbox.html" class="dropdown-item">
                            <div>
                                <?php if ($num > 0) {
                                    while ($result = mysqli_fetch_array($ret1)) { ?>
                                        <a class="dropdown-item"
                                            href="viewfoodorder.php?orderid=<?php echo $result['Ordernumber']; ?>">
                                            <i class="fa fa-envelope fa-fw"></i> #<?php echo $result['Ordernumber']; ?> Order
                                            Received from <?php echo $result['FirstName']; ?>
                                        </a>
                                    <?php }
                                } else { ?>
                                    <a class="dropdown-item" href="view-allorderfood.php">No New Order Received</a>
                                <?php } ?>
                            </div>
                        </a>
                    </li>

                </ul>
            </li>

            <!-- <li>
                <div class="dropdown profile-element ml-4 mr-4">
                    <img alt="image" class="rounded-circle" src="img/user.png" style="width: 30px; height: 30px;" /> 
                     <a data-toggle="dropdown" class="dropdown-toggle" href="#">
                        <span class="text-muted text-xs block"><?php //echo $name; ?><b class="caret">ALNUR</b></span>
                    </a>
                    <ul class="dropdown-menu animated fadeInRight m-t-xs">
                        <li><a class="dropdown-item" href="adminprofile.php">Profile</a></li>
                        <li><a class="dropdown-item" href="changepassword.php">Change Password</a></li>
                        <li class="dropdown-divider"></li>
                        <li><a class="dropdown-item" href="logout.php">Logout</a></li>
                    </ul>
                </div>
            </li> -->
            <li>
                <div class="dropdown profile-element ml-4 mr-4">
                    <img alt="image" class="rounded-circle" src="img/user.png" style="width: 30px; height: 30px;" />
                    <!-- Reduced width and height for profile image -->
                    <a data-toggle="dropdown" class="dropdown-toggle" href="#">
                        <span class="text-muted text-xs block"><?php echo $_SESSION['adminuser']; ?> <b class="caret"></b></span>
                    </a>
                    <ul class="dropdown-menu animated fadeInRight m-t-xs">
                        <li><a class="dropdown-item" href="adminprofile.php">Profile</a></li>
                        <li><a class="dropdown-item" href="changepassword.php">Change Password</a></li>
                        <li class="dropdown-divider"></li>
                        <li><a class="dropdown-item" href="logout.php">Logout</a></li>
                    </ul>
                </div>
            </li>


        </ul>
    </nav>
</div>