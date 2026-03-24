<?php
if(isset($_POST['updateBtn'])) {

    require('../../db.php');
    $data = [
        'name' => $_POST['name'],
        'price' => $_POST['price'],
        'duration_minutes' => $_POST['duration_minutes']
    ];

    $response = apiRequest('PATCH', 'services', $_POST['id'], $data);
    if ($response) {
        header('Location: ../../pages/szolgaltatasok.php');
    }
}
else {
    header('Location: ../../pages/szolgaltatasok.php');
}
