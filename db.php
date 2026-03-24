<?php
    $serverURL = 'http://localhost/php_mvc_api/index.php';

    function apiRequest($method, $table, $id = null, $data = null, $decode = true) {
        
        global $serverURL;

        $url = $serverURL . '?table=' . urlencode($table);
        if ($id !== null) {
            $url .= '&id=' . urlencode($id);
        }

        $method = strtoupper($method);

        if ($method === 'GET') {
            $content = file_get_contents($url);
            return $decode ? json_decode($content, true) : $content;
        }

        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $method);

        if ($data !== null) {
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data, true));
        }

        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

        $response = curl_exec($ch);

        return $decode ? json_decode($response, true) : $response;
    }
    
?>
