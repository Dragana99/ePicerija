<?php include('osnovni-delovi-stranica/menu.php'); ?>

    <?php 
        //Provera da li je postavljen id pice
        if(isset($_GET['pica_id']))
        {
            //Uzimanje id-a selektovane pice
            $pica_id = $_GET['pica_id'];

            //Uzimanje detalja selektovane pice
            $sql = "SELECT * FROM pica WHERE id=$pica_id";
			
            //Izvrsavanje upita
            $rezultat = mysqli_query($conn, $sql);
			
            //Brojanje redova
            $broj = mysqli_num_rows($rezultat);
			
            //Provera da li su podaci dostupni ili ne
            if($broj==1)
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

                        <p class="cena-pice">din.<?php echo $cena; ?></p>
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
                    <input type="tel" name="kontakt_tel" placeholder="npr. 0643xxxxxx" class="unos-responsive" required>

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

                    $kupac = $_POST['kupac'];
                    $kontakt-tel = $_POST['kontakt-tel'];
                    $email = $_POST['email'];
                    $adresa = $_POST['adresa'];


                    //Zabelezi porudzbinu u bazu podataka
                    //Kreiranje SQL-a radi cuvanja podataka
                    $sql2 = "INSERT INTO porudzbina SET 
                        pica = '$pica',
                        cena = $cena,
                        kolicina = $kolicina,
                        ukupno = $ukupno,
                        datum = '$datum',
                        status = '$status',
                        kupac = '$kupac',
                        kontakt-tel = '$kontakt-tel',
                        email = '$email',
                        adresa = '$adresa'
                    ";

                    //echo $sql2; die();

                    //Izvrsavanje upita
                    $rezultat2 = mysqli_query($conn, $sql2);

                    //Provera uspesnosti upita
                    if($rezultat2==true)
                    {
                        //Upit izvrsen, porudzbina je sacuvana
                        $_SESSION['porudzbina'] = "<div class='success centriran-text'>Uspesno izvrsena porudzbina.</div>";
                        header('location:'.SITEURL);
                    }
                    else
                    {
                        //Neuspesno sacuvana porudzbina
                        $_SESSION['porudzbina'] = "<div class='error centriran-text'>Neuspesno izvrsena porudzbina.</div>";
                        header('location:'.SITEURL);
                    }

                }
            
            ?>

        </div>
    </section>
    <!-- Sekcija - Pretraga pice - se ovde zavrsava -->

    <?php include('osnovni-delovi-stranica/footer.php'); ?>
