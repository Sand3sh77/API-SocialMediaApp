<?php
include "../../connection/config.php";

if ($_SERVER["REQUEST_METHOD"] === "GET") {
    $id = $_GET['id'];

    $sql = "SELECT DISTINCT u.id, u.name, u.profilePic
    FROM users u
    INNER JOIN relationships r ON u.id=r.followedUserId
    WHERE r.followerUserId=$id
    ORDER BY r.id DESC
    LIMIT 10";
    $result = mysqli_query($con, $sql);

    if ($result) {
        $data = [];
        while ($row = mysqli_fetch_assoc($result)) {
            $data[] = $row;
        }
        echo json_encode([
            "status" => 200,
            "message" => "All friends obtained succesfully",
            "data" => $data
        ]);
    } else {
        echo json_encode([
            "status" => 500,
            "message" => "Some error occured"
        ]);
    }

}

?>