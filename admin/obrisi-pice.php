<?php 
    //Uključivanje fajla konekcije
    include('../konfiguracija/konekcija.php');
    include_once '../klase/PicaKlasa.php';
    $pice = new Pica();

    //echo "Obriši stranicu";
    if(isset($_GET['id']) && isset($_GET['naziv_slike'])) //'&&' ili 'AND'
    {
        //1.Uzimanje id-a i naziva slike
        $id = $_GET['id'];
        $naziv_slike = $_GET['naziv_slike'];

        //2. Brisanje slike ukoliko je dostupna
        //Provera da li je slika dostupna i brisanje samo ukoliko jeste
        if($naziv_slike != "")
        {
            // slika je dostupna i briše se iz fajla
            //Uzimanje putanje slike
            $path = "../slike/pice/".$naziv_slike;

            //Brisanje fajla slike iz foldera
            $remove = unlink($path);

            //Provera da li je slika obrisana ili ne
            if($remove==false)
            {
                //Neuspešno brisanje slike
                $_SESSION['upload'] = "<div class='greska'>Slika je neuspešno obrisana.</div>";
                //Redirekcija ka stranici - upravljaj picama
                header('location:'.SITEURL.'admin/upravljaj-picama.php');
                //Stopiranje procesa brisanja pice
                die();
            }

        }

        //3.Brisanje pice iz baze
        $rezultat = $pice->obrisiPicu($id);

        //Provera da li je upit izvršen i postavljanje poruke sesije(procesa)
        //4.Redirekcija ka stranici - upravljaj picama uz poruku
        if($rezultat==true)
        {
            //Pica je uklonjena
            $_SESSION['delete'] = "<div class='uspesno'>Pica je uspešno obrisana.</div>";\
            header('location:'.SITEURL.'admin/upravljaj-picama.php');
        }
        else
        {
            //Neuspešno brisanje
            $_SESSION['delete'] = "<div class='greska'>Neuspešno obrisana pica.</div>";\
            header('location:'.SITEURL.'admin/upravljaj-picama.php');
        }

    }
    else
    {
        //Redirekcija ka stranici - upravljaj picama
        //echo "Redirekcija";
        $_SESSION['unauthorize'] = "<div class='greska'>Neautorizovan pristup.</div>";
        header('location:'.SITEURL.'admin/upravljaj-picama.php');
    }

?>
