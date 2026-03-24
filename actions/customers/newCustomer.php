<?php
if (isset($_POST['saveBtn'])) {

    require('../../db.php');
    $data = [
        'name' => $_POST['name'],
        'email' => $_POST['email'],
        'phone' => $_POST['phone']
    ];

    $response = apiRequest('POST', 'customers', null, $data);
    if ($response) {
        header('Location: ../../pages/ugyfelek.php');
        exit;
    }
}
else {
    header('Location: ../../pages/ugyfelek.php');
    exit;
}

?>