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


<!-- Sekcija pizza menu -->
<section class="pica-menu">
    <div class="kontejner">
        <h2 class="centriran-text">Pizza menu</h2>

        <?php 
            //Prikaz svih pica koje su dostupne
            $sql = "SELECT * FROM pica WHERE u_prodaji='Da'";

            //Izvrsavanje upita
            $rezultat=mysqli_query($conn, $sql);

            //Broj redova
            $broj = mysqli_num_rows($rezultat);

            //Provera da li postoje dostupne pice
            if($broj>0)
            {

                while($red=mysqli_fetch_assoc($rezultat))
                {
                    //Postavljanje vrednosti
                    $id = $red['id'];
                    $naziv = $red['naziv'];
                    $opis = $red['opis'];
                    $cena = $red['cena'];
                    $naziv_slike = $red['naziv_slike'];
                    ?>
                    
                    <div class="pica-menu-box">
                        <div class="pica-menu-slika">
                            <?php 
                                //Provera li je slika dostupna
                                if($naziv_slike=="")
                                {
                                    //Slika nije dostupna
                                    echo "<div class='error'>Slika nije dostupna</div>";
                                }
                                else
                                {
                                    //Slika je dostupna
                                    ?>
                                    <img src="<?php echo SITEURL; ?>slike/pice/<?php echo $naziv_slike; ?>" alt="Pizza" class="responsive-slike slike-curve">
                                    <?php
                                }
                            ?>
                            
                        </div>

                        <div class="pice-menu-opis">
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
                //Pica nije pronadjena
                echo "<div class='error'>Pica nije nađena.</div>";
            }
        ?>

        <div class="fiksiran"></div>

    </div>

</section>
<!-- Kraj pizza menu -->

<?php include('osnovni-delovi-stranica/footer.php'); ?>