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

    if (!isset($_GET['id'])) {
        echo json_encode(
            array('message' => 'Missing Required Parameters')
        );
        die();
    }

    // Get ID
    $quote->id = $_GET['id'];

    if($quote->read_single()) {
        $quote_arr = array(
            'id' => $quote->id,
            'quote' => $quote->quote,
            'author' =>$quote->author,
            'category' => $quote->category
        );

        print_r(json_encode($quote_arr));
    } else {
        echo json_encode(
            array('message' => 'No Quotes Found')
        );
    }