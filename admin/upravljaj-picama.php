<?php 
    include('delovi-stranica/menu.php'); 
    include_once '../klase/PicaKlasa.php';
    $pice = new Pica();
?>

<div class="glavni-sadrzaj">
    <div class="omotac">
        <h1>Upravljaj picama</h1>

        <br /><br />

                <!-- Dugme za dodavanje pice -->
                <a href="<?php echo SITEURL; ?>admin/dodaj-picu.php" class="btn-stil">Dodaj picu</a>

                <br /><br /><br />

                <?php 
                    if(isset($_SESSION['add']))
                    {
                        echo $_SESSION['add'];
                        unset($_SESSION['add']);
                    }

                    if(isset($_SESSION['delete']))
                    {
                        echo $_SESSION['delete'];
                        unset($_SESSION['delete']);
                    }

                    if(isset($_SESSION['upload']))
                    {
                        echo $_SESSION['upload'];
                        unset($_SESSION['upload']);
                    }

                    if(isset($_SESSION['unauthorize']))
                    {
                        echo $_SESSION['unauthorize'];
                        unset($_SESSION['unauthorize']);
                    }

                    if(isset($_SESSION['update']))
                    {
                        echo $_SESSION['update'];
                        unset($_SESSION['update']);
                    }
                
                ?>

                <table class="cela-tabela">
                    <tr>
                        <th>S.br.</th>
                        <th>Naziv</th>
                        <th>Cena</th>
                        <th>Slika</th>
                        <th>U prodaji</th>
                        <th>Postavke</th>
                    </tr>

                    <?php 
                        //Poziv funkcije sa SQL upitom za dobijanje svih pica iz baze
                        $rezultat = $pice->svePice();

                        //Kreiranje varijable serijskog broja i postavljanje inicijalne vrednosti 1
                        $sn=1;

                        if($broj = mysqli_num_rows($rezultat)>0)
                        {
                            //Pice postoje u bazi
                            //Uzimanje pica iz baze i prikaz
                            while($row=mysqli_fetch_assoc($rezultat))
                            {
                                //Uzimanje vrednosti iz svake kolone
                                $id = $row['id'];
                                $naziv = $row['naziv'];
                                $cena = $row['cena'];
                                $naziv_slike = $row['naziv_slike'];
                                $u_prodaji = $row['u_prodaji'];
                                ?>

                                <tr>
                                    <td><?php echo $sn++; ?>. </td>
                                    <td><?php echo $naziv; ?></td>
                                    <td><?php echo $cena; ?>din.</td>
                                    <td>
                                        <?php  
                                            //Provera da li postoji slika ili ne
                                            if($naziv_slike=="")
                                            {
                                                //Slika ne postoji, prikaz poruke o grešci
                                                echo "<div class='greska'>Slika nije dodata.</div>";
                                            }
                                            else
                                            {
                                                //Slika postoji, prikaz poruke.
                                                ?>
                                                <img src="<?php echo SITEURL; ?>slike/pice/<?php echo $naziv_slike; ?>" width="100px">
                                                <?php
                                            }
                                        ?>
                                    </td>
                                    <td><?php echo $u_prodaji; ?></td>
                                    <td>
                                        <a href="<?php echo SITEURL; ?>admin/izmeni-pice.php?id=<?php echo $id; ?>" class="btn-stil2">Izmeni pice</a>
                                        <a href="<?php echo SITEURL; ?>admin/obrisi-pice.php?id=<?php echo $id; ?>&naziv_slike=<?php echo $naziv_slike; ?>" class="btn-upozorenje">Obriši pice</a>
                                    </td>
                                </tr>

                                <?php
                            }
                        }
                        else
                        {
                            //Pica nije dodata u bazu
                            echo "<tr> <td colspan='7' class='greska'>Pica nije dodata.</td> </tr>";
                        }

                    ?>

                    
                </table>
    </div>
    
</div>

<?php include('delovi-stranica/footer.php'); ?>
