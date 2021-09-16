<?php
class Vrsta
{
    private $konekcija;

    function __construct() 
    {
        include_once "KonekcijaKlasa.php";
        $conn = new Konekcija();
        $this->konekcija = $conn->otvoriKonekciju();
    }
   
    //Funkcija za dodavanje nove vrste pice
    public function dodajVrstu($naziv, $naziv_slike, $u_prodaji)
    {
        $sqlUpit = "INSERT INTO `vrsta`(`id`, `naziv`, `naziv_slike`, `u_prodaji`) VALUES (NULL, '$naziv', '$naziv_slike', '$u_prodaji')";
        $rezultat = mysqli_query($this->konekcija, $sqlUpit);
        return $rezultat;   
    }
    
    //Funkcija za prikaz svih vrsta u bazi podataka
    public function sveVrste()
    {
        $sqlUpit="SELECT * FROM vrsta";
        $rezultat = mysqli_query($this->konekcija, $sqlUpit);
        return $rezultat; 
    }
    
    //Funkcija za prikaz podataka vrste sa određenim id-em
    public function prikazSaIdVrste($id)
    {
        $sqlUpit=" SELECT * FROM `vrsta` WHERE `id` = $id";
        $rezultat = mysqli_query($this->konekcija, $sqlUpit);
        return $rezultat; 
    }

    //Funkcija za prikaz svih vrsta u prodaji
    public function prikazVrstaUProdaji()
    {
        $sqlUpit="SELECT * FROM `vrsta` WHERE `u_prodaji`= 'Da'";
        $rezultat = mysqli_query($this->konekcija, $sqlUpit);
        return $rezultat; 
    }

    //Funkcija za brisanje vrste sa određenim id-em
    public function obrisiVrstu($id)
    {
        $sqlUpit=" DELETE FROM `vrsta` WHERE `id`= $id";
        $rezultat = mysqli_query($this->konekcija, $sqlUpit);
        return $this->konekcija->affected_rows; 
    }

    //funkcija za izmenu vrste sa određenim id-em
    public function izmeniVrstu($id, $naziv, $naziv_slike, $u_prodaji)
    {
        $sqlUpit="UPDATE vrsta SET naziv='$naziv', naziv_slike='$naziv_slike', u_prodaji='$u_prodaji' WHERE id='$id'";
        $rezultat2 = mysqli_query($this->konekcija, $sqlUpit);
        return $rezultat2;  
    }

    function __destruct() 
    {
        unset($this->konekcija);
    }

}
?>
