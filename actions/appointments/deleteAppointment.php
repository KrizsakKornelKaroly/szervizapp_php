<?php

    if (isset($_GET['id'])) {
        require('../../db.php');

        $response = apiRequest('DELETE', 'appointments', $_GET['id']);
        if ($response) {
            header('Location: ../../pages/idopontok.php');
            exit;
        }
    }
    else {
        header('Location: ../../pages/idopontok.php');
        exit;
    }
