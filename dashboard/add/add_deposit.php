<!DOCTYPE html>
<html lang="en">
<head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title>Add Deposit - DKBSS</title>
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
                                    <a class="dropdown-item" href="../logout">Logout</a>
                                </div>
                            </li>
                        </ul>
                    </div>
                </nav>
                <?php 
        if(isset($_POST["deposit_type"])){
            $deposit_type = $_POST["deposit_t"];
            $acc_no = $_POST["acc_id"];
            if($deposit_type == 'saving'){
                header('location: add_saving.php?acc_no='.$acc_no);
            }elseif($deposit_type == 'installment'){
                header('location: add_installment.php?lone_no='.$acc_no);

            }
        }
        ?>
        <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="../">Dashboard</a></li>
    <li class="breadcrumb-item active" aria-current="page">Add Deposit</li>
  </ol>
</nav>
                <div class="container-fluid">
                     <article class="card-body mx-auto" style="max-width: 700px;">
                    <h3>Deposit Type</h3>
                    <form class="form-signin" method="post">
                        <div class="form-group input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"> <i class="fa fa-one"></i> </span>
                                </div>
                                <select name="deposit_t" class="form-control" required autofocus>
                                <option value="" selected=""> Select Deposit Type</option>
                                <option value="saving">Saving(সঞ্চয়)</option>
                                <option value="installment">Installment(কিস্তি)</option>
                            </select>
                            </div>
                            <div class="form-group input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"> <i class="fa fa-lock"></i> </span>
                                    </div>
                                    <input name="acc_id" class="form-control" placeholder="Account or Loan Number" type="number" required autofocus>
                                </div>          
                   <div style="float:right">
                   <input type="submit" name="deposit_type" onclick="get_deposit()" value="Next" class="btn btn-info" />
                  </div>
           
                   </form>
    </article>
                </div>
    
</body>
<script src="../../js/jquery.js"></script>
        <script src="../../js/bootstrap.js"></script>
        <script src="../../js/fontawesome.js"></script>     
        <script>

        var url = window.location.toString();
            if (url.includes("accNoNotSend")) {
                Swal.fire("Sorry", "Fill up this form to make any kind of deposit", "error");
            }
        
            if (url.includes("AccNotFound")) {
                swal("Account Number Not Found", " ", "error");
            }
            if (url.includes("loan_no_not_found")) {
                swal("Loan Number Not Found", "", "error");
            }
            if (url.includes("DepositSuccessfull")) {
                swal("Deposit Successfull", "", "success");
            }

            if (url.includes("loan_request_not_complet_yet")) {
                swal("Loan Request Not Accepted Yet", "", "error");
            }
            if (url.includes("loan_already_complete")) {
            swal("Loan Already Complete");
          }
          if (url.includes("client_account_deactive")) {
            swal("Client Account Deactive", "", "error");
          }

        </script>   
</html>