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


    $q = "SELECT * FROM loan_list WHERE loan_no = '$loan_no'";
    $w = $conn->query($q);
    $info=mysqli_fetch_array($w);

    $acc_no = $info['acc_no'];




    // checking client is exist
    $query = mysqli_query($conn, "SELECT  * FROM client WHERE acc_no = '$acc_no'");
            if(mysqli_num_rows($query) > 0){
                $sql = "SELECT name FROM client WHERE acc_no = '$acc_no'";
                $sth = $conn->query($sql);
                $result=mysqli_fetch_array($sth);
                $title = $result['name'];
            }else{
               header('location: ../index.php?acc_not_found');
            }

            $q = "SELECT * FROM client WHERE acc_no = '$acc_no'";
            $w = $conn->query($q);
            $info=mysqli_fetch_array($w);

            $ll = "SELECT * FROM loan_list WHERE loan_no = '$loan_no'";
            $lll = $conn->query($ll);
            $loan_list=mysqli_fetch_array($lll);

            $req = $loan_list['req_status'];


            if($req == 0 && $loan_list['loan_complete'] == 1){
                $loan_status = "<span class='badge badge-success'>Completed</span>";
            }elseif($req == 1){
                $loan_status = "<a href='../request/complete_loan_req.php?loan_no=$loan_no' class='badge badge-warning'>Pending</a>";
            }elseif($req == 3){
                $loan_status = "<span class='badge badge-secondary'>Canceled</span>";
            }else{
                $loan_status = "<span class='badge badge-danger'>Running</span>";
            }

            $xx = "SELECT * FROM installment_deposit WHERE loan_no = '$loan_no'";
            $cc = $conn->query($xx);
            $loan_ins=mysqli_fetch_array($cc);

            $k = $conn->query("SELECT COUNT(id) as k FROM installment_deposit WHERE loan_no = '$loan_no'");
            $count=mysqli_fetch_array($k);

            $k = $conn->query("SELECT date FROM installment_deposit WHERE loan_no = '$loan_no' ORDER BY date DESC LIMIT 1");
            $last_installment=mysqli_fetch_array($k);


        ?>

    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title>Loan Status - DKBSSL</title>
        <link rel="shortcut icon" href="../../image/favicon.png" />
        <link href="../../css/bootstrap.css" rel="stylesheet">
        <link href="../../css/fontawesome.css" rel="stylesheet">
        <script src="../../js/sweetalert.js"></script>
        <link rel="stylesheet" href="../../css/style.css">
        <link rel="stylesheet" href="../../css/sweetalert.css">
        <link rel="stylesheet" href="../../css/datatable.css">
        <style>
        
        .bnw {
  -webkit-filter: grayscale(100%); /* Safari 6.0 - 9.0 */
  filter: grayscale(100%);
}
</style>
    </head>

    <body>
        <div class="d-flex" id="wrapper">
            <!-- Sidebar -->
            <div class="bg-light border-right" id="sidebar-wrapper">
                <div class="sidebar-heading">🇩​🇰​🇧​🇸​🇸​</div>
                <div class="list-group list-group-flush">
                    <a href="../index" class=" list-group-item list-group-item-action bg-light">Dashboard</a>
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
                                <a class="nav-link" href="" onclick="print_content('data')" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <i class="fa fa-print fa-lg"></i>
                                </a>
                            </li>
                            <li class="nav-item dropdown" style="padding-right:10px">
                                <a class="nav-link" href="../../index.php" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
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
    <li class="breadcrumb-item"><a href="loan">Loan List</a></li>
    <li class="breadcrumb-item active" aria-current="page">Loan Status</li>
  </ol>
</nav>

                <div id="data" class="container-fluid">
                    <div><center>
                    <div style="font-size:25px;">Loan Status</div></center>
