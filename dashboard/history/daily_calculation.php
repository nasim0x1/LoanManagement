<?php require_once("../../includes/config.php");

                if(isset($_POST['daily_calculation'])){
                    $date = $_POST['date'];

                    $query = mysqli_query($conn, "SELECT * FROM daily_history WHERE date='".$date."'");
                    if(mysqli_num_rows($query) > 0){  

                        $sql = "SELECT SUM(in_) AS in_,SUM(out_) as out_ FROM daily_history WHERE date = '$date'";
                        $sth = $conn->query($sql);
                        $result=mysqli_fetch_array($sth);

                        $in_ = $result['in_'];
                        $out_ = $result['out_'];
                        $total = $in_ - $out_;

                        // check daily calculation 
                        $query = mysqli_query($conn, "SELECT * FROM daily_calculation WHERE date='".$date."'");
                    if(mysqli_num_rows($query) > 0){  
                            // update
                            $SQL = "UPDATE daily_calculation set date = '$date',debit = '$out_',coming_in = '$in_',total = '$total' where date='".$date."'";
                        if ($conn->query($SQL) === TRUE) {
                            header('location: daily_calculation.php?Success');
                        }else{
                            header('location: daily_calculation.php?failed');

                        }

                    }else{
                        // insert 

                        $SQL = "INSERT INTO daily_calculation(date,debit,coming_in,total) VALUES ('$date','$out_','$in_','$total')";
                        if ($conn->query($SQL) === TRUE) {
                            header('location: daily_calculation.php?Success');
                        }else{                            
                            header('location: daily_calculation.php?failed');
                        }

                    }

                    }else{
                        header('location: daily_calculation.php?not_found_date');


                    }

                }

                    
            ?>
    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title>Daily Calculation - DKBSSL</title>
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
    <li class="breadcrumb-item active" aria-current="page">Daily Calculation</li>
  </ol>
</nav>
                <div class="container-fluid">



                <article class="card-body mx-auto" style="max-width: 700px;">
                    <h3>Select Date To Calculate</h3>
                    <form class="form-signin" method="post">
                            <div class="form-group input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"> <i class="fa fa-lock"></i> </span>
                                    </div>
                                    <input name="date" class="form-control" type="date" required autofocus>
                                </div>          
                   <div style="float:right">
                   <input type="submit" name="daily_calculation" value="Calculate" class="btn btn-info" />
                  </div>
           
                   </form></article> <br> <br>
  

                        <div id="data" class="last_added_client">
                        <center><font size="5px" style="color:#0F82C8;font-weight: bold;"> Daily Calculation </font></center><br>

                        <table id="list" class="table table-sm table-bordered table-striped">
                            <thead >
                                <tr align="center">
                                    <th>Date</th>
                                    <th>Coming In(+)</th>
                                    <th>Debit(-)</th>
                                    <th>Total</th>
                                </tr>
                            </thead>
                            <tbody>

                            <tr align="center">

                                <?php 

            $query = "SELECT * FROM daily_calculation ORDER BY date DESC";

                if ($result = $conn->query($query)) {
                    while ($row = $result->fetch_assoc()) {

                        $date = $row["date"];
                        $debit = $row["debit"];
                        
                        $coming_in = $row["coming_in"];
                        $total = $row["total"];
                        

        

    
                        echo '
                        <td align="center">'.$date.'</td>
                        <td align="center">'.$coming_in.'</td>
                        <td align="center">'.$debit.'</td>
                        <td align="center">'.$total.'</td>
                      </tr>';
                    }
                    $result->free();
                } 

                ?></tr>
                            </tbody>
                        </table>
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
          if (url.includes("not_found_date")) {
            swal("There are no Transaction on This Date", "", "error");

          }
          if (url.includes("Success")) {
            swal("Calculated", "", "success");

          }
          if (url.includes("failed")) {
            swal("Something went wrong", "", "error");

          }

    </script>

    </html>