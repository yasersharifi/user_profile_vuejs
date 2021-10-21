<?php
require 'config.php';

$user_id = $_GET["user_id"];
$sql = "DELETE FROM users WHERE id = " .$user_id;

$result = $conn->query($sql);

if ($result) {
    $response[] = array("status" => 1);
} else {
    $response[] = array("status" => 0);
}

echo json_encode($response);




 ?>
