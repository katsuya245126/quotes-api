<?php
    class Quote {
        // DB
        private $conn;
        private $table = 'quotes';

        // Quote properties
        public $id;
        public $quote;
        public $author_id;
        public $category_id;

        public function __construct($db) {
            $this->conn = $db;
        }

        public function read() {
            $query = "
                SELECT q.id, q.quote, a.author, c.category 
                FROM {$this->table} as q
                INNER JOIN authors a ON q.author_id = a.id
                INNER JOIN categories c ON q.category_id = c.id;
            ";

            // Prepare and execute
            $stmt = $this->conn->prepare($query);
            $stmt->execute();

            return $stmt;
        }

        /*
        public function read_single() {
            $query = 'SELECT * FROM ' . $this->table . ' WHERE id = :id LIMIT 1';

            // Prepare and bind param
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':id', $this->id);

            $stmt->execute();

            // Fetch result from DB into PHP associated array
            $row = $stmt->fetch(PDO::FETCH_ASSOC);

            $this->category = $row['category'];
        }

        public function create() {
            $query = 'INSERT INTO ' . $this->table . ' (category) VALUES (:category)';

            $stmt = $this->conn->prepare($query);
            
            // Clean data
            $this->category = htmlspecialchars(strip_tags($this->category));

            $stmt->bindParam(':category', $this->category);

            if($stmt->execute()) {
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
        */
    }