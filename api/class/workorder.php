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
            $sql = "SELECT `work-orders`.* FROM `work-orders` LEFT JOIN users ON `work-orders`.assignee = users.id WHERE `work-orders`.id = $id";
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

        // Get completed work orders by Assingee
        public function getCompletedorders($user_id){
            $sql = "SELECT `work-orders`.date_completed, `work-orders`.date_approved, `work-orders`.street_address,`work-orders`.secondary_address,`work-orders`.service FROM `work-orders` LEFT JOIN users ON `work-orders`.assignee = users.id WHERE `work-orders`.assignee = $user_id AND `work-orders`.status = 4";
            $result = mysqli_query($this->conn, $sql);
            $rows = mysqli_fetch_all($result, MYSQLI_ASSOC);
            return $rows;       
        }       

        // Get attachedments by order ID
        public function getAttachments($order_id){
            // $order_id=htmlspecialchars(strip_tags($order_id));
            $sql = "SELECT `file`, `created_at` FROM `attachments` WHERE workorder_id = $order_id";
            $result = mysqli_query($this->conn, $sql);
            $rows = mysqli_fetch_all($result, MYSQLI_ASSOC);
            return $rows;       
        }
        
        // Get orders by assignee
        public function getAssigneeorders($assignee){
            $assignee=htmlspecialchars(strip_tags($assignee));
            $sql = "SELECT `work-orders`.* FROM `work-orders` LEFT JOIN users ON `work-orders`.assignee = users.id WHERE `work-orders`.assignee = $assignee";
            $result = mysqli_query($this->conn, $sql);
            $rows = mysqli_fetch_all($result, MYSQLI_ASSOC);
            return $rows;       
        }   

        // DELETE Work Order
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

        // Delete Attachedment
        function deleteAttachedment($id){
            $id=htmlspecialchars(strip_tags($id));
            $stmt = $this->conn->prepare("DELETE FROM  `attachments` WHERE ID = ?");    
            $stmt->bind_param("s", $id);
        
            $sql = "SELECT * FROM `attachments` WHERE ID = $id";
            $result = mysqli_query($this->conn, $sql);
            $row = mysqli_fetch_all($result, MYSQLI_ASSOC);
            $file_path = $row[0]['file'];
            if($stmt->execute()){
                unlink($file_path);
                return true;
            }
            return false;
        }

        //Delete Attachedments (all photos for order)
        function deleteAttachedments($order_id){
            $order_id = htmlspecialchars(strip_tags($order_id));
            $stmt = $this->conn->prepare("DELETE FROM `attachments` WHERE `workorder_id` = ?");
            $stmt->bind_param("s", $order_id);

            $sql = "SELECT * FROM `attachments` WHERE `workorder_id` = $order_id";
            $result = mysqli_query($this->conn, $sql);
            $rows = mysqli_fetch_all($result, MYSQLI_ASSOC);

            if($stmt->execute()){
                foreach($rows as $row){
                    $file_path = $row['file'];
                    unlink($file_path);
                }
                return true;
            }
            return false;
        }

        
    }
?>