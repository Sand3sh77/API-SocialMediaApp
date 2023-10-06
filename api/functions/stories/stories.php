<?php
include "../../connection/config.php";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $cid = $_POST['currentUserId'];
    $pid = $_POST['paramsId'];

    $sql = "SELECT stories.id, stories.img, stories.createdAt, stories.userId, users.name, users.profilePic 
    FROM stories 
    INNER JOIN users ON stories.userId = users.id 
    INNER JOIN relationships ON stories.userId = relationships.followedUserId 
    WHERE relationships.followerUserId = $cid
    ORDER BY stories.id DESC";
    $result = mysqli_query($con, $sql);

    $sql1 = "SELECT stories.id, stories.img, stories.createdAt, stories.userId, users.name, users.profilePic 
    FROM stories 
    INNER JOIN users ON stories.userId = users.id 
    WHERE stories.userId=$cid
    ORDER BY stories.id DESC";
    $result1 = mysqli_query($con, $sql1);

    if ($result and $result1) {
        $story = [];
        while ($row = mysqli_fetch_assoc($result1)) {

            if ($row['id'] === $pid) {
                $row['active'] = true;
            } else {
                $row['active'] = false;
            }

            $story[] = $row;
        }
        while ($row = mysqli_fetch_assoc($result)) {

            if ($row['id'] === $pid) {
                $row['active'] = true;
            } else {
                $row['active'] = false;
            }

            $story[] = $row;
        }

        echo json_encode([
            "status" => 200,
            "message" => "Stories obtained succesfully",
            "data" => $story
        ]);
    } else {
        echo json_encode([
            "status" => 500,
            "message" => "Some error occured"
        ]);
    }

}


?>