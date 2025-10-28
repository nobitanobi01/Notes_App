<?php 
include "db.php";

if($_SERVER["REQUEST_METHOD"] == "POST"){

    $note_uid = $_POST["n_id"];
    $title = $_POST["title"];
    $subtitle = $_POST["subtitle"];
    $desc = $_POST["desc"];
    $font = $_POST["fontsize"];
    
   
    $sql = "UPDATE notes SET note_title=?, note_subtitle=?, note_desc=?, note_desc_fontsize=?, last_updated = CURRENT_TIMESTAMP WHERE note_unique_id=?";

    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt,"sssss",$title,$subtitle,$desc,$font,$note_uid);

    if(mysqli_stmt_execute($stmt)){
        // echo "Record Updated";
        header('location:index.php');
    }
    else{
        echo "Error updating record : " . mysqli_error($conn);
    }

    mysqli_stmt_close($stmt);
    mysqli_close($conn);
}
?>