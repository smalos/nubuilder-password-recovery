<?php

// used to get database connection
class Database{
 
    public $conn;

    // get the database connection
    public function getConnection(){
		
		// include the nuBuider config file
		require __DIR__ . '/../../../nuconfig.php';
		
        $this->conn = null;
 
        try{            
			$this->conn = new PDO("mysql:host=$nuConfigDBHost;dbname=$nuConfigDBName", $nuConfigDBUser, $nuConfigDBPassword);

        }catch(PDOException $exception){
            echo "Connection error: " . $exception->getMessage();
        }
 
        return $this->conn;
    }
}

?>