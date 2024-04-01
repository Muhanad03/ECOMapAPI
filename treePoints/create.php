<?php

    error_reporting(0);
    header('Access-Control-Allow-Origin:*');
    header('Content-Type: application/json');
    header('Access-Control-Allow-Method: GET');
    header('Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Request-With');

    include("functions.php");

    $_requestMethod = $_SERVER["REQUEST_METHOD"];
    
    if($_requestMethod == "POST"){

        $inputData = json_decode(file_get_contents("php://input"),true);

        if(empty($inputData)){

            $StoreTree = storeTree($_POST);
        }else{

            $StoreTree = storeTree($inputData);
        }


        echo $inputData;
        
    }else{

        $data = [

            'status' => 405,
            'message' => $_requestMethod. ' This Method used is not allowed'

        ];

        header("HTTP/1.0 405 This Method used is not allowed");
        echo json_encode($data);
    }



?>