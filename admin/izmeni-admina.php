<?php include('delovi-stranica/menu.php'); ?>

<div class="glavni-sadrzaj">
	<div class="omotac">
        <h1>Izmena Admina</h1>

        <br><br>

        <?php 
            //1. Uzimanje id-a selektovanog admina
            $id=$_GET['id'];

            //2. SQL upit za dobijanje detalja
            $sql="SELECT * FROM admin WHERE id=$id";

            //Izvršavanje upita
            $rezultat=mysqli_query($conn, $sql);

            //Provera uspešnosti upita
            if($rezultat==true)
            {
                // Provera da li su podaci dostupni ili ne
                $broj = mysqli_num_rows($rezultat);
                //Provera da li postoje podaci o adminu
                if($broj==1)
                {
                    // Uzimanje podataka
                    //echo "Admin dostupan";
                    $row=mysqli_fetch_assoc($rezultat);

                    $ime_prezime = $row['ime_prezime'];
                    $username = $row['username'];
                }
                else
                {
                    //Redirekcija ka stranici - upravljaj adminom
                    header('location:'.SITEURL.'admin/upravljaj-adminom.php');
                }
            }
        
        ?>


        <form action="" method="POST">

            <table class="tbl-30">
                <tr>
                    <td>Ime i prezime: </td>
                    <td>
                        <input type="text" name="ime_prezime" value="<?php echo $ime_prezime; ?>">
                    </td>
                </tr>

                <tr>
                    <td>Korisničko ime: </td>
                    <td>
                        <input type="text" name="username" value="<?php echo $username; ?>">
                    </td>
                </tr>

                <tr>
                    <td colspan="2">
                        <input type="hidden" name="id" value="<?php echo $id; ?>">
                        <input type="submit" name="submit" value="Izmena Admina" class="btn-stil2">
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
        //echo "Submit dugme kliknuto";
        //Uzimanje svh vrednosti iz forme
        $id = $_POST['id'];
        $ime_prezime = $_POST['ime_prezime'];
        $username = $_POST['username'];

        //SQL upit za update admina
        $sql = "UPDATE admin SET
        ime_prezime = '$ime_prezime',
        username = '$username' 
        WHERE id='$id'
        ";

        //Izvršavanje upita
        $rezultat = mysqli_query($conn, $sql);

        //Provera uspešnosti izvršavanja upita
        if($rezultat==true)
        {
            //Upit je izvršen i admin izmenjen
            $_SESSION['update'] = "<div class='uspesno'>Admin uspešno izmenjen.</div>";
            //Redirekcija ka stranici - upravljaj adminom
            header('location:'.SITEURL.'admin/upravljaj-adminom.php');
        }
        else
        {
            //Neuspešan update admina
            $_SESSION['update'] = "<div class='greska'>Neuspešna izmena admina.</div>";
            //Redirekcija ka stranici - upravljaj adminom
            header('location:'.SITEURL.'admin/upravljaj-adminomn.php');
        }
    }

?>


<?php include('delovi-stranica/footer.php'); ?>