<?php include('delovi-stranica/menu.php'); 
    include_once '../klase/VrstaKlasa.php';
    $vrste = new Vrsta();
?>
<div class="glavni-sadrzaj">
    <div class="omotac">
        <h1>Dodaj vrstu</h1>

        <br><br>

        <?php 
        
            if(isset($_SESSION['add']))
            {
                echo $_SESSION['add'];
                unset($_SESSION['add']);
            }

            if(isset($_SESSION['upload']))
            {
                echo $_SESSION['upload'];
                unset($_SESSION['upload']);
            }
        
        ?>

        <br><br>

        <!-- Dodaj Vrstu forma -->
        <form action="" method="POST" enctype="multipart/form-data">

            <table class="tbl-30">
                <tr>
                    <td>Naziv: </td>
                    <td>
                        <input type="text" name="naziv" placeholder="Naziv vrste">
                    </td>
                </tr>

                <tr>
                    <td>Naziv slike: </td>
                    <td>
                        <input type="file" name="slika">
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
                        <input type="submit" name="submit" value="Dodaj vrstu" class="btn-stil2">
                    </td>
                </tr>

            </table>

        </form>
        <!-- Forma Dodaj Vrstu kraj -->

        <?php 
        
            //Provera da li je Submit button kliknuto ili ne
            if(isset($_POST['submit']))
            {
                //echo "Kliknuto";

                //1. Uzimanje vrednosti iz forme Vrste
                $naziv = $_POST['naziv'];

				//Provera da li je Radio button kliknut ili ne
                if(isset($_POST['u_prodaji']))
                {
                    $u_prodaji = $_POST['u_prodaji'];
                }
                else
                {
                    $u_prodaji = "Ne";
                }


                if(isset($_FILES['slika']['name']))
                {
                    //Upload slike
                    //Da bi slika bila upload-ovana moramo znati njen naziv, source path i destination path
                    $naziv_slike= $_FILES['slika']['name'];
                    
                    // Upload slike samo ukoliko je selektovana
                    if($naziv_slike!= "")
                    {

                        //Preimenovanje slike 
                        //Uzimanje ekstenzije date slike (jpg, png, gif...) npr. "pica.jpg"
                        $ext = end(explode('.', $naziv_slike));

                        //Preimenovanje slike
                        $naziv_slike = "vrsta_pice".rand(000, 999).'.'.$ext; // npr. vrsta_pice.jpg
                        
                        $source_path = $_FILES['slika']['tmp_name'];

                        $destination_path = "../slike/vrste/".$naziv_slike;

                        //Kona??ni upload slike
                        $upload = move_uploaded_file($source_path, $destination_path);

                        //Provera da li je slika upload-ovana ili ne
                        //Ukoliko nije, proces se zaustavlja i izvr??ava redirekcija uz prikazivanje poruke o gre??ci
                        if($upload==false)
                        {
                            //Prikazi poruku
                            $_SESSION['upload'] = "<div class='greska'>Neuspe??no postavljenja slika. </div>";
                            //Redirekcija ka stranici Dodaj Vrstu
                            header('location:'.SITEURL.'admin/dodaj-vrstu.php');
                            //Stopiranje procesa
                            die();
                        }

                    }
                }
                else
                {
                    //Postavljanje blank vrednosti naziva slike
                    $naziv_slike="";
                }

                //Poziv funkcije za dodavanje nove vrste u bazu
                $rezultat = $vrste->dodajVrstu($naziv, $naziv_slike, $u_prodaji);

                //4. Provera da li je upit izvr??en i da li su podaci dodati ili ne
                if($rezultat==true)
                {
                    //Upit izvr??en, vrsta dodata
                    $_SESSION['add'] = "<div class='uspesno'>Vrsta upe??no dodata.</div>";
                    //Redirekcija ka stranici za upravljanje vrstom
                    header('location:'.SITEURL.'admin/upravljaj-vrstom.php');
                }
                else
                {
                    //Neuspe??no dodavanje vrste
                    $_SESSION['add'] = "<div class='greska'>Vrsta neuspe??no dodata.</div>";
                    //Redirekcija ka stranici za upravljanje vrstom
                    header('location:'.SITEURL.'admin/dodaj-vrstu.php');
                }
            }
        
        ?>

    </div>
</div>

<?php include('delovi-stranica/footer.php'); ?>
