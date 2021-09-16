<?php
//Sesija
session_start();

define('SITEURL', 'http://localhost/ePicerija-2/');
define('LOCALHOST', 'localhost');
define('DB_USERNAME', 'root');
define('DB_PASSWORD', '');
define('DB_NAME', 'epicerija');

include 'klasa-konekcija.php';

$conn = new Konekcija();
$conn = $conn->getConnection();

?>