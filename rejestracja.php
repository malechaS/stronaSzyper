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
    <header>
        <h1>Bank</h1>
    </header>
    <?php
    session_start();
    if(isset($_SESSION["email"]))
    {
        echo <<<ZALOGOWANY
            <nav>
                <a href="index.php">Strona główna</a>
                <a href="przelew.php">Przelew</a>
                <a href="historia.php">Historia transakcji</a>
                <a href="logowanie.php">Wyloguj</a>
            </nav>
        <section>
            <p>Masz już zalożone konto. </p>
        </section>
        ZALOGOWANY;
    }
    else
    {
        echo <<<NIEZALOGOWANY
        <nav>
            <a href="index.php">Strona główna</a>
            <a href="logowanie.php">Logowanie</a>
            <a href="rejestracja.php">Rejestracja</a>
        </nav>
        <section>
            <form action="rejestracja.php" method="post">
                <label for="imie">Imię</label>
                <input type="text" name="imie">
                <label for="nazwisko">Nazwisko</label>
                <input type="text" name="nazwisko">
                <label for="email">E-mail</label>
                <input type="text" name="email" id="">
                <label for="password">Hasło</label>
                <input type="password" name="passwordFirst" id="">
                <label for="password">Powtórz hasło</label>
                <input type="password" name="passwordSecond" id="">
                <input type="submit" value="Zarejestruj" id="button">
            </form>
        
        NIEZALOGOWANY;
    }
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
            $password = $passwordFirst;
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
            echo "Rejestracja przebiegła pomyślnie.";
        }
        $connect->close();
        echo "</section>";
    }
    ?>
</body>
</html>