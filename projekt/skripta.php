<?php
if (isset($_POST['naslov'], $_POST['sazetak'], $_POST['tekst'], $_POST['kategorija'])) {
    $naslov = $_POST['naslov'];
    $sazetak = $_POST['sazetak'];
    $tekst = $_POST['tekst'];
    $kategorija = $_POST['kategorija'];
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="style.css">
    <title>Projekt - Filip Poljak</title>
</head>
<body>
    <header>
        <div class="container">
            <h1><a href="index.php">franceinfo<span>:</span></a></h1>
        </div>
        <nav>
             <div class="container">
                <ul>
                    <li><a href="index.php">home</a></li>
                    <li><a href="kategorija.php?kategorija=elections">elections</a></li>
                    <li><a href="kategorija.php?kategorija=les+jt">les jt</a></li>
                    <li><a href="administracija.php">administracija</a></li>
                </ul>
             </div>
        </nav>
    </header>

    <main>
        <div class="container">
            <article class="clanak-nova">
                <h2><?php echo $naslov; ?></h2>
                <p class="psazetak"><?php echo $sazetak; ?></p>
                <img src="img/placeholder.jpg" alt="Clanak">
                <p class="ptekst"><?php echo $tekst; ?></p>
            </article>
        </div>
    </main>

    <footer class="ostali-foot">
        <div class="container">
            <p class="logo">franceinfo<span>:</span></p>
            <p>Filip Poljak - fpoljak@tvz.hr - 2026.</p>
        </div>
    </footer>
</body>
</html>