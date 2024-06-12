<?php

session_start();


include 'connect.php';

$datum = date('D,M d,Y');

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $username = $_POST['username'];
    $password = $_POST['password'];
    $query = "SELECT id, korisnicko_ime, lozinka, razina FROM korisnici WHERE korisnicko_ime = ?";
    if ($stmt = mysqli_prepare($dbc, $query)) {
        mysqli_stmt_bind_param($stmt, "s", $username);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_bind_result($stmt, $id, $username, $hashed_password, $level);
        if (mysqli_stmt_fetch($stmt)) {
         
            if (password_verify($password, $hashed_password)) {
               
                $_SESSION['korisnicko_ime'] = $username;
                $_SESSION['razina'] = $level;
                header("Location: index.php");
            } else {
                echo "<script>alert('Pogrešno korisničko ime ili lozinka')</script>";
            }
        } else {
            echo "<script>alert('Pogrešno korisničko ime ili lozinka')</script>";
        }
        mysqli_stmt_close($stmt);
    } else {
        echo "<script>alert('Greška ')</script>";
    }
    mysqli_close($dbc);
}
?>

<!DOCTYPE html>
<html lang="hr">
<head>
    <meta charset="UTF-8">
    <title>Prijava</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<header>
<div class="header-datum">
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
    </nav>
   <div class="sredina">
    <h2>Prijava</h2>
    <br>
    <form action="prijava.php" method="post">
        <label for="username">Korisničko ime:</label>
        <input type="text" id="username" name="username" required><br><br>
        <label for="password">Lozinka:</label>
        <input type="password" id="password" name="password" required><br><br>
        <input type="submit" value="Prijavi se">
    </form>
    </div>
    <footer>
        <p>&copy; 2024 Newsweek</p>
    </footer>
</body>
</html>

