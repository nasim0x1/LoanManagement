<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Add New Client - DKBSSL</title>
    <link rel="shortcut icon" href="../../image/favicon.png" />
    <link href="../../css/bootstrap.css" rel="stylesheet">
    <link href="../../css/fontawesome.css" rel="stylesheet">
    <script src="../../js/sweetalert.js"></script>
    <link rel="stylesheet" href="../../css/style.css">
    <link rel="stylesheet" href="../../css/sweetalert.css">
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
    <li class="breadcrumb-item active" aria-current="page">Add New Client</li>
  </ol>
</nav>

            <div id="content" class="container-fluid ">
                <?php
                include_once('../../includes/config.php');
                session_start();
                if (!isset($_SESSION["username"])) {
                    header("location:../../../index.php?error");
            }
                    // getting capitl value 
                    $query = "SELECT `capital` FROM `information` WHERE id=1";
                    $result = $conn->query($query);
                    $row = $result->fetch_assoc();
                    $capital =  $row["capital"];

if (isset($_POST["create"])) {

    $acc_id = $_POST["acc_no"];
    $name   = $_POST["client_name"];

    $father_or_husband_name = "" . $_POST["g_name"] . "(" . $_POST["f_or_h"] . ")";
    $mother_name            = $_POST["mother_name"];

    $gender      = $_POST["gender"];
    $age         = $_POST["age"];
    $nationality = $_POST["nationality"];

    $bcn_or_nid_type = $_POST["nid_or_bcn_type"];
    $bcn_or_nid      = "(" . $bcn_or_nid_type . ") " . $_POST["bcn_or_nid"] . "";

    $phone = $_POST["phone"];

    $districk          = $_POST["district"];
    $union             = $_POST["union"];
    $permanent_address = "" . $_POST["permanent_address"] . ", " . $union . ", " . $districk . "";
    $present_address   = $_POST["present_address"];

    $occupation = $_POST["occupation"];

    $nomini_name     = $_POST["nomini_name"];
    $nomini_relation = $_POST["nomini_relation"];

    $account_type   = $_POST["acc_type"];
    $note_book_page = $_POST["reg_page"];
    $remark         = "Good";
    $join_date      = $_POST["join_date"];
    $a_o_s      = $_POST["a_o_s"];

    $client_photo = 'no_img.png';

    $sql = "insert INTO client ( 
         acc_no,
         name,
         father_or_husband_name,
         mother_name,
         gender,
         age,
         nationality,
         bcn_or_nid_no,
         phone,
         present_address,
         permanent_address,
         occupation,
         nomini_name,
         nomini_relation,
         acc_type,
         client_photo,
         note_book_page,
         remark,
         join_date,
         client_status,
         total_saving,
         a_o_s,
         loan_running,
         s_w_r_n
         )
     VALUES (
         '$acc_id',
         '$name',
         '$father_or_husband_name',
         '$mother_name',
         '$gender',
         '$age',
         '$nationality',
         '$bcn_or_nid',
         '$phone',        
         '$present_address',
         '$permanent_address',
         '$occupation',
         '$nomini_name',
         '$nomini_relation',
         '$account_type',
         '$client_photo',
         '$note_book_page',
         '$remark',
         '$join_date',
         0,
         0,
         '$a_o_s',
         0,
         0)";

    if ($conn->query($sql) === TRUE) {

        // update capital with fee
        $new_capital = $capital + 30; 
        $update_capital = "UPDATE information SET capital='$new_capital' WHERE id=1";
        // mysqli_query($conn, $sql);

        if ($conn->query($update_capital) === TRUE) {
                // addting daily history
                $dailt_history = "INSERT INTO daily_history (
                     in_,
                     out_,
                     date,
                     description)
                VALUES (
                    30,
                    0,
                    '$join_date',
                    'Opening account and book fee(".$name.")')";
                    if ($conn->query($dailt_history) === TRUE) {
                        echo"<script>console.log('added in daily history');</script>";
                        }
            }        
        header("location: ../client/edit_client_information?new_client?acc=" . $acc_id);
    } else {
        if (mysqli_errno($conn) == 1062) {
            header("location: add_client.php?already_have_acc_no=" . $acc_id);

        } else {
            header("location: add_client.php?something_worng");
        }
    }

    $conn->close();
}

