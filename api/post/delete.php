<?php
    //headers
    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');
    header('Access-Control-Allow-Methods: DELETE');
    header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, Access-Control-Allow-Methods, Authorization, X-Requested-With');

    include_once '../../config/Database.php';
    include_once '../../models/Post.php';

    //instantiate db object and connect
    $database = new Database();
    $db = $database->connect();

    //instatiate blog post object
    $post = new Post($db);

    // //get raw posted data
    // $data = json_decode(file_get_contents("php://input"));
    // $post->id = $data->id;

    //get id from the url
    $post->id = isset($_GET['id']) ? $_GET['id'] : die() ;

    //delete post
    if($post->delete()){
        echo json_encode(
            array('message' => 'Post Deleted')
        );
    } else {
        echo json_encode(
            array('message' => 'Post Not Deleted')
        );
    }

