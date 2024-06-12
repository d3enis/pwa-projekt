<?php

include 'connect.php';


if ($_SERVER["REQUEST_METHOD"] == "POST") {
   
    $username = $_POST['username'];
    $firstname = $_POST['firstname'];
    $lastname = $_POST['lastname'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    
    
    if ($password === $confirm_password) {
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        $query = "INSERT INTO korisnici (ime, prezime, korisnicko_ime, lozinka, razina) VALUES (?, ?, ?, ?, 0)";

        $stmt = mysqli_prepare($dbc, $query);
        if ($stmt) {
            mysqli_stmt_bind_param($stmt, "ssss", $firstname, $lastname,$username, $hashed_password);

            if (mysqli_stmt_execute($stmt)) {
                echo "<script>alert('Registracija uspješna')</script>";
                header("location:index.php");
            } else {
                echo "<script>alert('Registracija neuspješna')</script>";
            }
            mysqli_stmt_close($stmt);
        } else {
            echo "<script>alert('Greška')</script>";
        }
        mysqli_close($dbc);
    } else {
        echo "<script>alert('Lozinke se ne podudaraju')</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="hr">
<head>
    <meta charset="UTF-8">
    <title>Registracija</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <header>   <div class="header-datum">
            <p>Sat, May 18, 2019</p>
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
            <li><a href="prijava.php">Prijava</a></li>
            <li><a href="registracija.php">Registracija</a></li>
        </ul>
    </nav></header>
    <div class="sredina">
    <h2>Registracija</h2>
    <br>
    <form action="registracija.php" method="post">
        <label for="username">Korisničko ime:</label>
        <input type="text" id="username" name="username" required><br><br>
        <label for="firstname">Ime:</label>
        <input type="text" id="firstname" name="firstname" required><br><br>
        <label for="lastname">Prezime:</label>
        <input type="text" id="lastname" name="lastname" required><br><br>
        <label for="password">Lozinka:</label>
        <input type="password" id="password" name="password" required><br><br>
        <label for="confirm_password">Potvrdite lozinku:</label>
        <input type="password" id="confirm_password" name="confirm_password" required><br><br>
        <input type="submit" value="Registriraj se">
    </form>
    </div>
    <footer>
        <p>&copy; 2024 Newsweek</p>
    </footer>
</body>
</html>
