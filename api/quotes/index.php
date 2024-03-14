<?php
    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');
    $method = $_SERVER['REQUEST_METHOD'];

    if ($method === 'OPTIONS') {
        header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');
        header('Access-Control-Allow-Headers: Origin, Accept, Content-Type, X-Requested-With');
        exit();
    } 
    
    switch ($method) {
        case 'GET':
            // Check if specific quote is requested
            if (isset($_GET['id'])) {
                require 'read_single.php';
            }
            // Check if filtering by author
            else if (isset($_GET['author_id']) && !isset($_GET['category_id'])) {
                require 'read_author.php'; 
            }
            // Check if filtering by category
            else if (isset($_GET['category_id']) && !isset($_GET['author_id'])) {
                require 'read_category.php';
            }
            // Check if filtering by both author and category
            else if (isset($_GET['author_id']) && isset($_GET['category_id'])) {
                require 'read_author_category.php';
            }
            // If no specific filter is provided, return all quotes
            else {
                require 'read.php';
            }
            break;
        case 'POST':
            require 'create.php';
            break;
        case 'PUT':
            require 'update.php';
            break;
        case 'DELETE':
            require 'delete.php';
            break;
        default:
            echo json_encode(['message' => 'Method not supported']);
            break;
}