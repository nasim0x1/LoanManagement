<?php require_once("../../includes/config.php");?>
    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title>Daily History - DKBSSL</title>
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
                                <a class="nav-link" href="index.php" onclick="print_table('data');" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
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
                                    <a class="dropdown-item" href="logout">Logout</a>
                                </div>
                            </li>
                        </ul>
                    </div>
                </nav>
                <nav aria-label="breadcrumb">
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="../">Dashboard</a></li>
    <li class="breadcrumb-item active" aria-current="page">Daily History</li>
  </ol>
</nav>

                <div class="container-fluid">

                        <div id="data" class="last_added_client">
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

            $query = "SELECT * FROM daily_history ORDER BY id DESC";

                if ($result = $conn->query($query)) {
                    while ($row = $result->fetch_assoc()) {
                        $id = $row["id"];
                        $date = $row["date"];
                        $in = $row["in_"];
                        $out = $row["out_"];
                        $des = $row["description"]; 

    
                        echo '
                        <td align="center">'.$id.'</td>
                        <td align="center">'.$date.'</td>
                        <td align="center">'.$in.' ৳</td>
                        <td align="center">'.$out.' ৳</td>
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

    </script>

    </html>