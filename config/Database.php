<?php
    error_reporting(E_ALL);
    ini_set('display_errors', 1);

    class Database {
        private $host;
        private $dbname;
        private $username;
        private $password;
        private $port;
        private $conn;

        public function __construct() {
            $this->host = getenv('HOST');
            $this->dbname = getenv('DBNAME');
            $this->username = getenv('USERNAME');
            $this->password = getenv('PASSWORD');
            $this->port = getenv('PORT');
        }

        public function connect() {
            if ($this->conn) {
                return $this->conn;
            } else {
                $dsn = "pgsql:host={$this->host};port={$this->port};dbname={$this->dbname};sslcert=blank;";

                try {
                    $this->conn = new PDO($dsn, $this->username, $this->password);
                    $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                    return $this->conn;
                } catch (PDOException $e) {
                    echo 'Connection erro: ' . $e->getMessage();
                }
            }
        }
    }