<?php
class Pica
{
    private $konekcija;

    function __construct() 
    {
        include_once "KonekcijaKlasa.php";
        $conn = new Konekcija();
        $this->konekcija = $conn->otvoriKonekciju();
    }
   
    //Funkcija za dodavanje nove pice
    public function dodajPicu($naziv, $opis, $cena, $naziv_slike, $vrsta_pice, $u_prodaji)
    {
        $sqlUpit = "INSERT INTO `pica`(`id`, `naziv`, `opis`, `cena`, `naziv_slike`, `id_vrste`, `u_prodaji`) VALUES (NULL, '$naziv', '$opis', '$cena', '$naziv_slike', '$vrsta_pice', '$u_prodaji')";
        $rezultat2 = mysqli_query($this->konekcija, $sqlUpit);
        return $rezultat2;   
    }

    //Funkcija za prikaz svih pica u bazi podataka
    public function svePice()
    {
        $sqlUpit="SELECT * FROM pica";
        $rezultat = mysqli_query($this->konekcija, $sqlUpit);
        return $rezultat; 
    }
    
    //Funkcija za prikaz podataka pice sa određenim id-em
    public function prikazSaIdPice($id)
    {
        $sqlUpit=" SELECT * FROM `pica` WHERE `id` = $id";
        $rezultat2 = mysqli_query($this->konekcija, $sqlUpit);
        return $rezultat2; 
    }

    //Funkcija za brisanje pice sa određenim id-em
    public function obrisiPicu($id)
    {
        $sqlUpit=" DELETE FROM `pica` WHERE `id`= $id";
        $rezultat = mysqli_query($this->konekcija, $sqlUpit);
        return $this->konekcija->affected_rows; 
    }

    //funkcija za izmenu pice sa određenim id-em
    public function izmeniPicu($id, $naziv, $opis, $cena, $naziv_slike, $vrsta, $u_prodaji)
    {
        $sqlUpit="UPDATE pica SET naziv='$naziv', opis='$opis', cena='$cena', naziv_slike='$naziv_slike', id_vrste='$vrsta', u_prodaji='$u_prodaji' WHERE id='$id'";
        $rezultat2 = mysqli_query($this->konekcija, $sqlUpit);
        return $rezultat2;  
    }

    //Funkcija za izvršavanje pretrage pica po unetoj ključnoj reči
    public function pretraziPice($pretraga)
    {
        $sqlUpit=" SELECT * FROM `pica` WHERE `naziv` LIKE '%$pretraga%' OR `opis` LIKE '%$pretraga%'";
        $rezultat = mysqli_query($this->konekcija, $sqlUpit);
        return $rezultat; 
    }

    //Funkcija za prikaz podataka pice sa određenim id-em
    public function prikazSaIdPice2($pica_id)
    {
        $sqlUpit=" SELECT * FROM `pica` WHERE `id` = $pica_id";
        $rezultat2 = mysqli_query($this->konekcija, $sqlUpit);
        return $rezultat2; 
    }

    function __destruct() 
    {
        unset($this->konekcija);
    }

}
?>
