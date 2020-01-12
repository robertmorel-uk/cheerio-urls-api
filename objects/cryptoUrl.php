<?php
class CryptoUrl{
 
    // database connection and table name
    private $conn;
    private $table_name = "cryptourlentries";
 
    // object properties
    public $urlID;
    public $urlTitle;
    public $urlLink;
    public $urlDescription;
    public $urlSource;
    public $urlDate;
 
    // constructor with $db as database connection
    public function __construct($db){
        $this->conn = $db;
    }

    // read products
    function read(){
    
        // select all query
        $query = "SELECT
                    urlID, urlTitle, urlLink, urlDescription, urlSource, urlDate
                FROM
                    $this->table_name
                ORDER BY
                    urlID DESC";
    
        // prepare query statement
        $stmt = $this->conn->prepare($query);
    
        // execute query
        $stmt->execute();
    
        return $stmt;
    }

    // used when filling up the update product form
function readOne(){
 
    // query to read single record
    $query = "SELECT
                urlID, urlTitle, urlLink, urlDescription, urlSource, urlDate
            FROM
                $this->table_name
            WHERE
                urlID = ?
            LIMIT
                0,1";
 
    // prepare query statement
    $stmt = $this->conn->prepare( $query );
 
    // bind id of product to be updated
    $stmt->bindParam(1, $this->urlID);
 
    // execute query
    $stmt->execute();
 
    // get retrieved row
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
 
    // set values to object properties
    $this->urlID = $row['urlID'];
    $this->urlTitle = $row['urlTitle'];
    $this->urlLink = $row['urlLink'];
    $this->urlDescription = $row['urlDescription'];
    $this->urlSource = $row['urlSource'];
    $this->urlDate = $row['urlDate'];
}

// search products
function search($keywords){
 
    // select all query
    $query = "SELECT
                urlID, urlTitle, urlLink, urlDescription, urlSource, urlDate
            FROM
                $this->table_name
            WHERE
                urlTitle LIKE ? OR urlLink LIKE ? OR urlDescription LIKE ?
            ORDER BY
                urlID DESC";
 
    // prepare query statement
    $stmt = $this->conn->prepare($query);
 
    // sanitize
    $keywords=htmlspecialchars(strip_tags($keywords));
    $keywords = "%{$keywords}%";
 
    // bind
    $stmt->bindParam(1, $keywords);
    $stmt->bindParam(2, $keywords);
    $stmt->bindParam(3, $keywords);
 
    // execute query
    $stmt->execute();
 
    return $stmt;
}

// read products with pagination
public function readPaging($from_record_num, $records_per_page){
 
    // select query
    $query = "SELECT
                urlID, urlTitle, urlLink, urlDescription, urlSource, urlDate
            FROM
                $this->table_name
            ORDER BY
                urlID DESC
            LIMIT ?, ?";
 
    // prepare query statement
    $stmt = $this->conn->prepare( $query );
 
    // bind variable values
    $stmt->bindParam(1, $from_record_num, PDO::PARAM_INT);
    $stmt->bindParam(2, $records_per_page, PDO::PARAM_INT);
 
    // execute query
    $stmt->execute();
 
    // return values from database
    return $stmt;
}

// used for paging products
public function count(){
    $query = "SELECT COUNT(*) as total_rows FROM " . $this->table_name . "";
 
    $stmt = $this->conn->prepare( $query );
    $stmt->execute();
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
 
    return $row['total_rows'];
}


}
?>