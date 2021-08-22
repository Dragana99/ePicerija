<?php include('osnovni-delovi-stranica/menu.php'); ?>

<?php 
    //Provera da li je prosao id
    if(isset($_GET['id_vrste']))
    {
        //Postavljenje id vrste
        $id_vrste = $_GET['id_vrste'];
        $sql = "SELECT naziv FROM vrsta WHERE id=$id_vrste";

        //Izvrsavanje upita
        $rezultat = mysqli_query($conn, $sql);

        //Uzimanje vrednosti iz baze
        $red = mysqli_fetch_assoc($rezultat);
        //Postavljanje naziva vrste
        $naziv_vrste = $red['naziv'];
    }
    else
    {
        //Redirekcija na home page
        header('location:'.SITEURL);
    }
?>


<!-- Sekcija pretrage pice -->
<section class="pretraga-pice centriran-text">
    <div class="kontejner">
        
        <h2>Pice <a href="#" class="beli-text">"<?php echo $naziv_vrste; ?>"</a></h2>

    </div>
</section>
<!-- kraj sekcije pretrage pice -->



<!-- Sekcija pizza menu -->
<section class="pica-menu">
    <div class="kontejner">
        <h2 class="centriran-text">Pizza menu</h2>

        <?php 
        
            //SQL upit za uzimanje pice iz odredjene kategorije
            $sql2 = "SELECT * FROM pica WHERE id_vrste=$id_vrste";

            //Izvrsavanje upita
            $rezultat2 = mysqli_query($conn, $sql2);

            //Count the reds
            $ukupno = mysqli_num_rows($rezultat2);

            //CHeck whether food is available or not
            if($ukupno>0)
            {
                //Food is Available
                while($red2=mysqli_fetch_assoc($rezultat2))
                {
                    $id = $red2['id'];
                    $naziv = $red2['naziv'];
                    $cena = $red2['cena'];
                    $opis = $red2['opis'];
                    $naziv_slike = $red2['naziv_slike'];
                    ?>
                    
                    <div class="pica-menu-box">
                        <div class="pica-menu-slika">
                            <?php 
                                if($naziv_slike=="")
                                {
                                    //Slika nije dostupna
                                    echo "<div class='error'>Slika nije dostupna.</div>";
                                }
                                else
                                {
                                    //Slika dostupna
                                    ?>
                                    <img src="<?php echo SITEURL; ?>slike/pice/<?php echo $naziv_slike; ?>" alt="Pizza" class="responsive-slika slika-curve">
                                    <?php
                                }
                            ?>
                            
                        </div>

                        <div class="pica-menu-opis">
                            <h4><?php echo $naziv; ?></h4>
                            <p class="cena-pice">$<?php echo $cena; ?></p>
                            <p class="detalji-pice">
                                <?php echo $opis; ?>
                            </p>
                            <br>

                            <a href="<?php echo SITEURL; ?>porudzbina.php?pica_id=<?php echo $id; ?>" class="btn btn-stil">Poruči</a>
                        </div>
                    </div>

                    <?php
                }
            }
            else
            {
                //Pica nije nadjena
                echo "<div class='error'>Pica nije nadjena.</div>";
            }
        
        ?>

        <div class="fiksiran"></div>
  
    </div>
</section>
<!-- Kraj pizza menu sekcije -->


<?php include('osnovni-delovi-stranica/footer.php'); ?>