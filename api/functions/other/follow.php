<?php
include "../../connection/config.php";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $followerId = $_POST['followerId'];
    $followedId = $_POST['followedId'];
    $isFollowed = $_POST['isFollowed'];

    if ($isFollowed === 'true') {
        $sql = "DELETE FROM relationships WHERE followerUserId='$followerId'and followedUserId='$followedId'";
        $result = mysqli_query($con, $sql);

        if ($result) {
            echo json_encode([
                "status" => 200,
                "message" => "Unfollowed Succesfully"
            ]);
        } else {
            echo json_encode([
                "status" => 500,
                "message" => "An error occured"
            ]);
        }
    } else {
        $sql = "INSERT INTO relationships(followerUserId,followedUserId,followedAt) VALUES ('$followerId','$followedId',NOW())";
        $result = mysqli_query($con, $sql);

        if ($result) {
            $not = "INSERT INTO notifications(notification,userId,createdAt) VALUES('started following you.',$followerId,NOW())";
            $nres = mysqli_query($con, $not);

            echo json_encode([
                "status" => 200,
                "message" => "Followed Succesfully"
            ]);
        } else {
            echo json_encode([
                "status" => 500,
                "message" => "An error occured"
            ]);
        }
    }

}

?>