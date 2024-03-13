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

    if($author->read_single()) {
        $author_arr = array(
            'id' => $author->id,
            'author' => $author->author
        );

        print_r(json_encode($author_arr));
    } else {
        echo json_encode(
            array('message' => 'author_id not found')
        );
    }