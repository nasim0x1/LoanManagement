<?php
   include_once('../includes/config.php');
   session_start();  
    if(!isset($_SESSION["username"]))  
    {  
         header("location:../index.php?error");  
    }  
   ?>

<?php

$sql = "SELECT capital FROM information WHERE id = 1";
$sth = $conn->query($sql);
$x=mysqli_fetch_array($sth);
$capital = $x['capital'];
if(isset($_POST["add"])){  
    $type = $_POST['get_type'];
    $date = $_POST['date'];
    $des = $_POST['des'];
    $amount = $_POST['amount'];
    if($amount <= 0){
        echo "valid amount";
    }else{

        if($type == "in_"){
            $in_ = $amount;
            $out_ = 0;
            $total_capital = $capital + $amount;
        }elseif($type == "out_"){
            $out_ = $amount;
            $in_ = 0;
            $total_capital = $capital - $amount;
        }
        
        // updating database
        $add_on_daily_history = "INSERT Into daily_history(date,in_,out_,description)VALUES('$date','$in_','$out_','$des')";
        if ($conn->query($add_on_daily_history) === TRUE) {
                $update_capital = "UPDATE information set capital = '$total_capital' where id = 1";
                if ($conn->query($update_capital) === TRUE) {
                    header("location: add_transaction.php?success");

                }else{
                    header("location: add_transaction.php?error");
                }
        }else{
            header("location: add_transaction.php?error");

        }

    }
        
}

?>

<!DOCTYPE html>
<html lang="en">
   <head>
      <meta charset="UTF-8">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <meta http-equiv="X-UA-Compatible" content="ie=edge">
      <title>Add Transaction - DKBSS</title>
      <link rel="shortcut icon" href="../image/favicon.png" />
      <link href="../css/bootstrap.css" rel="stylesheet">
      <link href="../css/fontawesome.css" rel="stylesheet">
      <script src="../js/sweetalert.js"></script>
      <link rel="stylesheet" href="../css/style.css">
      <link rel="stylesheet" href="../css/sweetalert.css">
      <link rel="stylesheet" href="../css/datatable.css">

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

                <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="../">Dashboard</a></li>
    <li class="breadcrumb-item active" aria-current="page">Add Transaction</li>
  </ol>
</nav>
            <div class="container-fluid">
            <article class="card-body mx-auto" style="max-width: 700px;">
                    <h3>Transaction Type</h3>
                    <form class="form-signin" method="post">
                        <div class="form-group input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"> <i class="fa fa-one"></i> </span>
                                </div>
                                <select name="get_type" class="form-control" required autofocus>
                                <option value="" selected=""> Type</option>
                                <option value="out_">Debit (খরচ)</option>
                                <option value="in_">Coming-in (আয়)</option>
                            </select>
                            </div>
                            <div class="form-group input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"> <i class="fa fa-lock"></i> </span>
                                    </div>
                                    <input name="date" class="form-control" placeholder="Date" value="<?php echo Date('Y-m-d');?>" type="date" required autofocus>
                                </div>    
                            <div class="form-group input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"> <i class="fa fa-calendar-week"></i> </span>
                                    </div>
                                    <input name="amount" class="form-control" placeholder="Amount" type="number" required autofocus>
                                </div>      
                                <div class="form-group input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"> <i class="fa fa-pen"></i> </span>
                                    </div>
                                    <textarea name="des" class="form-control" placeholder="Description" type="text" required autofocus></textarea>
                                </div>       
                   <div style="float:right">
                   <input type="submit" name="add" value="Add" class="btn btn-info" />
                  </div>
           
                   </form>
    </article>
    <div id="data" class="last_added_client" style="padding-top:50px">
                        <center><font size="5px" style="color:#0F82C8;font-weight: bold;"> Daily History </font></center><br>

                        <table id="list" class="table table-sm table-bordered table-striped">
                            <thead >
                                <tr align="center">
                                    <th >TrxID</th>
                                    <th >Date</th>
                                    <th ><i class="fas fa-plus"></i></th>
                                    <th ><i class="fas fa-minus"></i></th>
                                    <th scope="col">Description</th>
                                </tr>
                            </thead>
                            <tbody>

                                <?php 


            $get_history = "SELECT * FROM daily_history ORDER BY id DESC";
                if ($result = $conn->query($get_history)) {
                    while ($row = $result->fetch_assoc()) {
                        $id = $row["id"];
                        $date = $row["date"];
                        $in = $row["in_"];
                        $out = $row["out_"];
                        $des = $row["description"]; 

    
                        echo '
                        <td align="center">'.$id.'</td>
                        <td align="center">'.$date.'</td>
                        <td align="center">'.$in.'</td>
                        <td align="center">'.$out.'</td>
                        <td>'.$des.'</td>
                      </tr>';
                      echo '';
                    }
                    $result->free();
                } 

                ?>
                            </tbody>
                        </table>
                    </div>
      </div>
   </body>
   <script src="../js/jquery.js"></script>
   <script src="../js/bootstrap.js"></script>
   <script src="../js/fontawesome.js"></script>
   <script src="../js/datatable.js"></script>
    <script src="../js/datatable-bootstrap.js"></script>
   <script>
           var url = window.location.toString();
              if (url.includes("error")) {
            swal("Opps", "Something went worng. Try agine", "error");
        }
        if (url.includes("success")) {
            swal("Success", "Added Successfully", "success");
        }
      
          $("#menu-toggle").click(function(e) {
              e.preventDefault();
              $("#wrapper").toggleClass("toggled");
          });

          $('#list').dataTable( {
    "order": [[ 0, 'desc' ]]
} );   

   </script>
</html>