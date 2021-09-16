 <?php 
 include('osnovni-delovi-stranica/menu.php'); 
 include_once 'klase/PicaKlasa.php';
 $pice = new Pica();
 ?>

    <!-- Sekcija - Pretraga pice -->
    <section class="pretraga-pice centriran-text">
        <div class="kontejner">
            <?php 

                //Trazenje ključne reči - pretraga
                $pretraga = $_POST['pretraga'];
            ?>
            <h2>Pronađene pice: <a href="#" class="beli-text">"<?php echo $pretraga; ?>"</a></h2>

        </div>
    </section>
    <!-- Kraj sekcije - Pretraga pice -->

    <!-- Sekcija - Pica menu -->
    <section class="pica-menu">
        <div class="kontejner">
            <h2 class="centriran-text">Pica Menu</h2>

            <?php 

                //Poziv funkcije za pretragu naziva i opisa pica po unetoj ključnoj reči
                $rezultat = $pice->pretraziPice($pretraga);

                //Provera dostupnosti pice
                if(mysqli_num_rows($rezultat)>0)
                {
                    //Dostupna pica
                    while($row=mysqli_fetch_assoc($rezultat))
                    {
                        //Dobijanje detalja
                        $id = $row['id'];
                        $naziv = $row['naziv'];
						$opis = $row['opis'];
                        $cena = $row['cena'];    
                        $naziv_slike = $row['naziv_slike'];
                        ?>

                        <div class="pica-menu-box">
                            <div class="pica-menu-slika">
                                <?php 
                                    // Provera dostupnosti slike 
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
                            <h4><?php echo $naziv; ?></h4>
                            <p class="cena-pice"><?php echo $cena; ?> din.</p>
                            <p class="detalji-pice">
                                <?php echo $opis; ?>
                            </p>
                            <br>
                                <a href="<?php echo SITEURL; ?>porudzbina.php?pica_id=<?php echo $id; ?>" class="btn btn-stil">Poruči odmah</a>
                            </div>
                        </div>

                        <?php
                    }
                }
                else
                {
                    //Pica nije dostupna
                    echo "<div class='error'>Pica nije dostupna.</div>";
                }
            
            ?>

            <div class="fiksiran"></div>

        </div>

    </section>
    <!-- Kraj sekcije - Pica menu -->

    <?php include('osnovni-delovi-stranica/footer.php'); ?>
