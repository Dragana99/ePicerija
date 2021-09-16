<?php 
include('delovi-stranica/menu.php'); 
include_once '../klase/VrstaKlasa.php';
$vrste = new Vrsta();
?>

<div class="glavni-sadrzaj">
    <div class="omotac">
        <h1>Upravljaj vrstom</h1>

        <br /><br />
        <?php 
        
            if(isset($_SESSION['add']))
            {
                echo $_SESSION['add'];
                unset($_SESSION['add']);
            }

            if(isset($_SESSION['remove']))
            {
                echo $_SESSION['remove'];
                unset($_SESSION['remove']);
            }

            if(isset($_SESSION['delete']))
            {
                echo $_SESSION['delete'];
                unset($_SESSION['delete']);
            }

            if(isset($_SESSION['no-category-found']))
            {
                echo $_SESSION['no-category-found'];
                unset($_SESSION['no-category-found']);
            }

            if(isset($_SESSION['update']))
            {
                echo $_SESSION['update'];
                unset($_SESSION['update']);
            }

            if(isset($_SESSION['upload']))
            {
                echo $_SESSION['upload'];
                unset($_SESSION['upload']);
            }

            if(isset($_SESSION['failed-remove']))
            {
                echo $_SESSION['failed-remove'];
                unset($_SESSION['failed-remove']);
            }
        
        ?>
        <br><br>

                <!-- Dugme za dodavanje admina -->
                <a href="<?php echo SITEURL; ?>admin/dodaj-vrstu.php" class="btn-stil">Dodaj vrstu</a>

                <br /><br /><br />

                <table class="cela-tabela">
                    <tr>
                        <th>S.br.</th>
                        <th>Naziv</th>
                        <th>Slika</th>
                        <th>U prodaji</th>
                        <th>Postavke</th>
                    </tr>

                    <?php 

                        //funkcija sa SQL upitom za dobijanje svih vrsta iz baze
                        $rezultat = $vrste->sveVrste();

                        //Kreiranje varijable serijskog broja i dodeljivanje vrednosti 1
                        $sn=1;

                        //Provera da li postoje podaci u bazi
                        if($broj = mysqli_num_rows($rezultat)>0)
                        {
                            //Postoje podaci u bazi
                            //uzimanje podataka i prikaz
                            while($row=mysqli_fetch_assoc($rezultat))
                            {
                                $id = $row['id'];
                                $naziv = $row['naziv'];
                                $naziv_slike = $row['naziv_slike'];
                                $u_prodaji = $row['u_prodaji'];

                                ?>

                                    <tr>
                                        <td><?php echo $sn++; ?>. </td>
                                        <td><?php echo $naziv; ?></td>

                                        <td>

                                            <?php  
                                                //Provera da li je naziv slike dostupan ili ne
                                                if($naziv_slike!="")
                                                {
                                                    //Prikaz slike
                                                    ?>
                                                    
                                                    <img src="<?php echo SITEURL; ?>slike/vrste/<?php echo $naziv_slike; ?>" width="100px" >
                                                    
                                                    <?php
                                                }
                                                else
                                                {
                                                    //Prikaz poruke
                                                    echo "<div class='greska'>Slika nije pronađena.</div>";
                                                }
                                            ?>

                                        </td>


                                        <td><?php echo $u_prodaji; ?></td>
                                        <td>
                                            <a href="<?php echo SITEURL; ?>admin/izmeni-vrstu.php?id=<?php echo $id; ?>" class="btn-stil2">Izmeni vrstu</a>
                                            <a href="<?php echo SITEURL; ?>admin/obrisi-vrstu.php?id=<?php echo $id; ?>&naziv_slike=<?php echo $naziv_slike; ?>" class="btn-upozorenje">Obriši vrstu</a>
                                        </td>
                                    </tr>

                                <?php

                            }
                        }
                        else
                        {
                            //Nemamo podatke
                            //Prikazaćemo poruku u tabeli
                            ?>

                            <tr>
                                <td colspan="6"><div class="greska">Vrsta nije pronađena.</div></td>
                            </tr>

                            <?php
                        }
                    
                    ?>
                    
                </table>
    </div>
    
</div>

<?php include('delovi-stranica/footer.php'); ?>
