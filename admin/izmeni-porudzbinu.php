<?php 
include('delovi-stranica/menu.php'); 
include_once '../klase/PorudzbinaKlasa.php';
$porudzbine = new Porudzbina();
?>

<div class="glavni-sadrzaj">
	<div class="omotac">
        <h1>Izmeni porudžbinu</h1>
        <br><br>

        <?php 
        
            ////Provera da li je id setovan ili ne
            if(isset($_GET['id']))
            {
                //Uzimanje id-a
                $id=$_GET['id'];

                //Poziv funkcije za prikaz podataka porudžbine određenog id-a
                $rezultat = $porudzbine->prikazSaIdPorudzbine($id);

                if(mysqli_num_rows($rezultat)==1)
                {
                    //Detalji su dostupni
                    $row=mysqli_fetch_assoc($rezultat);

                    $pica = $row['pica'];
                    $cena = $row['cena'];
                    $kolicina = $row['kolicina'];
                    $status = $row['status'];
                    $kupac = $row['kupac'];
                    $kontakt_tel = $row['kontakt_tel'];
                    $email = $row['email'];
                    $adresa= $row['adresa'];
                }
                else
                {
                    //Detalji nisu dostupni
                    //Redirekcija ka stranici - upravljaj porudzbinom
                    header('location:'.SITEURL.'admin/upravljaj porudzbinom.php');
                }
            }
            else
            {
                //Redirekcija ka stranici - upravljaj porudzbinom
                header('location:'.SITEURL.'admin/upravljaj porudzbinom.php');
            }
        
        ?>

        <form action="" method="POST">
        
            <table class="tbl-30">
                <tr>
                    <td>Naziv pizze:</td>
                    <td><b> <?php echo $pica; ?> </b></td>
                </tr>

                <tr>
                    <td>Cena:</td>
                    <td>
                        <b> din. <?php echo $cena; ?></b>
                    </td>
                </tr>

                <tr>
                    <td>Količina:</td>
                    <td>
                        <input type="number" name="kolicina" value="<?php echo $kolicina; ?>">
                    </td>
                </tr>

                <tr>
                    <td>Status:</td>
                    <td>
                        <select name="status">
                            <option <?php if($status=="Poručeno"){echo "selected";} ?> value="Poruceno">Poručeno</option>
                            <option <?php if($status=="Dostava u toku"){echo "selected";} ?> value="Dostava u toku">Dostava u toku</option>
                            <option <?php if($status=="Dostavljeno"){echo "selected";} ?> value="Dostavljeno">Dostavljeno</option>
                            <option <?php if($status=="Otkazano"){echo "selected";} ?> value="Otkazano">Otkazano</option>
                        </select>
                    </td>
                </tr>

                <tr>
                    <td>Kupac: </td>
                    <td>
                        <input type="text" name="kupac" value="<?php echo $kupac; ?>">
                    </td>
                </tr>

                <tr>
                    <td>Telefon: </td>
                    <td>
                        <input type="text" name="kontakt_tel" value="<?php echo $kontakt_tel; ?>">
                    </td>
                </tr>

                <tr>
                    <td>Email: </td>
                    <td>
                        <input type="text" name="email" value="<?php echo $email; ?>">
                    </td>
                </tr>

                <tr>
                    <td>Adresa: </td>
                    <td>
                        <textarea name="adresa" cols="30" rows="5"><?php echo $adresa; ?></textarea>
                    </td>
                </tr>

                <tr>
                    <td clospan="2">
                        <input type="hidden" name="id" value="<?php echo $id; ?>">
                        <input type="hidden" name="cena" value="<?php echo $cena; ?>">

                        <input type="submit" name="submit" value="Izmeni porudzbinu" class="btn-stil2">
                    </td>
                </tr>
            </table>
        
        </form>


        <?php 
            //Provera da li je update dugme kliknuto ili ne
            if(isset($_POST['submit']))
            {
                //echo "Kliknuto";
                //Uzimanje svih vrednosti iz forme
                $id = $_POST['id'];
                $cena = $_POST['cena'];
                $kolicina = $_POST['kolicina'];

                $ukupno = $cena * $kolicina;

                $status = $_POST['status'];

                $kupac = $_POST['kupac'];
                $kontakt_tel = $_POST['kontakt_tel'];
                $email = $_POST['email'];
                $adresa = $_POST['adresa'];

                //Poziv funkcije za izmenu podataka o porudžbini
                $rezultat2 = $porudzbine->izmeniPorudzbinu($id, $kolicina, $ukupno, $status, $kupac, $kontakt_tel, $email, $adresa);

                //Provera da li je izmenjena porudzbina
                //i redirekcija ka stranici za upravljanje porudzbinama uz poruku
                if($rezultat2==true)
                {
                    //Izmenjeno
                    $_SESSION['update'] = "<div class='uspesno'>Porudžbina izmenjena uspešno.</div>";
                    header('location:'.SITEURL.'admin/upravljaj-porudzbinom.php');
                }
                else
                {
                    //Neuspena izmena
                    $_SESSION['update'] = "<div class='greska'>Neuspešno izmenjena porudžbina.</div>";
                    header('location:'.SITEURL.'admin/upravljaj-porudzbinom.php');
                }
            }
        ?>


    </div>
</div>

<?php include('delovi-stranica/footer.php'); ?>
