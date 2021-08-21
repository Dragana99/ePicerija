<?php include('osnovni-delovi-stranica/menu.php'); ?>

<section class="pretraga-pice centriran-text">
    <div class="kontejner">
        
        <form action="<?php echo SITEURL; ?>pretraga-pice.php" method="POST">
            <input type="search" name="pretraga" placeholder="Pretraga pice.." required>
            <input type="submit" name="submit" value="Trazi" class="btn btn-stil">
        </form>

    </div>
</section>


<section class="pica-menu">
    <div class="kontejner">
        <h2 class="centriran-text">Pice Menu</h2>

        <?php 
            $sql = "SELECT * FROM pica WHERE u_prodaji='Da'";

            $rezultat=mysqli_query($conn, $sql);

            $broj = mysqli_num_reds($rezultat);

            if($broj>0)
            {
                while($red=mysqli_fetch_assoc($rezultat))
                {
                    $id = $red['id'];
                    $naziv = $red['naziv'];
                    $opis = $red['opis'];
                    $cena = $red['cena'];
                    $naziv_slike = $red['naziv_slike'];
                    ?>
                    
                    <div class="pica-menu-box">
                        <div class="pica-menu-slika">
                            <?php 
                                if($naziv_slike=="")
                                {
                                    echo "<div class='error'>Slika nije dostupna</div>";
                                }
                                else
                                {
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

                            <a href="<?php echo SITEURL; ?>porudzbina.php?pica_id=<?php echo $id; ?>" class="btn btn-stil">Poruci</a>
                        </div>
                    </div>

                    <?php
                }
            }
            else
            {
                echo "<div class='error'>Pica nije nadjena</div>";
            }
        ?>

        <div class="fiksiran"></div>

    </div>

</section>

<?php include('osnovni-delovi-stranica/footer.php'); ?>