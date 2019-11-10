<?php
 require_once("../../includes/config.php");
 $url = $_SERVER['REQUEST_URI'];
 $urlarray=explode("=",$url);
 $acc_no=$urlarray[count($urlarray)-1];
 ?>
    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title>Acc No <?php echo $acc_no;?> Savings Deposit History - DKBSSL</title>
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

                <div class="container-fluid">
                        <div id="data" class="last_added_client">
                        <center><font size="5px" style="color:#0F82C8;font-weight: bold;"> Acc NO : <?php echo $acc_no;?> <?php $query = mysqli_query($conn, "SELECT * FROM client WHERE acc_no='".$acc_no."'");if(mysqli_num_rows($query) > 0 == false ){echo "<font color='red'>Not Found</font>";}?></font></center><br>

                        <table id="list" class="table table-sm table-bordered table-striped">
                            <thead >
                                <tr align="center">
                                    <th >Deposit No</th>
                                    <th >Date</th>
                                    <th >Amount</th>
                                    <th >Total Savings</th>
                                </tr>
                            </thead>
                            <tbody>

                                <?php 

            $query = "SELECT acc_no,date,amount,total_saving FROM saving_deposit WHERE acc_no = '$acc_no' ORDER BY id DESC";

            $sql = "SELECT COUNT(*) as k FROM saving_deposit where acc_no = '$acc_no'";
            $sth = $conn->query($sql);
            $count=mysqli_fetch_array($sth);
            $k = $count["k"]+1;


                if ($result = $conn->query($query)) {
                    while ($row = $result->fetch_assoc()) {

                        $k--;

                        $acc = $row["acc_no"];
                        $date = $row["date"];
                        $amount = $row["amount"];
                        $toatal = $row["total_saving"];
              
                        echo '
                        <td align="center">'.$k.'</td>
                        <td align="center">'.$date.'</td>
                        <td align="center">'.$amount.'৳</td>
                        <td align="center">'.$toatal.'৳</td>
                      </tr>';
                      echo '';
                    }
                    $result->free();
                } 

                ?>
                            </tbody>
                        </table>

                        <hr class="style2">
                        <?php 
                            $sql = "SELECT SUM(amount) as amount FROM saving_deposit where acc_no = '$acc_no'";
                            $sth = $conn->query($sql);
                            $total=mysqli_fetch_array($sth);
                           
                                                ?>
     <div style="padding-right:450px;">
                        <div class="float-right">Total Amount : <b><?php echo $total['amount']?> ৳</b></div>
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

        $('#list').dataTable( {
    "order": [[ 0, 'desc' ]]
} );    
var url = window.location.toString();
          if (!url.includes("acc_no=")) {
            window.location.replace("../index.php?acc_no_not_found");

          }

    </script>

    </html>