<?php
   include_once('../../includes/config.php');
   session_start();  
    if(!isset($_SESSION["username"]))  
    {  
         header("location:../../../index.php?error");  
    }  

    $url = $_SERVER['REQUEST_URI'];
    $urlarray=explode("=",$url);
    $loan_no=$urlarray[count($urlarray)-1];

    $sql = "SELECT capital FROM information WHERE id = 1";
    $sth = $conn->query($sql);
    $result=mysqli_fetch_array($sth);
    $capital = $result["capital"];

    $a = "SELECT acc_no,amount_with_charge FROM loan_list WHERE loan_no = $loan_no";
    $acc = $conn->query($a);
    $acc_=mysqli_fetch_array($acc);
    $acc_no = $acc_["acc_no"];
    $a_with_charge = $acc_['amount_with_charge'];


    // checkind is loan id exist on loan_list 
    $query = mysqli_query($conn, "SELECT  * FROM loan_list WHERE loan_no = '$loan_no'");
    if(mysqli_num_rows($query) > 0){
        $query = mysqli_query($conn, "SELECT  * FROM loan_list WHERE loan_no = '$loan_no' AND loan_complete = 0");
        if(mysqli_num_rows($query) > 0){
            $query = mysqli_query($conn, "SELECT  * FROM loan_list WHERE loan_no = '$loan_no' AND active = 1 AND req_status = 0");
            if(mysqli_num_rows($query) > 0){

     

            }else{
            header("location: add_deposit.php?loan_request_not_complet_yet");
            }
        }else{
            header("location: add_deposit.php?loan_already_complete");
        }
    }else{
        header("location: add_deposit.php?loan_no_not_found");
    }   


if(isset($_POST["add_deposit"])){

    $date = $_POST["date"];
    $amount = $_POST["amount"];

    $new_capital = $capital + $amount;
                $sql = "SELECT due FROM loan_list WHERE loan_no = '$loan_no'";
                $sth = $conn->query($sql);
                $result=mysqli_fetch_array($sth);

                $due = $result["due"] - $amount;

                if($due <= 0){
                    $loan_complete = 1;
                    $due_amount = 0;
                    $loan_running = 0;
                }else{
                    $loan_complete = 0;
                    $due_amount = $due;
                    $loan_running = 1;


                }

    $add_deposit = "INSERT INTO installment_deposit(loan_no, date, amount,due) VALUES ('$loan_no', '$date', '$amount','$due_amount')";
        if ($conn->query($add_deposit) === TRUE) {
            $update_LOan_list = "UPDATE loan_list SET due='$due' WHERE loan_no = '$loan_no'";
            if ($conn->query($update_LOan_list) === TRUE) {
                    // update daily history 
                $dailt_history = "INSERT INTO daily_history (
                    in_,
                    out_,
                    date,
                    description)
                VALUES (
                   '$amount',
                   0,
                   '$date',
                   'Installment Deposit(Loan No:".$loan_no.")')";
                   if ($conn->query($dailt_history) === TRUE) {
                    //    update capital 
                    $update_capital = "UPDATE information SET capital='$new_capital' WHERE id=1";
                                if ($conn->query($update_capital) === TRUE) {

                        $update_loan_status = "UPDATE loan_list SET loan_complete='$loan_complete' WHERE loan_no= '$loan_no'";
                        $conn->query($update_loan_status);
                        
                        $client_update = "UPDATE client SET loan_running='$loan_running' WHERE acc_no= '$acc_no'";
                        $conn->query($client_update);   

                    header("location: add_deposit.php?DepositSuccessfull");    
                 }else{
                        header("location: add_installment.php?DepositFeiled?loan_no=".$loan_no); 

                    }   
                   }else{
                    header("location: add_installment.php?DepositFeiled?loan_no=".$loan_no); 
                   }

            }else{
                header("location: add_installment.php?DepositFeiled?loan_no=".$loan_no); 
            }

            }else{
                header("location: add_installment.php?DepositFeiled?loan_no=".$loan_no); 
            }     
}            


$sql = "SELECT acc_no FROM loan_list WHERE loan_no = '$loan_no'";
$sth = $conn->query($sql);
$result=mysqli_fetch_array($sth);
$acc_no = $result["acc_no"];


 ?>


<!DOCTYPE html>
<html lang="en">
   <head>
      <meta charset="UTF-8">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <meta http-equiv="X-UA-Compatible" content="ie=edge">
      <title>Add Installment (কিস্তি) - DKBSS</title>
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
                <div class="sidebar-heading">installment</div>
                <div class="list-group list-group-flush">
                    <a href="../index" class="unclickable list-group-item list-group-item-action bg-light">Dashboard</a>
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
    <li class="breadcrumb-item"><a href="add_deposit">Add Deposit</a></li>
    <li class="breadcrumb-item active" aria-current="page">Add Installment</li>
  </ol>
