<?php

class Konekcija
    {
        private $server = "localhost";
        private $username = "root";
        private $password ="";
        private $database = "epicerija";
        public  $konekcija;
      
        public function otvoriKonekciju()
        {
            $this->konekcija = mysqli_connect($this->server, $this->username, $this->password, $this->database);
            if (!$this->konekcija) 
            {
                echo('Nije uspostavljena veza sa bazom podataka!');
                echo "<br/>";
            }
            return $this->konekcija;
        } 
    
        public function zatvoriKonekciju($pkonekcija)
        {
            mysqli_close($pkonekcija);
        } 
    } 
?>
