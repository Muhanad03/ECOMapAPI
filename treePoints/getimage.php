<?php

    header('Access-Control-Allow-Origin:*');
    header('Content-Type: application/json');
    header('Access-Control-Allow-Method: GET');
    header('Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Request-With');

    include("functions.php");

    $_requestMethod = $_SERVER["REQUEST_METHOD"];
    
    if($_requestMethod == "GET"){



        if(isset($_GET['id'])){

            $tree = getImage($_GET);
            echo $tree;

        }

        

       
        
    }else{

        $data = [

            'status' => 405,
            'message' => $_requestMethod. ' This Method used is not allowed'

        ];

        header("HTTP/1.0 405 This Method used is not allowed");
        echo json_encode($data);
    }



?>