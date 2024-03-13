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
            $query = 'SELECT * FROM ' . $this->table . ' WHERE id = :id LIMIT 1';

            // Prepare and bind param
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':id', $this->id);

            $stmt->execute();

            // Fetch result from DB into PHP associated array
            $row = $stmt->fetch(PDO::FETCH_ASSOC);

            if($row) {
                $this->category = $row['category'];

                return true;
            }

            return false;
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
                
                return true;
            }

            printf("Error: %s.\n", $stmt->error);

            return false;
        }

        public function update() {
            $query = 'UPDATE ' . $this->table . ' SET category = :category WHERE id = :id';

            $stmt = $this->conn->prepare($query);
            
            // Clean data
            $this->category = htmlspecialchars(strip_tags($this->category));
            $this->id = htmlspecialchars(strip_tags($this->id));

            $stmt->bindParam(':category', $this->category);
            $stmt->bindParam(':id', $this->id);

            if($stmt->execute()) {
                return true;
            }

            printf("Error: %s.\n", $stmt->error);

            return false;
        }

        public function delete() {
            $query = 'DELETE FROM ' . $this->table . ' WHERE id = :id';

            $stmt = $this->conn->prepare($query);

            $this->id = htmlspecialchars(strip_tags($this->id));

            $stmt->bindParam(':id', $this->id);

            if($stmt->execute()) {
                return true;
            }

            printf("Error: %s.\n", $stmt->error);

            return false;
        }
    }