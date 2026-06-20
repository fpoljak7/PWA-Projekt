<?php
include 'connect.php';

if (!isset($_GET['kategorija'])) {
    header('Location: index.php');
    exit;
}

$kategorija = $_GET['kategorija'];

$sql = "SELECT * FROM vijesti WHERE kategorija=? AND arhiva=0";
$stmt = mysqli_stmt_init($dbc);
if (mysqli_stmt_prepare($stmt, $sql)) {
    mysqli_stmt_bind_param($stmt, 's', $kategorija);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
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
        <section>
            <div class="container">
                <h2><?php echo $kategorija; ?></h2>
                <div class="grid-4">
                    <?php
                        while ($row = mysqli_fetch_array($result)) {
                            echo '<article>';
                            echo '<img src="img/' . $row['slika'] . '" alt="' . $row['naslov'] . '">';
                            echo '<h3><a href="clanak.php?id=' . $row['id'] . '">' . $row['naslov'] . '</a></h3>';
                            echo '</article>';
                        }
                    ?>
                </div>
            </div>
        </section>
    </main>

    <footer>
        <div class="container">
            <p>france.tv</p>
            <p>Filip Poljak - fpoljak@tvz.hr - 2026.</p>
        </div>
    </footer>
</body>
</html>