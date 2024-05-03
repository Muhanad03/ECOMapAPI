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
function createUser($userInfo){
    global $con;

    $first_name = $userInfo['first_name'];
    $first_name = mysqli_real_escape_string($con, $first_name);

    $last_name = $userInfo['last_name'];
    $last_name = mysqli_real_escape_string($con, $last_name);

    $email = $userInfo['email'];
    $email = mysqli_real_escape_string($con, $email);

    $password = $userInfo['password'];
    $password = mysqli_real_escape_string($con, $password);

    $user_type = 'U';

    // Check if user already exists
    $checkQuery = "SELECT * FROM user_details WHERE Email = '$email'";
    $checkResult = mysqli_query($con, $checkQuery);

    if(mysqli_num_rows($checkResult) > 0){
        $data = [
            'status' => 409,
            'message' => "User with this email already exists",
   

        ];
        header("HTTP/1.0 409 Conflict");
        return json_encode($data);
    }

    // Insert new user
    $insertQuery = "INSERT INTO user_details (First_Name, Last_Name, Email, Password,User_Type) VALUES ('$first_name', '$last_name', '$email', '$password','$user_type')";
    $insertResult = mysqli_query($con, $insertQuery);

    $checkQuery = "SELECT * FROM user_details WHERE Email = '$email'";
    $checkResult = mysqli_query($con, $checkQuery);
    $finalResult = mysqli_fetch_assoc($checkResult);

    if($insertResult){
        $data = [
            'status' => 201,
            'message' => "User created successfully",
            'data' => $finalResult
        ];
        header("HTTP/1.0 201 Created");
        return json_encode($data);
    }else{
        $data = [
            'status' => 500,
            'message' => "Internal Server Error",
        ];
        header("HTTP/1.0 500 Internal Server Error");
        return json_encode($data);
    }
}


?>