<?php
include 'connect.php';

$msg = '';
$registriranKorisnik = false;

if (isset($_POST['submit'])) {
    $ime = trim($_POST['ime']);
    $prezime = trim($_POST['prezime']);
    $username = trim($_POST['username']);
    $pass = $_POST['pass'];
    $passRep = $_POST['passRep'];

    if (empty($ime) || empty($prezime) || empty($username) || empty($pass) || empty($passRep)) {
        $msg = 'Sva polja moraju biti popunjena!';
    } elseif ($pass !== $passRep) {
        $msg = 'Lozinke se ne podudaraju!';
    } else {
        $hashed_password = password_hash($pass, PASSWORD_DEFAULT);
        $razina = 0;

        $sql = "SELECT korisnicko_ime FROM korisnik WHERE korisnicko_ime = ?";
        $stmt = mysqli_stmt_init($dbc);
        if (mysqli_stmt_prepare($stmt, $sql)) {
            mysqli_stmt_bind_param($stmt, 's', $username);
            mysqli_stmt_execute($stmt);
            mysqli_stmt_store_result($stmt);
        }

        if (mysqli_stmt_num_rows($stmt) > 0) {
            $msg = 'Korisničko ime već postoji!';
        } else {
            $sql2 = "INSERT INTO korisnik (ime, prezime, korisnicko_ime, lozinka, razina) VALUES (?, ?, ?, ?, ?)";
            $stmt2 = mysqli_stmt_init($dbc);
            if (mysqli_stmt_prepare($stmt2, $sql2)) {
                mysqli_stmt_bind_param($stmt2, 'ssssi', $ime, $prezime, $username, $hashed_password, $razina);
                mysqli_stmt_execute($stmt2);
                $registriranKorisnik = true;
            }
        }
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
            <form name="registracija" action="" method="POST">
                <div class="unos-cont">
                    <label for="ime">Ime</label>
                    <div class="unos-polje">
                        <input type="text" name="ime" id="ime" required>
                    </div>
                </div>

                <div class="unos-cont">
                    <label for="prezime">Prezime</label>
                    <div class="unos-polje">
                        <input type="text" name="prezime" id="prezime" required>
                    </div>
                </div>

                <div class="unos-cont">
                    <label for="username">Korisničko ime</label>
                    <div class="unos-polje">
                        <input type="text" name="username" id="username" required>
                    </div>
                </div>

                <div class="unos-cont">
                    <label for="pass">Lozinka</label>
                    <div class="unos-polje">
                        <input type="password" name="pass" id="pass" required>
                    </div>
                </div>

                <div class="unos-cont">
                    <label for="passRep">Ponovite lozinku</label>
                    <div class="unos-polje">
                        <input type="password" name="passRep" id="passRep" required>
                    </div>
                </div>

                <div class="unos-cont">
                    <button type="submit" name="submit">Registracija</button>
                </div>
            </form>
            <?php if ($registriranKorisnik): ?>
            <p>Korisnik je uspješno registriran! <a href="administracija.php">Prijavi se</a></p>
            <?php elseif ($msg): ?>
            <p class="bojaPoruke"><?php echo $msg; ?></p>
            <?php endif; ?>
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