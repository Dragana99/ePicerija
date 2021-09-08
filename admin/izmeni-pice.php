<?php include('delovi-stranica/menu.php'); ?>

<?php 
    //Provera da li je id setovan ili ne
    if(isset($_GET['id']))
    {
        //Uzimanje svih detalja
        $id = $_GET['id'];

        //SQL upit za donijanje selektovane pice
        $sql2 = "SELECT * FROM pica WHERE id=$id";
        //Izvršavanje upita
        $rezultat2 = mysqli_query($conn, $sql2);

        //Dobijanje vrednosti nakon izvršenja upita
        $row2 = mysqli_fetch_assoc($rezultat2);

        //Uzimanje pojedinačnih vrednosti selektovanih pica
        $naziv = $row2['naziv'];
        $opis = $row2['opis'];
        $cena = $row2['cena'];
        $trenutna_slika = $row2['naziv_slike'];
        $trenutna_vrsta = $row2['id_vrste'];
        $u_prodaji = $row2['u_prodaji'];

    }
    else
    {
        //Redirekcija ka stranici - Upravljaj picama
        header('location:'.SITEURL.'admin/upravljaj-picama.php');
    }
?>


<div class="glavni-sadrzaj">
	<div class="omotac">
        <h1>Izmeni pice</h1>
        <br><br>

        <form action="" method="POST" enctype="multipart/form-data">
        
        <table class="tbl-30">

            <tr>
                <td>Naziv: </td>
                <td>
                    <input type="text" name="naziv" value="<?php echo $naziv; ?>">
                </td>
            </tr>

            <tr>
                <td>Opis: </td>
                <td>
                    <textarea name="opis" cols="30" rows="5"><?php echo $opis; ?></textarea>
                </td>
            </tr>

            <tr>
                <td>Cena: </td>
                <td>
                    <input type="number" name="cena" value="<?php echo $cena; ?>">
                </td>
            </tr>

            <tr>
                <td>Trenutna slika: </td>
                <td>
                    <?php 
                        if($trenutna_slika == "")
                        {
                            //Slika nije dostupna 
                            echo "<div class='greska'>Slika nije dostupna.</div>";
                        }
                        else
                        {
                            //Slika je dostupna
                            ?>
                            <img src="<?php echo SITEURL; ?>slike/pice/<?php echo $trenutna_slika; ?>" width="150px">
                            <?php
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
                <td>Vrsta: </td>
                <td>
                    <select name="vrsta">

                        <?php 
                            //Upit za dobijanje vrsta u prodaji
                            $sql = "SELECT * FROM vrsta WHERE u_prodaji='Da'";
                            //Izvršavanje upita
                            $rezultat = mysqli_query($conn, $sql);
                            //Brojanje redova
                            $broj = mysqli_num_rows($rezultat);

                            //Provera da li je vrsta dostupna ili ne
                            if($broj>0)
                            {
                                //Vrsta je dostupna
                                while($row=mysqli_fetch_assoc($rezultat))
                                {
                                    $naziv = $row['naziv'];
                                    $id_vrste = $row['id'];
                                    
                                    //echo "<option value='$id_vrste'>$naziv</option>";f
                                    ?>
                                    <option <?php if($trenutna_vrsta==$id_vrste){echo "selected";} ?> value="<?php echo $id_vrste; ?>"><?php echo $naziv; ?></option>
                                    <?php
                                }
                            }
                            else
                            {
                                //Vrsta nije dostupna
                                echo "<option value='0'>Vrsta nije dostupna.</option>";
                            }

                        ?>

                    </select>
                </td>
            </tr>
			
            <tr>
                <td>U prodaji: </td>
                <td>
                    <input <?php if($u_prodaji=="Da") {echo "checked";} ?> type="radio" name="u_prodaji" value="Da"> Da 
                    <input <?php if($u_prodaji=="Ne") {echo "checked";} ?> type="radio" name="u_prodaji" value="Ne"> Ne 
                </td>
            </tr>

            <tr>
                <td>
                    <input type="hidden" name="id" value="<?php echo $id; ?>">
                    <input type="hidden" name="trenutna_slika" value="<?php echo $trenutna_slika; ?>">

                    <input type="submit" name="submit" value="Izmeni pice" class="btn-stil2">
                </td>
            </tr>
        
        </table>
        
        </form>

        <?php 
        
            if(isset($_POST['submit']))
            {
                //echo "Dugme kliknuto";

                //1. Uzimanje svih podataka iz forme
                $id = $_POST['id'];
                $naziv = $_POST['naziv'];
                $opis = $_POST['opis'];
                $cena = $_POST['cena'];
                $trenutna_slika = $_POST['trenutna_slika'];
                $vrsta = $_POST['vrsta'];
                $u_prodaji = $_POST['u_prodaji'];

                //2. Upload slike ukoliko je selektovana

                //Provera da li je upload dugme kliknuto ili ne
                if(isset($_FILES['slika']['name']))
                {
                    //Upload dugme je kliknuto
                    $naziv_slike = $_FILES['slika']['name']; //Nov naziv slike

                    //Provera dostupnosti fajla
                    if($naziv_slike!="")
                    {
                        //Slika je dostupna
                        //A. Upload nove slike

                        //Preimenovanje slike
                        $ext = end(explode('.', $naziv_slike)); //Uzima ekstenziju slike

                        $naziv_slike = "naziv_pice".rand(0000, 9999).'.'.$ext; //Ovo će biti preimenovana slika

                        //Uzimanje source i destination path-a
                        $src_path = $_FILES['slika']['tmp_name']; //Source Path
                        $dest_path = "../slike/pice/".$naziv_slike; //Destination Path

                        //Upload slike
                        $upload = move_uploaded_file($src_path, $dest_path);

                        /// Provera da li je slika upload-ovana ili ne
                        if($upload==false)
                        {
                            //Neuspešan uload
                            $_SESSION['upload'] = "<div class='greska'>Neuspešan upload slike.</div>";
                            //Redirekcija ka stranici - Upravljaj picama
                            header('location:'.SITEURL.'admin/upravljaj-picama.php');
                            //Stopiranje procesa
                            die();
                        }
                        //3. Brisanje slike ukoliko je nova upload-ovana
                        //B. Brisanje trenutne slike ukoliko je dostupna
                        if($trenutna_slika!="")
                        {
                            //Trenutna slika je dostupna
                            //Brisanje slike
                            $remove_path = "../slike/pice/".$trenutna_slika;

                            $remove = unlink($remove_path);

                            //Provera da li je slika obrisana ili ne
                            if($remove==false)
                            {
                                //Neuspešno brisanje trenutne slike
                                $_SESSION['remove-failed'] = "<div class='greska'>Neuspešno brisanje trenutne slike.</div>";
                                //Redirekcija ka stranici - Upravljaj picama
                                 header('location:'.SITEURL.'admin/upravljaj-picama.php');
                                //Stopiranje procesa
                                die();
                            }
                        }
                    }
                    else
                    {
                        $naziv_slike = $trenutna_slika; //Defaultna slika kada slika nije selektovana
                    }
                }
                else
                {
                    $naziv_slike = $trenutna_slika; //Defaultna slika kada dugme nije kliknuto
                }

                

                //4. Izmena pice u bazi
                $sql3 = "UPDATE pica SET 
                    naziv = '$naziv',
                    opis = '$opis',
                    cena = $cena,
                    naziv_slike = '$naziv_slike',
                    id_vrste = '$vrsta',
                    u_prodaji = '$u_prodaji'
                    WHERE id=$id
                ";

                //Izvršavanje SQL upita
                $rezultat3 = mysqli_query($conn, $sql3);

                //Provera da li je upit izvršen
                if($rezultat3==true)
                {
                    //Upit je izvršen i pizza izmenjena
                    $_SESSION['update'] = "<div class='uspesno'>Pizza izmenjena uspešno.</div>";
                    header('location:'.SITEURL.'admin/upravljaj-picama.php');
                }
                else
                {
                    //Neuspešna izmena pizze
                    $_SESSION['update'] = "<div class='greska'>Neuspešna izmena pizze.</div>";
                    header('location:'.SITEURL.'admin/upravljaj-picama.php');
                }

                
            }
        
        ?>

    </div>
</div>

<?php include('delovi-stranica/footer.php'); ?>