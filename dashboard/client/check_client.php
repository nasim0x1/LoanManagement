<?php
   include_once('../../includes/config.php');

   session_start();  
    if(!isset($_SESSION["username"]))  
    {  
         header("location:../../../index.php?error");  
    }  

    $url = $_SERVER['REQUEST_URI'];
    $urlarray=explode("=",$url);
    $acc_no=$urlarray[count($urlarray)-1];

    // checking client is exist
    $query = mysqli_query($conn, "SELECT  * FROM client WHERE acc_no = '$acc_no'");
            if(mysqli_num_rows($query) > 0){
                $sql = "SELECT name FROM client WHERE acc_no = '$acc_no'";
                $sth = $conn->query($sql);
                $result=mysqli_fetch_array($sth);
                $title = $result['name'];
            }else{
               header('location: index.php?acc_not_found');
            }

            $q = "SELECT * FROM client WHERE acc_no = '$acc_no'";
            $w = $conn->query($q);
            $info=mysqli_fetch_array($w);


            $ccc = "SELECT COUNT(*) as kk, SUM(amount) AS ss FROM loan_list WHERE acc_no = '$acc_no' and  active != 3";
            $zzz = $conn->query($ccc);
            $v=mysqli_fetch_array($zzz);
            $total_loan =  $v["kk"];
            $total_loan_balance =  $v["ss"];

            $xx = "SELECT COUNT(*) as k FROM saving_deposit WHERE acc_no = '$acc_no'";
            $cc = $conn->query($xx);
            $x=mysqli_fetch_array($cc);
            $total_deposit_time =  $x["k"];


            $total_loan_req = $conn->query("SELECT COUNT(*) as kk, SUM(amount) AS ss FROM loan_list WHERE acc_no = '$acc_no' ");
            $get_loan_total_req = mysqli_fetch_array($total_loan_req);

            $total_with_req = $conn->query("SELECT COUNT(id) as kk FROM withdrawal_list where acc_no = '$acc_no' ");
            $get_with_total_req = mysqli_fetch_array($total_with_req);


            $ccc = "SELECT COUNT(*) as kkk, SUM(amount) AS sss FROM withdrawal_list WHERE acc_no = '$acc_no' AND req_status = 0";
            $zzz = $conn->query($ccc);
            $b=mysqli_fetch_array($zzz);
            $total_w =  $b["kkk"];
            $total_w_balance =  $b["sss"];

        ?>

    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title>Client List - DKBSSL</title>
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
                                <a class="nav-link" href="" onclick="print_content('data')" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <i class="fa fa-print fa-lg"></i>
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
    <li class="breadcrumb-item"><a href="index">Client Information</a></li>
    <li class="breadcrumb-item active" aria-current="page"><?php echo $info['name'];?></li>
  </ol>
</nav>

                <div class="container-fluid">
                    <div id="data">
                        <!-- header start  -->

                    <table style="color:#257590;" width="100%" cellspacing="0" cellpadding="0">

<tbody>
    <tr>
        <td width="25%">
            <table width="100%;" cellspacing="0" cellpadding="0">
                <tbody>
                    <tr>
                        <td>&nbsp;</td>
                        <td style="text-align: right;color:#696957; font-size: 11px;"> </td>
                    </tr>
                </tbody>
            </table>
        </td>
        <td style="text-align:center;color:#3B93C9;" width="50%">
        <div style="font-size:15px;">
            গণপ্রজাতন্ত্রী বাংলাদেশ সরকার অনুমোদিত
            </div>
        <img src="../../image/logo.png" height="70">
            <div style="font-size:25px;"><b>দুরন্ত ক্ষুদ্র ব্যবসায়ী সমবায় সমিতি লিঃ </b></div>
            <span style="color:#0F82C8;font-weight: bold;"> রেজি নংঃ :</span>&nbsp; (৩৯) ২৯/১২/২০১৬ইং  </div>
            <div style="font-size:14x; ">হাড়িপুকুর বাঘেরহাট, গড়েয়া, ঠাকুরগাঁও - ৫১০০ ।</div>
            <br>
        </td>
        <td style="vertical-align: top; text-align:right; font-size: 13px;font-family: 'Times New Roman';" width="24%">

        </td>
    </tr>

