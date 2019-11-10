<?php
   include_once('../includes/config.php');
   session_start();  
    if(!isset($_SESSION["username"]))  
    {  
         header("location:../index.php?error");  
    }  
   ?>

<?php

$sql = "SELECT login_pass FROM login";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) {
       $db_pass = $row["login_pass"];
    }
}

if(isset($_POST["changepass"]))  
 {  
    $pass = $_POST["oldpass"];
    $oldpass = md5($pass);
      if($oldpass == $db_pass){
         if($_POST["newpass"] == $_POST["newpass2"]){

            $newpass = md5($_POST["newpass"]);   
            $sql = "UPDATE login SET login_pass='$newpass' WHERE id=1";
      
            if ($conn->query($sql) === TRUE) {
               header("location: ?newpasschange");
           } else {
            header("location: ?dberror");
           }
           $conn->close();
         }else{
            header("location: ?newpasserror");  
         }
      }else{
         header("location: ?oldpasserror");  
      }
 }


 if(isset($_POST["changename"])){
    
   $getname = str_replace(' ', '', $_POST["name"]);
   $newname =  strtolower($getname);

   $sql = "UPDATE login SET login_name='$newname' WHERE id=1";

   if ($conn->query($sql) === TRUE) {
      header("location: ?namechange");
  } else {
   header("location: ?dberror");
  }

}
if(isset($_POST["update_capital"])){
    $new_capital = $_POST['capital'];
    $lp = $_POST['lp'];
    $update_capital = "UPDATE information SET capital = '$new_capital',loan_percentage = '$lp' WHERE id = 1";
    if ($conn->query($update_capital) === TRUE) {
        header("location: setting.php?capital_updatted");    
    }else{
        header("location: setting.php?capital_update_failed");
    }
}
?>

<!DOCTYPE html>
<html lang="en">
   <head>
      <meta charset="UTF-8">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <meta http-equiv="X-UA-Compatible" content="ie=edge">
      <title>Setting - DKBSS</title>
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
                    <div class="alert alert-success">
                    <a href="index" class="list-group-item list-group-item-action bg-light">Dashboard</a>
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
                    <a class="unclickable nav-active list-group-item list-group-item-action bg-light">Setting</a>
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
                <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="../">Dashboard</a></li>
    <li class="breadcrumb-item active">Setting</li>
  </ol>
</nav>

            <div class="container-fluid">
               <h2 class="mt-4">Setting</h2></br>
            <div class="container">
            <div class="row">
            <div class="col-xl-6 col-md-6 mb-4">

            <div class="card card-signin">
        
                    <div class="card-body">
                    <h4 style="color:green">Change Username</h4>
                        <form class="form-signin" method="post">
                            <label>New Name</label>
                            <input type="text" name="name" class="form-control" required autofocus />
                            <br />
                            <center><h6 style="color:red;align:center">Note : Name Will Change in Small Letter and Whitespace Will Remove<b>(Md Shameem => mdshamem)</b></h6></center>
                            <center>
                                <input type="submit" name="changename" value="Change" class="btn btn-info" />
                            </center>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-xl-6 col-md-6 mb-4">

            <div class="card card-signin">
                    <div class="card-body">
                    <h4 style="color:green">Change Password</h4>

                        <form class="form-signin" method="post">
                            <label>Old Password</label>
                            <input type="password" name="oldpass" class="form-control" required autofocus />
                            <br />
                            <label>New Password</label>
                            <input type="password" name="newpass" class="form-control" required autofocus/>
                            <br />
                            <label>Re-type New Password</label>
                            <input type="password" name="newpass2" class="form-control" required autofocus/>
                            <br />
                            <center>
                                <input type="submit" name="changepass" value="Change" class="btn btn-info" />
                            </center>
                        </form>
                    </div>
                </div>
            </div>
            </div>
        </div>
            
            </div>
            <center><button type="button" class="btn btn-primary" data-toggle="modal" data-target="#update_capital">
                Update Information</button></center>
         </div>
         
         <!-- /#page-content-wrapper -->
      </div>
      <?php 
                                                    $sql = "SELECT capital,loan_percentage FROM information WHERE id = 1";
                                                    $sth = $conn->query($sql);
                                                    $result=mysqli_fetch_array($sth);
                                                   
                                                ?>
      <!-- capital updater -->
      <div class="modal fade" id="update_capital" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Information</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form method="post">
      <div class="modal-body">
      <h5 style="color:green"><b>Capital ! 😊 </b></h5>
      <input type="number" name="capital" value="<?php  echo $result["capital"];?>" placeholder="<?php  echo $result["capital"];?>" class="form-control" required autofocus />
      <h5 style="color:green"><b>Loan Percentage ! 😊 </b></h5>
      <input type="number" name="lp" value="<?php  echo $result["loan_percentage"];?>" placeholder="<?php  echo $result["loan_percentage"];?>" class="form-control" required autofocus />

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <input type="submit" name="update_capital" value="Save changes" class="btn btn-primary">
      </div>
      </form>
    </div>
  </div>
</div>
   </body>
   <script src="../js/jquery.js"></script>
   <script src="../js/bootstrap.js"></script>
   <script src="../js/fontawesome.js"></script>
   <script>
      window.onload = function() {
      
          $("#menu-toggle").click(function(e) {
              e.preventDefault();
              $("#wrapper").toggleClass("toggled");
          });
      
          var url = window.location.toString();
          if (url.includes("index.php?login") && url.includes("#") != true) {
              var name = url.split("=")[1].substring(0, 11);
              swal(name, "Welcome to Dashboard", "success");
          }
          if (url.includes("?oldpasserror") && url.includes("#") != true) {
              swal("Incorrect Old Password","", "error");
          }
          if (url.includes("?newpasserror") && url.includes("#") != true) {
              swal("New Password Do Not Match","", "error");
          }
          if (url.includes("?dberror") && url.includes("#") != true) {
              swal("Database Error","", "success");
          }
          if (url.includes("?newpasschange") && url.includes("#") != true) {
              swal("Password Changed Successfully","", "success");
          }
          if (url.includes("?namechange") && url.includes("#") != true) {
              swal("Name Changed Successfully","", "success");
          }
          if (url.includes("?capital_updatted") && url.includes("#") != true) {
              swal("Information Update Successfully","", "success");
          }
          if (url.includes("?capital_update_failed") && url.includes("#") != true) {
              swal("Informaion Update Failed","", "error");
          }
      }

   </script>
</html>