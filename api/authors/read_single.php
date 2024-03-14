<?php
    // Headers
    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');

    include_once '../../config/Database.php';
    include_once '../../models/Author.php';

    // Instantiate DB & Connect
    $database = new Database();
    $db = $database->connect();

    // Instantiate Author object
    $author = new Author($db);

    if (!isset($_GET['id'])) {
        echo json_encode(
            array('message' => 'Missing Required Parameters')
        );
        die();
    }

    // Get ID
    $author->id = $_GET['id'];

    $response = $author->read_single();

    if($response['success']) {
        echo json_encode(
            array(
                'id' => $author->id,
                'author' => $author->author
            )
        );
    } else {
        echo json_encode(
            array('message' => $response['message'])
        );
    }