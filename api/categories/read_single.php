<?php
    // Headers
    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');

    include_once '../../config/Database.php';
    include_once '../../models/Category.php';

    // Instantiate DB & Connect
    $database = new Database();
    $db = $database->connect();

    // Instantiate Category object
    $category = new Category($db);

    if (!isset($_GET['id'])) {
        echo json_encode(
            array('message' => 'Missing Required Parameters')
        );
        die();
    }

    // Get ID
    $category->id = $_GET['id'];

    $response = $category->read_single();

    if($response['success']) {
        echo json_encode(
            array(
                'id' => $category->id,
                'category' => $category->category
            )
        );
    } else {
        echo json_encode(
            array('message' => $response['message'])
        );
    }