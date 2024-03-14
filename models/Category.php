<?php
    class Category {
        // DB
        private $conn;
        private $table = 'categories';

        // Category properties
        public $id;
        public $category;

        public function __construct($db) {
            $this->conn = $db;
        }

        public function read() {
            $query = 'SELECT * FROM ' . $this->table;

            // Prepare and execute
            $stmt = $this->conn->prepare($query);
            $stmt->execute();

            return $stmt;
        }

        public function read_single() {
            // Check if the id exists in the table first
            if (!$this->recordExists($this->table, $this->id)) {
                return ['success' => false, 'message' => 'category_id Not Found'];
            }

            $query = 'SELECT * FROM ' . $this->table . ' WHERE id = :id LIMIT 1';

            // Prepare and bind param
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':id', $this->id);

            $stmt->execute();

            // Fetch result from DB into PHP associated array
            $row = $stmt->fetch(PDO::FETCH_ASSOC);

            if($row) {
                $this->category = $row['category'];

                return ['success' => true];
            }

            return ['success' => false, 'message' => 'Something went wrong'];
        }

        public function create() {
            $query = 'INSERT INTO ' . $this->table . ' (category) VALUES (:category) RETURNING id';

            $stmt = $this->conn->prepare($query);
            
            // Clean data
            $this->category = htmlspecialchars(strip_tags($this->category));

            $stmt->bindParam(':category', $this->category);

            if($stmt->execute()) {
                // Fetch and set ID before returning
                $row = $stmt->fetch(PDO::FETCH_ASSOC);
                $this->id = $row['id'];
                
                return ['success' => true];
            }

            return ['success' => false, 'message' => 'Category Not Created'];
        }

        public function update() {
            // Check if the id exists in the table first
            if (!$this->recordExists($this->table, $this->id)) {
                return ['success' => false, 'message' => 'category_id Not Found'];
            }

            $query = 'UPDATE ' . $this->table . ' SET category = :category WHERE id = :id RETURNING id';

            $stmt = $this->conn->prepare($query);
            
            // Clean data
            $this->category = htmlspecialchars(strip_tags($this->category));
            $this->id = htmlspecialchars(strip_tags($this->id));

            $stmt->bindParam(':category', $this->category);
            $stmt->bindParam(':id', $this->id);

            if($stmt->execute()) {
                // Fetch and set ID before returning
                $row = $stmt->fetch(PDO::FETCH_ASSOC);
                $this->id = $row['id'];

                return ['success' => true];
            }

            return ['success' => false, 'message' => 'Category Not Updated'];
        }

        public function delete() {
            // Check if the id exists in the table first
            if (!$this->recordExists($this->table, $this->id)) {
                return ['success' => false, 'message' => 'category_id Not Found'];
            }

            $query = 'DELETE FROM ' . $this->table . ' WHERE id = :id RETURNING id';

            $stmt = $this->conn->prepare($query);

            $this->id = htmlspecialchars(strip_tags($this->id));

            $stmt->bindParam(':id', $this->id);

            if($stmt->execute()) {
                return ['success' => true];
            }

            return ['success' => false, 'message' => 'Category Not Deleted'];
        }

        private function recordExists($tableName, $id) {
            // Check if at least one row exists with the id in the given table
            // Returns True if it exists, False if not
            $query = "SELECT EXISTS(SELECT 1 FROM {$tableName} WHERE id = :id)";

            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':id', $id);
        
            if ($stmt->execute()) {
                // Fetch first column from the first row in the result set and return it as boolean
                return (bool) $stmt->fetchColumn();
            }
        
            return false;
        }
    }