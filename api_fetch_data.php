<?php

    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json; charset=UTF-8');
    header('Access-Control-Allow-Methods: GET');
    header("Access-Control-Max-Age: 3600");
    header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, Access-Control-Allow-Methods, Authorization, X-Requested-With');

    include "db.php";

    if($_SERVER['REQUEST_METHOD'] == "GET") {
        
        $db = new Database();
        try {
            if(!($conn = $db->getConnection()))
                throw new Exception("Could not get database connection! Custom Exception");
        }
        catch(Exception $e) {
            echo $e->getMessage();
        }
        try {
            $fetch_query = "SELECT * FROM students ORDER BY name ASC";
            $records = mysqli_query($conn, $fetch_query) or throw new Exception("Could not fetch record! Some error occured!");
            if(mysqli_num_rows($records) > 0) {
                $output = mysqli_fetch_all($records, MYSQLI_ASSOC);
                echo json_encode($output);
            }
            else {
                echo json_encode(array('status'=>0, 'message'=>'No record found!!'));
            }
        }
        catch(Exception $e) {
            $e->getMessage();
        }
    }
?>