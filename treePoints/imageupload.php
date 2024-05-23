<?php

error_reporting(0);
header('Access-Control-Allow-Origin:*');
header('Content-Type: application/json');
header('Access-Control-Allow-Method: POST');
header('Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Request-With');
include("functions.php");

$requestMethod = $_SERVER["REQUEST_METHOD"];
$inputData = json_decode(file_get_contents("php://input"), true);

if ($requestMethod == "POST") {
    if (empty($inputData)) {
        $StoreTree = storeTreeImage($_POST);
    } else {
        $StoreTree = storeTreeImage($inputData);
    }
    echo $StoreTree;
} else {
    $data = [
        'status' => 405,
        'message' => $requestMethod . ' This Method used is not allowed'
    ];
    echo json_encode($data);
}
?>
