<?php include('delovi-stranica/menu.php'); ?>

<div class="glavni-sadrzaj">
	<div class="omotac">
        <h1>Promeni lozinku</h1>
        <br><br>

        <?php 
            if(isset($_GET['id']))
            {
                $id=$_GET['id'];
            }
        ?>

        <form action="" method="POST">
        
            <table class="tbl-30">
                <tr>
                    <td>Trenutna lozinka: </td>
                    <td>
                        <input type="password" name="trenutni_password" placeholder="Trenutna lozinka">
                    </td>
                </tr>

                <tr>
                    <td>Nova lozinka:</td>
                    <td>
                        <input type="password" name="novi_password" placeholder="Nova lozinka">
                    </td>
                </tr>

                <tr>
                    <td>Potvrdi lozinku: </td>
                    <td>
                        <input type="password" name="potvrdi_password" placeholder="Potvrdi lozinku">
                    </td>
                </tr>

                <tr>
                    <td colspan="2">
                        <input type="hidden" name="id" value="<?php echo $id; ?>">
                        <input type="submit" name="submit" value="Promeni lozinku" class="btn-stil2">
                    </td>
                </tr>

            </table>

        </form>

    </div>
</div>

<?php 

            //Provera da li je submit dugme kliknuto ili ne
            if(isset($_POST['submit']))
            {
                //echo "Kliknuto";

                //1. Uzimanje podataka iz forme
                $id=$_POST['id'];
                $trenutni_password = $_POST['trenutni_password'];
                $novi_password = $_POST['novi_password'];
                $potvrdi_password = $_POST['potvrdi_password'];


                //2. Provera da li korisnik sa trenutnim id-em i trenutnom lozinkom postoji ili ne
                $sql = "SELECT * FROM admin WHERE id=$id AND password='$trenutni_password'";

                //Izvršavanje upita
                $rezultat = mysqli_query($conn, $sql);

                if($rezultat==true)
                {
                    //Provera da li su podaci dotupni ili ne
                    $broj=mysqli_num_rows($rezultat);

                    if($broj==1)
                    {
                        //Korisnik postoji i lozinka može biti primenjena
                        //echo "Korisnik postoji";

                        //Provera da li se nova lozinka i potvrda poklapaju
                        if($novi_password==$potvrdi_password)
                        {
                            //Izmena lozinke
                            $sql2 = "UPDATE admin SET 
                                password='$novi_password' 
                                WHERE id=$id
                            ";

                            //Izvršavanje upita
                            $rezultat2 = mysqli_query($conn, $sql2);

                            //Provera da li je upit izvršen ili ne
                            if($rezultat2==true)
                            {
                                //Prikaz poruke o uspešnosti
                                //Redirekcija ka stranici - upravljaj adminom i poruka
                                $_SESSION['change-pwd'] = "<div class='uspesno'>Lozinka uspešno promenjena. </div>";
                                //Redirekcija ka stranici
                                header('location:'.SITEURL.'admin/upravljaj-adminom.php');
                            }
                            else
                            {
                                //Prikaz poruke o grešci
                                //Redirekcija ka stranici - upravljaj adminom i poruka
                                $_SESSION['change-pwd'] = "<div class='greska'>Lozinka neuspešno promenjena. </div>";
                                //Redirekcija ka stranici
                                header('location:'.SITEURL.'admin/upravljaj-adminom.php');
                            }
                        }
                        else
                        {
                            //Redirekcija ka stranici - upravljaj adminom i poruka o grešci
                            $_SESSION['pwd-not-match'] = "<div class='greska'>Lozinke se ne poklapaju. </div>";
                            //Redirekcija ka stranici
                            header('location:'.SITEURL.'admin/upravljaj-adminom.php');

                        }
                    }
                    else
                    {
                        //Korisnik ne postoji, prikaz poruke i redirekcija
                        $_SESSION['user-not-found'] = "<div class='greska'>Korisnik nije pronađen. </div>";
                        //Redirekcija ka stranici
                        header('location:'.SITEURL.'admin/upravljaj-adminom.php');
                    }
                }

            }

?>


<?php include('delovi-stranica/footer.php'); ?>