<?php
    class Workorder{
        // Connection
        private $conn;
        // Table
        private $db_table = "work-orders";
        // Columns
        public $id;
        public $client_name;
        public $street_address;
        public $secondary_address;
        public $city;
        public $state;
        public $zip;
        public $country;
        public $owner;
        public $start_date;
        public $due_date;
        public $instructions;
        public $status;
        public $service;
        public $date_created;
        public $assignee;
        public $approved_by;
        public $date_completed;
        public $date_approved;
        public $access_code;
        // Db connection
        public function __construct($db){
            $this->conn = $db;
        }
        // GET ALL
        public function getWorkorders(){
            $sql = "SELECT `work-orders`.*, users.first_name, users.last_name FROM `work-orders` LEFT JOIN users ON `work-orders`.assignee = users.id ORDER BY date_created DESC";
            $result = mysqli_query($this->conn, $sql);
            $rows = mysqli_fetch_all($result, MYSQLI_ASSOC);
            return $rows;
        }
        // CREATE
        
        // READ single
        public function getWorkorder($id){
            $sql = "SELECT `work-orders`.*, users.first_name, users.last_name FROM `work-orders` LEFT JOIN users ON `work-orders`.assignee = users.id WHERE `work-orders`.id = $id";
            $result = mysqli_query($this->conn, $sql);
            $rows = mysqli_fetch_all($result, MYSQLI_ASSOC);
            return $rows;       
        }      

        // Get orders by Status
        public function getStatusorders($status){
            $status=htmlspecialchars(strip_tags($status));
            $sql = "SELECT `work-orders`.*, users.first_name, users.last_name FROM `work-orders` LEFT JOIN users ON `work-orders`.assignee = users.id WHERE `work-orders`.status = $status";
            $result = mysqli_query($this->conn, $sql);
            $rows = mysqli_fetch_all($result, MYSQLI_ASSOC);
            return $rows;       
        }       
        
        // Get orders by assignee
        public function getAssigneeorders($assignee){
            $assignee=htmlspecialchars(strip_tags($assignee));
            $sql = "SELECT `work-orders`.*, users.first_name, users.last_name FROM `work-orders` LEFT JOIN users ON `work-orders`.assignee = users.id WHERE `work-orders`.assignee = $assignee";
            $result = mysqli_query($this->conn, $sql);
            $rows = mysqli_fetch_all($result, MYSQLI_ASSOC);
            return $rows;       
        }   

        // DELETE
        function deleteWorkorder($id){
            $id=htmlspecialchars(strip_tags($id));
            // $sqlQuery = "DELETE FROM " . $this->db_table . " WHERE id = ?";
            $stmt = $this->conn->prepare("DELETE FROM  `work-orders` WHERE ID = ?");    
            $stmt->bind_param("s", $id);
        
            if($stmt->execute()){
                return true;
            }
            return false;
        }
    }
?>