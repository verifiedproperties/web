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
        public function createWorkorder(){
            $sqlQuery = "INSERT INTO
                        ". $this->db_table ."
                    SET
                        client_name = :client_name, 
                        street_address = :street_address, 
                        secondary_address = :secondary_address, 
                        city = :city, 
                        state = :state, 
                        zip = :zip, 
                        country = :country, 
                        owner = :owner, 
                        start_date = :start_date, 
                        due_date = :due_date, 
                        instructions = :instructions, 
                        status = :status, 
                        service = :service, 
                        date_created = :date_created, 
                        assignee = :assignee, 
                        approved_by = :approved_by, 
                        date_completed = :date_completed, 
                        date_approved = :date_approved, 
                        access_code = :access_code";
        
            $stmt = $this->conn->prepare($sqlQuery);
        
            // sanitize
            $this->client_name=htmlspecialchars(strip_tags($this->client_name));
        
            // bind data
            $stmt->bindParam(":client_name", $this->client_name);
            if($stmt->execute()){
               return true;
            }
            return false;
        }
        // READ single
        public function getWorkorder($id){
            $sql = "SELECT `work-orders`.*, users.first_name, users.last_name FROM `work-orders` LEFT JOIN users ON `work-orders`.assignee = users.id WHERE `work-orders`.id = $id";
            $result = mysqli_query($this->conn, $sql);
            $rows = mysqli_fetch_all($result, MYSQLI_ASSOC);
            return $rows;       
        }        
        // UPDATE
        public function updateEmployee(){
            $sqlQuery = "UPDATE
                        ". $this->db_table ."
                    SET
                        client_name = :client_name, 
                        street_address = :street_address, 
                        secondary_address = :secondary_address, 
                        city = :city, 
                        state = :state, 
                        zip = :zip, 
                        country = :country, 
                        owner = :owner, 
                        start_date = :start_date, 
                        due_date = :due_date, 
                        instructions = :instructions, 
                        status = :status, 
                        service = :service, 
                        date_created = :date_created, 
                        assignee = :assignee, 
                        approved_by = :approved_by, 
                        date_completed = :date_completed, 
                        date_approved = :date_approved, 
                        access_code = :access_code
                    WHERE 
                        id = :id";
        
            $stmt = $this->conn->prepare($sqlQuery);
        
            $this->client_name=htmlspecialchars(strip_tags($this->client_name));
        
            // bind data
            $stmt->bindParam(":client_name", $this->client_name);
        
            if($stmt->execute()){
               return true;
            }
            return false;
        }
        // DELETE
        function deleteWorkorder(){
            $sqlQuery = "DELETE FROM " . $this->db_table . " WHERE id = ?";
            $stmt = $this->conn->prepare($sqlQuery);
        
            $this->id=htmlspecialchars(strip_tags($this->id));
        
            $stmt->bindParam(1, $this->id);
        
            if($stmt->execute()){
                return true;
            }
            return false;
        }
    }
?>