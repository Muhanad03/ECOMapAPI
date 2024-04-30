<?php 

require '../DatabaseCon.php';


function error($message){

    $data = [
    
        'status' => 422,
        'message' => $message,

    ];

    header("HTTP/1.0 200 $message");
    return json_encode($data);
    exit();
}


function checkLogin($userInfo){

    global $con;

    $email = $userInfo['email'];
    $email = mysqli_real_escape_string($con,$email);
    
    $password = $userInfo['password'];
    $password = mysqli_real_escape_string($con,$password);

    $query = "SELECT * FROM user_details WHERE Email = '$email' AND Password = '$password' LIMIT 1";
    $result = mysqli_query($con,$query);

    if($result){

        if(mysqli_num_rows($result) == 1){

            $finalResult = mysqli_fetch_assoc($result);

            $data = [
        
                'status' => 200,
                'message' => "user was found",
                'data' => $finalResult
            ];
        
            header("HTTP/1.0 200 Ok");
            return json_encode($data);



        }else{

            $data = [
        
                'status' => 404,
                'message' => "data not found",
        
            ];
        
            header("HTTP/1.0 404 data not found");
            return json_encode($data);
        }


    }else{

        $data = [
        
            'status' => 500,
            'message' => "Internal API Error",
    
        ];
    
        header("HTTP/1.0 500 Internal API Error");
        return json_encode($data);
    }

}


?>