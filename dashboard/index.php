<?php
   include_once('../includes/config.php');

   session_start();  
    if(!isset($_SESSION["username"]))  
    {  
         header("location:../index.php?error");  
    }  

    if(isset($_POST["c_s_d"])){
        $acc = $_POST['acc_no'];
        header("location: history/client_saving_history.php?acc_no=".$acc);
    }
    if(isset($_POST["c_i_d"])){
        $loan = $_POST['loan_no'];
        header("location: history/client_installment_deposit_history.php?loan_no=".$loan);
    }
    if(isset($_POST["check_loan"])){
        $loan = $_POST['loan_no'];
        header("location: history/loan_status.php?loan_no=".$loan);
    }
    if(isset($_POST["check_client"])){
        $acc = $_POST['acc_no'];
        header("location: client/check_client.php?acc_no=".$acc);
    }
   ?>

    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title>Dashboard - DKBSS</title>
        <link rel="shortcut icon" href="../image/favicon.png" />
        <link href="../css/bootstrap.css" rel="stylesheet">
        <link href="../css/fontawesome.css" rel="stylesheet">
        <script src="../js/sweetalert.js"></script>
        <link rel="stylesheet" href="../css/style.css">
        <link rel="stylesheet" href="../css/sweetalert.css">
    </head>

    <body>
        <div class="d-flex" id="wrapper">
            <!-- Sidebar -->
            <div class="bg-light border-right" id="sidebar-wrapper">
                <div class="sidebar-heading">🇩​🇰​🇧​🇸​🇸​</div>
                <div class="list-group list-group-flush">
                    <span href="" class="unclickable nav-active list-group-item list-group-item-action bg-light">Dashboard</span>
                                    <div class="alert alert-success">
                    <a href="add/add_client" class="list-group-item list-group-item-action bg-light">Add New Client</a>
                    <a href="add/add_deposit" class="list-group-item list-group-item-action bg-light">Add Deposit</a>
                    <a href="add_transaction.php" class="list-group-item list-group-item-action bg-light">Add Transaction</a>
                                    </div><div class="alert alert-success">
                    <a href="client/" class="list-group-item list-group-item-action bg-light">Check Client Information</a>
                    <a href="client/list" class="list-group-item list-group-item-action bg-light">Client List</a>
                    <a href="request/withdrawal_or_loan_request" class="list-group-item list-group-item-action bg-light">Make a Request</a>
                    <a href="request/" class="list-group-item list-group-item-action bg-light">Complate Request</a>
                                    </div><div class="alert alert-success">
                    <a href="history/loan" class="list-group-item list-group-item-action bg-light">Loan History</a>
                    <a href="history/withdrawal" class="list-group-item list-group-item-action bg-light">Savings Withdrawal History</a>
                                     </div><div class="alert alert-success">
                    <a href="request/loan_request_list.php" class="list-group-item list-group-item-action bg-light">Loan Request List</a>
                    <a href="request/saving_withdrawal_request_list.php" class="list-group-item list-group-item-action bg-light">Withdrawal Request List</a>
                                    </div><div class="alert alert-success">
                    <a href="history/saving_deposit" class="list-group-item list-group-item-action bg-light">Deposit List</a>
                    <a href="history/installment_deposit" class="list-group-item list-group-item-action bg-light">Installment List</a>
                                     </div><div class="alert alert-success">
                    <a href="history/" class="list-group-item list-group-item-action bg-light">Daily History</a>
                    <a href="history/daily_calculation" class="list-group-item list-group-item-action bg-light">Daily Calculation</a>
                    <a href="setting" class="list-group-item list-group-item-action bg-light">Setting</a>
                </div></div>
            </div>
            <!-- /#sidebar-wrapper -->
            <!-- Page Content -->
            <div id="page-content-wrapper">
                <nav class="navbar navbar-expand-lg navbar-light bg-light ">
                    <button class="btn " id="menu-toggle">
                        <i class="fa fa-bars"></i>
                    </button>
                    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <div class="collapse navbar-collapse" id="navbarSupportedContent">
                        <ul class="navbar-nav ml-auto mt-2 mt-lg-0">
                            <li class="nav-item dropdown">
                                <a class="nav-link" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <i class="fa fa-user fa-lg"></i>
                                </a>
                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                    <center>
                                        <p style="color:green;">Welcome Admin</p>
                                    </center>
                                    <a class="dropdown-item" href="setting">Setting</a>
                                    <div class="dropdown-divider"></div>
                                    <a class="dropdown-item" href="logout">Logout</a>
                                </div>
                            </li>
                        </ul>
                    </div>
                </nav>
                <div class="alert alert-success" role="alert"><marquee scrollamount="3">
                    <font color="#28B463"> Welcome  <font color="red"><?php echo $_SESSION["username"];?></font> To Dashboard.</font> Now <b id="today"></b>.<font color="#873600"> Date Format : Month - Day -Year</font>
                 </marquee> </div>
                <div class="container-fluid">
                    <header class="header">
               
                        <div class="row">
                            <!-- total capital -->
                            <div class="col-xl-3 col-md-6 mb-4 ">
                                <div class="card border-left-primary border-danger shadow h-100 py-2">
                                    <div class="card-body">
                                        <div class="row no-gutters align-items-center">
                                            <div class="col mr-2">
                                                <div class="text-xs font-weight-bold text-primary mb-1">Total Capital</div>
                                                <div class="h5 mb-0 font-weight-bold text-gray-800">৳
                                              <?php 
                                                    $sql = "SELECT * FROM information WHERE id = 1";
                                                    $sth = $conn->query($sql);
                                                    $result=mysqli_fetch_array($sth);
                                                    echo $result["capital"];
                                                    $lp = $result['loan_percentage'];
                                                ?>
                                                </div>
                                            </div>
                                            <div class="col-auto">
                                                <i class="fab fa-cuttlefish fa-2x text-gray-300" style="color:red"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- total intarest -->
                            <div class="col-xl-3 col-md-6 mb-4">
                                <div class="card border-left-success border-danger shadow h-100 py-2">
                                    <div class="card-body">
                                        <div class="row no-gutters align-items-center">
                                            <div class="col mr-2">
                                                <div class="text-xs font-weight-bold text-success mb-1">Total Intarest by Loan</div>
                                                <div class="h5 mb-0 font-weight-bold text-gray-800">৳
                                                  <?php 
                                                            $sql = "SELECT SUM(amount) as amount FROM loan_list WHERE loan_complete =1";
                                                            $sth = $conn->query($sql);
                                                            $total_capital=mysqli_fetch_array($sth);
                                                            echo ($total_capital["amount"]/100)*$lp;
                                                ?>
                                                </div>
                                            </div>
                                            <div class="col-auto">
                                                <i class="fas fa-info fa-2x text-gray-300" style="color:#CB4335;"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!--total loan -->
                            <div class="col-xl-3 col-md-6 mb-4">
                                <div class="card border-left-info border-danger shadow h-100 py-2">
                                    <div class="card-body">
                                        <div class="row no-gutters align-items-center">
                                            <div class="col mr-2">
                                                <div class="text-xs font-weight-bold text-info mb-1">Total Loan & Amount Paid</div>
                                                <div class="row no-gutters align-items-center">
                                                    <div class="col-auto">
                                                        <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800">৳
                                                            <?php 
                                                            $sql = "SELECT SUM(amount) as amount FROM loan_list where active = 1";
                                                            $sth = $conn->query($sql);
                                                            $total_capital=mysqli_fetch_array($sth);
                                                            echo $total_capital["amount"];
                                                ?> /
                                                                <?php 
                                                $sql = "SELECT COUNT(*) as count FROM loan_list where active = 1";
                                                $sth = $conn->query($sql);
                                                $total_capital=mysqli_fetch_array($sth);
                                                echo $total_capital["count"];
                                                ?> <br><a href="history/loan" class="badge badge-info">Details</a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-auto">
                                                <i class="fas fa-money-bill-alt fa-2x text-gray-300"  style="color:#AF7AC5;"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Pending Loan Requests -->
                            <div class="col-xl-3 col-md-6 mb-4">
                                <div class="card border-left-warning border-danger shadow h-100 py-2">
                                    <div class="card-body">
                                        <div class="row no-gutters align-items-center">
                                            <div class="col mr-2">
                                                <div class="text-xs font-weight-bold text-warning mb-1"><font color="#943126">Pending Request (L|W)</font></div>
                                                <div class="h5 mb-0 font-weight-bold text-gray-800">
                                                    <font color="red">
                                                    <?php 
                                                $sql = "SELECT COUNT(*) as k FROM loan_list WHERE req_status = 1";
                                                $sth = $conn->query($sql);
                                                $total_capital=mysqli_fetch_array($sth);
                                                echo $total_capital["k"];
                                                ?></font> | <font color="Green">
                                                                         <?php 
                                                $sql = "SELECT COUNT(*) as k FROM withdrawal_list WHERE req_status = 1";
                                                $sth = $conn->query($sql);
                                                $total_capital=mysqli_fetch_array($sth);
                                                echo $total_capital["k"];
                                                ?></font><br>  <a href="request/" class="badge badge-info">Details</a>
                                                </div>
                                              
                                            </div>
                                            <div class="col-auto">
                                                <i class="fas fa-spinner fa-2x text-gray-300"  style="color:#58D68D;"></i><br>
                                                
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- first row end -->

                        <div class="row">
                            <!-- Earnings (Monthly) Card Example -->
                            <div class="col-xl-3 col-md-6 mb-4">
                                <div class="card border-left-success border-success shadow h-100 py-2 ">
                                    <div class="card-body">
                                        <div class="row no-gutters align-items-center">
                                            <div class="col mr-2">
                                                <div class="text-xs font-weight-bold text-success mb-1">Total Client</div>
                                                <div class="h5 mb-0 font-weight-bold text-gray-800">

                                                    <?php 
                                                $sql = "SELECT COUNT(*) as k FROM client";
                                                $sth = $conn->query($sql);
                                                $total_capital=mysqli_fetch_array($sth);
                                                echo $total_capital["k"];
                                                ?> <br><a href="client/list" class="badge badge-info">Details</a>
                                                </div>
                                            </div>
                                            <div class="col-auto">
                                                <i class="fas fa-user fa-2x text-gray-300"  style="color:#5DADE2;"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Earnings (Monthly) Card Example -->
                            <div class="col-xl-3 col-md-6 mb-4">
                                <div class="card border-success border-left-primary shadow h-100 py-2">
                                    <div class="card-body">
                                        <div class="row no-gutters align-items-center">
                                            <div class="col mr-2">
                                                <div class="text-xs font-weight-bold text-primary mb-1">Total Saving Deposit</div>
                                                <div class="h5 mb-0 font-weight-bold text-gray-800">৳
                                                    <?php 
                                                $sql = "SELECT SUM(amount) as amount FROM saving_deposit";
                                                $sth = $conn->query($sql);
                                                $total_capital=mysqli_fetch_array($sth);
                                               echo $total_capital["amount"];
                                                ?>
                                                        /
                                                        <?php 
                                                $sql = "SELECT COUNT(*) as k FROM saving_deposit";
                                                $sth = $conn->query($sql);
                                                $total_capital=mysqli_fetch_array($sth);
                                               echo $total_capital["k"];
                                                ?> <br><a href="history/saving_deposit" class="badge badge-info">Details</a>
                                                </div>
                                            </div>
                                            <div class="col-auto">
                                                <i class="fas fa-store fa-2x text-gray-300"  style="color:#2980B9;"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Pending Requests Card Example -->
                            <div class="col-xl-3 col-md-6 mb-4">
                                <div class="card border-left-warning border-success shadow h-100 py-2">
                                    <div class="card-body">
                                        <div class="row no-gutters align-items-center">
                                            <div class="col mr-2">
                                                <div class="text-xs font-weight-bold text-warning mb-1"><font color="#48C9B0">Total Installment Coll:</font></div>
                                                <div class="h5 mb-0 font-weight-bold text-gray-800">৳

                                                    <?php 
                                                $sql = "SELECT SUM(amount) as amount FROM installment_deposit";
                                                $sth = $conn->query($sql);
                                                $total_capital=mysqli_fetch_array($sth);
                                               echo $total_capital["amount"];
                                                ?> /
                                                        <font size="2px" color="red">(Due: 

                                            <?php 
                                                $sql = "SELECT SUM(due) as due FROM loan_list WHERE loan_complete = 0 AND req_status = 0";
                                                $sth = $conn->query($sql);
                                                $total_capital=mysqli_fetch_array($sth);
                                               echo $total_capital["due"];
                                                ?> ৳)</font><br><a href="history/installment_deposit" class="badge badge-info">Details</a>


                                                </div>
                                            </div>
                                            <div class="col-auto">
                                                <i class="fas fa-piggy-bank fa-2x text-gray-300"  style="color:#A3E4D7;"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Earnings (Monthly) Card Example -->
                            <div class="col-xl-3 col-md-6 mb-4">
                                <div class="card border-left-info border-success shadow h-100 py-2">
                                    <div class="card-body">
                                        <div class="row no-gutters align-items-center">
                                            <div class="col mr-2">
                                                <div class="text-xs font-weight-bold text-info mb-1"><font color="#8E44AD">Total Savings Withd:</font></div>
                                                <div class="row no-gutters align-items-center">
                                                    <div class="col-auto">
                                                        <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800">৳

                                                            <?php 
                                                $sql = "SELECT SUM(amount) as amount FROM withdrawal_list where req_status = 0";
                                                $sth = $conn->query($sql);
                                                $total_capital=mysqli_fetch_array($sth);
                                               echo $total_capital["amount"];
                                                ?>/<?php 
                                                $sql = "SELECT COUNT(*) as k FROM withdrawal_list where req_status = 0";
                                                $sth = $conn->query($sql);
                                                $total_capital=mysqli_fetch_array($sth);
                                               echo $total_capital["k"]-1;
                                                ?><br> <a href="history/withdrawal" class="badge badge-info">Details</a>

                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-auto">
                                                <i class="fas fa-clipboard-check fa-2x text-gray-300"  style="color:#5499C7;"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </header>
                    <div class="row">
                    <div class="col-xl-3 col-md-3 mb-4">
                    <div class="card border-primary mb-3 " style="max-width: 18rem;">
                            <div class="card-header">Check Client Status</div>
                            <div class="card-body text-primary">
                            <div class="form-group">
                                    <form class="form" method="post">
                                        <input class="form-control" type="number" name="acc_no" placeholder="Acc Number" required autofocus>
                                      <br> <center> <input class="btn btn-primary" type="submit" name="check_client" value="Check"></center>
                                    </div></form></div>

                            </div>
                            </div>
                            <div class="col-xl-3 col-md-3 mb-4">
                            <div class="card border-warning mb-3" style="max-width: 18rem;">
                            <div class="card-header">Check Loan status</div>
                            <div class="card-body text-primary">
                            <form class="form" method="post">
                                    <div class="form-group">
            
                                        <input class="form-control" type="number" name="loan_no" placeholder="Loan Number" required autofocus>
                                       <br><center> <input class="btn btn-primary" type="submit" name="check_loan" value="Check"></center>
                                    </div> </form></div>
                            </div>
                            </div>
                            <div class="col-xl-3 col-md-3 mb-4">
                            <div class="card border-success mb-3" style="max-width: 18rem;">
                            <div class="card-header">Check Savings Deposit</div>
                            <div class="card-body text-primary">
                            <form class="form" method="post">
                                    <div class="form-group">
                                        <input class="form-control" type="number" name="acc_no" placeholder="Acc Number" required autofocus>
                                       <br><center> <input class="btn btn-primary" type="submit" name="c_s_d" value="Check"></center>
                                    </div> </form></div></div>
                            </div>
                            <div class="col-xl-3 col-md-3 mb-4">
                            <div class="card border-danger mb-3" style="max-width: 18rem;">
                            <div class="card-header">Check Client Installment</div>
                            <div class="card-body text-primary">
                            <form class="form" method="post">
                                    <div class="form-group">
                                        <input class="form-control" type="number" name="loan_no" placeholder="Acc Number" required autofocus>
                                       <br><center> <input class="btn btn-primary" type="submit" name="c_i_d" value="Check"></center>
                                    </div> </form></div></div>
                            </div>




                    </div>

                    <!-- form row  -->

                </div>
            </div>
        </div>
        <!-- /#page-content-wrapper -->
        </div>
        </div>
    </body>
    <script src="../js/jquery.js"></script>
    <script src="../js/bootstrap.js"></script>
    <script src="../js/fontawesome.js"></script>
    <script src="../js/sweetalert.js"></script>
    <script src="../js/main.js"></script>
    <script>

        window.onload = function() {
            var d = new Date();          
            var n = d.toLocaleString([], { hour12: true});
            document.getElementById("today").innerHTML = n;
       


            $("#menu-toggle").click(function(e) {
                e.preventDefault();
                $("#wrapper").toggleClass("toggled");
            });

            var url = window.location.toString();
            if (url.includes("index.php?login") && url.includes("#") != true) {
                var name = url.split("=")[1].substring(0, 11);
                swal(name, "Welcome to Dashboard", "success");
            }

            if (url.includes("loan_no_not_found")) {
                swal("Loan Number Not Found", "", "error");
            }
            if (url.includes("index.php?acc_no_not_found")) {
                swal("Account Number Not Found", "", "error");
            }


        }

        function add_deposit() {
            $("#add_deposit").modal();
        }
    </script>

    </html>