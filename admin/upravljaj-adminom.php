<?php include('delovi-stranica/menu.php'); ?>

        <!-- Sekcija - glavni sadržaj -->
        <div class="glavni-sadrzaj">
            <div class="omotac">
                <h1>Upravljaj adminom</h1>

                <br />

                <?php 
                    if(isset($_SESSION['add']))
                    {
                        echo $_SESSION['add']; //Prikaz poruke sesije
                        unset($_SESSION['add']); //Brisanje poruke sesije
                    }

                    if(isset($_SESSION['delete']))
                    {
                        echo $_SESSION['delete'];
                        unset($_SESSION['delete']);
                    }
                    
                    if(isset($_SESSION['update']))
                    {
                        echo $_SESSION['update'];
                        unset($_SESSION['update']);
                    }

                    if(isset($_SESSION['user-not-found']))
                    {
                        echo $_SESSION['user-not-found'];
                        unset($_SESSION['user-not-found']);
                    }

                    if(isset($_SESSION['pwd-not-match']))
                    {
                        echo $_SESSION['pwd-not-match'];
                        unset($_SESSION['pwd-not-match']);
                    }

                    if(isset($_SESSION['change-pwd']))
                    {
                        echo $_SESSION['change-pwd'];
                        unset($_SESSION['change-pwd']);
                    }

                ?>
                <br><br><br>

                <!-- Dugme za dodavanje admina -->
                <a href="dodaj-admina.php" class="btn-stil">Dodaj admina</a>

                <br /><br /><br />

                <table class="cela-tabela">
                    <tr>
                        <th>S. br.</th>
                        <th>Ime i prezime</th>
                        <th>Korisnicko ime</th>
                        <th>Postavke</th>
                    </tr>

                    
                    <?php 
                        //Upit za dobijanje svih admina
                        $sql = "SELECT * FROM admin";
                        //Izvršavanje upita
                        $rezultat = mysqli_query($conn, $sql);

                        //Provera da li je upit uspešno izvršen
                        if($rezultat==TRUE)
                        {
                            //Brojanje redova radi provere postojanja podataka u bazi
                            $broj = mysqli_num_rows($rezultat); // Funkcja za dobijanje svih redova u bazi

                            $sn=1; //Kreiranje varijable i dodeljivanje vrednosti

                            //Provera broja redova
                            if($broj>0)
                            {
                                //Podaci u bazi postoje
                                while($rows=mysqli_fetch_assoc($rezultat))
                                {
                                    //Upotreba while petlje za dobijanje svih podataka iz baze.
                                    //While petlja će se izvršavati sve dok postoje podaci u bazi.

                                    //Uzimanje pojadinačnih podataka
                                    $id=$rows['id'];
                                    $ime_prezime=$rows['ime_prezime'];
                                    $username=$rows['username'];

                                    //Prikaz vredosti u tabeli
                                    ?>
                                    
                                    <tr>
                                        <td><?php echo $sn++; ?>. </td>
                                        <td><?php echo $ime_prezime; ?></td>
                                        <td><?php echo $username; ?></td>
                                        <td>
                                            <a href="<?php echo SITEURL; ?>admin/izmeni-lozinku.php?id=<?php echo $id; ?>" class="btn-stil">Promeni Lozinku</a>
                                            <a href="<?php echo SITEURL; ?>admin/izmeni-admina.php?id=<?php echo $id; ?>" class="btn-stil2">Izmeni Admina</a>
                                            <a href="<?php echo SITEURL; ?>admin/obrisi-admina.php?id=<?php echo $id; ?>" class="btn-upozorenje">Obriši Admina</a>
                                        </td>
                                    </tr>

                                    <?php

                                }
                            }
                            else
                            {
                                //Podaci u bazi ne postoje
                            }
                        }

                    ?>
                    
                </table>

            </div>
        </div>
        <!-- Sekcija - glavni sadržaj - kraj -->

<?php include('delovi-stranica/footer.php'); ?>