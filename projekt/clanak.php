<?php
include 'connect.php';

if (!isset($_GET['id'])) {
    header('Location: index.php');
    exit;
}

$id = $_GET['id'];

$sql = "SELECT * FROM vijesti WHERE id=?";
$stmt = mysqli_stmt_init($dbc);
if (mysqli_stmt_prepare($stmt, $sql)) {
    mysqli_stmt_bind_param($stmt, 'i', $id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $row = mysqli_fetch_array($result);
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
                <?php
                    echo "<h2>".htmlspecialchars($row['naslov'])."</h2>";
                    echo "<p class='psazetak'>".htmlspecialchars($row['sazetak'])."</p>";
                    echo "<img src='img/".$row['slika']."' alt='Clanak'>";
                    echo "<div class='ptekst'>". $row['tekst'] . "</div>";
                ?>
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