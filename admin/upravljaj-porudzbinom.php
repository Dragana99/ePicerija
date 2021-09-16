<?php 
include('delovi-stranica/menu.php'); 
include_once '../klase/PorudzbinaKlasa.php';
$porudzbine = new Porudzbina();
?>

<div class="glavni-sadrzaj">
    <div class="omotac">
        <h1>Upravljaj porudžbinom</h1>

                <br /><br /><br />

                <?php 
                    if(isset($_SESSION['update']))
                    {
                        echo $_SESSION['update'];
                        unset($_SESSION['update']);
                    }
                ?>
                <br><br>

                <table class="cela-tabela">
                    <tr>
                        <th>S.br.</th>
                        <th>Pica</th>
                        <th>Cena </th>
                        <th>Količina</th>
                        <th>Ukupno</th>
                        <th>Datum</th>
                        <th>Status</th>
                        <th>Kupac</th>
                        <th>Telefon</th>
                        <th>Email</th>
                        <th>Adresa</th>
                        <th>Postavke</th>
                    </tr>

                    <?php 
                        //Poziv funkcije za prikaz svih porudžbina iz baze
                        $rezultat = $porudzbine->svePorudzbine();

                        $sn = 1; //Kreiranje varijable serijskog broja i dodeljivanje inicijalne vrednosti 1

                        if(mysqli_num_rows($rezultat)>0)
                        {
                            //Porudžbina dostupna
                            while($row=mysqli_fetch_assoc($rezultat))
                            {
                                //Uzimanje svih detalja porudžbine
                                $id = $row['id'];
                                $pica = $row['pica'];
                                $cena = $row['cena'];
                                $kolicina = $row['kolicina'];
                                $ukupno = $row['ukupno'];
                                $datum = $row['datum'];
                                $status = $row['status'];
                                $kupac = $row['kupac'];
                                $kontakt_tel = $row['kontakt_tel'];
                                $email = $row['email'];
                                $adresa = $row['adresa'];
                                
                                ?>

                                    <tr>
                                        <td><?php echo $sn++; ?>. </td>
                                        <td><?php echo $pica; ?></td>
                                        <td><?php echo $cena; ?></td>
                                        <td><?php echo $kolicina; ?></td>
                                        <td><?php echo $ukupno; ?></td>
                                        <td><?php echo $datum; ?></td>

                                        <td>
                                            <?php 
                                                // Poručeno, Dostava u toku, Dostavljeno, Otkazano

                                                if($status=="Poručeno")
                                                {
                                                    echo "<label>$status</label>";
                                                }
                                                elseif($status=="Dostava u toku")
                                                {
                                                    echo "<label style='color: orange;'>$status</label>";
                                                }
                                                elseif($status=="Dostavljeno")
                                                {
                                                    echo "<label style='color: green;'>$status</label>";
                                                }
                                                elseif($status=="Otkazano")
                                                {
                                                    echo "<label style='color: red;'>$status</label>";
                                                }
                                            ?>
                                        </td>

                                        <td><?php echo $kupac; ?></td>
                                        <td><?php echo $kontakt_tel; ?></td>
                                        <td><?php echo $email; ?></td>
                                        <td><?php echo $adresa; ?></td>
                                        <td>
                                            <a href="<?php echo SITEURL; ?>admin/izmeni-porudzbinu.php?id=<?php echo $id; ?>" class="btn-stil2">Izmeni porudžbinu</a>
                                        </td>
                                    </tr>

                                <?php

                            }
                        }
                        else
                        {
                            //Porudžbina nije dostupna
                            echo "<tr><td colspan='12' class='greska'>Porudžbina nije dostupna.</td></tr>";
                        }
                    ?>

 
                </table>
    </div>
    
</div>

<?php include('delovi-stranica/footer.php'); ?>
