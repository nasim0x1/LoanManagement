<?php
   include_once('../../includes/config.php');

   session_start();  
    if(!isset($_SESSION["username"]))  
    {  
         header("location:../../index.php?error");  
    }  

    if (isset($_POST["add_req"])) {
        
        $acc_no = $_POST["acc_no"];


        $query = mysqli_query($conn, "SELECT * FROM client WHERE acc_no='".$acc_no."'");

        if(mysqli_num_rows($query) > 0){
            if($_POST["type"]=='lone'){
                header('location: loan_request.php?acc_no='.$acc_no);
            }elseif($_POST["type"]=='withdrawal'){
                header('location: saving_withdrawal_request.php?acc_no='.$acc_no);
            }
        }else{
            header('location: withdrawal_or_loan_request.php?AccNotFound');
        }

    }


   ?>

    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title>Add New Request - DKBSS</title>
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
    <li class="breadcrumb-item active" aria-current="page">Add New Request</li>
  </ol>
</nav>
                <div class="container-fluid">


                
                <article class="card-body mx-auto" style="max-width: 700px;">
                    <h3>New Request</h3>
                    <form class="form-signin" method="post">
                        <div class="form-group input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"> <i class="fa fa-one"></i> </span>
                                </div>
                                <select name="type" class="form-control" required autofocus>
                                <option value="" selected=""> Select Type</option>
                                <option value="lone">Loan (ঋণ)</option>
                                <option value="withdrawal">Withdrawal(সঞ্চয় উত্তোলন)</option>
                            </select>
                            </div>
            
                            <div class="form-group input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"> <i class="fa fa-lock"></i> </span>
                                    </div>
                                    <input name="acc_no" class="form-control" placeholder="Only Account Number" type="number" required autofocus>
                                </div>          
                   <div style="float:right">
                   <input type="submit" id="id" name="add_req" value="Next" class="btn btn-info" />
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
            if (url.includes("AccNotFound") && url.includes("#") != true) {
                swal("Account Not Found", "", "error");
            }
            if (url.includes("request_added_successfully") && url.includes("#") != true) {
                swal("Request Add Successfully", "", "success");
            }
            if (url.includes("loan_running") && url.includes("#") != true) {
                swal("Client Already In a Loan", "", "error");
            }
            if (url.includes("one_req_already_pending") && url.includes("#") != true) {
                swal("One Request Already Pending", "", "error");
            }           
             if (url.includes("client_acc_deactive") && url.includes("#") != true) {
                swal("Client Account Deactived", "", "error");
            }
            </script>
    </html>