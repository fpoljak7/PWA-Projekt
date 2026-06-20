<?php
session_start();
include 'connect.php';

if (!isset($_SESSION['username']) || $_SESSION['level'] != 1) {
    header('Location: administracija.php');
    exit;
}

if (isset($_POST['submit'])) {
    $naslov     = $_POST['naslov'];
    $sazetak    = $_POST['sazetak'];
    $tekst      = $_POST['tekst'];
    $kategorija = $_POST['kategorija'];
    $archive    = isset($_POST['arhiva']) ? 0 : 1;

    $picture = $_FILES['slika']['name'];
    $target_dir = 'img/' . $picture;
    move_uploaded_file($_FILES['slika']['tmp_name'], $target_dir);

    $sql = "INSERT INTO vijesti (naslov, sazetak, tekst, slika, kategorija, arhiva) VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = mysqli_stmt_init($dbc);
    if (mysqli_stmt_prepare($stmt, $sql)) {
        mysqli_stmt_bind_param($stmt, 'sssssi', $naslov, $sazetak, $tekst, $picture, $kategorija, $archive);
        mysqli_stmt_execute($stmt);
    }
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
            <form name="unos_vijesti" action="" method="POST" enctype="multipart/form-data">
                <div class="unos-cont">
                    <label for="naslov">Naslov vijesti</label>
                    <div class="unos-polje">
                        <input type="text" name="naslov" id="naslov" autofocus>
                    </div>
                </div>

                <div class="unos-cont">
                    <label for="sazetak">Kratki sažetak</label>
                    <div class="unos-polje">
                        <textarea name="sazetak" id="sazetak"></textarea>
                    </div>
                </div>

                <div class="unos-cont">
                    <label for="tekst">Tekst</label>
                    <div class="unos-polje">
                        <textarea name="tekst" id="tekst"></textarea>
                    </div>
                </div>

                <div class="unos-cont">
                    <label for="kategorija">Kategorija</label>
                    <div class="unos-polje">
                        <select name="kategorija" id="kategorija">
                            <option value="elections">Elections</option>
                            <option value="les jt">Les JT</option>
                        </select>
                    </div>
                </div>

                <div class="unos-cont">
                    <label for="slika">Slika</label>
                    <div class="unos-polje">
                        <input type="file" name="slika" id="slika">
                    </div>
                </div>

                <div class="unos-cont">
                    <label for="arhiva">Prikaži na stranici</label>
                    <input type="checkbox" name="arhiva" id="arhiva" value="1" checked>
                </div>

                <div class="unos-cont">
                    <button type="submit" name="submit" class="prihvati">Prihvati</button>
                    <button type="reset" name="reset" class="izbrisi">Poništi</button>
                </div>
            </form>
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