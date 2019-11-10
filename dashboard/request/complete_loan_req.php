<?php 
require_once("../../includes/config.php");

        $url = $_SERVER['REQUEST_URI'];
        $urlarray=explode("=",$url);
        $loan_no=$urlarray[count($urlarray)-1];

        $query = mysqli_query($conn, "SELECT  * FROM loan_list WHERE loan_no = '$loan_no'");
        if(mysqli_num_rows($query) > 0){
            $query = mysqli_query($conn, "SELECT  * FROM loan_list WHERE loan_no = '$loan_no' AND req_status= 3");
            if(mysqli_num_rows($query) > 0){
                header("location: index.php?cancled");
            }else{
                $query = mysqli_query($conn, "SELECT  * FROM loan_list WHERE loan_no = '$loan_no' AND active= 1");
                if(mysqli_num_rows($query) > 0){
                    header("location: index.php?loan_payment_complete");
                }
            }

            $sth = $conn->query("SELECT  * FROM loan_list WHERE loan_no = '$loan_no'");
            $result=mysqli_fetch_array($sth);
            $acc_no = $result['acc_no']; 

            $amount =$result['amount'];

            
            $info = "SELECT * FROM client WHERE acc_no = '$acc_no'";
            $information_get = $conn->query($info);
            $information=mysqli_fetch_array($information_get);


            $c = "SELECT * FROM information WHERE id = 1";
            $cp = $conn->query($c);
            $x=mysqli_fetch_array($cp);
            $old_capital = $x['capital'];

            }else{
                header("location: index.php?loan_no_not_found");
            }

            if (isset($_POST["update"])) {
                $get_status = $_POST['status'];
                $date = $_POST['paid_date'];

                    if($get_status == 1){
                        $req = 0;
                        $active = 1;
                    }elseif($get_status == 0){
                        $req = 1;
                        $active = 0;
                    }elseif($get_status == 3){
                        $req = 3;
                        $active = 0;
                    }

                $sql = "UPDATE loan_list SET req_status ='$req',active = '$active',paid_date = '$date' where loan_no = '$loan_no'";
                if ($conn->query($sql) === TRUE) {

                    if($get_status == 1){
                        $update_client_prfile = "UPDATE client set loan_running = $active where acc_no = '$acc_no'";
         
                        if ($conn->query($update_client_prfile) === TRUE) {

                            $update_client_balance = "UPDATE client set total_saving = '$new_balance' where acc_no = '$acc_no'";

                            $dailt_history = "INSERT INTO daily_history (
                                in_,
                                out_,
                                date,
                                description)
                            VALUES (
                               50,
                               $amount,
                               '$date',
                               'Loan Paid(ACC NO:".$acc_no.") and 50 Tk Loan Charge For Client Dead Issue')";
                               if ($conn->query($dailt_history) === TRUE) {
                                $new_capital =($old_capital+50)-$amount;
                                $update_capital = "UPDATE information SET capital='$new_capital' WHERE id=1";
                                if ($conn->query($update_capital) === TRUE) {
                                header("location: complete_loan_req.php?UpdateSuccessfull?loan_no=".$loan_no);
                        
                                }
                            }
                    
                    }
                    }else{
                        header("location: complete_loan_req.php?UpdateSuccessfull?loan_no=".$loan_no);
                    }
                    
                }else{
                    echo "Error: " . $sql . "<br>" . $conn->error;

                }
            }
 
?>
    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title>Loan Status- DKBSSL</title>
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
    <li class="breadcrumb-item"><a href="loan_request_list">Loan Request List</a></li>
    <li class="breadcrumb-item active" aria-current="page">Action</li>
  </ol>
</nav>

            <div class="container-fluid">
                <div class="row">

                    <div class="card-body">
                        <div class="e-profile">
                        <center><h4>Complete Loan Request</h4></center>
                            <div class="profile_pic_edit">
                                <center>
                                    <img id="profileImage" alt="<?php echo $information['name'];?>" class="circle_view" src="../../image/client_photo/<?php echo $information['client_photo'];?>">
                                </center>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="table-responsive-xl">
                    <table class="table table-sm border table-striped">
                        <thead>
                            <tr align="center">
                                <th scope="col" style="text-align: center;">ACC No</th>
                                <th scope="col">Name</th>
                                <th scope="col">Phone</th>
                                <th scope="col">Loan Amount</th>
                                <th scope="col">Per Installment</th>
                                <th scope="col">Req Date</th>
                            </tr>
                            <tr align="center">
                            <th><?php echo $acc_no;?></th>
                            <td><?php echo $information['name'];?></td>
                            <td>0<?php echo $information['phone'];?></td>
                            <td><?php echo $result['amount']?> ৳</td>
                            <td><?php echo $result['amount_with_charge']/120;?> ৳</td>
                            <td><?php echo $result['request_date']?></td>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
                <div class="container" style="width:300px;">
                <div class="card card-signin my-5">
                    <div class="card-body">
                        <form class="form-signin" method="post">
                            <label>Payment Status</label>
                            <select name="status" class="custom-select" required autofocus>
                                        <option value="0" <?php if($result["req_status"]==1 && $result[ 'loan_complete']==0 ){ echo 'selected=""'; }?>>Pending</option>
                                        <option value="1" <?php if($result['active']==1 ){ echo 'selected=""'; }?>> Completed</option>
                                        <option value="3" <?php if($result[ 'loan_complete']==0 && $result['req_status']==3 ){ echo 'selected=""'; }?>>Canceled</option>
                                    </select>                            <br /> <br />
                            <label>Payment Date</label>
                            <input class="form-control" name="paid_date" type="date" value="<?php echo Date("Y-m-d");?>" placeholder="<?php echo $result['paid_date'];?>" required autofocus>
                            <br />
                            <center>
                                <input type="submit" name="update" value="Update" class="btn btn-info" />
                            </center>
                        </form>
                    </div>
                </div>
            </div>
            </div>

            


</body>
    <script src="../../js/jquery.js"></script>
    <script src="../../js/bootstrap.js"></script>
    <script src="../../js/fontawesome.js"></script>


<!-- datatable -->
    <script src="../../js/datatable.js""></script>
    <script src="../../js/datatable-bootstrap.js""></script>


    <script src="../../js/main.js"></script>

    <script>
        $("#menu-toggle").click(function(e) {
            e.preventDefault();
            $("#wrapper").toggleClass("toggled");
        });

        $(function() {
            $('[data-toggle="tooltip"]').tooltip()
        })


var url = window.location.toString();
 if (!url.includes("loan_no=")) {
    window.location.replace("index.php?loan_no_not_found");
          }
 if (url.includes("UpdateSuccessfull")) {
    swal("Update SuccessFull", "", "success");
        
        }
        if (url.includes("request_added_successfully")) {
    swal("Loan Request Added", "", "success");
        
        }
          
        
    </script>

    </html>