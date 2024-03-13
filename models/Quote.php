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

            if($row) {
                $this->quote = $row['quote'];
                $this->author_id = $row['author_id'];
                $this->author = $row['author'];
                $this->category_id = $row['category_id'];
                $this->category = $row['category'];

                return true;
            }

            return false;
        }
        
        public function create() {
            // Check for valid foreign keys for authors and categories
            if (!$this->checkForeignKeyExists('authors', $this->author_id)) {
                return ['success' => false, 'message' => 'author_id Not Found'];
            }
            
            if (!$this->checkForeignKeyExists('categories', $this->category_id)) {
                return ['success' => false, 'message' => 'category_id Not Found'];
            }

            // Insert info and return id, author_id, and category_id
            $query = "
                WITH inserted AS (
                    INSERT INTO {$this->table} (quote, author_id, category_id)
                    VALUES (:quote, :author_id, :category_id)
                    RETURNING id, author_id, category_id
                )
                SELECT inserted.id, a.author AS author, c.category AS category
                FROM inserted
                JOIN authors a ON a.id = inserted.author_id
                JOIN categories c ON c.id = inserted.category_id
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
                // Fetch and set ID, author, and category before returning
                $row = $stmt->fetch(PDO::FETCH_ASSOC);
                $this->id = $row['id'];
                $this->author = $row['author'];
                $this->category = $row['category'];
                
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

        private function checkForeignKeyExists($tableName, $id) {
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