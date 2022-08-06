<?php

    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json; charset=UTF-8');
    header('Access-Control-Allow-Methods: DELETE');
    header("Access-Control-Max-Age: 3600");
    header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, Access-Control-Allow-Methods, Authorization, X-Requested-With');

    include "db.php";

    $json = array();
    if($_SERVER["REQUEST_METHOD"] == "DELETE") {
        $db = new Database();
        try {
            if(!($conn = $db->getConnection()))
                throw new Exception("Could not get database connection!");
        }
        catch(Exception $e) {
            echo $e->getMessage();
        }
        $data = json_decode(file_get_contents("php://input"), true);
        $student_id = mysqli_real_escape_string($conn, trim($data['sid']));
        if(isset($student_id) && $student_id > 0) {
            $is_delete = $db->delete("students", "id=".$student_id);
            if($is_delete > 0)
            {
                $json['status']=1;
                $json['message']= $is_delete." records deleted";
            }
            else
            {
                $json['status']=0;
                $json['message']="Error occured";
            }
        }
        else {
            $json['status']=0;
            $json['message']="Incorrect student ID";
        }
    }
    else {
        $json['status']=0;
        $json['message']="Incorrect Request Mehod: ".$_SERVER["REQUEST_METHOD"];
    }
    echo json_encode($json);
?>