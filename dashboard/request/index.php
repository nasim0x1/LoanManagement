<?php
require_once("../../includes/config.php");
if(isset($_POST["req_type"])){

    $get_type = $_POST['type'];
    $get_id = $_POST['id'];
    if($get_type == 'loan'){
        header("Location: complete_loan_req.php?loan_no=".$get_id);
    }elseif($get_type == 'saving'){
        header("Location: complete_saving_req.php?acc_no=".$get_id);
    }
}


?>

    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title>Complete Request - DKBSSL</title>
        <link rel="shortcut icon" href="../../image/favicon.png" />
        <link href="../../css/bootstrap.css" rel="stylesheet">
        <link href="../../css/fontawesome.css" rel="stylesheet">
        <script src="../../js/sweetalert.js"></script>
        <link rel="stylesheet" href="../../css/style.css">
        <link rel="stylesheet" href="../../css/sweetalert.css">        
        <link rel="stylesheet" href="../../css/datatable.css">
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
                        <li class="nav-item dropdown" style="padding-right:10px">
                                <a class="nav-link" href="index.php" onclick="print_table('data')" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <i class="fa fa-home fa-print"></i>
                                </a>
                            </li>
                            <li class="nav-item dropdown" style="padding-right:10px">
                                <a class="nav-link" href="index.php" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <i class="fa fa-home fa-lg"></i>
                                </a>
                            </li>
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
    <li class="breadcrumb-item active" aria-current="page">Action For Request</li>
  </ol>
</nav>

                <div class="container-fluid">
<div class="row">
                <article class="card-body mx-auto" style="max-width: 700px;">
                    <h3>Select Request Type</h3>
                    <form class="form-signin" method="post">
                        <div class="form-group input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"> <i class="fa fa-one"></i> </span>
                                </div>
                                <select name="type" class="form-control" required autofocus>
                                <option value="" selected=""> Select Request Type</option>
                                <option value="saving">Savings Withdrawal</option>
                                <option value="loan">Loan</option>
                            </select>
                            </div>
                            <div class="form-group input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"> <i class="fa fa-lock"></i> </span>
                                    </div>
                                    <input name="id" class="form-control" placeholder="Account or Loan Number" type="number" required autofocus>
                                </div>          
                   <div style="float:right">
                   <input type="submit" name="req_type"  value="Next" class="btn btn-info" />
                  </div>
           
                   </form>
    </article>
</div>
<!-- 
                <div class="row">
                        <div class="col-xl-6 col-md-5 mb-4 border" style="padding:30px">
                        <h4>Loan Request</h4>
                        <table id="list" class="table table-sm table-bordered table-striped">
                            <thead >
                                <tr align="center">
                                    <th>Loan No</th>
                                    <th>Acc No</th>
                                    <th>Req Date</th>
                                    <th>Paid Date</th>
                                    <th>T Amount</th>
                                </tr>
                            </thead>
                            <tbody>

                            <tr align="center">

                                <?php 

            $query = "SELECT * FROM loan_list WHERE req_status = 1 ORDER BY loan_no DESC ";

                if ($result = $conn->query($query)) {
                    while ($row = $result->fetch_assoc()) {

                        $loan_no = $row["loan_no"];
                        $acc_no = $row["acc_no"];
                        $paid_date = $row["paid_date"];
                        $req_date = $row["request_date"];
                        $o_w_c = $row["amount_with_charge"];
                        echo '
                        <td><a class="badge badge-danger" href="complete_loan_req.php?loan_no='.$loan_no.'">'.$loan_no.'</a></td>
                        <td>'.$acc_no.'</td>
                        <td>'.$req_date.'</td>
                        <td>'.$paid_date.'</td>
                        <td>'.$o_w_c.'</td>
                      </tr>';
                      echo '';
                    }
                    $result->free();
                } 

                ?></tr>
                            </tbody>
                        </table>                        </div>
                        <div class="col-xl-6 col-md-5 mb-4 border"  style="padding:30px">
                        <h4>Savings Withdrawal Request</h4>
                        <table id="list2" class="table table-sm table-bordered table-striped">
                            <thead >
                                <tr align="center">
                                    <th>Acc No</th>
                                    <th>Req Date</th>
                                    <th>Paid Date</th>
                                    <th>T Amount</th>
                                </tr>
                            </thead>
                            <tbody>

                            <tr align="center">

                                <?php 

            $query = "SELECT * FROM withdrawal_list WHERE req_status = 1 ORDER BY id DESC";

                if ($result = $conn->query($query)) {
                    while ($row = $result->fetch_assoc()) {

                        $acc_no = $row["acc_no"];
                        
                        $amount = $row["amount"];
                        $paid_date = $row["withdrawal_date"];
                        $req_date = $row["request_date"];
                      

                        echo '
                        <td><a class="badge badge-danger" href="complete_saving_req?acc_no='.$acc_no.'">'.$acc_no.'</a></td>
                        <td>'.$req_date.'</td>
                        <td>'.$paid_date.'</td>
                        <td>'.$amount.'</td>
                      </tr>';
                      echo '';
                    }
                    $result->free();
                } 

                ?></tr>
                            </tbody>
                        </table>                        </div> -->

                </div>

                

                </div>

    </body>
    <script src="../../js/jquery.js"></script>
    <script src="../../js/bootstrap.js"></script>
    <script src="../../js/fontawesome.js"></script>


<!-- datatable -->
    <script src="../../js/datatable.js"></script>
    <script src="../../js/datatable-bootstrap.js"></script>


    <script src="../../js/main.js"></script>

    <script>
        $("#menu-toggle").click(function(e) {
            e.preventDefault();
            $("#wrapper").toggleClass("toggled");
        });

        $('#list').dataTable( {
                "order": [[ 0, 'desc' ]]
            } );    
        $('#list2 ').dataTable( {
                "order": [[ 0, 'desc' ]]
            } );  

        var url = window.location.toString();
          if (url.includes("loan_no_not_found")) {
            swal("Loan Number Not Found", "", "error");
          }      
           if (url.includes("acc_no_not_found")) {
            swal("Account Number Not Found", "", "error");

          } 
          if (url.includes("loan_already_complete")) {
            swal("Account Number Not Found", "", "error");

          } 
          if (url.includes("cancled")) {
            swal("Request Canceled", "", "success");

          } 
          if (url.includes("loan_payment_complete")) {
            swal("Loan Paid", "", "success");

          } 
          if (url.includes("wr_paid")) {
            swal("Request Paid", "", "success");

          }      
          if (url.includes("error")) {
            swal("OPS.....Error", "", "error");

          }      
          
       


    </script>

    </html>