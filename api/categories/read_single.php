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

    $category->read_single();

    $category_arr = array(
        'id' => $category->id,
        'category' => $category->category
    );

    print_r(json_encode($category_arr));