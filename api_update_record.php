<?php

    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json; charset=UTF-8');
    header('Access-Control-Allow-Methods: PUT');
    header("Access-Control-Max-Age: 3600");
    header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, Access-Control-Allow-Methods, Authorization, X-Requested-With');

    include "db.php";

    $json = array();
    if($_SERVER["REQUEST_METHOD"] == "PUT") {
        $db = new Database();
        try {
            if(!($conn = $db->getConnection()))
                throw new Exception("Could not get database connection! Custom Exception");
        }
        catch(Exception $e) {
            echo $e->getMessage();
        }
        $data = json_decode(file_get_contents("php://input"), true);
        $student_id = mysqli_real_escape_string($conn, trim($data['sid']));
        if(isset($student_id) && $student_id > 0) {
            $update_data = array(
                'name'=>$data['name'],
                'course'=>$data['course'],
                'email'=>$data['email'],
                'phone_no'=>$data['phone_no'],
            );
            $is_update = $db->update("students", $update_data, "id=".$data['sid']);
            if($is_update == 1)
            {
                $json['status']=1;
                $json['message']="Record updated";
            }
            else
            {
                $json['status']=0;
                $json['message']="Error occured";
            }
        }
    }
    else {
        $json['status']=0;
        $json['message']="Incorrect Request Mehod: ".$_SERVER["REQUEST_METHOD"];
    }
    echo json_encode($json);
?>