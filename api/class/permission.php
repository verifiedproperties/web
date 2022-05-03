<?php
    class Permission{
        // Connection
        private $conn;
        
        // Db connection
        public function __construct($db){
            $this->conn = $db;
        }
 
        
        // Check Admin
        public function checkAdmin($id){
            $sql = "SELECT `role` FROM `users` WHERE id = $id LIMIT 1";
            $result = mysqli_query($this->conn, $sql);
            $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
            return $row['role'];       
        }     
        
        // Check Assignee
        public function checkAssignee($id){
            $sql = "SELECT `role` FROM `users` WHERE id = $id LIMIT 1";
            $result = mysqli_query($this->conn, $sql);
            $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
            return $row['role'];   
        }
        
    }
?>