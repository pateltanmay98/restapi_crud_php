<?php

    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json; charset=UTF-8');
    header('Access-Control-Allow-Methods: POST');
    header("Access-Control-Max-Age: 3600");
    header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, Access-Control-Allow-Methods, Authorization, X-Requested-With');

    include "db.php";

    $json = array();
    
    if($_SERVER["REQUEST_METHOD"] == "POST") {
        $db = new Database();
        try{
            if(!($conn = $db->getConnection()))
                throw new Exception("Could not get database connection!");
        }
        catch(Exception $e){
            echo $e->getMessage();
        }
        $data = json_decode(file_get_contents("php://input"), true);
        // echo '<pre>'; print_r($data);
        $student_id = mysqli_real_escape_string($conn, trim($data['sid']));
        if(isset($student_id))
        {
            $sql = "select * from students where id=".$student_id;
            try{
                $result = mysqli_query($conn, $sql) or throw new Exception("Could not fetch record! Some error occured!");
            }
            catch(Exception $e){
                $e->getMessage();
            }
            $data = array();
            $row = mysqli_fetch_assoc($result);
            if(mysqli_num_rows($result) > 0) {
                $data = array(
                    'student_id'=>$row['id'],
                    'name'=>$row['name'],
                    'course'=>$row['course'],
                    'email'=>$row['email'],
                    'phone_no'=>$row['phone_no']
                );
            }
            $json['status'] = 1;
            $json['data'] = $data;
        }
        else {
            $json['status'] = 0;
            $json['data'] = "Invalid student ID!!";
        }
    }
    else {
        $json['status']=0;
        $json['message']="Incorrect Request Mehod: ".$_SERVER["REQUEST_METHOD"];
    }
    echo json_encode($json);
?>