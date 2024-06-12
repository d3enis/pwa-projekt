<?php 
session_start();
include  'connect.php';

$datum = date('D,M d,Y');
if (isset($_POST['clear_session'])) {
    session_unset();
    session_destroy();
    header("location:index.php");
    exit;
}
if (isset($_GET['id'])) {
    $article_id = intval($_GET['id']); 
} else {
    echo "<script>alert('Nema post id-a')</script>";
    die();
}


$sql = "SELECT kategorija, naslov, datum, slika, sazetak, tekst FROM vijesti WHERE id = $article_id";
$result = $dbc->query($sql);
if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
} else {
    echo "<script>alert('Nema rezultata')</script>";
    die();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>News Article</title>
    <link rel="stylesheet" href="style.css">
    <script>
        function checkRazina() {
            let razina = <?php echo json_encode($_SESSION['razina']); ?>;
             if (razina === 0) {
                alert("Nemate pristup");
            } else if (razina === 1) {
                window.location.replace("unos.php");
            }
        }
    </script>
</head>

<body>

<header>

<div class="datum">
    <?php echo $datum ?>
</div>

<div class="korisnik">
    <?php
    if (!empty($_SESSION['korisnicko_ime'])) {
        echo $_SESSION['korisnicko_ime'];
        echo "<form method='post' action=''>";
        echo "<input type='submit' class='logout' name='clear_session' value='Odjavi se'>";
        echo "</form>";
    }
    ?>
</div>

<div class="header-naslov">
    <h1>Newsweek</h1>
</div>

</header>
<nav>
<ul>
    <li><a href="index.php">Home</a></li>
    <li><a href="kategorija.php?id=us">U.S.</a></li>
    <li><a href="kategorija.php?id=world">World</a></li>
    <?php if (isset($_SESSION['korisnicko_ime'])): ?>
        <li><a onclick="checkRazina()">Administracija</a></li>
    <?php else: ?>
        <li><a href="prijava.php">Prijava</a></li>
        <li><a href="registracija.php">Registracija</a></li>
    <?php endif; ?>

</ul>
</nav>
    <main>
        <section role="main">
            <div class="row sredina">
            <h1 class="title"><?php
                echo $row['naslov'];
                ?></h1>
                 <br>
            <section class="slikaDivClanak">
                <?php
                echo '<img class="slikaClanak" src="' . $row['slika'] . '">';
                ?>
            </section>
                <p>AUTOR:admin</p>
                <p>OBJAVLJENO: <?php
                echo "<span>" . $row['datum'] . "</span>";
                ?></p>
                  <br>
            <section class="about">
                <p>
                    <?php
                    echo "<i>" . $row['sazetak'] . "</i>";
                    ?>
                </p>
            </section>
            <section class="sadrzaj">
                <p>
                    <?php
                    echo $row['tekst'];
                    ?>
                </p>
            </section>
            </div>
         
        </section>
    </main>
    <footer>
        <p>&copy; 2024 Newsweek</p>
    </footer>
</body>

</html>