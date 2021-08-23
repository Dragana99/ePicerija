<?php include('osnovni-delovi-stranica/menu.php'); ?>

<!-- Sekcija pretrage pica -->
<section class="pretraga-pice centriran-text">
    <div class="kontejner">
        
        <form action="<?php echo SITEURL; ?>pretraga-pice.php" method="POST">
            <input type="search" name="pretraga" placeholder="Pretraga pice.." required>
            <input type="submit" name="submit" value="Pretraga" class="btn btn-stil">
        </form>

    </div>
</section>
<!-- Kraj sekcije za pretragu pice -->

<?php 
    if(isset($_SESSION['porudzbina']))
    {
        echo $_SESSION['porudzbina'];
        unset($_SESSION['porudzbina']);
    }
?>

<!-- Sekcija za vrste pice -->
<section class="kategorije">
    <div class="kontejner">
        <h2 class="centriran-text">Pretraga pice</h2>

        <?php 
            //Kreiranje SQL upita za prikaz svih vrsta pica
            $sql = "SELECT * FROM vrsta WHERE u_prodaji='Da' LIMIT 3";
            //Izvrsavanje upita
            $rezultat = mysqli_query($conn, $sql);
            //Broj redova vrsta pica
            $broj = mysqli_num_rows($rezultat);

            if($broj>0)
            {
                //Vrste u prodaji
                while($red=mysqli_fetch_assoc($rezultat))
                {
                    //Postavljanje vrednosti
                    $id = $red['id'];
                    $naziv = $red['naziv'];
                    $naziv_slike = $red['naziv_slike'];
                    ?>
                    
                    <a href="<?php echo SITEURL; ?>vrste-pice.php?id_vrste=<?php echo $id; ?>">
                        <div class="box-3 float-kontejner">
                            <?php 
                                //Provera da li je slika nadjena
                                if($naziv_slike=="")
                                {
                                    //Prikaz poruke
                                    echo "<div class='error'>Slika nije nadjena</div>";
                                }
                                else
                                {
                                    //Slika je nadjena
                                    ?>
                                    <img src="<?php echo SITEURL; ?>slike/vrste/<?php echo $naziv_slike; ?>" alt="Pizza" class="responsive-slike slike-curve">
                                    <?php
                                }
                            ?>
                            

                            <h3 class="float-text beli-text"><?php echo $naziv; ?></h3>
                        </div>
                    </a>

                    <?php
                }
            }
            else
            {
                //Vrste nisu dostupne
                echo "<div class='error'>Vrste nisu dostupne.</div>";
            }
        ?>


        <div class="fiksiran"></div>
    </div>
</section>
<!-- Kraj sekcije vrsta -->



<!-- Sekcija pica menu -->
<section class="pica-menu">
    <div class="kontejner">
        <h2 class="centriran-text">Pizza menu</h2>

        <?php 
        
        //Getting Foods from Database that are active and featured
        //SQL Query
        $sql2 = "SELECT * FROM pica WHERE u_prodaji='Da' LIMIT 6";

        //Izvrsavanje upita
        $rezultat2 = mysqli_query($conn, $sql2);

        //Broj redova
        $broj2 = mysqli_num_rows($rezultat2);

        //Provera da li su pice u prodaji
        if($broj2>0)
        {
            //Pice u prodaji
            while($red=mysqli_fetch_assoc($rezultat2))
            {
                //Vrednosti
                $id = $red['id'];
                $naziv = $red['naziv'];
                $cena = $red['cena'];
                $opis = $red['opis'];
                $naziv_slike = $red['naziv_slike'];
                ?>

                <div class="pica-menu-box">
                    <div class="pica-menu-slika">
                        <?php 
                            //Provera da li je slika dostupna
                            if($naziv_slike=="")
                            {
                                //Slika nije dostupna.
                                echo "<div class='error'>Slika nije dostupna.</div>";
                            }
                            else
                            {
                                //Slika je dostupna.
                                ?>
                                <img src="<?php echo SITEURL; ?>slike/pice/<?php echo $naziv_slike; ?>" alt="Pizza" class="responsive-slike slike-curve">
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
            //Pice koje nisu dostupne - nisu u prodaji
            echo "<div class='error'>Pice nisu u prodaji.</div>";
        }

        ?>

        <div class="fiksiran"></div>

    </div>

</section>
<!-- Kraj pizza menu sekcije -->


<?php include('osnovni-delovi-stranica/footer.php'); ?>