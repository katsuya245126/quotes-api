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
            // Check if the id exists in the table first
            if (!$this->recordExists($this->table, $this->id)) {
                return ['success' => false, 'message' => 'No Quotes Found'];
            }

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

                return ['success' => true];
            }

            return ['success' => false, 'message' => 'Something went wrong'];
        }

        public function read_by_author() {
            // Check if the id exists in the table first
            if (!$this->recordExists('authors', $this->author_id)) {
                return ['success' => false, 'message' => 'No Quotes Found'];
            }

            $query = "
                SELECT q.id, q.quote, q.author_id, q.category_id, a.author, c.category 
                FROM {$this->table} as q
                INNER JOIN authors a ON q.author_id = a.id
                INNER JOIN categories c ON q.category_id = c.id
                WHERE a.id = :author_id
            ";

            // Prepare and bind param
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':author_id', $this->author_id);

            $stmt->execute();

            // Fetch all rows by author
            $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

            // If rows are returned, the author has quotes
            if(count($rows) > 0) {
                // Only include the id, quote, author name, and category name in the result
                $quotes_arr = array_map(function($row) {
                    return [
                        'id' => $row['id'],
                        'quote' => $row['quote'],
                        'author' => $row['author'],
                        'category' => $row['category']
                    ];
                }, $rows);

                return ['success' => true, 'data' => $quotes_arr];
            } else {
                // The author exists, but there are no quotes for them
                return ['success' => false, 'message' => 'No Quotes Found'];
            }
        } 
        
        public function create() {
            // Check for valid foreign keys for authors and categories
            if (!$this->recordExists('authors', $this->author_id)) {
                return ['success' => false, 'message' => 'author_id Not Found'];
            }
            
            if (!$this->recordExists('categories', $this->category_id)) {
                return ['success' => false, 'message' => 'category_id Not Found'];
            }

            // Insert info and return id, author_id, and category_id
            $query = "
                INSERT INTO {$this->table} (quote, author_id, category_id)
                VALUES (:quote, :author_id, :category_id)
                RETURNING id
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
                // Fetch and set ID category before returning
                $row = $stmt->fetch(PDO::FETCH_ASSOC);
                $this->id = $row['id'];
                
                return ['success' => true];
            }

            return ['success' => false, 'message' => 'Quote Not Created'];
        }

        public function update() {
            // Check if the id exists in the table first
            if (!$this->recordExists($this->table, $this->id)) {
                return ['success' => false, 'message' => 'No Quotes Found'];
            }

            // Check for valid foreign keys for authors and categories
            if (!$this->recordExists('authors', $this->author_id)) {
                return ['success' => false, 'message' => 'author_id Not Found'];
            }
            
            if (!$this->recordExists('categories', $this->category_id)) {
                return ['success' => false, 'message' => 'category_id Not Found'];
            }

            $query = "
                UPDATE {$this->table}
                SET quote = :quote, author_id = :author_id, category_id = :category_id
                WHERE id = :id
                RETURNING id;
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
                // Fetch and set ID category before returning
                $row = $stmt->fetch(PDO::FETCH_ASSOC);
                $this->id = $row['id'];
                
                return ['success' => true];
            }

            return ['success' => false, 'message' => 'Quote Not Updated'];
        }

        public function delete() {
            // Check if the id exists in the table first
            if (!$this->recordExists($this->table, $this->id)) {
                return ['success' => false, 'message' => 'No Quotes Found'];
            }

            $query = "
                DELETE FROM {$this->table}
                WHERE id = :id
                RETURNING id;
            ";

            $stmt = $this->conn->prepare($query);

            $this->id = htmlspecialchars(strip_tags($this->id));

            $stmt->bindParam(':id', $this->id);

            if($stmt->execute()) {
                // Fetch and set ID category before returning
                $row = $stmt->fetch(PDO::FETCH_ASSOC);
                $this->id = $row['id'];
                
                return ['success' => true];
            }

            return ['success' => false, 'message' => 'Quote Not Deleted'];
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