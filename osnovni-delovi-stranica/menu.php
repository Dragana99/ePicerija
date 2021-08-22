<?php include('konfiguracija/konekcija.php'); ?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ePicerija</title>

    <!-- Link do CSS fajla -->
    <link rel="stylesheet" href="css/stil1.css">
</head>

<body>
    <!-- Sekcija za navigaciju -->
    <section class="navbar">
        <div class="kontejner">
            <div class="logo">
                <a href="<?php echo SITEURL; ?>" title="Logo">
                    <img src="slike/logo.png" alt="ePicerija Logo" class="responsive-slika">
                </a>
            </div>

            <div class="menu text-desno">
                <ul>
                    <li>
                        <a href="<?php echo SITEURL; ?>">Pocetna</a>
                    </li>
                    <li>
                        <a href="<?php echo SITEURL; ?>vrste.php">Vrste</a>
                    </li>
                    <li>
                        <a href="<?php echo SITEURL; ?>pice.php">Pice</a>
                    </li>
                </ul>
            </div>

            <div class="fiksiran"></div>
        </div>
    </section>
