<?php
    // Headers
    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');

    include_once '../../config/Database.php';
    include_once '../../models/Quote.php';

    // Instantiate DB & Connect
    $database = new Database();
    $db = $database->connect();

    // Instantiate Quote object
    $quote = new Quote($db);

    if (!isset($_GET['category_id'])) {
        echo json_encode(
            array('message' => 'Missing Required Parameters')
        );
        die();
    }

    // Get ID
    $quote->category_id = $_GET['category_id'];

    $result = $quote->read_by_category();

    if($result['success']) {
        echo json_encode($result['data']);
    } else {
        echo json_encode(array('message' => $result['message']));
    }
    