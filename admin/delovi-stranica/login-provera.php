<?php 
	//Autorizacija - Kontrola pristupa
    //Provera da li je korisnik ulogovan ili ne
    if(!isset($_SESSION['korisnik'])) //Ukoliko korisnička sesija nije setovana
    {
        //Korisnik nije ulogovan
        //Redirekcija ka login stranici sa porukom
        $_SESSION['no-login-message'] = "<div class='error centriran-text'>Molimo Vas ulogujte se za prostup Admin Panelu.</div>";
        //Redirekcija ka login stranici
        header('location:'.SITEURL.'admin/login.php');
    }

?>