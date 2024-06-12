<?php
session_start();
include 'connect.php';

$datum = date('D,M d,Y');
if (isset($_POST['clear_session'])) {
    session_unset();
    session_destroy();
    header("location:index.php");
    exit;
}
if (isset($_GET['id'])) {
    $kategorija = $_GET['id']; // Ensure it's an integer
} else {
    echo "No article ID provided";
    die();
}
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['delete_post'])) {
    $id = $_POST['delete_post'];
    $query = "DELETE FROM vijesti WHERE id = ?";
    $statement = mysqli_prepare($dbc,$query);
    mysqli_stmt_bind_param($statement, "i", $id);
                mysqli_stmt_execute($statement);
    if(mysqli_stmt_affected_rows($statement) == 1) {
        header("location:index.php");
        return true;
    } else {
        echo "<script>alert('Greska')</script>";
        return false;
    }
}
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['edit_post'])) {
    $id = $_POST['edit_post'];
   header('location:skripta.php?id='.$id);
}



?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Newsweek</title>
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
        <section class="news-section">
        <?php 
                if($kategorija == "us"){
                    echo '<h2>U.S.</h2>';
                }else
                echo '<h2>World</h2>';
            ?>
            <div class="news-grid">
            <?php
$query =  "SELECT * FROM vijesti WHERE arhiva=0 AND kategorija='$kategorija' ORDER BY id DESC LIMIT 4";
$result = mysqli_query($dbc, $query);
 $i=0;
 while($row = mysqli_fetch_array($result)) {
 echo '<article>';
 echo'<div class="article">';
 echo '<div class="sport_img">';
 echo '<img src="'.$row['slika'].'"';
 echo '</div>';
 echo '<div class="media_body">';
 echo '<h4 class="title">';
 echo '<a href="clanak.php?id='.$row['id'].'">';
 echo $row['naslov'];
 echo '</a></h4>';
 echo '<div>';
 echo '<br>';
 if(isset($_SESSION['razina']) && $_SESSION['razina'] == 1) {
     echo '<div>';
     echo '  <form method="POST">';
     echo '<button type="submit" name="edit_post" value="' . $row['id'] . '">Uredi</button>';
     echo ' | ';
     echo '<button type="submit" name="delete_post" value="' . $row['id'] . '">Izbriši</button>';
     echo '  </form>';
     echo '</div>';
 }
 echo '</div>';
 echo '</div></div>';
 echo '</article>';
 }?> 
            </div>
        </section>
    </main>
    <footer>
        <p>&copy; 2024 NEWSWEEK</p>
        <p>Denis Maksimović,dmaksimov@tvz.hr,2024</p>
    </footer>
</body>
</html>
