<!DOCTYPE html>
<html lang="en">
<head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title>Client Information Picker - DKBSS</title>
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
                   session_start();  
                    if(!isset($_SESSION["username"]))  
                    {  
                         header('location: ../../../index.php?error');  
                    }  

                    include("../../includes/config.php");
        if(isset($_POST["get_acc_no"])){
            $acc_no = $_POST["acc_no"];
            $type = $_POST["type"];

            if($type == 'view_info'){
                header("location: check_client.php?acc_no=".$acc_no);
            }elseif($type == 'edit_info'){
                header("location: edit_client_information.php?acc_no=".$acc_no);

            }
        }
        ?>
                      <nav aria-label="breadcrumb">
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="../">Dashboard</a></li>
    <li class="breadcrumb-item active" aria-current="page">Check Client </li>
  </ol>
</nav>
                <div class="container-fluid">
                     <article class="card-body mx-auto" style="max-width: 700px;">
                    <h3>Client Account Number</h3>
                    <form class="form-signin" method="post">
                    <div class="form-group input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"> <i class="fa fa-user"></i> </span>
                                </div>
                                <select name="type" class="form-control" required autofocus>
                                <option selected="" value="view_info">View Information</option>
                                <option value="edit_info">Edit Information</option>
                            </select>
                            </div>
                            <div class="form-group input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"> <i class="fa fa-lock"></i> </span>
                                    </div>
                                    <input name="acc_no" class="form-control" placeholder="Account Number" type="number" required autofocus>
                                </div>          
                   <div style="float:right">
                   <input type="submit" name="get_acc_no" value="Check" class="btn btn-info" />
                  </div>
           
                   </form>
    </article>

    <div id="data" class="last_added_client" style="padding-top:55px">
                        <table id="list" class="table table-sm border table-striped">
                            <thead >
                                <tr>
                                    <th scope="col" style="text-align: center;">ACC No</th>
                                    <th scope="col">Name</th>
                                    <th scope="col">Permanent Address</th>
                                    <th scope="col">Phone</th>
                                    <th scope="col">Join Date</th>
                                    <th scope="col">ACC Type</th>
                                    <th scope="col">Total Saving</th>
                                    <th scope="col">Status</th>
                                </tr>
                            </thead>
                            <tbody>

                                <?php 

            $query = "SELECT * FROM client ORDER BY acc_no DESC";

                if ($result = $conn->query($query)) {
                    while ($row = $result->fetch_assoc()) {
                        $acc_id = $row["acc_no"];
                        $name = $row["name"];
                        $address = $row["permanent_address"];
                        $age = $row["age"];
                        $phone = $row["phone"]; 
                        $join = $row["join_date"]; 
                        $acc_type = $row["acc_type"]; 
                        $photo = $row["client_photo"]; 
                        $total_savings = $row["total_saving"]; 
                        $s = $row["client_status"]; 

                        if($s == 1){
                            $status = "<i class='fas fa-check' style='color:green;'></i>";
                        }else{
                            $status = "<i class='fas fa-times' style='color:red;'></i>";
                        }
                        echo '<tr>
                        <th scope="row" style="text-align: center;"><a href="check_client?acc_no='.$acc_id.'">'.$acc_id.'</a></th>
                        <td>
                       
                        '.$name.'
                      </font>
                        </td>
                        <td>'.$address.'</td>
                        <td>0'.$phone.'</td>
                        <td>'.$join.'</td>
                        <td>'.$acc_type.'</td>
                        <td>'.$total_savings.' ৳</td>
                        <td align="center"><a href="edit_client_information.php?acc_no='.$acc_id.'">'.$status.'</a></td>
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
                </div>
    
</body>
<script src="../../js/jquery.js"></script>
        <script src="../../js/bootstrap.js"></script>
        <script src="../../js/fontawesome.js"></script>     
        <script src="../../js/datatable.js" "></script>
<script src="../../js/datatable-bootstrap.js ""></script>
        <script>

$('#list').dataTable( {
    "order": [[ 0, 'desc' ]]
} );

        var url = window.location.toString();
            if (url.includes("acc_not_found")) {
                swal("Sorry ! Client Not Found","", "error");
            }
        </script>   
</html>