?>
                    <article class="card-body mx-auto" style="max-width: 840px;">
                        <h3>Add New Client</h3>
                        <form class="form-signin" method="post">
                            <div class="form-group input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"> <i class="fa fa-user"></i> </span>
                                </div>
                                <input name="client_name" class="form-control" placeholder="Full Name" type="text" required autofocus>
                            </div>

                            <div class="form-group input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"> <i class="fa fa-user-tie"></i> </span>
                                </div>
                                <select name="f_or_h" class="custom-select" required autofocus>
                                    <option value="F" selected="F">Father's </option>
                                    <option value="H">Husband's</option>
                                </select>
                                <input name="g_name" class="form-control" placeholder="Full Name" type="text" required autofocus>
                            </div>

                            <div class="form-group input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"> <i class="fas fa-female"></i> </span>
                                </div>
                                <input name="mother_name" class="form-control" placeholder="Mother`s Full Name" type="text" required autofocus>
                            </div>

                            <div class="form-group input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"> <i class="fa fa-venus-mars"></i> </span>
                                </div>
                                <select name="gender" class="custom-select" required autofocus>
                                    <option value="" selected="">Gender</option>
                                    <option value="Male">Male</option>
                                    <option value="Female">Female</option>
                                    <option value="Other">Others</option>
                                </select>

                                <div class="input-group-prepend">
                                    <span class="input-group-text"> <i class="fa fa-info"></i> </span>
                                </div>
                                <select name="age" class="form-control" required autofocus style="max-width: 200px;">
                                    <option value="" selected="">Age</option>
                                    <option value="17">17</option>
                                    <option value="18">18</option>
                                    <option value="19">19</option>
                                    <option value="20">20</option>
                                    <option value="21">21</option>
                                    <option value="22">22</option>
                                    <option value="23">23</option>
                                    <option value="24">24</option>
                                    <option value="25">25</option>
                                    <option value="26">26</option>
                                    <option value="27">27</option>
                                    <option value="28">28</option>
                                    <option value="29">29</option>
                                    <option value="30">30</option>
                                    <option value="31">31</option>
                                    <option value="32">32</option>
                                    <option value="33">33</option>
                                    <option value="34">34</option>
                                    <option value="35">35</option>
                                    <option value="36">36</option>
                                    <option value="37">37</option>
                                    <option value="38">38</option>
                                    <option value="39">39</option>
                                    <option value="40">40</option>
                                    <option value="41">41</option>
                                    <option value="42">42</option>
                                    <option value="43">43</option>
                                    <option value="44">44</option>
                                    <option value="45">45</option>
                                    <option value="46">46</option>
                                    <option value="47">47</option>
                                    <option value="48">48</option>
                                    <option value="49">49</option>
                                    <option value="50">50</option>
                                    <option value="51">51</option>
                                    <option value="52">52</option>
                                    <option value="53">53</option>
                                    <option value="54">54</option>
                                    <option value="55">55</option>
                                    <option value="56">56</option>
                                    <option value="57">57</option>
                                    <option value="58">58</option>
                                    <option value="59">59</option>
                                    <option value="60">60</option>
                                    <option value="61">61</option>
                                    <option value="62">62</option>
                                    <option value="63">63</option>
                                    <option value="64">64</option>
                                    <option value="65">65</option>
                                    <option value="66">66</option>
                                    <option value="67">67</option>
                                    <option value="68">68</option>
                                    <option value="69">69</option>
                                    <option value="70">70</option>
                                    <option value="71">71</option>
                                    <option value="72">72</option>
                                    <option value="73">73</option>
                                    <option value="74">74</option>
                                    <option value="75">75</option>
                                    <option value="76">76</option>
                                    <option value="77">77</option>
                                    <option value="78">78</option>
                                    <option value="79">79</option>
                                    <option value="80">80</option>
                                    <option value="81">81</option>
                                    <option value="82">82</option>
                                    <option value="83">83</option>
                                    <option value="84">84</option>
                                    <option value="85">85</option>
                                    <option value="86">86</option>
                                </select>

                                <div class="input-group-prepend">
                                    <span class="input-group-text"> <i class="fa fa-flag"></i> </span>
                                </div>
                                <select name="nationality" class="custom-select" style="max-width: 200px;">
                                    <option value="Bangladeshi" selected="Bangladeshi"> Bangladeshi </option>
                                </select>

                            </div>

                            <div class="form-group input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"> <i class="fa fa-id-card"></i> </span>
                                </div>
                                <select name="nid_or_bcn_type" class="custom-select" style="max-width: 160px;" required autofocus>
                                    <option value="NID" selected="NID">National ID</option>
                                    <option value="BCN">Birth Certificate </option>
                                </select>
                                <input name="bcn_or_nid" class="form-control" placeholder="Number" type="number" required autofocus>
                            </div>

                            <div class="form-group input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"> <i class="fa fa-phone"></i> </span>
                                </div>
                                <input name="phone" class="form-control" placeholder="Phone" type="number" minlength="11"  maxlength="11" required autofocus>
                            </div>

                            <div class="form-group input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"> <i class="fa fa-map-marker"></i> </span>
                                </div>
                                <input name="permanent_address" class="form-control" placeholder="Permanent Address" type="address" required autofocus>
                                <select name="union" class="form-control" style="max-width: 180px;" required autofocus>
                                    <option value="" selected=""> Select Union</option>
                                    <option value="06 no Auliapur"> 06 No Auliapur</option>
                                    <option value="12 no Salandor"> 12 No Salandor</option>
                                    <option value="13 no Goreya">13 No Goreya</option>
                                    <option value="17 no Jagannathpur">17 No Jagannathpur</option>
                                    <option value="18 no Shukhanpukhuri">18 No Shukhanpukhuri</option>
                                </select>
                                <select name="district" class="form-control" style="max-width: 180px;" required autofocus>
                                    <option value="Thakurgaon" selected=""> Thakurgaon</option>
                                </select>
                            </div>

                            <div class="form-group input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"> <i class="fa fa-map-marker-alt"></i> </span>
                                </div>
                                <input name="present_address" class="form-control" placeholder="Present Address" type="address" required autofocus>
                            </div>

                            <div class="form-group input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"> <i class="fa fa-building"></i> </span>
                                </div>
                                <select name="occupation" class="form-control" required autofocus>
                                    <option value="" selected=""> Select Occupation</option>
                                    <option value="Unemployed">Unemployed</option>
                                    <option value="Farmer">Farmer</option>
                                    <option value="Day Laborer">Day Laborer</option>
                                    <option value="Student">Student</option>
                                    <option value="Shopkeeper">Shopkeeper</option>
                                    <option value="Businessman">Businessman</option>
                                    <option value="Others">Others</option>
                                </select>

                                <div class="input-group-prepend">
                                    <span class="input-group-text"> <i class="fa fa-file-invoice-dollar"></i> </span>
                                </div>
                                <select name="acc_type" class="form-control" required autofocus>
                                    <option value="" selected="">Account Type</option>
                                    <option value="Daily">Daily</option>
                                    <option value="Monthly">Monthly</option>
                                </select>

                            </div>

                            <div class="form-group input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"> <i class="fa fa-user"></i> </span>
                                </div>
                                <input name="nomini_name" class="form-control" placeholder="Account Nomini Name" type="text" required autofocus>

                                <select name="nomini_relation" class="custom-select" style="max-width: 160px;">
                                    <option selected="">Relation</option>
                                    <option value="Father">Father </option>
                                    <option value="Mother">Mother </option>
                                    <option value="Brother">Brother </option>
                                    <option value="Sister">Sister </option>
                                    <option value="Daughter">Daughter </option>
                                    <option value="Son">Son </option>
                                    <option value="Other">Other </option>

                                </select>
                            </div>

                            <div class="form-group input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"> <i class="fa fa-lock"></i> </span>
                                </div>

                                <?php
                                    $sql = "SELECT * FROM client ORDER BY acc_no DESC LIMIT 0,1";
                                    $sth = $conn->query($sql);
                                    $result=mysqli_fetch_array($sth);?>

                                    <font class="form-control" style="max-width: 160px;">Account No:</font>
                                    <input name="acc_no" class="form-control" placeholder="Account Number" value="<?php $acc = $result['acc_no']+1; echo $acc;?>" type="number" required autofocus>
                            </div>
                            <small class="form-text text-muted">Last added account number :                                  
                                <font color="green"><b>
                                    <?php echo $result["acc_no"];?> ( <?php echo $result["name"];?> ) </b></font></small>
                            <br>

                            <div class="form-group input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"> <i class="fa fa-calendar-alt"></i> </span>
                                </div>

                                <font class="form-control" style="max-width: 160px;">Join Date:</font>

                                <input type="date" name="join_date" class="form-control" required autofocus>
                            </div>

                            <div class="form-group input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"> <i class="fa fa-book-sort-amount-down-alt "></i> </span>
                                </div>
                                <font class="form-control" style="max-width: 200px;">Amount of Savings:</font>
                                <input name="a_o_s" class="form-control" value="10" placeholder="Amount of Savings" type="number" required autofocus>
                            </div>

                            <div class="form-group input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"> <i class="fa fa-book-open "></i> </span>
                                </div>
                                <input name="reg_page" class="form-control" placeholder="Register Book & Page Number" type="text">
                            </div>
                            <center>

                                <p style="font-weight: bold;color:red">Note : Please take account opening & book fee.It will automatically add on capital</p>

                                <input type="submit" name="create" value="Add Client Account" class="btn btn-primary" />
                            </center>
                        </form>
                    </article>

            </div>
        </div>
        <!-- /#page-content-wrapper -->
    </div>
</body>
<script src="../../js/jquery.js"></script>
<script src="../../js/bootstrap.js"></script>
<script src="../../js/fontawesome.js"></script>
<script>
    window.onload = function() {

        $("#menu-toggle").click(function(e) {
            e.preventDefault();
            $("#wrapper").toggleClass("toggled");
        });

        var url = window.location.toString();
        if (url.includes("?already_have_acc_no=") && url.includes("#") != true) {
            var id = url.split("=")[1].substring(0, 11);
            console.log(id);
            swal(id, "Already Have. Change Account ID", "error");
        }
        if (url.includes("add_client.php?something_worng") && url.includes("#") != true) {
            console.log(id);
            swal("Opps", "Something went worng. Try agine", "error");
        }

    }
</script>

</html>