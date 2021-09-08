<?php include('../konfiguracija/konekcija.php'); ?>

<html>
    <head>
        <title>Login - ePicerija</title>
        <link rel="stylesheet" href="../css/admin-stil.css">
    </head>

    <body>
        
        <div class="login">
            <h1 class="centriran-text">Login</h1>
            <br><br>

            <?php 
                if(isset($_SESSION['login']))
                {
                    echo $_SESSION['login'];
                    unset($_SESSION['login']);
                }

                if(isset($_SESSION['no-login-message']))
                {
                    echo $_SESSION['no-login-message'];
                    unset($_SESSION['no-login-message']);
                }
            ?>
            <br><br>

            <!-- Sekcija za login -->
            <form action="" method="POST" class="centriran-text">
            Korisnicko ime: <br>
            <input type="text" name="username" placeholder="Korisnicko ime"><br><br>

            Lozinka: <br>
            <input type="password" name="password" placeholder="Lozinka"><br><br>

            <input type="submit" name="submit" value="Uloguj se" class="btn-stil">
            <br><br>
            </form>
            <!-- Kraj login forme -->

        </div>

    </body>
</html>

<?php 

    //Provera za login
    if(isset($_POST['submit']))
    {
        //1. Uzimanje podataka iz login forme
        $korisnickoIme = $_POST['username'];
        $lozinka = $_POST['password'];

        //2. SQL upit za proveru da li admin postoji u bazi
        $sql = "SELECT * FROM admin WHERE username='$korisnickoIme' AND password='$lozinka'";

        //3. Izvrsavanje upita
        $rezultat = mysqli_query($conn, $sql);

        //4. Broj koji pokazuje da li korisnik postoji u bazi
        $broj = mysqli_num_rows($rezultat);

        if($broj==1)
        {
            //Ukoliko postoji - rezultat je 1, login je uspesan
            $_SESSION['login'] = "<div class='uspesno'>Uspesno ste se ulogovali.</div>";
            $_SESSION['korisnik'] = $korisnickoIme; //Provera da li je korisnik ulogovan, a logout ponistava sesiju za tog korisnika

            //Redirekcija na pocetnu stranicu
            header('location:'.SITEURL.'admin/');
        }
        else
        {
            //Ukoliko login nije uspesan
            $_SESSION['login'] = "<div class='greska centriran-text'>Nije ispravno korisnicko ime ili lozinka</div>";
            //Redirekcija na stranicu za logovanje
            header('location:'.SITEURL.'admin/login.php');
        }


    }

?>