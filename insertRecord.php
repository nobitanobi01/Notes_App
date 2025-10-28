<?php 
include "db.php";

if($_SERVER["REQUEST_METHOD"] == "POST"  && isset($_FILES["image"])){


    $targetDir = "assets/images/";

    $note_uid = "note_" . mt_rand(1000, 9999);
    $title = $_POST["title"];
    $subtitle = $_POST["subtitle"];
    $desc = $_POST["desc"];
    $font = $_POST["fontsize"];

    if(!file_exists(($targetDir))){
        mkdir($targetDir,0777,true);
    }
    $targetfile = $targetDir . basename($_FILES["image"]["name"]);
    $uImage = $targetfile;
    move_uploaded_file($_FILES["image"]["tmp_name"],$targetfile);
    

    $sql = "INSERT INTO notes (note_unique_id,note_title,note_subtitle,note_desc,note_desc_fontsize,note_image) 
    VALUES ('$note_uid', '$title' ,'$subtitle','$desc','$font','$uImage')";

    if($conn->query($sql) === TRUE){
        // echo "Done";

        header('location:index.php');
    }
    else{
        echo "Error";
    }
    $conn->close();
}
else{
    echo "Error";
}
?>