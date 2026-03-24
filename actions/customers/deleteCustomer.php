<?php

    if (isset($_GET['id'])) {
        require('../../db.php');
        
        $response = apiRequest('DELETE', 'customers', $_GET['id']);
        if ($response) {
            header('Location: ../../pages/ugyfelek.php');
            exit;
        }
    }
    else {
        header('Location: ../../pages/ugyfelek.php');
        exit;
    }