<table style="border:1px solid #4d99b3;margin:0px 0px 0px 0px;color:#257590;width:100%;font-size:17px;" cellspacing="0" cellpadding="0">
		<tbody><tr>
            <td align="center" style="padding:4px 10px;vertical-align: top;" width="25%">
       
            <img height="120" src="../../image/client_photo/<?php echo $info['client_photo'] ?>" alt="profile">
      
					<div style="color:#4d99b3; font-weight:bold"><?php echo $info['name'] ?></div>
					
					<div style="color:#696957;">
                    <?php echo $info['bcn_or_nid_no'] ?>
					</div>
				
				
			</td>
			<td style="border-left: 1px solid #4d99b3;padding: 0px;">
				<table style="width:100%;" cellspacing="0" cellpadding="0">
						<tbody><tr>
							<td style="padding:1px 14px 1px 14px;border-bottom:1px solid #4d99b3;border-right:1px solid #4d99b3;text-align: center; padding: 2px;"> Loan No</td>
                            <td style="padding:1px 14px 1px 14px;border-bottom:1px solid #4d99b3;border-right:1px solid #4d99b3;text-align: center;">Acc No</td>
                            <td style="padding:1px 14px 1px 14px;border-bottom:1px solid #4d99b3;text-align: center;">Request Date</td>
                            <td style="padding:1px 14px 1px 14px;border-bottom:1px solid #4d99b3;border-right:1px solid #4d99b3;text-align: center;">Paid Date</td>

							
						</tr>
						
						<tr>
							<td style="text-align: center; padding: 2px;color:#696957;"><?php echo $loan_no; ?></td>
							<td style="text-align: center;color:#696957;"><?php echo $info['acc_no'] ?></td>
							<td style="text-align: center;color:#696957;"><?php echo $loan_list['request_date']; ?></td>
							<td style="text-align: center;color:#696957;"><?php echo $loan_list['paid_date']; ?></td>
						
						</tr>
						<tr>
							<td style="padding:1px 5px 1px 5px;border:1px solid #4d99b3;border-left:0px; text-align: center;padding: 2px;">Amount</td>
							<td style="padding:1px 5px 1px 5px;border:1px solid #4d99b3;border-left:0px;text-align: center;">Amount With Charge</td>
							<td style="padding:1px 5px 1px 5px;border:1px solid #4d99b3;border-left:0px;text-align: center;">Installment Per Day</td>
							<td style="padding:1px 5px 1px 5px;border:1px solid #4d99b3;border-left:0px;border-right: 0px;text-align: center;">Checking Date</td>
							
						</tr>
						
						<tr>
							<td style="text-align: center;padding: 2px;color:#696957;"> <?php echo $loan_list['amount'] ?> ৳</td>
							<td style="text-align: center;color:#696957;"><?php echo $loan_list['amount_with_charge'] ?> ৳</td>
							<td style="text-align: center;color:#696957;"><?php echo $loan_list['amount_with_charge']/120 ?>৳</td>
							<td style="text-align: center;color:#696957;"><?php echo Date("Y-m-d"); ?></td>
						</tr>
						<tr>
							<td style="background:#0000;padding:1px 5px 1px 5px;border:1px solid #4d99b3;border-left:0px;text-align: center;padding: 2px;"> Total Installment</td>
                            <td style="padding:1px 5px 1px 5px;border:1px solid #4d99b3;border-left:0px;text-align: center;" colspan="1">Due</td>
							<td style="padding:1px 5px 1px 5px;border:1px solid #4d99b3;border-left:0px;text-align: center;" >Last Installment Date</td>
							<td style="padding:1px 5px 1px 5px;border:1px solid #4d99b3;border-left:0px;border-right: 0px;text-align: center; background-color: #0000;">Status</td>
							
						</tr>
						
						<tr>
							<td style="text-align: center;padding: 2px;color:#696957;"><?php echo $count['k'] ?> times</td>
                            <td colspan="1" style="text-align: center;color:#696957;"><?php echo $loan_list['due']; ?> ৳</td>
							<td  style="text-align: center;color:#696957;"><?php echo $last_installment['date']; ?></td>
							<td style="font-size:20px;text-align: center;color:#696957;"><div class=""><?php echo $loan_status; ?></div></td>
						
						</tr>
					
					</tbody></table>
				</td>
		</tr>
	</tbody></table>
    <br>

    <table id="list" class="table table-sm table-bordered table-striped">
                            <thead >
                                <tr align="center">
                                    <th style="max-width: 40px;">Installment  No</th>
                                    <th >Date</th>
                                    <th >Amount</th>
                                    <th >Due</th>
                                </tr>
                            </thead>
                            <tbody>

                                <?php 

                $sql = "SELECT COUNT(id) as k FROM installment_deposit where loan_no = '$loan_no' ORDER BY id DESC";
                $sth = $conn->query($sql);
                $total=mysqli_fetch_array($sth);
                $k = $total['k']+1;

            $query = "SELECT * FROM installment_deposit where loan_no = '$loan_no' ORDER BY id DESC";

                if ($result = $conn->query($query)) {
                    while ($row = $result->fetch_assoc()) {
                        $loan = $row["loan_no"];
                        $date = $row["date"];
                        $amount = $row["amount"];
                        $due = $row["due"];
                        $k--;
              
                        echo '
                        <td align="center">'.$k.'</td>
                        <td align="center">'.$date.'</td>
                        <td align="center">'.$amount.'৳</td>
                        <td align="center">'.$due.'৳    </td>
                        </tr>';
                      echo '';
                    }
                    $result->free();
                } 

                ?>
                            </tbody>
                        </table>
                      


                    </div>

    </body>
    <script src="../../js/jquery.js"></script>
    <script src="../../js/bootstrap.js"></script>
    <script src="../../js/fontawesome.js"></script>

    <!-- datatable -->
    <script src="../../js/datatable.js" "></script>
<script src="../../js/datatable-bootstrap.js ""></script>

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