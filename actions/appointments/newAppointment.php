<?php

    if (isset($_POST['saveBtn'])) {

        require('../../db.php');
        $data = [
            'customer_id' => $_POST['customer_id'],
            'service_id' => $_POST['service_id'],
            'appointment_date' => $_POST['appointment_date'],
            'appointment_time' => $_POST['appointment_time'],
            'status' => $_POST['status'],
            'note' => $_POST['note']
        ];

        $response = apiRequest('POST', 'appointments', null, $data);
        if ($response) {
            header('Location: ../../pages/idopontok.php');
        }
    }
    else {
        header('Location: ../../pages/idopontok.php');
    }




?>