</nav>
            <div class="container-fluid">


            <!-- form for deposit -->
            <div class="table-bordered">
            <article class="card-body mx-auto" style="max-width: 800px;">
                    <h3>Add New Installment</h3>
                    <form class="form-signin" method="post">
                    <div class="form-group input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text"> <i class="fa fa-money-check-alt"></i> </span>
                            </div>
                            <font class="form-control" style="max-width: 160px;">Amount:</font>
                            <input type="number" name="amount" class="form-control"  placeholder="Amount" required autofocus>
                        </div>
            <div class="form-group input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text"> <i class="fa fa-calendar-alt"></i> </span>
                            </div>
                            <font class="form-control" style="max-width: 160px;">Date:</font>
                            <input type="date" name="date" value="<?php echo date('Y-m-d'); ?>" class="form-control" required autofocus>
                        </div>
            <input type="submit" name="add_deposit" value="Add Deposit" style="float:right" class="btn btn-primary" />
                        </center>
                    </form>
                </article></div>


            <div class="row" style="margin-top:70px">
            <div class="col-xl-5 col-md-5 mb-3">
            <h4 class="">Client Information :</h4> 
            <?php
            $sql = "SELECT * FROM client WHERE acc_no = '$acc_no'";
            $sth = $conn->query($sql);
            $profile=mysqli_fetch_array($sth);
            
            ?>
 


            <div class="table-bordered">
            <center><img src="../../image/client_photo/<?php echo $profile['client_photo']?>" style="border-radius: 50%;margin-top:10px;" height="110" width="auto">
            <h5><?php echo $profile['name']?></h5s>
            </center>
                <div style="margin:15px">
                <p>Address : <?php echo $profile['permanent_address']?><br>
                Phone : 0<?php echo $profile['phone']?><br>
                Account Type : <?php echo $profile['acc_type']?> <br>
                Join Date : <?php echo $profile['join_date']?>
                
                </p>

                </div>
          </div>       

                        
                        </div>
                        <!-- col end  -->

                       <div class="col-xl-7 col-md-7 mb-5">
                       <h4 class="">Installment History :</h4>         
                       <table id="list" class="table table-bordered">
                        <thead>
                            <tr style="text-align: center;">
                            <th scope="col" style="width: 50px" >No</th>
                            <th scope="col">Date</th>
                            <th scope="col">Amount</th>
                            <th scope="col">Due</th>
                            <th scope="col">Action</th>
                            </tr>
                        </thead>
                        <tbody>

                        <?php

            $query = "SELECT date,amount,due,id  FROM installment_deposit  WHERE loan_no = '$loan_no' ORDER BY id DESC";

            $sql = "SELECT COUNT(id) as c FROM installment_deposit WHERE loan_no = '$loan_no'";
            $sth = $conn->query($sql);
            $result=mysqli_fetch_array($sth);
            $count = $result["c"];
            



            if ($result = $conn->query($query)) {
                    while ($row = $result->fetch_assoc()) {

                        $date = $row["date"];
                        $amount = $row["amount"];
                        $tatal_saving = $row["due"];
                        $count -=1;
                        $deposit_id = $row["id"];

   
                            $x = $count + 1;


                        echo '<tr style="text-align: center;">
                        <th>'.$x.'</th>
                        <td>'.$date.'</td>
                        <td>'.$amount.'</td>
                        <td>'.$tatal_saving.'</td>
                        <td align="center"><a href="../edit/installment_deposit_delete.php?id='.$deposit_id.'"><i class="fa fa-trash-alt" style="color:red;"></i></a></td>
                      </tr>';
                      echo '';
                    }
                    $result->free();
                } else{
                    echo $conn->error;
                }

                ?>
                        </tbody>
                        </table>
                    <!-- col end -->
                    </div>    
                    </div>  
                    <!-- row contianer end  -->

      
    </div>
  </div>
  
</div>
            </div>
         </div>
         <!-- /#page-content-wrapper -->
      </div>
   </body>
   <script src="../../js/jquery.js"></script>
   <script src="../../js/bootstrap.js"></script>
   <script src="../../js/fontawesome.js"></script>
   <script src="../../js/datatable.js""></script>
    <script src="../../js/datatable-bootstrap.js""></script>
   <script>
              $('#list').dataTable( {
    "order": [[ 0, 'desc' ]]
} );
      window.onload = function() {
              
          $("#menu-toggle").click(function(e) {
              e.preventDefault();
              $("#wrapper").toggleClass("toggled");
          });
          var url = window.location.toString();
          if (url.includes("DepositFeiled")) {
            swal("Deposit Feiled. Contact Developer", "", "error");
          }

      }

   </script>
</html>

<?php 
 ?>