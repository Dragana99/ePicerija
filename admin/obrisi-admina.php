<?php 

    //Uključivanje fajla konekcije
    include('../konfiguracija/konekcija.php');

    // 1.Uzimanje id-a admina koji će biti obrisan
    $id = $_GET['id'];

    //2. SQL upit za brisanje admina
    $sql = "DELETE FROM admin WHERE id=$id";

    //Izvršavanje upita
    $rezultat = mysqli_query($conn, $sql);

    // Provera uspešnosti izvršavanja upita
    if($rezultat==true)
    {
        //Upit je uspišno izvršen i admin je obrisan
        //echo "Admin obrisan";
        //Kreiranjje varijable sesije(procesa) za prikaz poruke
        $_SESSION['delete'] = "<div class='uspesno'>Admin je uspešno obrisan.</div>";
        //Redirekcija ka stranici - upravljaj adminom
        header('location:'.SITEURL.'admin/upravljaj-adminom.php');
    }
    else
    {
        //Neuspešno brisanje admina
        //echo "Admin neuspešno obrisan";

        $_SESSION['delete'] = "<div class='greska'>Neuspešno brisanje admina. Pokušajte ponovo.</div>";
        header('location:'.SITEURL.'admin/upravljaj-adminom.php');
    }

?>