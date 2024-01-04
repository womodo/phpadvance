<?php

// print_r($_REQUEST);
// print_r($_FILES);

$action = $_REQUEST['action'];

if (!empty($action)) {
    require_once 'partials/User.php';
    $obj = new User();
}

// adding user action
if ($action == 'adduser' && !empty($_POST)) {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $mobile = $_POST['mobile'];
    $photo = $_FILES['photo'];

    $playerId = !empty($_POST['userId']) ? $_POST['userId'] : "";

    $imagename = "";
    if (!empty($photo['name'])) {
        $imagename = $obj->uploadPhoto($photo);
        $playerData = [
            'name' => $username,
            'email' => $email,
            'mobile' => $mobile,
            'photo' => $imagename,
        ];
    } else {
        $playerData = [
            'name' => $username,
            'email' => $email,
            'mobile' => $mobile,
        ];
    }

    if ($playerId) {
        $obj->update($playerData, $playerId);
    } else {
        $playerId = $obj->add($playerData);
    }

    if (!empty($playerId)) {
        $player = $obj->getRow('id', $playerId);
        echo json_encode($player);
        exit();
    }
} 

// getcountof function and getAllUsers action
if ($action == 'getAllUsers') {
    $page = (!empty($_GET['page'])) ? $_GET['page'] : 1;
    $limit = 4;

    $start = ($page - 1) * $limit;
    $users = $obj->getRows($start, $limit);
    if (!empty($users)) {
        $userlist = $users;
    } else {
        $userlist = [];
    }
    $total = $obj->getCount();
    $userArr = ['count' => $total, 'users' => $userlist];
    echo json_encode($userArr);
    exit();
}


// action to perform editing
if ($action == 'editUserData') {
    $playerId = !empty($_GET['id']) ? $_GET['id'] : "";
    if (!empty($playerId)) {
        $user = $obj->getRow('id', $playerId);
        echo json_encode($user);
        exit();
    }
}

// perform deleting
if ($action == 'deleteUser') {
    $playerId = !empty($_GET['id']) ? $_GET['id'] : "";
    if (!empty($playerId)) {
        $isdeleted = $obj->deleteRow($playerId);
        if ($isdeleted) {
            $displaymessage = ['delete' => 1];
        } else {
            $displaymessage = ['delete' => 0];
        }
        echo json_encode($displaymessage);
        exit();
    }
}

// search data
if ($action == 'searchUser') {
    $queryString = !empty($_GET['searchQuery']) ? trim($_GET['searchQuery']) : "";
    $results = $obj->searchUser($queryString);
    echo json_encode($results);
    exit();
}

?>