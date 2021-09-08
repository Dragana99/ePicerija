<?php 
    //Uključivanje fajla konekcije
    include('../konfiguracija/konekcija.php');

    //echo "Obriši stranicu";
    //Provera da li su id i naziv_slike postavljeni ili ne
    if(isset($_GET['id']) AND isset($_GET['naziv_slike']))
    {
        //Uzimanje vrednosti i brisanje
        //echo "Uzmi podatke i obriši";
        $id = $_GET['id'];
        $naziv_slike = $_GET['naziv_slike'];

        //Fizičko brisanje slike ukoliko je dostupna
        if($naziv_slike != "")
        {
            //Slika je dostupna, dakle briše se.
            $path = "../slike/vrste/".$naziv_slike;
            //Brisanje slike
            $remove = unlink($path);

            //Ukoliko je brisanje slike neuspešno dodaje se poruka o grešci i stopira proces
            if($remove==false)
            {
                //Postavljanje poruke procesa(sesije)
                $_SESSION['remove'] = "<div class='greska'>Neuspešno brisanje slike vrste.</div>";
                //Redirekcija ka stranici - upravljaj vrstom
                header('location:'.SITEURL.'admin/upravljaj-vrstom.php');
                //Stopiranje procesa
                die();
            }
        }

        //Brisanje podataka iz baze
        //SQL za brisanje podataka iz baze
        $sql = "DELETE FROM vrsta WHERE id=$id";

        //Izvršavanje upita
        $rezultat = mysqli_query($conn, $sql);

        //Provera da li su podaci obrisani iz baze ili ne
        if($rezultat==true)
        {
            //Postavljanje poruke o uspešnosti i redirekcija
            $_SESSION['delete'] = "<div class='uspesno'>Vrsta uspešno obrisana.</div>";
            //Redirekcija ka stranici - upravljaj vrstom
            header('location:'.SITEURL.'admin/upravljaj-vrstom.php');
        }
        else
        {
            //Postavljanje poruke o neuspešnosti
            $_SESSION['delete'] = "<div class='greska'>Neuspešno obrisana vrsta.</div>";
            //Redirekcija ka stranici - upravljaj vrstom
            header('location:'.SITEURL.'admin/upravljaj-vrstom.php');
        }

 

    }
    else
    {
        //Redirekcija ka stranici - upravljaj vrstom
        header('location:'.SITEURL.'admin/upravljaj-vrstom.php');
    }
?>