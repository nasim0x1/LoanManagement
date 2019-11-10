<?php
   include_once('../../includes/config.php');

   session_start();  
    if(!isset($_SESSION["username"]))  
    {  
         header("location:../index.php?error");  
    } 
    
    $url = $_SERVER['REQUEST_URI'];
    $urlarray=explode("=",$url);
    $acc_no=$urlarray[count($urlarray)-1];


    $check = mysqli_query($conn, "SELECT * FROM client WHERE acc_no='".$acc_no."'");
    if(mysqli_num_rows($check) > 0){
        $check = mysqli_query($conn, "SELECT * FROM client WHERE acc_no='".$acc_no."' and client_status = 1");
        if(mysqli_num_rows($check) > 0){
            $check = mysqli_query($conn, "SELECT * FROM withdrawal_list WHERE acc_no='".$acc_no."' AND  req_status = 1");
        if(mysqli_num_rows($check) > 0){
            header("location: withdrawal_or_loan_request.php?one_req_already_pending");
        }
            
        }else{
            header("location: withdrawal_or_loan_request.php?client_acc_deactive");
        }
        
    }
    else{
        // client not found 
        header("location: withdrawal_or_loan_request.php?AccNotFound");

    }


    $sql = "SELECT total_saving FROM client WHERE acc_no ='".$acc_no."'";
    $sth = $conn->query($sql);
    $result=mysqli_fetch_array($sth);


    $current_balance = $result["total_saving"];

    if(isset($_POST["add_req"])){

        $account_number = $_POST["account_number"];
        $amount = $_POST["amount"];
        $req_date = $_POST["request_date"];
        $ho_date = $_POST["ho_date"];

        $new_balance = $current_balance - $amount;



        $add_requ = "INSERT into withdrawal_list(`acc_no`, `req_status`, `amount`, `request_date`, `withdrawal_date`, `available_balance`) VALUES(
                   '$account_number',
                   1,
                   '$amount',
                   '$req_date',
                   '$ho_date',
                   '$new_balance'
               )";
                if ($conn->query($add_requ) === TRUE) {

                    $get = "SELECT id FROM withdrawal_list ORDER BY id DESC LIMIT 0,1";
                    $get_id = $conn->query($get);
                    $zz=mysqli_fetch_array($get_id);
                    $req_no = $zz['id'];

                    $update_client = "UPDATE client set s_w_r_n = '$req_no' WHERE acc_no = '$acc_no'";
                    if ($conn->query($update_client) === TRUE) {
                    header("location: withdrawal_or_loan_request.php?request_added_successfully");
                    }
                }
    else{
        // already have loan
        header("location: aving_withdrawal_request.php?error?acc_no=".$acc_no);
    }

        }
        
   ?>
    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title>Add Savings Withdrawal Request - DKBSS</title>
        <link rel="shortcut icon" href="../../image/favicon.png" />
        <link href="../../css/bootstrap.css" rel="stylesheet">
        <link href="../../css/fontawesome.css" rel="stylesheet">
        <script src="../../js/sweetalert.js"></script>
        <link rel="stylesheet" href="../../css/style.css">
        <link rel="stylesheet" href="../../css/sweetalert.css">
    </head>

    <body>
        <div class="d-flex" id="wrapper">
            <!-- Sidebar -->
            <div class="bg-light border-right" id="sidebar-wrapper">
                <div class="sidebar-heading">🇩​🇰​🇧​🇸​🇸​</div>
                <div class="list-group list-group-flush">
                    <a href="../index" class="nav-active list-group-item list-group-item-action bg-light">Dashboard</a>
                  </div>
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
                                    <a class="dropdown-item" href="../logout">Logout</a>
                                </div>
                            </li>
                        </ul>
                    </div>
                </nav>
                <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="../">Dashboard</a></li>
    <li class="breadcrumb-item"><a href="withdrawal_or_loan_request">Add Request</a></li>
    <li class="breadcrumb-item active" aria-current="page">Add Savings Withdrawal</li>
  </ol>
</nav>
                <div class="container-fluid">
                
                <article class="card-body mx-auto" style="max-width: 700px;">
                    <h3>Savings Withdrawal Request:</h3>
                    <form class="form-signin" method="post">

                    <div class="form-group input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"> <i class="fa fa-user"></i> </span>
                                    </div>
                                    <font class="form-control"  style="max-width: 120px;">Account No:</font>

                                    <input name="account_number" class="form-control" value= "<?php echo $acc_no ?>" type="number" readonly required autofocus>
                                
                                </div> 
                            <div class="form-group input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"> <i class="fa fa-lock"></i> </span>
                                    </div>
                                    <input name="amount" class="form-control" placeholder="Amount" type="number" required autofocus min="10" max="<?php echo $current_balance ?>"> 
               
                                </div> 
                                <small class="form-text text-muted">Maximum Withdrawable Amount :                                  
                                <font color="green"><b>
                                    <?php
                                    echo $current_balance;?> ৳</b></font></small><br>

                                

                           <div class="form-group input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text"> <i class="fa fa-calendar-alt"></i> </span>
                            </div>
                            <font class="form-control" style="max-width: 160px;">Request Date:</font>
                            <input type="date" name="request_date" value="<?php echo date('Y-m-d'); ?>" class="form-control" required autofocus>
                        </div>

                        <div class="form-group input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text"> <i class="fa fa-calendar-alt"></i> </span>
                            </div>
                            <font class="form-control" style="max-width: 160px;">Handover Date:</font>
                            <input type="date" name="ho_date" class="form-control" required autofocus>
                        </div>                                     
                   <div style="float:right">
                   <input type="submit" name="add_req" value="Submit" class="btn btn-info" />
                  </div>
                   </form>
    </article>
                    
                  </div> 
                </div>
            </div>
        </div>
    </div>




    </body>
    <script src="../../js/jquery.js"></script>
    <script src="../../js/bootstrap.js"></script>
    <script src="../../js/fontawesome.js"></script>

            <script>

            var url = window.location.toString();
            if (url.includes("error") && url.includes("#") != true) {
                swal("Error ! Try Agine", "", "error");
            }
            </script>
    </html>