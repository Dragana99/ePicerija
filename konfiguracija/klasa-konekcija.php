<?php
class Konekcija
{
    private $localhost = LOCALHOST;
    private $db_username = DB_USERNAME;
    private $db_password = DB_PASSWORD;

    function __construct()
    {
        $this->connQuery = mysqli_connect($this->localhost, $this->db_username, $this->db_password) or die(mysqli_error()); //Kpnekcija sa bazom
        mysqli_select_db($this->connQuery, DB_NAME) or die(mysqli_error());
    }

    function getConnection()
    {
        return $this->connQuery;
    }
}
?>