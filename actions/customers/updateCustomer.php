<?php
if(isset($_POST['updateBtn'])) {

    require('../../db.php');
    $data = [
        'name' => $_POST['name'],
        'email' => $_POST['email'],
        'phone' => $_POST['phone']
    ];

    $response = apiRequest('PATCH', 'customers', $_POST['id'], $data);
    if ($response) {
        header('Location: ../../pages/ugyfelek.php');
    }
}
else {
    header('Location: ../../pages/ugyfelek.php');
}