</tbody>
</table>
<!-- header end  -->
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
							<td style="padding:1px 14px 1px 14px;border-bottom:1px solid #4d99b3;border-right:1px solid #4d99b3;text-align: center; padding: 2px;"> Age</td>
                            <td style="padding:1px 14px 1px 14px;border-bottom:1px solid #4d99b3;border-right:1px solid #4d99b3;text-align: center;">Gender</td>
                            <td style="padding:1px 14px 1px 14px;border-bottom:1px solid #4d99b3;text-align: center;">Occupation</td>
                            <td style="padding:1px 14px 1px 14px;border-bottom:1px solid #4d99b3;border-right:1px solid #4d99b3;text-align: center;">Status</td>

							
						</tr>
						
						<tr>
							<td style="text-align: center; padding: 2px;color:#696957;"><?php echo $info['age'] ?></td>
							<td style="text-align: center;color:#696957;"><?php echo $info['gender'] ?></td>
							<td style="text-align: center;color:#696957;"><?php echo $info['occupation'] ?></td>
							<td style="text-align: center;color:#696957;"><?php if($info['client_status'] == 1){echo "<i class='fas fa-check' style='color:green;'></i>";}else{echo"<i class='fas fa-times' style='color:red;'></i>";} ?></td>
						
						</tr>
						<tr>
							<td style="padding:1px 5px 1px 5px;border:1px solid #4d99b3;border-left:0px; text-align: center;padding: 2px;"> Join Date</td>
							<td style="padding:1px 5px 1px 5px;border:1px solid #4d99b3;border-left:0px;text-align: center;">Account Type</td>
							<td style="padding:1px 5px 1px 5px;border:1px solid #4d99b3;border-left:0px;text-align: center;">Savings Amount</td>
							<td style="padding:1px 5px 1px 5px;border:1px solid #4d99b3;border-left:0px;border-right: 0px;text-align: center;">Reg: Book Page</td>
							
						</tr>
						
						<tr>
							<td style="text-align: center;padding: 2px;color:#696957;"> <?php echo $info['join_date'] ?></td>
							<td style="text-align: center;color:#696957;"><?php echo $info['acc_type'] ?></td>
							<td style="text-align: center;color:#696957;"><?php echo $info['a_o_s'] ?>৳</td>
							<td style="text-align: center;color:#696957;"><?php echo $info['note_book_page'] ?></td>
						</tr>
						<tr>
							<td style="background:#cceeff;padding:1px 5px 1px 5px;border:1px solid #4d99b3;border-left:0px;text-align: center;padding: 2px;"> Total Deposit</td>
                            <td style="padding:1px 5px 1px 5px;border:1px solid #4d99b3;border-left:0px;text-align: center;" colspan="1">Total Withdrawal</td>
							<td style="padding:1px 5px 1px 5px;border:1px solid #4d99b3;border-left:0px;text-align: center;" >Total Loan</td>
                        
							<td style="padding:1px 5px 1px 5px;border:1px solid #4d99b3;border-left:0px;border-right: 0px;text-align: center; background-color: #ffcccc;">Balance</td>
							
						</tr>
						
						<tr>
							<td style="text-align: center;padding: 2px;color:#696957;"><?php echo $total_deposit_time ?> times</td>
                            <td colspan="1" style="text-align: center;color:#696957;"><?php echo $total_w_balance; echo"৳/"; echo $total_w; echo " times"; ?></td>
							<td  style="text-align: center;color:#696957;"><?php echo $total_loan_balance; echo"৳/"; echo $total_loan; echo " times"; ?></td>
							<td style="font-size:20px;text-align: center;color:#696957;"><div class=""><?php echo $info['total_saving'] ?>৳</div></td>
						
						</tr>
					
					</tbody></table>
				</td>
		</tr>
	</tbody>
    </table> <br>
    <table style="padding-right:500px;border:1px solid #4d99b3;color:#257590;width:100%;font-size:15px;" cellspacing="0" cellpadding="0">
		<tbody><tr>
			<td style="background-color:#CCEEFF;padding-left:5px;padding-right:5px;width: 16%;vertical-align:top;">
					Total Withdrawal Req:<br>
			</td>
			<td style="padding-left:45px;padding-right:10px;border-left: 1px solid #4d99b3;color:#696957; vertical-align:top;">
				
					
					<?php echo $get_with_total_req['kk'];?> Times
			</td>
			<td style="background-color:#CCEEFF;padding-left:5px;padding-right:5px;border-left: 1px solid #4d99b3; vertical-align:top; ">
				
					
					Total Loan Request:
				
			</td>
			<td style="border-left: 1px solid #4d99b3;color:#696957;vertical-align: top;padding-left:45px;">
				
					<span style="width:60%;display: inline-block;text-align: right;padding-right: 10px;">
                    <?php echo $get_loan_total_req['kk'];?> Times
					</span>
				
				
				
			</td>
			<td style="background-color:#CCEEFF;padding-left:5px;padding-right:5px;border-left: 1px solid #4d99b3; border-right:1px solid #4d99b3; vertical-align: top;">
				Loan Status:
			</td>
			<td style="padding-left:10px;padding-right:10px;width: 15%;vertical-align: top;color:#696957; text-align: center;font-size:15px;">
				<?php if($info['loan_running'] == 1){echo "<font color='red'>1 Running</font>";}else{echo"<font color='green'>All Paid</font>";}?>
			</td>
		</tr>
	</tbody></table><br>
    <div class="row">

    <div class="col-xl-6 col-md-6 mb-4">

    <h5>Last 10 Installment</h5>

    <table class="table table-sm table-bordered table-striped">
                            <thead >
                                <tr align="center">
                                    <th >Installment No</th>
                                    <th >Date</th>
                                    <th >Amount</th>
                                    <th >Due</th>
                                </tr>
                            </thead>
                            <tbody>

                                <?php 

                                $x = "SELECT * FROM loan_list where acc_no = '$acc_no' and active = 1";
                                $xx = $conn->query($x);
                                $xxx=mysqli_fetch_array($xx);

                                $loan_no = $xxx['loan_no'];   

            $query = "SELECT * FROM installment_deposit WHERE loan_no = '$loan_no' ORDER BY id DESC LIMIT 0,10";

            $sql = "SELECT COUNT(*) as k FROM installment_deposit where loan_no = '$loan_no'";
            $sth = $conn->query($sql);
            $count=mysqli_fetch_array($sth);
            $k = $count["k"]+1;


                if ($result = $conn->query($query)) {
                    while ($row = $result->fetch_assoc()) {

                        $k--;

                        $date = $row["date"];
                        $amount = $row["amount"];
                        $due = $row["due"];
              
                        echo '
                        <td align="center">'.$k.'</td>
                        <td align="center">'.$date.'</td>
                        <td align="center">'.$amount.'৳</td>
                        <td align="center">'.$due.'৳</td>
                      </tr>';
                      echo '';
                    }
                    $result->free();
                } 

                ?>
                            </tbody>
                        </table>

    
    
    </div>

    <div class="col-xl-6 col-md-6 mb-4">
    <h5>Last 10 Savings Deposit</h5>
    
    <table class="table table-sm table-bordered table-striped">
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

            $query = "SELECT acc_no,date,amount,total_saving FROM saving_deposit WHERE acc_no = '$acc_no' ORDER BY id DESC LIMIT 0,10";

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
    </div> </div>
    


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

        $('#list').dataTable();
    </script>

    </html>