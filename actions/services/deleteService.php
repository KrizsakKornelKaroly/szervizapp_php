<?php

    if (isset($_GET['id'])) {
        require('../../db.php');

        $response = apiRequest('DELETE', 'services', $_GET['id']);
        if ($response) {
            header('Location: ../../pages/szolgaltatasok.php');
            exit;
        }
    }
    else {
        header('Location: ../../pages/szolgaltatasok.php');
        exit;
    }
