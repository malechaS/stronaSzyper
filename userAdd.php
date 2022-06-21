<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Strona</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <nav>
        <a href="rejestracja.html">rejestracja</a>
        <a href="logowanie.html">logowanie</a>
        <a href="index.php">index</a>
        <a href="przelew.html">przelew</a>
        <a href="historia.php">historia</a>
    </nav>
    <?php
        if($_SERVER["REQUEST_METHOD"] == "POST")
        {
            # TODO Dodać walidację pól
            $imie = $_POST["imie"];
            $nazwisko = $_POST["nazwisko"];
            $email = $_POST["email"];
            $passwordFirst = $_POST["passwordFirst"];
            $passwordSecond = $_POST["passwordSecond"];
            if($passwordFirst == $passwordSecond)
            {
                $password = password_hash($passwordFirst, PASSWORD_DEFAULT);
            }
            # baza danych
            $serverName = "127.0.0.1";
            $userName = "root";
            $userPassword = "";
            $databaseName = "bank";

            $connect = new mysqli($serverName, $userName, $userPassword, $databaseName);

            if($connect->connect_error) 
            {
                echo "Błąd";
            } 
            $sql = "INSERT INTO `users` (`id`, `imie`, `nazwisko`, `email`, `haslo`, `uprawnienia`) VALUES (NULL, '$imie', '$nazwisko', '$email', '$password', '0');";
            if($connect->query($sql) === TRUE)
            {
                echo "Sukces";
            }
            $connect->close();
        }
    ?>
</body>
</html>