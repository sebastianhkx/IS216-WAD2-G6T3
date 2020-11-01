<?php
    class Event_Get {
    
        // database connection and table name
        private $conn;
        private $table_name = "event_list";

        // object properties
        public $event_id;
        public $user_id;
        public $date;
        public $start_time;
        public $end_time;
        public $location;
        public $title;
        public $description;
        public $completed;
            
        // constructor with $db as database connection
        public function __construct($db) {
            $this->conn = $db;
        }

        // get all winners
        public function read() {
        
            // select all query
            $query = "SELECT
                            *
                        FROM
                            event_list";

        
            // prepare query statement
            $stmt = $this->conn->prepare($query);
        
            // execute query
            $stmt->execute();
        
            return $stmt;
        }
        

    }

    class Task_Get {
    
        // database connection and table name
        private $conn;
        private $table_name = "task_list";

        // object properties
        public $task_id;
        public $user_id;
        public $date;
        public $start_time;
        public $end_time;
        public $repeatable;
        public $title;
        public $description;
            
        // constructor with $db as database connection
        public function __construct($db) {
            $this->conn = $db;
        }

        // get all winners
        public function read() {
        
            // select all query
            $query = "SELECT
                            *
                        FROM
                            task_list";

        
            // prepare query statement
            $stmt = $this->conn->prepare($query);
        
            // execute query
            $stmt->execute();
        
            return $stmt;
        }

    }



?>