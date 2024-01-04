<?php

$conn = new mysqli("localhost","root","zaq12wsx","test");

$name = $_POST['name'];
$email = $_POST['email'];

$sql = "INSERT INTO students (name, email) VALUES ('$name', '$email')";

$conn->query($sql);

$post_data = $_POST;
$id['id'] = $conn->insert_id;

$data = array_merge($id, $post_data);
sleep(3);
echo json_encode($data);
