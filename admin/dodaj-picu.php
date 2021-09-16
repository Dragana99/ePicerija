<?php 
include('delovi-stranica/menu.php'); 
include_once '../klase/PicaKlasa.php';
include_once '../klase/VrstaKlasa.php';
$pice = new Pica();
$vrste = new Vrsta();
?>

<div class="glavni-sadrzaj">
    <div class="omotac">
        <h1>Dodaj picu</h1>

        <br><br>

        <?php 
            if(isset($_SESSION['upload']))
            {
                echo $_SESSION['upload'];
                unset($_SESSION['upload']);
            }
        ?>

        <form action="" method="POST" enctype="multipart/form-data">
        
            <table class="tbl-30">

                <tr>
                    <td>Naziv: </td>
                    <td>
                        <input type="text" name="naziv" placeholder="Naziv pice">
                    </td>
                </tr>

                <tr>
                    <td>Opis: </td>
                    <td>
                        <textarea name="opis" cols="30" rows="5" placeholder="Opis pice."></textarea>
                    </td>
                </tr>

                <tr>
                    <td>Cena: </td>
                    <td>
                        <input type="number" name="cena">
                    </td>
                </tr>

                <tr>
                    <td>Naziv slike: </td>
                    <td>
                        <input type="file" name="slika">
                    </td>
                </tr>

                <tr>
                    <td>Vrsta pice: </td>
                    <td>
                        <select name="vrsta_pice">

                            <?php 
                                //PHP kod za prikaz vrsta pice iz baze
                                //1. Poziv funkcije za prikaz svih vrsta pice koje su u prodaji
                                $rezultat = $vrste->prikazVrstaUProdaji();

                                //ukoliko je broj veći od nule, imamo vrste, u suprotnom ih nema
                                if(mysqli_num_rows($rezultat)>0)
                                {
                                    //vrste postoje
                                    while($row=mysqli_fetch_assoc($rezultat))
                                    {
                                        //uzimanje detalja vrste
                                        $id_vrste = $row['id'];
                                        $naziv = $row['naziv'];
                                        
                                        ?>

                                        <option value="<?php echo $id_vrste; ?>"><?php echo $naziv; ?></option>

                                        <?php
                                    }
                                }
                                else
                                {
                                    //vrsta ne postoji
                                    ?>
                                    <option value="0">Nije pronađena vrsta pice.</option>
                                    <?php
                                }
                               
                            ?>

                        </select>
                    </td>
                </tr>

                <tr>
                    <td>U prodaji: </td>
                    <td>
                        <input type="radio" name="u_prodaji" value="Da"> Da 
                        <input type="radio" name="u_prodaji" value="Ne"> Ne
                    </td>
                </tr>

                <tr>
                    <td colspan="2">
                        <input type="submit" name="submit" value="Dodaj picu" class="btn-stil2">
                    </td>
                </tr>

            </table>

        </form>

        
        <?php 

            //Provera da li je dugme kliknuto ili ne
            if(isset($_POST['submit']))
            {
                //Dodavanje pice u bazu podataka
                //echo "Kliknuto";
                
                //1. Uzimanje podataka iz forme
                $naziv = $_POST['naziv'];
                $opis = $_POST['opis'];
                $cena = $_POST['cena'];
                $vrsta_pice = $_POST['vrsta_pice'];

                //Provera da li je radio button za "u prodaji" stikliran
                if(isset($_POST['u_prodaji']))
                {
                    $u_prodaji = $_POST['u_prodaji'];
                }
                else
                {
                    $u_prodaji = "Ne"; //postavljanje difoltne vrednosti
                }

                //2. Upload slike ukoliko je selektovana
                //Provera da li je selektovana slika klikuta ili ne i upload slike samo ukoliko je selektovana
                if(isset($_FILES['slika']['name']))
                {
                    //Uzimanje detalja slektovane slike
                    $naziv_slike = $_FILES['slika']['name'];

                    //Provera da li je selektovana slika klikuta ili ne i upload slike samo ukoliko je selektovana
                    if($naziv_slike!="")
                    {
                        // Slika je selektovana
                        //A. Preimenovanje slike
                        //Uzimanje ekstenzije slike (jpg, png, gif, itd.) "calcona.jpg" calcona jpg
                        $ext = end(explode('.', $naziv_slike));

                        // Kreiranje novog imena slike
                        $naziv_slike = "naziv_pice".rand(0000,9999).".".$ext; //Nov naziv slike moze biti "Naziv-pice-25.jpg"

                        //B. Upload slike
                        //Uzimanje src i destination path-a

                        // Source path je trenutna lokacija slike
                        $src = $_FILES['slika']['tmp_name'];

                        //Destination Path je tamo gde ce slika biti upload-ovana
                        $dst = "../slike/pice/".$naziv_slike;

                        //Upload-ovana slika pizze
                        $upload = move_uploaded_file($src, $dst);

                        //Provera upload-a
                        if($upload==false)
                        {
                            //Neuspesan upload
                            //Redirekcija ka stranici Dodaj picu uz poruku 
                            $_SESSION['upload'] = "<div class='greska'>Neuspešan upload slike.</div>";
                            header('location:'.SITEURL.'admin/dodaj-picu.php');
                            //Stopiranje procesa
                            die();
                        }

                    }

                }
                else
                {
                    $naziv_slike = ""; //Postavljanje prazne difoltne vrednosti
                }

                //3. Insert u bazu podataka

                //Poziv funkcije za dodavanje pice u bazu podataka
                $rezultat2 = $pice->dodajPicu($naziv, $opis, $cena, $naziv_slike, $vrsta_pice, $u_prodaji);

                //Provera da li su podaci uneti ili ne
                //4. Redirekcija ka stranici za upravljanje picama i prikaz poruke
                if($rezultat2 == true)
                {
                    //Podaci uspešno uneti
                    $_SESSION['add'] = "<div class='uspesno'>Pica uspešno dodata.</div>";
                    header('location:'.SITEURL.'admin/upravljaj-picama.php');
                }
                else
                {
                    //Neuspešan unos podataka
                    $_SESSION['add'] = "<div class='greska'>Pica neuspešno dodata.</div>";
                    header('location:'.SITEURL.'admin/upravljaj-picama.php');
                }

                
            }

        ?>


    </div>
</div>

<?php include('delovi-stranica/footer.php'); ?>
