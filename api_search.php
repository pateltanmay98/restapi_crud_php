<?php

    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json; charset=UTF-8');
    header("Access-Control-Max-Age: 3600");

    include "db.php";

    $json = array();

    if($_SERVER["REQUEST_METHOD"] == "GET") {
        $db = new Database();
        try{
            if(!($conn = $db->getConnection()))
                throw new Exception("Could not get database connection!");
        }
        catch(Exception $e){
            echo $e->getMessage();
        }
        if(isset($_GET['search']) && $_GET['search'] != "")
        {
            $search_str = mysqli_real_escape_string($conn, trim($_GET['search']));
            $sql = "SELECT * FROM students WHERE name LIKE '%".$search_str."%' or course LIKE '%".$search_str."%' or email LIKE '%".$search_str."%' or phone_no LIKE '%".$search_str."%'";
            try {
                $records = mysqli_query($conn, $sql) or throw new Exception("Could not fetch record! Some error occured!");
                if(mysqli_num_rows($records) > 0) {
                    $output = mysqli_fetch_all($records, MYSQLI_ASSOC);
                    echo json_encode($output);
                }
                else {
                    echo json_encode(array('status'=>0, 'message'=>'No record found!!'));
                }
            }
            catch(Exception $e){
                $e->getMessage();
            }
        }
    }
    else {
        $json['status']=0;
        $json['message']="Incorrect Request Mehod: ".$_SERVER["REQUEST_METHOD"];
        echo json_encode($json);
    }
?>