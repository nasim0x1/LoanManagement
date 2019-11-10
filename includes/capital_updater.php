function plus_on_capital($amount){
    $sql = "UPDATE information SET capital='$amount' WHERE id=1";
    if ($conn->query($sql) === TRUE) {
        return true;
    } else {
        return false;
    }

}