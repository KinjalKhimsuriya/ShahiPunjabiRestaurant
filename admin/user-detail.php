<?php
session_start();
error_reporting(0);
include('includes/dbconnection.php');
if (strlen($_SESSION['fosaid'] == 0)) {
    header('location:logout.php');
} else {
    if (isset($_GET['del'])) {
        $id=intval($_GET['del']);    
        $query=mysqli_query($con,"delete from tbluser where ID='$id'");
            if ($query) {
             echo "<script>alert('User deleted');</script>";
             echo "<script>window.location.href='user-detail.php'</script>";
          }
          else
            {
               echo "<script>alert('Something Went Wrong. Please try again.');</script>";
                echo "<script>window.location.href='user-detail.php'</script>";
            }
        }
        
}
?>
<!DOCTYPE html>
<html>

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Shahi Punjabi Restaurant</title>

    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="font-awesome/css/font-awesome.css" rel="stylesheet">
    <link href="css/plugins/iCheck/custom.css" rel="stylesheet">
    <link href="css/plugins/steps/jquery.steps.css" rel="stylesheet">
    <link href="css/animate.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">
    <!-- DataTables CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.12.1/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.3.0/css/responsive.dataTables.min.css">
</head>

<body>

    <div id="wrapper">

        <?php include_once('includes/leftbar.php');?>

        <div id="page-wrapper" class="gray-bg">
            <?php include_once('includes/header.php');?>

            <div class="row border-bottom">
            </div>
            <div class="row wrapper border-bottom white-bg page-heading">
            <div class="col-lg-10">
                <h2>Reg User</h2>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="dashboard.php">Home</a>
                    </li>
                    <li class="breadcrumb-item active">
                        <a href="user-detail.php">Users</a>
                    </li>
                </ol>
            </div>
        </div>
        <?php
if (isset($_COOKIE['profile_update_msg'])) {
    $message = $_COOKIE['profile_update_msg'];
    // Display the message
    // echo "<script>alert('$message');</script>";
    // Optionally, delete the cookie after showing the message
    setcookie('profile_update_msg', '', time() - 3600, '/');
}
?>


            <div class="wrapper wrapper-content animated fadeInRight">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="ibox">
                            <div class="ibox-content">
                                <!-- Icon and title for the table -->
                                <div class="d-flex align-items-center mb-4">
                                    <p style="color:#0c3b2e; font-size: 30px; ">User Details</p>
                                    <a href="add_user.php"  style="font-size: 30px; color: #0c3b2e; margin-left:80%;"><i class="fa fa-plus"></i></a>
                                </div>

                                <!-- Table with col-lg-12 and increased width -->
                                <div class="table-responsive">
                                    <table id="userTable" class="table table-bordered mg-b-0" style="width: 100%;">
                                        <thead>
                                            <tr>
                                                <th>S.NO</th>
                                                <th>First Name</th>
                                                <th>Last Name</th>
                                                <th>Mobile Number</th>
                                                <th>Email</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <?php
                                            $ret = mysqli_query($con, "select * from tbluser");
                                            $cnt = 1;
                                            while ($row = mysqli_fetch_array($ret)) {
                                        ?>
                                        <tbody>
                                            <tr>
                                                <td><?php echo $cnt; ?></td>
                                                <td><?php echo $row['FirstName']; ?></td>
                                                <td><?php echo $row['LastName']; ?></td>
                                                <td><?php echo $row['MobileNumber']; ?></td>
                                                <td><?php echo $row['Email']; ?></td>
                                                <td>
                                                    <a href="edit-userprofile.php?userid=<?php echo $row['ID']; ?>" class="text-primary mr-3">
                                                        <i class="fa fa-pencil-square-o" aria-hidden="true"></i>
                                                    </a>
                                                    <a href="user-detail.php?del=<?php echo $row['ID'];?>" style="color:red;" onclick="return confirm('Do you really want to delete the user?');"><i class="fa fa-trash" aria-hidden="true"></i></a>
                                                </td>
                                            </tr>
                                            <?php
                                            $cnt = $cnt + 1;
                                    } ?>


                                    </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <?php include_once('includes/footer.php');?>

        </div>
    </div>

    <!-- Mainly scripts -->
    <script src="js/jquery-3.1.1.min.js"></script>
    <script src="js/popper.min.js"></script>
    <script src="js/bootstrap.js"></script>
    <script src="js/plugins/metisMenu/jquery.metisMenu.js"></script>
    <script src="js/plugins/slimscroll/jquery.slimscroll.min.js"></script>

    <!-- DataTables JS -->
    <script src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.3.0/js/dataTables.responsive.min.js"></script>

    <!-- Custom and plugin javascript -->
    <script src="js/inspinia.js"></script>
    <script src="js/plugins/pace/pace.min.js"></script>

    <!-- Steps -->
    <script src="js/plugins/steps/jquery.steps.min.js"></script>

    <!-- Jquery Validate -->
    <script src="js/plugins/validate/jquery.validate.min.js"></script>

    <script>
        $(document).ready(function() {
            // Initialize DataTable with responsive extension and configure options
            $('#userTable').DataTable({
                responsive: true,
                paging: true,
                searching: true, // Enable search across all columns
                info: true, // Enable table info (e.g., showing entries)
                lengthChange: true, // Allow the user to change the number of entries per page
                columnDefs: [{
                    targets: [0], // Column with index 0 (S.NO) will not be searchable
                    searchable: false
                }],
                language: {
                    search: "Search all columns:" // Customize search box label
                }
            });
        });
    </script>

</body>

</html>
