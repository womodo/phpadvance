<?php

$data = [];

// ajaxから渡されたデータ
$inputVal = $_POST['inputVal'];
if ($inputVal) {
    $data[] = $inputVal;
}

// Fetch APIから渡されたデータ
$postData = json_decode(file_get_contents("php://input"), true);
if ($postData['inputVal']) {
    $data[] = $postData['inputVal'];
}

$data = array_merge($data, ['apple', 'banana', 'cherry']);
echo json_encode($data);

?>