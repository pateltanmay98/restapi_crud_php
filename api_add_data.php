<?php

    header("Access-Control-Allow-Origin: *");
    header("Content-Type: application/json; charset=UTF-8");
    header("Access-Control-Allow-Methods: POST");
    header("Access-Control-Max-Age: 3600");
    header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

    include "db.php";

    $json = array();
    if($_SERVER['REQUEST_METHOD'] == "POST") {
        $db = new Database();
        $data = json_decode(file_get_contents("php://input"), true);
        $insert_data = array(
            "name"=>$data['add_name'],
            "course"=>$data['add_course'],
            "email"=>$data['add_email'],
            "phone_no"=>$data['add_phone_no']
        );
        $is_insert = $db->insert("students", $insert_data);
        if($is_insert == 1)
        {
            $json['status']=1;
			$json['message']="Record inserted";
        }
        else
        {
            $json['status']=0;
			$json['message']="Error occured";
        }
    }
    else {
        $json['status']=0;
        $json['message']="Incorrect Request Mehod: ".$_SERVER["REQUEST_METHOD"];
    }
    echo json_encode($json);
?>