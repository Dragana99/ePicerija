<?php include('delovi-stranica/menu.php'); ?>

<div class="glavni-sadrzaj">
	<div class="omotac">
        <h1>Izmeni vrstu</h1>
        <br><br>

        <?php 
        
            //Provera da li je id setovan ili ne
            if(isset($_GET['id']))
            {
                //Uzimanje id-a i ostalih detalja
                //echo "Uzimanje podataka";
                $id = $_GET['id'];
                //SQL upit za dobijanje svih ostalih podataka
                $sql = "SELECT * FROM vrsta WHERE id=$id";

                //Izvršavanje upita
                $rezultat = mysqli_query($conn, $sql);

                //Brojanje redova radi provere validnosti id-a
                $broj = mysqli_num_rows($rezultat);

                if($broj==1)
                {
                    //Uzimanje svih podataka
                    $row = mysqli_fetch_assoc($rezultat);
                    $naziv = $row['naziv'];
                    $trenutna_slika = $row['naziv_slike'];
                    $u_prodaji = $row['u_prodaji'];
                }
                else
                {
                    //Redirekcija ka stranici - upravljaj vrstom, uz poruku
                    $_SESSION['no-category-found'] = "<div class='greska'>Vrsta nije pronađena.</div>";
                    header('location:'.SITEURL.'admin/upravljaj-vrstom.php');
                }

            }
            else
            {
                //Redirekcija ka stranici - upravljaj vrstotm
                header('location:'.SITEURL.'admin/upravljaj-vrstom.php');
            }
        
        ?>

        <form action="" method="POST" enctype="multipart/form-data">

            <table class="tbl-30">
                <tr>
                    <td>Naziv: </td>
                    <td>
                        <input type="text" name="naziv" value="<?php echo $naziv; ?>">
                    </td>
                </tr>

                <tr>
                    <td>Slika: </td>
                    <td>
                        <?php 
                            if($trenutna_slika != "")
                            {
                                //Prikaz slike
                                ?>
                                <img src="<?php echo SITEURL; ?>slike/vrste/<?php echo $trenutna_slika; ?>" width="150px">
                                <?php
                            }
                            else
                            {
                                //Prikaz poruke
                                echo "<div class='greska'>Slika nije pronađena.</div>";
                            }
                        ?>
                    </td>
                </tr>

                <tr>
                    <td>Nova slika: </td>
                    <td>
                        <input type="file" name="slika">
                    </td>
                </tr>

                <tr>
                    <td>U prodaji: </td>
                    <td>
                        <input <?php if($u_prodaji=="Da"){echo "checked";} ?> type="radio" name="u_prodaji" value="Da"> Da 

                        <input <?php if($u_prodaji=="Ne"){echo "checked";} ?> type="radio" name="u_prodaji" value="Ne"> Ne 
                    </td>
                </tr>

                <tr>
                    <td>
                        <input type="hidden" name="trenutna_slika" value="<?php echo $trenutna_slika; ?>">
                        <input type="hidden" name="id" value="<?php echo $id; ?>">
                        <input type="submit" name="submit" value="Izmena vrste" class="btn-stil2">
                    </td>
                </tr>

            </table>

        </form>

        <?php 
        
            if(isset($_POST['submit']))
            {
                //echo "Kliknuto";
                //1. Uzimanje svoh vrednosti iz forme
                $id = $_POST['id'];
                $naziv = $_POST['naziv'];
                $trenutna_slika = $_POST['trenutna_slika'];
                $u_prodaji = $_POST['u_prodaji'];

                //2. Izmena nove slike ukoliko je selektovana
                //Provera da li je naziv selektovan ili ne
                if(isset($_FILES['slika']['name']))
                {
                    //Uzimanje detalja slike
                    $naziv_slike = $_FILES['slika']['name'];

                    //Provera da li je slika dostupna ili ne
                    if($naziv_slike != "")
                    {
                        //Slika je dostupna
                        //A. Upload nove slike

                        //Automatsko preimenovanje slike 
                        //Uyimanje ekstenzije slike (jpg, png, gif, itd.) npr. "margarita.jpg"
                        $ext = end(explode('.', $naziv_slike));

                        //Preimenovanje slike
                        $naziv_slike = "vrsta_pice".rand(000, 999).'.'.$ext; // npr. vrsta_pice.jpg
                        
                        $source_path = $_FILES['slika']['tmp_name'];

                        $destination_path = "../slike/vrste/".$naziv_slike;

                        //Konačni upload slike
                        $upload = move_uploaded_file($source_path, $destination_path);

                        //Provera da li je slika upoad-ovana ili ne
                        //Ukoliko slika nije upload-ovana, proces se stopira i vrsi redirekcija uz poruku
                        if($upload==false)
                        {
                            //Postavljanje poruke
                            $_SESSION['upload'] = "<div class='greska'>Neuspešan upload slike.</div>";
                            //Redirekcija ka stranici - upravljaj vrstom
                            header('location:'.SITEURL.'admin/upravljaj-vrstom.php');
                            //Stopiranje procesa
                            die();
                        }

                        //B. Brisanje trenutne slike,, ukoliko je dostupna
                        if($trenutna_slika!="")
                        {
                            $remove_path = "../slike/vrste/".$trenutna_slika;

                            $remove = unlink($remove_path);

                            //Provera da li je slika obrisana ili ne
                            //Ukoliko je neuspešno obrisana, prikaz poruke i stopiranje procesa
                            if($remove==false)
                            {
                                //Neuspešno obrisana slika
                                $_SESSION['failed-remove'] = "<div class='greska'>Neuspešno brisanje trenutne slike.</div>";
                                header('location:'.SITEURL.'admin/upravljaj-vrstom.php');
                                die();//Stopiranje procesa
                            }
                        }
                        

                    }
                    else
                    {
                        $naziv_slike = $trenutna_slika;
                    }
                }
                else
                {
                    $naziv_slike = $trenutna_slika;
                }

                //3. Update baze podataka
                $sql2 = "UPDATE vrsta SET 
                    naziv = '$naziv',
                    naziv_slike = '$naziv_slike',
                    u_prodaji = '$u_prodaji' 
                    WHERE id=$id
                ";

                //Izvršavanje upita
                $rezultat2 = mysqli_query($conn, $sql2);

                //4. Redirekcija ka stranici - upravljaj vrstom, uz poruku
                //Provera da li je izvršen ili ne
                if($rezultat2==true)
                {
                    //Vrsta izmenjena
                    $_SESSION['update'] = "<div class='uspesno'>Vrsta uspešno izmenjena.</div>";
                    header('location:'.SITEURL.'admin/upravljaj-vrstom.php');
                }
                else
                {
                    //Neuspešna izmena vrste
                    $_SESSION['update'] = "<div class='greska'>Vrsta neuspešno izmenjena.</div>";
                    header('location:'.SITEURL.'admin/upravljaj-vrstom.php');
                }

            }
        
        ?>

    </div>
</div>

<?php include('delovi-stranica/footer.php'); ?>