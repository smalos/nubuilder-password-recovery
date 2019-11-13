<?php
// 'user' object
class User
{

    // database connection and table name
    private $conn;
    private $table_user = "zzzzsys_user";
    private $table_password_request = "password_request";

    // object properties
    public $id;
    public $username;
    public $email;
    public $date_requested;
    public $password;
    public $access_code;

    // constructor
    public function __construct($db)
    {
        $this->conn = $db;
    }

    // check if given email exist in the database
    function emailExists()
    {

        // query to check if email exists
        $query = "SELECT zzzzsys_user_id as id, 
			  '' as firstname, '' as lastname, 
			  sus_name as username, 
			  sus_zzzzsys_access_id as access_level, 
			  sus_login_password as password, '' as status
            FROM " . $this->table_user . "
            WHERE sus_email = ?
            LIMIT 0,1";

        // prepare the query
        $stmt = $this
            ->conn
            ->prepare($query);

        // sanitize
        $this->email = htmlspecialchars(strip_tags($this->email));

        // bind given email value
        $stmt->bindParam(1, $this->email);

        // execute the query
        $stmt->execute();

        // get number of rows
        $num = $stmt->rowCount();

        // if email exists, assign values to object properties for easy access and use for php sessions
        if ($num > 0)
        {

            // get record details / values
            $row = $stmt->fetch(PDO::FETCH_ASSOC);

            // assign values to object properties
            $this->id = $row['id'];
            $this->username = $row['username'];

            // return the id because email exists in the database
            return $this->id;
        }

        // return empty string if email does not exist in the database
        return "";
    }

    // in sert the user id, email, expiration and access code into a table
    function insertAccessCode($id)
    {

        $insertSql = "INSERT INTO " . $this->table_password_request . " (pw_user_id, pw_email, pw_expiration, pw_access_code)
					VALUES
					(:id, :email, :expiration, :access_code)";

        //Prepare our INSERT SQL statement.
        $stmt = $this
            ->conn
            ->prepare($insertSql);

        // sanitize
        $this->access_code = htmlspecialchars(strip_tags($this->access_code));
        $this->email = htmlspecialchars(strip_tags($this->email));
        $this->id = htmlspecialchars(strip_tags($id));

        // bind the values from the form
        $stmt->bindParam(':access_code', $this->access_code);
        $stmt->bindParam(':email', $this->email);
        $stmt->bindParam(':id', $this->id);

        $access_code_duration = 3600; // 1h
        $expiration = date('Y-m-d H:i:s', time() + $access_code_duration);
        $stmt->bindParam(':expiration', $expiration, PDO::PARAM_STR);

        // execute the query
        if ($stmt->execute())
        {
            return true;
        }

        return false;
    }

    // check if given access_code exists in the database
    // and if the password has not been used and not expired
    function accessCodeExists()
    {

        // query to check if access_code exists and unused
        $query = "SELECT pw_user_id as id
            FROM " . $this->table_password_request . "
            WHERE 
				 pw_access_code = :access_code AND pw_usedate is NULL
				 AND pw_expiration > :expiration
            LIMIT 0,1";

        // prepare the query
        $stmt = $this
            ->conn
            ->prepare($query);

        // sanitize
        $this->access_code = htmlspecialchars(strip_tags($this->access_code));

        // bind given access_code value
        $stmt->bindParam('access_code', $this->access_code);

        $expiration = date('Y-m-d H:i:s');
        $stmt->bindParam(':expiration', $expiration, PDO::PARAM_STR);

        // execute the query
        $stmt->execute();

        // get number of rows
        $num = $stmt->rowCount();

        // if access_code exists
        if ($num > 0)
        {

            // get record details / values
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            // assign values to object properties
            $this->id = $row['id'];

            // return the id  because access_code exists in the database
            return $this->id;
        }

        // return empty string if access_code does not exist in the database
        return "";

    }

    // Update the nuBuilder password
    function updatePassword($id)
    {

        // update query
        $query = "UPDATE " . $this->table_user . "
            SET sus_login_password = :password
            WHERE zzzzsys_user_id = :id";

        // prepare the query
        $stmt = $this
            ->conn
            ->prepare($query);

        // sanitize
        $this->password = htmlspecialchars(strip_tags($this->password));
        $this->id = htmlspecialchars(strip_tags($id));

        // bind the values from the form
        $password_hash = md5($this->password);
        $stmt->bindParam(':password', $password_hash);
        $stmt->bindParam(':id', $this->id);

        // execute the query
        if ($stmt->execute())
        {
            return true;
        }

        return false;
    }

    // Once the password was changed, we update the record with the use date
    function setAccessCodeUsed($access_code)
    {

        // update query
        $query = "UPDATE " . $this->table_password_request . "
            SET pw_usedate = :usedate
            WHERE pw_access_code = :access_code";

        // prepare the query
        $stmt = $this
            ->conn
            ->prepare($query);

        // sanitize
        $this->access_code = htmlspecialchars(strip_tags($access_code));

        // bind the values from the form
        $stmt->bindParam(':access_code', $this->access_code);

        $usedate = date('Y-m-d H:i:s');
        $stmt->bindParam(':usedate', $usedate, PDO::PARAM_STR);

        // execute the query
        if ($stmt->execute())
        {
            return true;
        }

        return false;
    }

}

