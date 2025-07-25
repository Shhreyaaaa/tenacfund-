<?php
class sqlConnection {
    private $host;
    private $user;
    private $pass;
    private $database;
    private $conn;
    private $query;  //  Add this line to avoid dynamic property

    // Initiate Sqlconnection
    public function __construct() {
        require(__DIR__ . '/db_credentials.php'); // <-- load secret

        $this->host = DB_HOST;
        $this->user = DB_USER;
        $this->pass = DB_PASS;
        $this->database = DB_NAME;

        $this->conn = mysqli_connect($this->host, $this->user, $this->pass, $this->database);
        if (!$this->conn) {
            die("<center><span style='color:red;'>Connection failed: " . mysqli_connect_error() . "</span></center>");
        }
    }

    // Run query
    public function fireQuery($qry) {
        if (!empty($qry)) {
            $this->query = mysqli_query($this->conn, $qry);
            return $this->query;
        } else {
            die("<center><span style='color:red; font-weight:bold'>Database Table Error !!!</span></center>");
        }
    }

    // Escape string
    public function realString($qry) {
        if (!empty($qry)) {
            $this->query = mysqli_real_escape_string($this->conn, $qry);
            return $this->query;
        } else {
            die("<center><span style='color:red; font-weight:bold'>Database Table Error !!!</span></center>");
        }
    }

    // Get last inserted ID
    public function lastId() {
        return mysqli_insert_id($this->conn);
    }

    // Count Row
    public function rowCount($param) {
        if (!empty($param)) {
            return mysqli_num_rows($param);
        }
        return 0;
    }

    // Fetch as associative array
    public function fetchAssoc($param) {
        if (!empty($param) && mysqli_num_rows($param) > 0) {
            $arr = [];
            while ($rs = mysqli_fetch_assoc($param)) {
                $arr[] = $rs;
            }
            return $arr;
        }
        return NULL;
    }

    // Fetch as object
    public function fetchAssocobject($param) {
        if (!empty($param) && mysqli_num_rows($param) > 0) {
            $arr = [];
            while ($rs = mysqli_fetch_object($param)) {
                $arr[] = $rs;
            }
            return $arr;
        }
        return NULL;
    }
}
?>