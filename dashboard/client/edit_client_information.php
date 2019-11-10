<?php 
                   include_once('../../includes/config.php');
                   session_start();  
                    if(!isset($_SESSION["username"]))  
                    {  
                         header('location: ../../../index.php?error');  
                    }  

                    $url = $_SERVER['REQUEST_URI'];
                    $urlarray=explode("=",$url);
                    $acc_no=$urlarray[count($urlarray)-1];

                    // checking client is exist
                    $query = mysqli_query($conn, "SELECT  * FROM client WHERE acc_no = '$acc_no'");
                            if(mysqli_num_rows($query) > 0){
                                $sql = "SELECT * FROM client WHERE acc_no = '$acc_no'";
                                $sth = $conn->query($sql);
                                $result=mysqli_fetch_array($sth);
                                $title = $result['name'];
                                $old_profile = $result['client_photo'];
                                $loan_status =  $result['loan_running'];
                            }else{
                               header('location: index.php?acc_not_found');
                            }

        if (isset($_POST["update"])) {
            $new_client_photo;

            if($_FILES['photo']['size'] != 0){
                $old_photo_path = "../../image/client_photo/$old_profile";
                $temp = explode(".", $_FILES["photo"]["name"]);
                $newfilename = round(microtime(true)) . '.' . end($temp);
                $img_path = "../../image/client_photo/$newfilename";
                if(move_uploaded_file($_FILES["photo"]["tmp_name"], $img_path)) 
                {
                    $new_client_photo = $newfilename;

                    if($old_profile != "no_img.png"){
                        if(file_exists($old_photo_path) == true){
                            unlink($old_photo_path);
                        }
                    }
                }   
            }else{
                $new_client_photo = $old_profile;
            }
            $name   = $_POST["name"];

            $total_saving = $_POST['total_saving'];

            $father_or_husband_name =  $_POST["f_or_h"];
            $mother_name = $_POST["mother_name"];
        
            $gender      = $_POST["gender"];
            $age         = $_POST["age"];
        
            $bcn_or_nid_type = $_POST["nid_or_bcn"];
        
            $phone = $_POST["phone"];
            $loan_running = $_POST["loan_running"];
            
            $permanent_address = $_POST["permanent_address"];
            $present_address   = $_POST["present_address"];
        
            $occupation = $_POST["occupation"];
        
            $nomini_name     = $_POST["nomini_name"];
            $nomini_relation = $_POST["nomini_relation"];
        
            $account_type   = $_POST["acc_type"];
            $note_book_page = $_POST["note_book_page"];
            $remark         =  $_POST["remark"];
            $join_date      = $_POST["join_date"];
            $a_o_s      = $_POST["a_o_s"];
            $account_status = $_POST["status"];
        
            $sql = "UPDATE client SET 
        
            name = '$name',
            client_status = '$account_status',
            age = '$age',
            gender = '$gender',
            mother_name = '$mother_name',
            father_or_husband_name = '$father_or_husband_name',
            bcn_or_nid_no	= '$bcn_or_nid_type',
            phone = '$phone',
            permanent_address = '$permanent_address',
            present_address = '$present_address',
            occupation = '$occupation',
            nomini_name = '$nomini_name',
            nomini_relation = '$nomini_relation',
            acc_type = '$account_type',
            note_book_page = '$note_book_page',
            note_book_page= '$note_book_page',
            remark = '$remark',
            join_date = '$join_date',
            total_saving = '$total_saving',
            a_o_s = '$a_o_s',
            client_photo = '$new_client_photo',
            loan_running = '$loan_running'
            WHERE acc_no='$acc_no'";
        
        if ($conn->query($sql) === TRUE) {
          header("location: edit_client_information.php?update_success?acc_no=".$acc_no);
        } else {
        //   header("location: edit_client_information.php?error?acc_no=".$acc_no);
          echo "Error updating record: " . $conn->error;
        
        }
        
        
        
        
   }
        ?>
    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title>Edit -
            <?php echo $title ?> - DKBSS
        </title>
        <link rel="shortcut icon" href="../../image/favicon.png" />
        <link href="../../css/bootstrap.css" rel="stylesheet">
        <link href="../../css/fontawesome.css" rel="stylesheet">
        <script src="../../js/sweetalert.js"></script>
        <link rel="stylesheet" href="../../css/style.css">
        <link rel="stylesheet" href="../../css/sweetalert.css">
        <style>
        .amount:focus {
            background-color: #ffcccc;
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
    <li class="breadcrumb-item"><a href="index">Check Client</a></li>
    <li class="breadcrumb-item active" aria-current="page">Edit <b><?php echo $result['name'];?> </b>Information</li>
  </ol>
</nav>
                <div class="container-fluid">
                    <div class="row flex-lg-nowrap">
                        <div class="col">
                            <div class="row">
                                <div class="col mb-3">
                                    <div class="card">
                                        <div class="card-body">
                                            <div class="e-profile">
                                                <div class="profile_pic_edit">
                                                    <form class="form" enctype="multipart/form-data" method="post">
                                                        <center>
                                                        <img id="profileImage" alt="<?php echo $result['name'];?>" class="circle_view" src="../../image/client_photo/<?php echo $old_profile;?>">
                                                        <input type="file" name="photo" id="imageUpload" accept="image/gif, image/jpeg, image/png, image/jpg" onchange="document.getElementById('profileImage').src = window.URL.createObjectURL(this.files[0])" hidden>
                                                        </center>
                                                </div>
                                            </div>
                                            <div class="tab-content pt-3">
                                                <div class="tab-pane active">
                                                    <div class="row">
                                                        <div class="col">
                                                            <div class="row">
                                                                <div class="col">

                                                                    <div class="form-group">
                                                                        <label>Full Name</label>
                                                                        <input class="form-control" type="text" name="name" placeholder="<?php echo $result['name'];?>" value="<?php echo $result['name'];?>" required autofocus>
                                                                    </div>
                                                                </div>

                                                                <div class="col">
                                                                    <div class="form-group">
                                                                        <label>Phone</label>
                                                                        <input class="form-control" type="tel" name="phone" placeholder="0<?php echo $result['phone'];?>" value="0<?php echo $result['phone'];?>"  maxlength="11" maxlength="11" required autofocus>
                                                                    </div>
                                                                </div>

                                                                <div class="col">
                                                                    <div class="form-group">
                                                                        <label>Age</label>
                                                                        <input class="form-control" type="text" name="age" placeholder="<?php echo $result['age'];?>" value="<?php echo $result['age'];?>" maxlength="2" min="16" required autofocus>
                                                                    </div>
                                                                </div>
                                                                <div class="col">
                                                                    <div class="form-group">
                                                                        <label>Total Savings</label>
                                                                        <input class="form-control amount" type="number" name="total_saving" placeholder="<?php echo $result['total_saving'];?>" value="<?php echo $result['total_saving'];?>" min="0" required autofocus>
                                                                   
                                                                    </div>
                                                                </div>

                                                            </div>

                                                            <div class="row">
                                                                <div class="col">
                                                                    <div class="form-group">
                                                                        <label>Present Address</label>
                                                                        <input class="form-control" name="present_address" type="text" value="<?php echo $result['present_address'];?>" placeholder="<?php echo $result['present_address'];?>" required autofocus>
                                                                    </div>
                                                                </div>

                                                                <div class="col">
                                                                    <div class="form-group">
                                                                        <label>Permanent Address</label>
                                                                        <input class="form-control" name="permanent_address" type="text" value="<?php echo $result['permanent_address'];?>" placeholder="<?php echo $result['permanent_address'];?>" required autofocus>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <div class="row">
                                                                <div class="col">
                                                                    <div class="form-group">
                                                                        <label>NID or BCN</label>
                                                                        <input class="form-control" name="nid_or_bcn" type="text" value="<?php echo $result['bcn_or_nid_no'];?>" placeholder="<?php echo $result['bcn_or_nid_no'];?>" required autofocus>
                                                                    </div>
                                                                </div>

                                                                <div class="col">
                                                                    <div class="form-group">
                                                                        <label>Occupation</label>
                                                                        <div class="form-contorl">
                                                                            <select name="occupation" class="custom-select" style="max-width: 160px;" required autofocus>
                                                                                <option value="Unemployed" <?php if($result[ 'occupation']=='Unemployed' ){ echo 'selected=""'; }?>>Unemployed</option>
                                                                                <option value="Farmer" <?php if($result[ 'occupation']=="Farmer" ){ echo 'selected=""'; }?>> Farmer </option>
                                                                                <option value="Day Laborer" <?php if($result[ 'occupation']=="Day Laborer" ){ echo 'selected=""'; }?>> Day Laborer </option>
                                                                                <option value="Student" <?php if($result[ 'occupation']=='Student' ){ echo 'selected=""'; }?>>Student</option>
                                                                                <option value="Shopkeeper" <?php if($result[ 'occupation']=='Shopkeeper' ){ echo 'selected=""'; }?>>Shopkeeper</option>
                                                                                <option value="Businessman" <?php if($result[ 'occupation']=='Businessman' ){ echo 'selected=""'; }?>>Businessman</option>
                                                                                <option value="Others" <?php if($result[ 'occupation']=='Others' ){ echo 'selected=""'; }?>>Others</option>

                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                                <div class="col">
                                                                    <div class="form-group">
                                                                        <label>Account Type</label>
                                                                        <div class="form-contorl">
                                                                            <select name="acc_type" class="custom-select" style="max-width: 160px;" required autofocus>
                                                                                <option value="Daily" <?php if($result[ 'acc_type']=="Daily" ){ echo 'selected=""'; }?>> Daily </option>

                                                                                <option value="Monthly" <?php if($result[ 'acc_type']=='Monthly' ){ echo 'selected=""'; }?>>Monthly</option>

                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                                <div class="col">
                                                                    <div class="form-group">
                                                                        <label>Amount of Savings</label>
                                                                        <input class="form-control" name="a_o_s" type="number" value="<?php echo $result['a_o_s'];?>" placeholder="<?php echo $result['a_o_s'];?>" min="1" required autofocus>
                                                                    </div>
                                                                </div>

                                                            </div>

                                                            <div class="row">

                                                                <div class="col">
                                                                    <div class="form-group">
                                                                        <label>Father or Husband Name</label>
                                                                        <input class="form-control" name="f_or_h" type="text" value="<?php echo $result['father_or_husband_name'];?>" placeholder="<?php echo $result['father_or_husband_name'];?>" required autofocus>
                                                                    </div>
                                                                </div>

                                                                <div class="col">
                                                                    <div class="form-group">
                                                                        <label>Mother Name</label>
                                                                        <input class="form-control" name="mother_name" type="text" value="<?php echo $result['mother_name'];?>" placeholder="<?php echo $result['mother_name'];?>" required autofocus>
                                                                    </div>
                                                                </div>

                                                                <div class="col">
                                                                    <div class="form-group">
                                                                        <label>Nomini Name</label>
                                                                        <input class="form-control" name="nomini_name" type="text" value="<?php echo $result['nomini_name'];?>" placeholder="<?php echo $result['nomini_name'];?>" required autofocus>
                                                                    </div>
                                                                </div>

                                                                <div class="col">
                                                                    <div class="form-group">
                                                                        <label>Nomini Relation</label>
                                                                        <div class="form-contorl">
                                                                            <select name="nomini_relation" class="custom-select" style="max-width: 160px;" required autofocus>
                                                                                <option value="Mother" <?php if($result[ 'nomini_relation']=='Mother' ){ echo 'selected=""'; }?>>Mother</option>
                                                                                <option value="Father" <?php if($result[ 'nomini_relation']=='Father' ){ echo 'selected=""'; }?>>Father</option>
                                                                                <option value="Sister" <?php if($result[ 'nomini_relation']=="Sister" ){ echo 'selected=""'; }?>> Sister </option>

                                                                                <option value="Brother" <?php if($result[ 'nomini_relation']=='Brother' ){ echo 'selected=""'; }?>>Brother</option>
                                                                                <option value="Daughter" <?php if($result[ 'nomini_relation']=='Daughter' ){ echo 'selected=""'; }?>>Daughter</option>
                                                                                <option value="Son" <?php if($result[ 'nomini_relation']=='Son' ){ echo 'selected=""'; }?>>Son</option>
                                                                                <option value="Other" <?php if($result[ 'nomini_relation']=='Other' ){ echo 'selected=""'; }?>>Other</option>

                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                            </div>

                                                            <div class="row">

                                                                <div class="col">
                                                                    <div class="form-group">
                                                                        <label>Account Type</label>
                                                                        <div class="form-contorl">
                                                                            <select name="gender" class="custom-select" style="max-width: 160px;" required autofocus>
                                                                                <option value="Male" <?php if($result[ 'gender']=="Male" ){ echo 'selected=""'; }?>> Male </option>

                                                                                <option value="Female" <?php if($result[ 'gender']=='Female' ){ echo 'selected=""'; }?>>Female</option>
                                                                                <option value="Other" <?php if($result[ 'gender']=='Other' ){ echo 'selected=""'; }?>>Other</option>

                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                                <div class="col">
                                                                    <div class="form-group">
                                                                        <label>Join Date</label>
                                                                        <input class="form-control" name="join_date" type="date" value="<?php echo $result['join_date'];?>" placeholder="<?php echo $result['bcn_or_nid_no'];?>" required autofocus>
                                                                    </div>
                                                                </div>

                                                                <div class="col">
                                                                    <div class="form-group">
                                                                        <label>Remark</label>
                                                                        <div class="form-contorl">
                                                                            <select name="remark" class="custom-select" style="max-width: 160px;" required autofocus>
                                                                                <option value="Good" <?php if($result[ 'remark']=="Good" ){ echo 'selected=""'; }?>>Good</option>

                                                                                <option value="Bad" <?php if($result[ 'remark']=="Bad" ){ echo 'selected=""'; }?>>Bad</option>

                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                                <div class="col">
                                                                    <div class="form-group">
                                                                        <label>Reg Book Info</label>
                                                                        <input class="form-control" name="note_book_page" type="text" value="<?php echo $result['note_book_page'];?>" placeholder="<?php echo $result['note_book_page'];?>">
                                                                    </div>
                                                                </div>

                                                            </div>

                                                            <div class="row">
                                                               
                                                                <div class="col">
                                                                    <div class="form-group">
                                                                        <label>Client Status</label>
                                                                            <?php if($result['client_status'] == 1){echo "<span class='badge badge-success'>Active</span></i>";}else{echo "<span class='badge badge-danger'>Deactive</span>";}?></label>
                                                                        <div class="form-contorl">
                                                                            <select name="status" class="custom-select" style="max-width: 160px;" required autofocus>
                                                                                <option value="1" <?php if($result[ 'client_status']==1 ){ echo 'selected=""'; }?>><span>&#10003;</span> Active Now </option>

                                                                                <option value="0" <?php if($result[ 'client_status']==0 ){ echo 'selected=""'; }?>>✘ Deavtive Now</option>

                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col">
                                                                    <div class="form-group">
                                                                        <label>Loan Status</label>
                                                                            <?php if($result['loan_running'] == 1){echo "<span class='badge badge-success'>Loan Running</span></i>";}else{echo "<span class='badge badge-danger'>Not Running</span>";}?></label>
                                                                        <div class="form-contorl">
                                                                            <select name="loan_running" class="custom-select" style="max-width: 160px;" required autofocus>
                                                                                <option value="1" <?php if($result['loan_running']== 1 ){ echo 'selected=""'; }?>> Added </option>

                                                                                <option value="0" <?php if($result[ 'loan_running']== 0 ){ echo 'selected=""'; }?>>Removed</option>

                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            
                                                            </div>

                                                            <div class="col d-flex justify-content-end">
                                                                <input class="btn btn-primary" value="Update" type="submit" name="update">
                                                            </div>
                                                            </form>

                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
    </body>
    <script src="../../js/jquery.js"></script>
    <script src="../../js/bootstrap.js"></script>
    <script src="../../js/fontawesome.js"></script>
    <script>
        $("#menu-toggle").click(function(e) {
            e.preventDefault();
            $("#wrapper").toggleClass("toggled");
        });
        $("#profileImage").click(function(e) {
            $("#imageUpload").click();

        });

        var url = window.location.toString();
        if (url.includes("update_success")) {
            swal("Update Successfully", "", "success");

        }
        if (url.includes("error")) {
            swal("Update Failed", "", "error");

        }

        if (url.includes("new_client")) {
            swal({
                title: "Client Added Successfully. You can edit client information on this page.",
            });

        }
    </script>

    </html>