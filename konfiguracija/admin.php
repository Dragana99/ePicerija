<?php
class Admin
{
    function __construct($conn, $ime_prezime, $username, $password)
    {
        $this->conn = $conn;
        $this->ime_prezime = $ime_prezime;
        $this->username = $username;
        $this->password = $password;
        //$this->password = md5($password); kriptovan password
        
        include_once dirname(getcwd()) . '/konfiguracija/konekcija.php';
        // $conn = new Konekcija();
        $this->konekcija = $this->conn->getConnection();
    }

    function dodaj($conn)
    {
        $sql = "INSERT INTO admin SET 
                ime_prezime='{$this->ime_prezime}',
                username='{$this->username}',
                password='{$this->password}'
            ";
        //3. Izvršavanje upita i čuvanje podataka u bazu
        $rezultat = mysqli_query($conn, $sql) or die(mysqli_error());
        //4. Provera da li su (Upiti izvršeni) podaci uneti ili ne i prikaz adekvatne poruke
        if ($rezultat == TRUE) {
            //Podaci su uneti
            //echo "Podaci Uneti";
            //Kreiranje varijable sesije za prikaz poruke
            $_SESSION['add'] = "<div class='uspesno'>Admin dodat uspešno.</div>";
            //Redirekcija ka stranici za upravljanje adminom
            header("location:" . SITEURL . 'admin/upravljaj-adminom.php');
        } else {
            //Neuspešno uneti podaci 
            //echo "Neuspešan unos";
            //Kreiranje varijable sesije za prikaz poruke
            $_SESSION['add'] = "<div class='greska'>Admin neuspešno dodat.</div>";
            //Redirekcija stranice za dodavanje admina
            header("location:" . SITEURL . 'admin/dodaj-admina.php');
        }
    }
}
