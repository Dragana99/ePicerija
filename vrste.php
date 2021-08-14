<?php include('osnovni-delovi-stranica/menu.php'); ?>

<section class="kategorije">
    <div class="kontejner">
        <h2 class="centriran-text">Sve pizze</h2>

        <?php 

            //Pikazivanje svih pica koje su u prodaji
            $sql = "SELECT * FROM vrsta WHERE u_prodaji='Da'";

            $rezultat = mysqli_query($conn, $sql);

            $broj = mysqli_num_rows($rezultat);

            if($broj>0)
            {
                while($red=mysqli_fetch_assoc($rezultat))
                {
                    $id = $red['id'];
                    $naziv = $red['naziv'];
                    $naziv_slike = $red['naziv_slike'];
                    ?>
                    
                    <a href="<?php echo SITEURL; ?>vrste-pice.php?id_vrste=<?php echo $id; ?>">
                        <div class="box-3 float-kontejner">
                            <?php 
                                if($naziv_slike=="")
                                {
                                    echo "<div class='error'>Slika nije pronadjena</div>";
                                }
                                else
                                {
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
                echo "<div class='error'>Vrsta nije nadjena</div>";
            }
        
        ?>
        
        <div class="fiksiran"></div>
    </div>
</section>

<?php include('partials-front/footer.php'); ?>