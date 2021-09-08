<?php 
    //Poziva konekciju
    include('../konfiguracija/konekcija.php');
    //Zatvara(gasi) sesiju
    session_destroy(); //Zatvara sesiju za trenutno ulogovanog korisnika

    //Redirekcija na login stranicu
    header('location:'.SITEURL.'admin/login.php');

?>