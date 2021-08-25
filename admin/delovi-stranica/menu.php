<?php 
    include('../konfiguracija/konekcija.php'); 
    include('login-provera.php');
?>

<html>
    <head>
        <title>ePicerija - Naslovna stranica</title>

        <link rel="stylesheet" href="../css/admin.css">
    </head>
    
    <body>
        <!-- Menu Sekcija -->
        <div class="menu centriran-text">
            <div class="omotac">
                <ul>
                    <li><a href="index.php">Naslovna</a></li>
                    <li><a href="upravljaj-adminom.php">Admin</a></li>
                    <li><a href="upravljaj-vrstom.php">Kategorije</a></li>
                    <li><a href="upravljaj-picama.php">Pice</a></li>
                    <li><a href="upravljaj-porudzbinom.php">Porudzbina</a></li>
                    <li><a href="logout.php">Logout</a></li>
                </ul>
            </div>
        </div>
        <!-- Sekcija Menu kraj -->