<?php
    // Headers
    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');
    header('Access-Control-Allow-Methods: DELETE');
    header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Access-Control-Allow-Methods, Content-Type, Access-Control-Allow-Origin, Authorization, X-Requested-With');

    include_once '../../config/Database.php';
    include_once '../../models/Category.php';

    // Instantiate DB & Connect
    $database = new Database();
    $db = $database->connect();

    // Instantiate Category object
    $category = new Category($db);

    // Get raw posted data
    $data = json_decode(file_get_contents("php://input"));

    if (is_null($data) || empty($data->id)) {
        echo json_encode(
            array('message' => 'Missing Required Parameters')
        );
        die();
    }

    $category->id = $data->id;

    $response = $category->delete();

    if($response['success']) {
        echo json_encode(
            array(
                'id' => $category->id,
            )
        );
    } else {
        echo json_encode(
            array('message' => $response['message'])
        );
    }