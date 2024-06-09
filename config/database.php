<?php
require 'constants.php';
/*
    *PDO Database Class
    *Connect to database
    *create prepared statements
    *bind Values
    *return rows and results
*/

class Database{
    private $host = 'localhost';
    private $user = 'root';
    private $pass = '';
    private $dbname = 'pdo';
    // will be the pdo object
    private $dbh;
    private $stmt;
    private $error;

    public function __construct()
    {
        // set dsn
        $dsn = 'mysql:host='.$this->host.';dbname='.$this->dbname;
        $options = array(
            PDO::ATTR_PERSISTENT => true,
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
        );
        // Create PDO instance
        try{
            $this->dbh = new PDO($dsn, $this->user, $this->pass, $options);
        }catch(PDOException $e){
            $this->error = $e->getMessage();
            echo $this->error;
        }
    }

    // prepare statement with query
    public function query($sql){
        $this->stmt = $this->dbh->prepare($sql);
    }

    // bind values to prepared statement using named parameters
    public function bind($param, $value, $type = null){
        if(is_null($type)){
            switch (true) {
                case is_int($value):
                    # code...
                    $type = PDO::PARAM_INT;
                    break;
                case is_bool($value):
                    # code...
                    $type = PDO::PARAM_BOOL;
                    break;
                case is_null($value):
                    # code...
                    $type = PDO::PARAM_NULL;
                    break;
                
                default:
                    # code...
                    $type = PDO::PARAM_STR;
                    
            }
        }
        $this->stmt->bindValue($param, $value, $type);
    }
    // execute the prepared statement
    public function execute(){
        return $this->stmt->execute();
    }

    // return multiple records
    public function resultSet(){
        $this->execute();
        return $this->stmt->fetchAll(PDO::FETCH_OBJ);
    }

    // return single records
    public function single(){
        $this->execute();
        return $this->stmt->fetch(PDO::FETCH_OBJ);
    }

    // get row count
    public function rowCount(){
        return $this->stmt->rowCount();
    }
}
?>