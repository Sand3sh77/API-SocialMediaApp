<?php
include "../../connection/config.php";

if ($_SERVER["REQUEST_METHOD"] === "GET") {
    $id = $_GET['id'];

    $sql = "SELECT u.id, u.name, u.profilePic
    FROM users u
    LEFT JOIN relationships r ON u.id = r.followedUserId AND r.followerUserId = $id
    WHERE r.followedUserId IS NULL AND u.id != $id
    ORDER BY RAND()
    LIMIT 3";
    $result = mysqli_query($con, $sql);

    if ($result) {
        $data = [];
        while ($row = mysqli_fetch_assoc($result)) {
            $data[] = $row;
        }
        echo json_encode([
            "status" => 200,
            "message" => "Suggestions obtained succesfully",
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