<?php
if (isset($_POST['saveBtn'])) {

    require('../../db.php');
    $data = [
        'name' => $_POST['name'],
        'price' => $_POST['price'],
        'duration_minutes' => $_POST['duration_minutes']
    ];

    $response = apiRequest('POST', 'services', null, $data);
    if ($response) {
        header('Location: ../../pages/szolgaltatasok.php');
        exit;
    }
}
else {
    header('Location: ../../pages/szolgaltatasok.php');
    exit;
}

?>