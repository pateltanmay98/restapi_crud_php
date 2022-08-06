<?php

    class Database
    {
        private $servername = 'localhost';
        private $username = 'root';
        private $password = '';
        private $dbname = 'practice';
        public $conn;

        function __construct()
        {
            try {
                if(!($this->conn = mysqli_connect($this -> servername, $this -> username, $this -> password, $this -> dbname))) {
                    throw new Exception(mysqli_connect_error());
                }
            }
            catch(Exception $e) {
                echo $e->getMessage();
            }
        }
        function getConnection()
        {
            return $this->conn;
        }
        function insert($table, $data) {
            try {
                if(isset($table) && isset($data) && $table != null && $data != null)
                {
                    $col_name = array();
                    $values = array();
                    foreach($data as $key => $val) {
                        $val = mysqli_real_escape_string($this->conn, trim($val));
                        if($val != "")
                        {
                            $col_name[] = $key;
                            $values[] = "'".$val."'";
                        }
                    }
                    $sql = "INSERT INTO ".trim($table)." (".implode(', ', $col_name).") VALUES (".implode(', ', $values).")";
                    mysqli_query($this->conn, $sql) or throw new Exception("Record is not inserted! Some error occured!");
                    $insert_affect = mysqli_affected_rows($this->conn);
                    if($insert_affect == 1)
                        return 1;
                    else
                        return 0;
                }
            }
            catch(Exception $e) {
                $e->getMessage();
            }
        }
        function update($table, $data, $where) {
            try{
                if(isset($table) && isset($data) && isset($where) && $table != null && $data != null && $where != null)
                {
                    $data_col = array();
                    foreach($data as $key=>$val) {
                        $val = mysqli_real_escape_string($this->conn, trim($val));
                        $data_col[] = "$key = '$val'";
                    }
                    $sql = "UPDATE ".trim($table)." SET ".implode(', ', $data_col)." WHERE ".trim($where);
                    mysqli_query($this->conn, $sql) or throw new Exception("Record is not updated! Some error occured!");
                    $update_affect = mysqli_affected_rows($this->conn);
                    if($update_affect > 0)
                        return 1;
                    else
                        return 0;
                }
            }
            catch(Exception $e) {
                $e->getMessage();
            }
        }
        function delete($table, $where) {
            if(isset($table) && isset($where) && $table != null && $where != null) {
                try {
                    $sql = "DELETE FROM ".trim($table)." WHERE ".trim($where);
                    mysqli_query($this->conn, $sql) or throw new Exception("Record is not deleted! Some error occured!");
                    $delete_affect = mysqli_affected_rows($this->conn);
                    if($delete_affect > 0)
                        return $delete_affect;
                    else
                        return 0;
                }
                catch(Exception $e) {
                    $e->getMessage();
                }
            }
        }
    }
?>