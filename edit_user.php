<?php
require "config.php";

$data = json_decode(file_get_contents("php://input"));

$user_id = $data->user_id;
$name = $data->name;
$email = $data->email;
$mobile = $data->mobile;

$sql = "UPDATE users SET name = '$name', email = '$email', mobileno = '$mobile' WHERE id = " . $user_id;
$result = $conn->query($sql);

if ($result) {
    $response[] = array("status" => 1);
} else {
    $response[] = array("status" => 0);
}


echo json_encode($response);



 ?>
