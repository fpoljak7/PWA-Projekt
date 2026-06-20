<?php
include 'connect.php';

$query = "SELECT * FROM vijesti WHERE kategorija='elections' AND arhiva=0 LIMIT 5";
$result = mysqli_query($dbc, $query);

$query2 = "SELECT * FROM vijesti WHERE kategorija='les jt' AND arhiva=0 LIMIT 4";
$result2 = mysqli_query($dbc, $query2);
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
                <h2>Élections européennes 2019</h2>
                <div class="grid-5">
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
        <section>
            <div class="container">
                <h2>Les JT</h2>
                <div class="grid-4">
                    <?php
                        while ($row = mysqli_fetch_array($result2)) {
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