<?php 

require '../DatabaseCon.php';
function getTreeList(){

    global $con;

    $query = "SELECT * FROM tree_details";

    $query_run = mysqli_query($con,$query);

    if($query_run){


        if(mysqli_num_rows($query_run)>0){

            $response = mysqli_fetch_all($query_run,MYSQLI_ASSOC);
            $data = [
    
                'status' => 200,
                'message' => 'Data fetched successfully',
                'data' => $response
    
            ];
    
            header("HTTP/1.0 200 All good");
            return json_encode($data);

            
        }else{

            $data = [
    
                'status' => 404,
                'message' => 'No data found'
    
            ];
    
            header("HTTP/1.0 404 No data found");
            return json_encode($data);
        }


        

    }else{

        $data = [

            'status' => 500,
            'message' => 'Internal API problem'

        ];

        header("HTTP/1.0 500 Internal API problem");
        return json_encode($data);
    }



}


function error($message){

    $data = [
    
        'status' => 422,
        'message' => $message,

    ];

    header("HTTP/1.0 200 $message");
    return json_encode($data);
    exit();
}

function storeTree($treeData){

    global $con;

    $AddedByUser_ID = mysqli_real_escape_string($con,$treeData['AddedByUser_ID']);
    $Longitude = mysqli_real_escape_string($con,$treeData['Longitude']);
    $Latitude = mysqli_real_escape_string($con,$treeData['Latitude']);
    $Height = mysqli_real_escape_string($con,$treeData['Height']);
    $Circumference = mysqli_real_escape_string($con,$treeData['Circumference']);
    $Plant_Age = mysqli_real_escape_string($con,$treeData['Plant_Age']);
    $Comment = mysqli_real_escape_string($con,$treeData['Comment']);
            

    if(empty(trim($Latitude)) ||empty(trim($Longitude))||empty(trim($AddedByUser_ID))||empty(trim($Height))||empty(trim($Circumference))
    ||empty(trim($Plant_Age))||empty(trim($Comment))){


            return error('Check Data');

    }else{


        if (!is_numeric($Latitude) || !is_numeric($Longitude)|| !is_numeric($Longitude)|| !is_numeric($Height)|| !is_numeric($Circumference)) {

            return error('Wrong data type');
        }else{


            $Latitude = (double)$Latitude;
            $Longitude = (double)$Longitude;
            $Height = (double)$Height;
            $Circumference = (double)$Circumference;
            $AddedByUser_ID = (int)$AddedByUser_ID;

            $query = "INSERT INTO tree_details (Longitude,Latitude,Height,Circumference,AddedByUser_ID,Plant_Age,
            Comment) VALUES ('$Longitude', '$Latitude','$Height','$Circumference','$AddedByUser_ID',
            '$Plant_Age','$Comment')";
            $result = mysqli_query($con,$query);
    
            if($result){

                $checkQuery = "SELECT * FROM tree_details WHERE Longitude = '$Longitude' AND Latitude = 
                '$Latitude'";
                $checkResult = mysqli_query($con, $checkQuery);
                $finalResult = mysqli_fetch_assoc($checkResult);
                
                $data = [
        
                    'status' => 201,
                    'message' => "Data stored successfully",
                    'data'=>$finalResult
            
                ];
            
                header("HTTP/1.0 201 Data stored successfully");
                return json_encode($data);
                
    
            }else{
    
                $data = [
        
                    'status' => 500,
                    'message' => "Internal API Error",
            
                ];
            
                header("HTTP/1.0 500 Internal API Error");
                return json_encode($data);
            }

        }
    
        
       
    }


    

}


function getTree($GET){

    global $con;

    if($GET['id'] ==null){

        return error("Wrong data");
    }
    $id = $GET['id'];
    $id = mysqli_real_escape_string($con,$id);

    $query = "SELECT * FROM tree_details WHERE Tree_ID = '$id' LIMIT 1";
    $result = mysqli_query($con,$query);

    if($result){

        if(mysqli_num_rows($result) == 1){

            $finalResult = mysqli_fetch_assoc($result);

            $data = [
        
                'status' => 200,
                'message' => "Tree was found",
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


function updateTree($treeData,$GET){

    global $con;

    if(!isset($GET['id'])){

        return error("tree id not found");

    }else{


    }

    $treeID = mysqli_real_escape_string($con,$GET['longitude']);
    $longitude = mysqli_real_escape_string($con,$treeData['longitude']);
    $latitude = mysqli_real_escape_string($con,$treeData['latitude']);

    if(empty(trim($latitude)) ||empty(trim($longitude))){


            return error('Check Data');

    }else{


        if (!is_numeric($latitude) || !is_numeric($longitude)) {

            return error('Latitude and longitude must be numeric');
        }else{


            $latitude = (double)$latitude;
            $longitude = (double)$longitude;
    
            $query = "UPDATE trees (longitude,latitude) VALUES ('$longitude', '$latitude')";
            $result = mysqli_query($con,$query);
    
            if($result){
    
                $data = [
        
                    'status' => 201,
                    'message' => "Data stored successfully",
            
                ];
            
                header("HTTP/1.0 201 Data stored successfully");
                return json_encode($data);
                
    
            }else{
    
                $data = [
        
                    'status' => 500,
                    'message' => "Internal API Error",
            
                ];
            
                header("HTTP/1.0 500 Internal API Error");
                return json_encode($data);
            }

        }
    
        
       
    }


    

}

function storeTreeImage($imageData) {
    global $con;

    $AddedByUser_ID = mysqli_real_escape_string($con, $imageData['AddedByUser_ID']);
    $Tree_ID = mysqli_real_escape_string($con, $imageData['Tree_ID']);
    $TreeBase64 = $imageData['TreeBase64']; 


    $filename = uniqid() . '.png'; 

    $uploadDir = 'tree_images/';

    if (!file_exists($uploadDir)) {
        mkdir($uploadDir, 0777, true);
    }

    $filePath = $uploadDir . $filename;
    $img = str_replace('data:image/png;base64,', '',$TreeBase64);
    $img = str_replace(' ', '+', $img);
    $data = base64_decode($img);
    echo($TreeBase64);
   

    $success = file_put_contents($filePath, $data);

    if ($success !== false) {
        $query = "INSERT INTO tree_image (Tree_ID, User_ID, ImagePath) VALUES ('$Tree_ID', '$AddedByUser_ID', '$filePath')";
        $result = mysqli_query($con, $query);


        if ($result) {
            $data = [
                'status' => 201,
                'message' => "Image data stored successfully",
            ];
            header("HTTP/1.0 201 Image data stored successfully");
            return json_encode($data);
        } else {
            $data = [
                'status' => 500,
                'message' => "Failed to store image data in database",
            ];
            header("HTTP/1.0 500 Failed to store image data in database");
            return json_encode($data);
        }
    } else {
        $data = [
            'status' => 500,
            'message' => "Failed to save image on server",
        ];
        header("HTTP/1.0 500 Failed to save image on server");
        return json_encode($data);
    }
}



    




?>