<?php 

require '../DatabaseCon.php';
function getTreeList(){

    global $con;

    $query = "SELECT * FROM trees";

    $query_run = mysqli_query($con,$query);

    if($query_run){


        if(mysqli_num_rows($query_run)>0){

            $respone = mysqli_fetch_all($query_run,MYSQLI_ASSOC);
            $data = [
    
                'status' => 200,
                'message' => 'Data fetched successfully',
                'data' => $respone
    
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

    header("HTTP/1.0 200 Wrong data type");
    return json_encode($data);
    exit();
}

function storeTree($treeData){

    global $con;

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
    
            $query = "INSERT INTO trees (longitude,latitude) VALUES ('$longitude', '$latitude')";
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

?>