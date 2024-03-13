<?php
    class Quote {
        // DB
        private $conn;
        private $table = 'quotes';

        // Quote properties
        public $id;
        public $quote;
        public $author_id;
        public $author;
        public $category_id;
        public $category;

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

        
        public function read_single() {
            $query = "
                SELECT q.id, q.quote, q.author_id, q.category_id, a.author, c.category 
                FROM {$this->table} as q
                INNER JOIN authors a ON q.author_id = a.id
                INNER JOIN categories c ON q.category_id = c.id
                WHERE q.id = :id
                LIMIT 1
            ";

            // Prepare and bind param
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':id', $this->id);

            $stmt->execute();

            // Fetch result from DB into PHP associated array
            $row = $stmt->fetch(PDO::FETCH_ASSOC);

            $this->quote = $row['quote'];
            $this->author_id = $row['author_id'];
            $this->author = $row['author'];
            $this->category_id = $row['category_id'];
            $this->category = $row['category'];
        }
        
        public function create() {
            $query = "
                INSERT INTO {$this->table} (quote, author_id, category_id)
                VALUES (:quote, :author_id, :category_id)
            ";

            $stmt = $this->conn->prepare($query);
            
            // Clean data
            $this->quote = htmlspecialchars(strip_tags($this->quote));
            $this->author_id = htmlspecialchars(strip_tags($this->author_id));
            $this->category_id = htmlspecialchars(strip_tags($this->category_id));

            $stmt->bindParam(':quote', $this->quote);
            $stmt->bindParam(':author_id', $this->author_id);
            $stmt->bindParam(':category_id', $this->category_id);

            if($stmt->execute()) {
                return true;
            }

            printf("Error: %s.\n", $stmt->error);

            return false;
        }

        public function update() {
            $query = "
                UPDATE {$this->table}
                SET quote = :quote, author_id = :author_id, category_id = :category_id
                WHERE id = :id;
            ";

            $stmt = $this->conn->prepare($query);
            
            // Clean data
            $this->id = htmlspecialchars(strip_tags($this->id));
            $this->quote = htmlspecialchars(strip_tags($this->quote));
            $this->author_id = htmlspecialchars(strip_tags($this->author_id));
            $this->category_id = htmlspecialchars(strip_tags($this->category_id));

            $stmt->bindParam(':id', $this->id);
            $stmt->bindParam(':quote', $this->quote);
            $stmt->bindParam(':author_id', $this->author_id);
            $stmt->bindParam(':category_id', $this->category_id);

            if($stmt->execute()) {
                return true;
            }

            printf("Error: %s.\n", $stmt->error);

            return false;
        }

        public function delete() {
            $query = "
                DELETE FROM {$this->table}
                WHERE id = :id;
            ";

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