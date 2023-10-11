<?php
include "../../connection/config.php";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $id = $_POST['id'];
    $location = $_POST['location'];
    $currentImage = $_POST['currentImage'];

    $image = $_FILES['file'];
    $image_name = $image['name'];
    $image_ext = $image['type'];
    $image_tmp = $image['tmp_name'];
    $image_location = "../../images/user/" . $location . '/' . $image_name;
    move_uploaded_file($image_tmp, $image_location);
    $image_location_db = "api/images/user/" . $location . '/' . $image_name;

    if ($location === "profile") {

        $not = "INSERT INTO notifications(notification,userId,createdAt) VALUES('changed profile picture.',$id,NOW())";
        $nres = mysqli_query($con, $not);

        $sql = "UPDATE users SET profilePic='$image_location_db' where id='$id'";
    } else if ($location === "cover") {

        $not = "INSERT INTO notifications(notification,userId,createdAt) VALUES('changed cover picture.',$id,NOW())";
        $nres = mysqli_query($con, $not);
        $sql = "UPDATE users SET coverPic='$image_location_db' where id='$id'";
    }
    $result = mysqli_query($con, $sql);

    if ($result) {
        if ($currentImage) {
            unlink('../../images/user/' . $location . '/' . substr($currentImage, strrpos($currentImage, '/') + 1));
        }
        echo json_encode([
            "status" => 200,
            "message" => "Image updated succesfully",
            "location" => $image_location_db
        ]);
    } else {
        echo json_encode([
            "status" => 500,
            "message" => "Some error occured"
        ]);
    }
}

?>