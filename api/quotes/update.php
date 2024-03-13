<?php
    // Headers
    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');
    header('Access-Control-Allow-Methods: PUT');
    header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Access-Control-Allow-Methods, Content-Type, Access-Control-Allow-Origin, Authorization, X-Requested-With');

    include_once '../../config/Database.php';
    include_once '../../models/Quote.php';

    // Instantiate DB & Connect
    $database = new Database();
    $db = $database->connect();

    // Instantiate Quote object
    $quote = new Quote($db);

    // Get raw posted data
    $data = json_decode(file_get_contents("php://input"));

    if (is_null($data) || empty($data->quote) || empty($data->author_id) || empty($data->category_id)) {
        echo json_encode(
            array('message' => 'Missing Required Parameters')
        );
        die();
    }

    $quote->id = $data->id;
    $quote->quote = $data->quote;
    $quote->author_id = $data->author_id;
    $quote->category_id = $data->category_id;

    if($quote->update()) {
        echo json_encode(
            array('message' => 'Quote Updated')
        );
    } else {
        echo json_encode(
            array('message' => 'Quote Not Updated')
        );
    }