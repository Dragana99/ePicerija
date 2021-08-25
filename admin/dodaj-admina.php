<?php include('delovi-stranica/menu.php'); ?>

<div class="glavni-sadrzaj">
    <div class="omotac">
        <h1>Dodaj admina</h1>

        <br><br>

        <?php 
            if(isset($_SESSION['add'])) //Provera da li je sesija setovana ili ne
            {
                echo $_SESSION['add']; //Prikaz poruke sesije ukoliko je setovana
                unset($_SESSION['add']); //Brisanje poruke sesije
            }
        ?>

        <form action="" method="POST">

            <table class="tbl-30">
                <tr>
                    <td>Ime i prezime: </td>
                    <td>
                        <input type="text" name="ime_prezime" placeholder="Unesite vaše ime i prezime">
                    </td>
                </tr>

                <tr>
                    <td>Korisničko ime: </td>
                    <td>
                        <input type="text" name="username" placeholder="Vaše korisničko ime">
                    </td>
                </tr>

                <tr>
                    <td>Lozinka: </td>
                    <td>
                        <input type="password" name="password" placeholder="Vaša lozinka">
                    </td>
                </tr>

                <tr>
                    <td colspan="2">
                        <input type="submit" name="submit" value="Dodaj Admina" class="btn-stil2">
                    </td>
                </tr>

            </table>

        </form>


    </div>
</div>

<?php include('partials/footer.php'); ?>


<?php 
    //Obrada podataka iz forme i čuvanje u bazu podataka

    //Provera da li je submit dugme pritisnuto ili ne

    if(isset($_POST['submit']))
    {
        //Dugme je kliknuto
        //echo "Dugme kliknuto";

        //1. Uzimanje podataka iz forme
        $ime_prezime = $_POST['ime_prezime'];
        $username = $_POST['username'];
        $password= md5($_POST['password']); //Enkripcija lozinke sa MD

        //2. SQL Upit za čuvanje podataka u bazu
        $sql = "INSERT INTO admin SET 
            ime_prezime='$ime_prezime',
            username='$username',
            password='$password'
        ";
		
        //3. Izvršavanje upita i čuvanje podataka u bazu
        $rezultat = mysqli_query($conn, $sql) or die(mysqli_error());

        //4. Provera da li su (Upiti izvršeni) podaci uneti ili ne i prikaz adekvatne poruke
        if($rezultat==TRUE)
        {
            //Podaci su uneti
            //echo "Podaci Uneti";
            //Kreiranje varijable sesije za prikaz poruke
            $_SESSION['add'] = "<div class='success'>Admin dodat uspešno.</div>";
            //Redirekcija ka stranici za upravljanje adminom
            header("location:".SITEURL.'admin/upravljaj-adminom.php');
        }
        else
        {
            //Neuspešno uneti podaci 
            //echo "Neuspešan unos";
            //Kreiranje varijable sesije za prikaz poruke
            $_SESSION['add'] = "<div class='error'>Admin neuspešno dodat.</div>";
            //Redirekcija stranice za dodavanje admina
            header("location:".SITEURL.'admin/dodaj-admina.php');
        }

    }
    
?>
