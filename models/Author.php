<?php
    class Author {
        // DB
        private $conn;
        private $table = 'authors';

        // Author properties
        public $id;
        public $author;

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
                $this->author = $row['author'];

                return true;
            }

            return false;
        }

        public function create() {
            $query = 'INSERT INTO ' . $this->table . ' (author) VALUES (:author) RETURNING id';

            $stmt = $this->conn->prepare($query);
            
            // Clean data
            $this->author = htmlspecialchars(strip_tags($this->author));

            $stmt->bindParam(':author', $this->author);

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
            $query = 'UPDATE ' . $this->table . ' SET author = :author WHERE id = :id';

            $stmt = $this->conn->prepare($query);
            
            // Clean data
            $this->author = htmlspecialchars(strip_tags($this->author));
            $this->id = htmlspecialchars(strip_tags($this->id));

            $stmt->bindParam(':author', $this->author);
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