<?php  
include_once('includes/config.php');
 session_start();  
 if(isset($_SESSION["username"]))  
 {  
      header("location: ./dashboard");  
 }  

 if(isset($_POST["login"]))  
 {  
      if(empty($_POST["username"]) && empty($_POST["password"]))  
      {  
           echo"<script>alert('Please Input Username and Password !');</script>";  
      }  
      else  
      {  
           $username = mysqli_real_escape_string($conn, $_POST["username"]);  
           $password = mysqli_real_escape_string($conn, $_POST["password"]);  
           $password = md5($password);  
           $query = "SELECT * FROM login WHERE login_name = '$username' AND login_pass = '$password'";  
           $result = mysqli_query($conn, $query);  
           if(mysqli_num_rows($result) > 0)  
           {  
                $_SESSION['username'] = $username;  
                header("location: ./dashboard/index.php?login=".$username);  
           }  
           else  
           {  
            header("location: ?failed");

           }  
      }  
 }  
 ?>  


<!DOCTYPE html>
<html>

<head>
    <title>Login</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/bootstrap.css">
    <link rel="stylesheet" href="css/sweetalert.css">
    <link rel="stylesheet" href="css/style.css">
    <link rel="shortcut icon" href="image/favicon.png" />
    <script src="js/sweetalert.js"></script>
</head>
<style>
    .centered {
        position: fixed;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        transform: -webkit-translate(-50%, -50%);
        transform: -moz-translate(-50%, -50%);
        transform: -ms-translate(-50%, -50%);
    }
</style>

<body class="bg-dark">                       
                        <div class="container"  style="width:300px; padding-top:10%">
                         <div class="card card-signin my-5">
                    <div class="card-body">
                        <form class="form-signin" method="post">
                            <label>Enter Username</label>
                            <input type="text" name="username" class="form-control" required autofocus />
                            <br />
                            <label>Enter Password</label>
                            <input type="password" name="password" class="form-control" required autofocus/>
                            <br />
                            <center>
                                <input type="submit" name="login" value="Login" class="btn btn-info" />
                            </center>
                        </form>
                    </div>
                </div>
            </div>
        </div>

</body>
<script>
    window.onload = function() {
        var url = window.location.toString();

        if (url.includes("?error")) {
            var name = url.split("?")[1].substring(0, 11);
            swal({
                title: 'Sorry',
                text: 'You have to login first',
                })
        }
        if (url.includes("?logout")) {
            var name = url.split("?")[1].substring(0, 11);
            swal("Successfully", "You have been logout!", "success");
        }
        if (url.includes("?failed")) {
            var name = url.split("?")[1].substring(0, 11);
            swal("Failed", "Username Or Password Incorrect", "error");
        }
        }
</script>

</html>