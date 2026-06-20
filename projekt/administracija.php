<?php
session_start();
include 'connect.php';

if (isset($_GET['logout'])) {
    session_destroy();
    header('Location: administracija.php');
    exit;
}

$uspjesnaPrijava = false;
$admin = false;

if (isset($_POST['prijava'])) {
    $username = $_POST['username'];
    $password = $_POST['lozinka'];

    $sql = "SELECT korisnicko_ime, lozinka, razina FROM korisnik WHERE korisnicko_ime = ?";
    $stmt = mysqli_stmt_init($dbc);
    if (mysqli_stmt_prepare($stmt, $sql)) {
        mysqli_stmt_bind_param($stmt, 's', $username);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_store_result($stmt);
    }
    mysqli_stmt_bind_result($stmt, $imeKorisnika, $lozinkaKorisnika, $levelKorisnika);
    mysqli_stmt_fetch($stmt);

    if (mysqli_stmt_num_rows($stmt) > 0 && password_verify($password, $lozinkaKorisnika)) {
        $uspjesnaPrijava = true;
        $_SESSION['username'] = $imeKorisnika;
        $_SESSION['level'] = $levelKorisnika;
        if ($levelKorisnika == 1) {
            $admin = true;
        }
    }
}

if (isset($_SESSION['username'])) {
    $uspjesnaPrijava = true;
    if ($_SESSION['level'] == 1) {
        $admin = true;
    }
}

if ($admin && isset($_POST['delete'])) {
    $id = $_POST['id'];

    $sql_delete = "DELETE FROM vijesti WHERE id=?";
    $stmt_delete = mysqli_stmt_init($dbc);
    if (mysqli_stmt_prepare($stmt_delete, $sql_delete)) {
        mysqli_stmt_bind_param($stmt_delete, 'i', $id);
        mysqli_stmt_execute($stmt_delete);
    }
}

if ($admin && isset($_POST['update'])) {
    $id = $_POST['id'];
    $naslov = $_POST['naslov'];
    $sazetak = $_POST['sazetak'];
    $tekst = $_POST['tekst'];
    $kategorija = $_POST['kategorija'];
    $archive = isset($_POST['arhiva']) ? 0 : 1;

    if (!empty($_FILES['slika']['name'])) {
        $picture = $_FILES['slika']['name'];
        $target_dir = 'img/' . $picture;
        move_uploaded_file($_FILES['slika']['tmp_name'], $target_dir);

        $sql_update = "UPDATE vijesti SET naslov=?, sazetak=?, tekst=?, kategorija=?, arhiva=?, slika=? WHERE id=?";
        $stmt_update = mysqli_stmt_init($dbc);
        if (mysqli_stmt_prepare($stmt_update, $sql_update)) {
            mysqli_stmt_bind_param($stmt_update, 'ssssisi', $naslov, $sazetak, $tekst, $kategorija, $archive, $picture, $id);
            mysqli_stmt_execute($stmt_update);
        }
    } 
    else {
        $sql_update = "UPDATE vijesti SET naslov=?, sazetak=?, tekst=?, kategorija=?, arhiva=? WHERE id=?";
        $stmt_update = mysqli_stmt_init($dbc);
        if (mysqli_stmt_prepare($stmt_update, $sql_update)) {
            mysqli_stmt_bind_param($stmt_update, 'ssssii', $naslov, $sazetak, $tekst, $kategorija, $archive, $id);
            mysqli_stmt_execute($stmt_update);
        }
    }
}

$query = "SELECT * FROM vijesti";
$result = mysqli_query($dbc, $query);
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

        <?php if ($admin): ?>

            <div class="container">
                <div class="odjava-cont">
                    <p>Bok <?php echo $_SESSION['username']; ?>! [Admin]</p>
                    <a href="administracija.php?logout=1" class="logout">Odjava</a>
                </div>
                <a href="unos.php" id="nova">Nova vijest <b>+</b></a>
            </div>

            <?php while ($row = mysqli_fetch_array($result)) { ?>

                <div class="container">
                    <form name="unos_vijesti" action="" method="POST" enctype="multipart/form-data">

                        <div class="unos-cont">
                            <label>Naslov vijesti</label>
                            <div class="unos-polje">
                                <input type="text" name="naslov" value="<?php echo htmlspecialchars($row['naslov']); ?>">
                            </div>
                        </div>

                        <div class="unos-cont">
                            <label>Kratki sažetak</label>
                            <div class="unos-polje">
                                <textarea name="sazetak"><?php echo htmlspecialchars($row['sazetak']); ?></textarea>
                            </div>
                        </div>

                        <div class="unos-cont">
                            <label>Tekst</label>
                            <div class="unos-polje">
                                <textarea name="tekst"><?php echo htmlspecialchars($row['tekst']); ?></textarea>
                            </div>
                        </div>

                        <div class="unos-cont">
                            <label>Kategorija vijesti</label>
                            <div class="unos-polje">
                                <select name="kategorija">
                                    <option value="elections" <?php if ($row['kategorija'] == 'elections') echo 'selected'; ?>>Elections</option>
                                    <option value="les jt" <?php if ($row['kategorija'] == 'les jt') echo 'selected'; ?>>Les JT</option>
                                </select>
                            </div>
                        </div>

                        <div class="unos-cont">
                            <label>Slika</label>
                            <div class="unos-polje">
                                <input type="file" name="slika">
                                <img src="img/<?php echo $row['slika']; ?>" width="100px">
                            </div>
                        </div>

                        <div class="unos-cont">
                            <label>Prikaži na stranici</label>
                            <input type="checkbox" name="arhiva" value="1" <?php if ($row['arhiva'] == 0) echo 'checked'; ?>>
                        </div>

                        <input type="hidden" name="id" value="<?php echo $row['id']; ?>">

                        <div class="unos-cont">
                            <button type="submit" name="update" class="prihvati">Izmijeni</button>
                            <button type="submit" name="delete" class="izbrisi">Izbriši</button>
                        </div>

                    </form>
                </div>
                <hr>

            <?php } ?>

        <?php elseif ($uspjesnaPrijava && !$admin): ?>

            <div class="container">
                <div class="odjava-cont">
                    <p>Bok <?php echo $_SESSION['username']; ?>! [Korisnik] <br>Nemate dovoljno prava za pristup ovoj stranici.</p>
                    <a href="administracija.php?logout=1" class="logout">Odjava</a>
                </div>
            </div>

        <?php else: ?>

            <div class="container">
                <form action="" method="POST">
                    <div class="unos-cont">
                        <label for="username">Korisničko ime</label>
                        <div class="unos-polje">
                            <input type="text" name="username" id="username">
                        </div>
                    </div>
                    <div class="unos-cont">
                        <label for="lozinka">Lozinka</label>
                        <div class="unos-polje">
                            <input type="password" name="lozinka" id="lozinka">
                        </div>
                    </div>
                    <div class="unos-cont">
                        <button type="submit" name="prijava">Prijava</button>
                    </div>
                </form>
                

                <?php if (isset($_POST['prijava']) && !$uspjesnaPrijava): ?>
                    <p class="bojaPoruke">Neispravno korisničko ime ili lozinka.</p>
                <?php endif; ?>

                <p>Nemate račun? <a href="registracija.php">Registrirajte se</a></p>
            </div>

        <?php endif; ?>

    </main>

    <footer class="ostali-foot">
        <div class="container">
            <p class="logo">franceinfo<span>:</span></p>
            <p>Filip Poljak - fpoljak@tvz.hr - 2026.</p>
        </div>
    </footer>
</body>
</html>