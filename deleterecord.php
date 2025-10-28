<?php 
include "db.php";

if($_SERVER["REQUEST_METHOD"] == "POST"){

    $note_uid = $_POST["note_id"];
    
    $sql = "DELETE FROM notes WHERE note_unique_id=?";
    $stmt = mysqli_prepare($conn,$sql);
    mysqli_stmt_bind_param($stmt,"s",$note_uid);

    if(mysqli_stmt_execute($stmt)){
        header('location:index.php');
    }
    else{
        echo "Error deleting record : " . mysqli_error($conn);
    }
    mysqli_stmt_close($stmt);
    mysqli_close($conn);

}
?>