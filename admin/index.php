<?php include('delovi-stranica/menu.php'); ?>

<!-- Glavna sekcija index stranice -->
<div class="glavni-sadrzaj">
    <div class="omotac">
        <h1>Pocetna admin stranica</h1>
        <br><br>
        <?php 
            if(isset($_SESSION['login']))
            {
                echo $_SESSION['login'];
                unset($_SESSION['login']);
            }
        ?>
        <br><br>

        <div class="kolona-4 centriran-text">

            <?php 
                // KREIRANJE UPITA ZA BROJ VRSTA PICA NA SAJTU
                $sql = "SELECT * FROM vrsta";
                //Izvrsavanje upita
                $rezultat = mysqli_query($conn, $sql);
                //broj
                $broj = mysqli_num_rows($rezultat);
            ?>

            <h1><?php echo $broj; ?></h1>
            <br />
            Vrste pice
        </div>

        <div class="kolona-4 centriran-text">

            <?php 
                // KREIRANJE UPITA ZA BROJ VRSTA PICA NA SAJTU
                $sql2 = "SELECT * FROM pica";
                //Izvrsavanje upita
                $rezultat2 = mysqli_query($conn, $sql2);
                //broj
                $broj2 = mysqli_num_rows($rezultat2);
            ?>

            <h1><?php echo $broj2; ?></h1>
            <br />
            Pice
        </div>

        <div class="kolona-4 centriran-text">
            
            <?php 
                // KREIRANJE UPITA ZA BROJ PORUDZBINA NA SAJTU
                $sql3 = "SELECT * FROM porudzbina";
                //Izvrsavanje upita
                $rezultat3 = mysqli_query($conn, $sql3);
                //broj
                $broj3 = mysqli_num_rows($rezultat3);
            ?>

            <h1><?php echo $broj3; ?></h1>
            <br />
            Ukupno porudzbina
        </div>

        <div class="kolona-4 centriran-text">
            
            <?php 
                //KREIRANJE UPITA KOJI RACUNA SUMU SVIH PICA SA STATUSOM 'PORUCENO'
                $sql4 = "SELECT SUM(cena) AS ukupno FROM porudzbina WHERE status='Dostavljeno'";

                //Izvrsavanje upita
                $rezultat4 = mysqli_query($conn, $sql4);

                //Vrednost
                $red4 = mysqli_fetch_assoc($rezultat4);
                
                //Iy dobijene vrednosti uzimamo ukupnu sumu
                $ukupna_zarada = $red4['ukupno'];

            ?>

            <h1><?php echo $ukupna_zarada; ?> din.</h1>
            <br />
            Zarada
        </div>

        <div class="fiksiran"></div>

    </div>
</div>
<!-- Kraj glavne sekcije -->

<?php include('delovi-stranica/footer.php') ?>