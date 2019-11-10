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

            // checking client status if loan running or user not found 
            $check = mysqli_query($conn, "SELECT * FROM client WHERE acc_no='".$acc_no."'");
            if(mysqli_num_rows($check) > 0){
                $check = mysqli_query($conn, "SELECT * FROM client WHERE acc_no='".$acc_no."' and client_status = 1");
            if(mysqli_num_rows($check) > 0){
                $status = mysqli_query($conn, "SELECT * FROM client WHERE acc_no='".$acc_no."' AND 	loan_running = 0");
            if(mysqli_num_rows($status) > 0){
            }
                else{
                    header("location: withdrawal_or_loan_request.php?loan_running");

                }

            }else{
                header("location: withdrawal_or_loan_request.php?client_acc_deactive");
            }
            
            }
            else{
        // client not found 
        header("location: withdrawal_or_loan_request.php?AccNotFound");

    }

    $sql = "SELECT loan_percentage FROM information where id = 1";
    $sth = $conn->query($sql);
    $result=mysqli_fetch_array($sth);
    $loan_percentage = $result["loan_percentage"];
    
    if(isset($_POST["add_req"])){

        $account_number = $_POST["account_number"];
        $loan_no = $_POST["loan_number"];
        $amount = $_POST["amount"];
        $req_date = $_POST["request_date"];
        $ho_date = $_POST["handover_date"];

                // no loan running
                $amount_with_charge = (($amount/100)*$loan_percentage) + $amount;

                $add_loan = "INSERT into loan_list(
                    `acc_no`, 
                    `loan_no`,
                    `request_date`,
                    `paid_date`,
                    `amount`,
                    `amount_with_charge`,
                    `active`,
                    `req_status`,
                    `due`,
                    `loan_complete`
                       ) VALUES(
                           '$account_number',
                           '$loan_no',
                           '$req_date',
                           '$ho_date',
                           '$amount',
                           '$amount_with_charge',
                           0,
                           1,
                           '$amount_with_charge',
                           0
                       )";
                        if ($conn->query($add_loan) === TRUE) {
                            header("location: complete_loan_req.php?request_added_successfully?loan_no=".$loan_no);
                        }
            else{
                // already have loan
                header("location: withdrawal_or_loan_request.php?already_loan_running?acc_no=".$acc_no);
            }
    }




   ?>

    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title>Loan Request - DKBSS</title>
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
                    <a href="../index" class="list-group-item list-group-item-action bg-light">Dashboard</a>
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
                                    <a class="dropdown-item" href="logout">Logout</a>
                                </div>
                            </li>
                        </ul>
                    </div>
                </nav>
                <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="../">Dashboard</a></li>
    <li class="breadcrumb-item"><a href="withdrawal_or_loan_request">Add New Request</a></li>
    <li class="breadcrumb-item active" aria-current="page">Add New Loan</li>
  </ol>
</nav>
                <div class="container-fluid">
                
                <article class="card-body mx-auto" style="max-width: 700px;">
                    <h3>Loan Request:</h3>
                    <form class="form-signin" method="post">

                    <div class="form-group input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"> <i class="fa fa-user"></i> </span>
                                    </div>
                                    <font class="form-control"  style="max-width: 120px;">Account No:</font>

                                    <input name="account_number" class="form-control" value= "<?php echo $acc_no ?>" type="number" readonly required autofocus>
                                
                                </div> 

                    <div class="form-group input-group">
                                    <?php
                                    $sql = "SELECT * FROM loan_list ORDER BY loan_no DESC LIMIT 0,1";
                                    $sth = $conn->query($sql);
                                    $result=mysqli_fetch_array($sth);?>
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"> <i class="fa fa-lira-sign"></i> </span>
                                    </div>
                                    <font class="form-control"  style="max-width: 120px;">Loan No:</font>
                                    <input name="loan_number" class="form-control" value="<?php echo $result["loan_no"]+1;?>" type="number" required autofocus>
                                </div> 
                                <div class="form-group input-group">
                                <small class="form-text text-muted">Last Loan Number :                                  
                                </small>
                                <font color="green"><b>
                                    <?php
                                    echo $result["loan_no"];
                                ?></b></font>
                                </div>



                            <div class="form-group input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"> <i class="fa fa-lock"></i> </span>
                                    </div>
                                    <input name="amount" class="form-control" placeholder="Amount" type="number" required autofocus>
                                
                                </div> 

                                <font style="max-width: 160px;">Request Date:</font>


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
                            <input type="date" name="handover_date" class="form-control" required autofocus>
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
          if (url.includes("?acc_no=") == false) {
            window.location.replace("withdrawal_or_loan_request.php?AccNotFound");
          }
          </script>

    </html>