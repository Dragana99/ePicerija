<?php include('delovi-stranica/menu.php'); ?>

<div class="glavni-sadrzaj">
    <div class="omotac">
        <h1>Dodaj admina</h1>

        <br><br>

        <?php
        if (isset($_SESSION['add'])) //Provera da li je sesija setovana ili ne
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

<?php include('delovi-stranica/footer.php'); ?>


<?php
//Obrada podataka iz forme i čuvanje u bazu podataka

//Provera da li je submit dugme pritisnuto ili ne

if (isset($_POST['submit'])) {
    //Dugme je kliknuto
    //echo "Dugme kliknuto";

    require_once dirname(getcwd()) . '/konfiguracija/admin.php';
    require_once dirname(getcwd()) . '/konfiguracija/AdminBLL.php';

    // napravi novog admina
    $koneckija = new Konekcija();
    $admin = new Admin($koneckija, $_POST["ime_prezime"], $_POST['username'], $_POST["password"]);
    $adminBLL = new AdminBLL($koneckija, $admin);
    try {
        $adminBLL->dodajAdmina();
    } catch (Exception $ex) {
        print_r("Greska: " . $ex->getMessage());
    }
}


?>