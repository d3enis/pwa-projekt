<?php 
include 'connect.php';
session_start();
if (isset($_GET['id'])) {
    $article_id = intval($_GET['id']); 
} else {
    echo '<script>alert("Post nema id")</script>';
    die();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $naslov = $_POST['naslov'];
    $sazetak = $_POST['sazetak'];
    $tekst = $_POST['tekst'];
   
    if (isset($_FILES['slika']) && $_FILES['slika']['error'] === UPLOAD_ERR_OK) {
        $fileTmpPath = $_FILES['slika']['tmp_name'];
        $fileName = $_FILES['slika']['name'];
        $fileSize = $_FILES['slika']['size'];
        $fileType = $_FILES['slika']['type'];
        $fileNameCmps = explode(".", $fileName);
        $fileExtension = strtolower(end($fileNameCmps));

   
        $newFileName = md5(time() . $fileName) . '.' . $fileExtension;


        $uploadFileDir = 'img/';
        $dest_path = $uploadFileDir . $newFileName;

        
        if(move_uploaded_file($fileTmpPath, $dest_path)) {
            $slika = $dest_path;
        } else {
            echo '<script>alert("Greška u uploadanju slike")</script>';
            die();
        }
    } else {

        $slika = $_POST['existing_slika'];
    }

    $sql = "UPDATE vijesti SET naslov=?, slika=?, sazetak=?, tekst=? WHERE id=?";
    $stmt = $dbc->prepare($sql);
    $stmt->bind_param("ssssi", $naslov, $slika, $sazetak, $tekst, $article_id);

    if ($stmt->execute()) {
        echo '<script>alert("Uspješno ste izmjenii post")</script>';
    } else {
        echo '<script>alert("Greška u izmjeni posta")</script>';
    }
}

$sql = "SELECT kategorija, naslov, datum, slika, sazetak, tekst FROM vijesti WHERE id = $article_id";
$result = $dbc->query($sql);
if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
} else {
    echo '<script>alert("Nema rezultata")</script>';
    die();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit News Article</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>
<header>


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
            <div class="row">
                <div class="sredina">
                <h2 class="title">Uredi članak</h2>
                <form  method="post" enctype="multipart/form-data">
                    <label for="naslov">Naslov:</label>
                    <input type="text" id="naslov" name="naslov" value="<?php echo htmlspecialchars($row['naslov']); ?>" required>
                    <br>

                    <label for="slika">Slika:</label>
                    <input type="file" id="slika" name="slika">
                    <br>
                    <input type="hidden" name="existing_slika" value="<?php echo htmlspecialchars($row['slika']); ?>">
                    <?php if (!empty($row['slika'])): ?>
                        <img src="<?php echo htmlspecialchars($row['slika']); ?>" alt="Current Image" style="max-width: 200px;">
                    <?php endif; ?>
                    <br>

                    <label for="sazetak">Sazetak:</label>
                    <textarea id="sazetak" name="sazetak" required><?php echo htmlspecialchars($row['sazetak']); ?></textarea>
                    <br>

                    <label for="tekst">Tekst:</label>
                    <textarea id="tekst" name="tekst" required><?php echo htmlspecialchars($row['tekst']); ?></textarea>
                    <br>

                    <input type="submit" value="Ažuriraj">
                </form>
            </div>
            </div>
        </section>
    </main>
    <footer>
        <p>&copy; 2024 Newsweek</p>
    </footer>
</body>

</html>
