<?php
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Method: POST');
header('Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Request-With');

include("userfunctions.php");

$_requestMethod = $_SERVER["REQUEST_METHOD"];

if ($_requestMethod == "POST") {
    $inputData = json_decode(file_get_contents("php://input"), true);

    if ($inputData === null) {
        $data = [
            'status' => 400,
            'message' => 'Invalid JSON data'
        ];
        header("HTTP/1.0 400 Bad Request");
        echo json_encode($data);
    } else {
        // JSON decoding successful, proceed with login
        $checkUser = checkLogin($inputData);
        echo $checkUser;
    }
} else {
    // Invalid request method
    $data = [
        'status' => 405,
        'message' => $_requestMethod . ' This Method used is not allowed'
    ];
    header("HTTP/1.0 405 Method Not Allowed");
    echo json_encode($data);
}
?>
