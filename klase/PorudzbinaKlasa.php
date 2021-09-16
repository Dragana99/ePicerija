<?php
class Porudzbina
{
    private $konekcija;

    function __construct() 
    {
        include_once "KonekcijaKlasa.php";
        $conn = new Konekcija();
        $this->konekcija = $conn->otvoriKonekciju();
    }
   
    //Funkcija za prikaz svih porudžbina iz baze podataka
    public function svePorudzbine()
    {
        $sqlUpit="SELECT * FROM `porudzbina` ORDER BY `id` DESC";
        $rezultat = mysqli_query($this->konekcija, $sqlUpit);
        return $rezultat; 
    }
    
    //Funkcija za prikaz podataka porudžbine sa određenim id-em
    public function prikazSaIdPorudzbine($id)
    {
        $sqlUpit=" SELECT * FROM `porudzbina` WHERE `id` = $id";
        $rezultat = mysqli_query($this->konekcija, $sqlUpit);
        return $rezultat; 
    }

    //Funkcija za čuvanje podataka o porudžbini
    public function sacuvajPorudzbinu($pica, $cena, $kolicina, $ukupno, $datum, $status, $kupac, $kontakt_tel, $email, $adresa)
    {
        $kupac = mysqli_real_escape_string($this->konekcija, $kupac);

        $sqlUpit="INSERT INTO `porudzbina` (`id`, `pica`, `cena`, `kolicina`, `ukupno`, `datum`, `status`, `kupac`, `kontakt_tel`, `email`, `adresa`) VALUES (NULL, '$pica', '$cena', '$kolicina', '$ukupno', '$datum', '$status', '$kupac', '$kontakt_tel', '$email', '$adresa')";
        $rezultat2 = mysqli_query($this->konekcija, $sqlUpit);
        return $rezultat2; 
    }

    //funkcija za izmenu podataka o porudžbini sa određenim id-em
    public function izmeniPorudzbinu($id, $kolicina, $ukupno, $status, $kupac, $kontakt_tel, $email, $adresa)
    {
        $sqlUpit="UPDATE `porudzbina` SET kolicina='$kolicina', ukupno='$ukupno', status='$status', kupac='$kupac', kontakt_tel='$kontakt_tel', email='$email', adresa='$adresa' WHERE id='$id'";
        $rezultat2 = mysqli_query($this->konekcija, $sqlUpit);
        return $rezultat2;  
    }

    function __destruct() 
    {
        unset($this->konekcija);
    }

}
?>
