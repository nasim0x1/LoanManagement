<?php
 header('Content-type : bitmap; charset=utf-8');

 include("../includes/config.php");
 
 if(isset($_POST["encoded_string"])){    
	$encoded_string = $_POST["encoded_string"];
	$image_name = $_POST["image_name"];
    $acc_no = $_POST["acc_no"];
    

    $sql = "SELECT client_photo FROM client WHERE acc_no = '$acc_no'";
    $sth = $conn->query($sql);
    $result=mysqli_fetch_array($sth);
    $old_profile = $result['client_photo'];
    $old_photo_path = "../image/client_photo/$old_profile";	
	$decoded_string = base64_decode($encoded_string);
	$path = '../image/client_photo/'.$image_name;
	$file = fopen($path, 'wb');
	$is_written = fwrite($file, $decoded_string);
	fclose($file);
	if($is_written > 0) {	
        $sql = "UPDATE client SET client_photo = '$image_name' WHERE acc_no='$acc_no'";
        if ($conn->query($sql) === TRUE)  { 
            if($result['client_photo'] != "no_img.png"){
                if(file_exists($old_photo_path) == true){
                    unlink($old_photo_path);
                }
          }         
        }
		mysqli_close($conn);
    }
}


// api input :
//             1. image base64 string 
//             2.image name
//             3.client account number

?>