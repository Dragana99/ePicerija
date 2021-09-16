<?php 
include('osnovni-delovi-stranica/menu.php'); 
include_once 'klase/PicaKlasa.php';
include_once 'klase/PorudzbinaKlasa.php';
$pice = new Pica();
$porudzbine = new Porudzbina();
?>

    <?php 
        //Provera da li je postavljen id pice
        if(isset($_GET['pica_id']))
        {
            //Uzimanje id-a selektovane pice
            $pica_id = $_GET['pica_id'];

            //Poziv funkcije za prikaz detalja pice sa određenim id-em
            $rezultat = $pice->prikazSaIdPice2($pica_id);
			
            //Provera da li su podaci dostupni ili ne
            if(mysqli_num_rows($rezultat)==1)
            {
                //Dostupni podaci
                //Uzimanje podataka iz baze
                $row = mysqli_fetch_assoc($rezultat);

                $naziv = $row['naziv'];
                $cena = $row['cena'];
                $naziv_slike = $row['naziv_slike'];
            }
            else
            {
                //Pica nije dostupna
                //Redirekcija ka pocetnoj stranici
                header('location:'.SITEURL);
            }
        }
        else
        {
            //Redirekcija ka pocetnoj stranici
            header('location:'.SITEURL);
        }
    ?>

    <!-- Sekcija - Pretraga pice -->
    <section class="pretraga-pice">
        <div class="kontejner">
            
            <h2 class="centriran-text beli-text">Popunite formu za potvrdu porudžbine.</h2>

            <form action="" method="POST" class="porudzbina">
                <fieldset>
                    <legend>Selektovana pica</legend>

                    <div class="pica-menu-slika">
                        <?php 
                        
                            //Provera da li je slika dostupna ili ne
                            if($naziv_slike=="")
                            {
                                //Slika nije dostupna
                                echo "<div class='error'>Slika nije dostupna.</div>";
                            }
                            else
                            {
                                //Slika je dostupna
                                ?>
                                <img src="<?php echo SITEURL; ?>slike/pice/<?php echo $naziv_slike; ?>" alt="margarita" class="responsive-slike slike-curve">
                                <?php
                            }
                        ?>
                        
                    </div>
    
                    <div class="pica-menu-opis">
                        <h3><?php echo $naziv; ?></h3>
                        <input type="hidden" name="pica" value="<?php echo $naziv; ?>">

                        <p class="cena-pice"><?php echo $cena; ?>din.</p>
                        <input type="hidden" name="cena" value="<?php echo $cena; ?>">

                        <div class="oznaka-porudzbine">Količina</div>
                        <input type="broj" name="kolicina" class="unos-responsive" value="1" required>
                        
                    </div>

                </fieldset>
                
                <fieldset>
                    <legend>Detalji dostave:</legend>
                    <div class="oznaka-porudzbine">Ime i prezime</div>
                    <input type="text" name="kupac" placeholder="npr. Petar Petrovic" class="unos-responsive" required>

                    <div class="oznaka-porudzbine">Broj telefona</div>
                    <input type="number" name="kontakt_tel" placeholder="npr. 0643xxxxxx" class="unos-responsive" required>

                    <div class="oznaka-porudzbine">Email</div>
                    <input type="email" name="email" placeholder="npr. pp@gmail.com" class="unos-responsive" required>

                    <div class="oznaka-porudzbine">Adresa</div>
                    <textarea name="adresa" rows="10" placeholder="npr. Nikole Pasica 10" class="unos-responsive" required></textarea>

                    <input type="submit" name="potvrdi" value="Potvrdi porudžbinu" class="btn btn-stil">
                </fieldset>

            </form>

            <?php 

                //Provera da li je dugme - Potvrdi - pritisnuto
                if(isset($_POST['potvrdi']))
                {
                    //Uzimanje detalja iz forme
                    $pica = $_POST['pica'];
                    $cena = $_POST['cena'];
                    $kolicina = $_POST['kolicina'];

                    $ukupno = $cena * $kolicina; // ukupno = cena x kolicina 

                    $datum = date("Y-m-d h:i:sa"); //Datum i vreme porudzbine

                    $status = "Poruceno";  //Poruceno, Dostava u toku, Dostavljeno, Otkazano

                    //postavljanje vrednosti u promenjljive
                    $kupac = $_POST['kupac'];
                    $kontakt_tel = $_POST['kontakt_tel'];
                    $email = $_POST['email'];
                    $adresa = $_POST['adresa'];


                    //Poziv funkcije za smeštanje podataka o porudžbini
                    $rezultat2 = $porudzbine->sacuvajPorudzbinu($pica, $cena, $kolicina, $ukupno, $datum, $status, $kupac, $kontakt_tel, $email, $adresa);
                    
                    //Provera uspešnosti upita
                    if($rezultat2==true)
                    {
                        //Upit izvršen, porudžbina je sačuvana
                        $_SESSION['porudzbina'] = "<div class='success centriran-text'>Porudžbina je uspešno primljena.</div>";
                        header('location:'.SITEURL);
                    }
                    else
                    {
                        //Neuspešno sačuvana porudžbina
                        $_SESSION['porudzbina'] = "<div class='error centriran-text'>Neuspešno izvršena porudžbina.</div>";
                        header('location:'.SITEURL);
                    }

                }
            
            ?>

        </div>
    </section>
    <!-- Sekcija - Pretraga pice - se ovde završava -->

    <?php include('osnovni-delovi-stranica/footer.php'); ?>
