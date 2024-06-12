<?php
include 'connect.php';
session_start();
$datum = date('D, M d, Y');
$korisnicko_ime = $_SESSION['korisnicko_ime'];
$razina = $_SESSION['razina'];

if (isset($_POST['clear_session'])) {
    session_unset();
    session_destroy();
    header("location:index.php");
    exit;
}


if ($razina == 0) {
    echo '<script>alert("Nemate pristup")</script>';
} else {
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $picture = $_FILES['pphoto']['name'];
        $title = $_POST['title'];
        $about = $_POST['about'];
        $content = $_POST['content'];
        $category = $_POST['category'];
        $date = date('d.m.Y.');
        $archive = isset($_POST['archive']) ? 1 : 0;

        $target_dir = "img/";
        $target_file = $target_dir . basename($_FILES["pphoto"]["name"]);
        $uploadOk = 1;
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

        if ($uploadOk == 0) {
            echo '<script>alert("Upload neuspjesan")</script>';
        } else {
            if (move_uploaded_file($_FILES["pphoto"]["tmp_name"], $target_file)) {
                $file_directory = $target_file;
                echo '<script>alert("Uspješan upload")</script>';
            }
        }

        $query = "INSERT INTO vijesti (datum, naslov, sazetak, tekst, slika, kategorija, arhiva) VALUES ('$date', '$title', '$about', '$content', '$target_file', '$category', '$archive')";
        $result = mysqli_query($dbc, $query) or die('Error querying database.');
        mysqli_close($dbc);
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>News Form</title>
    <link rel="stylesheet" href="style.css">
    <script>
        function validateForm() {
            let valid = true;

      
            const title = document.querySelector('input[name="title"]');
            const about = document.querySelector('textarea[name="about"]');
            const content = document.querySelector('textarea[name="content"]');
            const pphoto = document.querySelector('input[name="pphoto"]');
            const category = document.querySelector('select[name="category"]');

            
            const errorMessages = document.querySelectorAll('.error-message');
            errorMessages.forEach(msg => msg.remove());

            const formFields = document.querySelectorAll('.form-field-textual, .input-text');
            formFields.forEach(field => field.style.borderColor = '');

           
            if (title.value.length < 5 || title.value.length > 30) {
                valid = false;
                title.style.borderColor = 'red';
                const errorMessage = document.createElement('p');
                errorMessage.classList.add('error-message');
                errorMessage.style.color = 'red';
                errorMessage.innerText = 'Naslov vijesti mora imati 5 do 30 znakova';
                title.parentNode.appendChild(errorMessage);
            }

            
            if (about.value.length < 10 || about.value.length > 100) {
                valid = false;
                about.style.borderColor = 'red';
                const errorMessage = document.createElement('p');
                errorMessage.classList.add('error-message');
                errorMessage.style.color = 'red';
                errorMessage.innerText = 'Kratki sadržaj vijesti mora imati 10 do 100 znakova';
                about.parentNode.appendChild(errorMessage);
            }

       
            if (content.value.trim() === "") {
                valid = false;
                content.style.borderColor = 'red';
                const errorMessage = document.createElement('p');
                errorMessage.classList.add('error-message');
                errorMessage.style.color = 'red';
                errorMessage.innerText = 'Sadržaj vijesti ne smije biti prazan';
                content.parentNode.appendChild(errorMessage);
            }

            
            if (pphoto.files.length === 0) {
                valid = false;
                pphoto.style.borderColor = 'red';
                const errorMessage = document.createElement('p');
                errorMessage.classList.add('error-message');
                errorMessage.style.color = 'red';
                errorMessage.innerText = 'Slika mora biti odabrana';
                pphoto.parentNode.appendChild(errorMessage);
            }

          
            if (category.value === "") {
                valid = false;
                category.style.borderColor = 'red';
                const errorMessage = document.createElement('p');
                errorMessage.classList.add('error-message');
                errorMessage.style.color = 'red';
                errorMessage.innerText = 'Kategorija mora biti odabrana';
                category.parentNode.appendChild(errorMessage);
            }

            return valid;
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
            if (!empty($_SESSION['korisnicko_ime']) && !empty($_SESSION['razina'])) {
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
            <li><a href="kategorija.php?id=sport">U.S.</a></li>
            <li><a href="kategorija.php?id=world">World</a></li>
            <?php if (isset($_SESSION['korisnicko_ime'])): ?>
                <li><a href="unos.php">Administracija</a></li>
            <?php else: ?>
                <li><a href="prijava.php">Prijava</a></li>
                <li><a href="registracija.php">Registracija</a></li>
            <?php endif; ?>
        </ul>
    </nav>
    <div class="sredina">
    <form method="POST" enctype="multipart/form-data" onsubmit="return validateForm();">
        <div class="form-item">
            <label for="title">Naslov vijesti</label>
            <div class="form-field">
                <input type="text" name="title" class="form-field-textual">
            </div>
        </div>
        <div class="form-item">
            <label for="about">Kratki sadržaj vijesti (do 50 znakova)</label>
            <div class="form-field">
                <textarea name="about" cols="30" rows="10" class="form-field-textual"></textarea>
            </div>
        </div>
        <div class="form-item">
            <label for="content">Sadržaj vijesti</label>
            <div class="form-field">
                <textarea name="content" cols="30" rows="10" class="form-field-textual"></textarea>
            </div>
        </div>
        <div class="form-item">
            <label for="pphoto">Slika: </label>
            <div class="form-field">
                <input type="file" accept="image/jpg,image/jpeg,image/png" class="input-text" name="pphoto">
            </div>
        </div>
        <div class="form-item">
            <label for="category">Kategorija vijesti</label>
            <div class="form-field">
                <select name="category" class="form-field-textual">
                    <option value="">Odaberi kategoriju</option>
                    <option value="us">US</option>
                    <option value="world">World</option>
                </select>
            </div>
        </div>
        <div class="form-item">
            <label>Spremiti u arhivu:
                <div class="form-field">
                    <input type="checkbox" name="archive">
                </div>
            </label>
        </div>
        <div class="form-item">
            <button type="reset" value="Poništi">Poništi</button>
            <button type="submit" value="Prihvati">Prihvati</button>
        </div>
    </form>
    </div>
    <footer>
        <p>&copy; 2024 NEWSWEEK</p>
        <p>Denis Maksimović, dmaksimov@tvz.hr, 2024</p>
    </footer>
</body>

</html>