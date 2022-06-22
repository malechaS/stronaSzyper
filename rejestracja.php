<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Strona</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
</head>
<body>
    <header>
        <h1>Bank</h1>
    <?php
    $wiadomosc = "";
    session_start();
    if(isset($_SESSION["email"]))
    {
        $imie = $_SESSION["imie"];
        echo <<<ZALOGOWANY
        <div class="username">
            <h4>$imie</h4>
            <a href="logowanie.php"><span class="material-symbols-outlined">logout</span></a>
        </div>
        </header>
            <nav>
                <a href="index.php">Strona główna</a>
                <a href="przelew.php">Przelew</a>
                <a href="historia.php">Historia transakcji</a>
            </nav>
        <section>
            <p>Masz już zalożone konto. </p>
        </section>
        ZALOGOWANY;
    }
    else
    {
        echo <<<NIEZALOGOWANY
        </header>
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
        if(!empty($_POST["imie"]) and !empty($_POST["nazwisko"]) and !empty($_POST["email"]) and !empty($_POST["passwordFirst"]) and !empty($_POST["passwordSecond"]))
        {
            $imie = $_POST["imie"];
            $nazwisko = $_POST["nazwisko"];
            $email = $_POST["email"];
            $passwordFirst = $_POST["passwordFirst"];
            $passwordSecond = $_POST["passwordSecond"];
            if($passwordFirst == $passwordSecond)
            {
                $password = password_hash($passwordFirst, PASSWORD_DEFAULT);

                # baza danych
                $serverName = "127.0.0.1";
                $userName = "root";
                $userPassword = "";
                $databaseName = "bank";

                $connect = new mysqli($serverName, $userName, $userPassword, $databaseName);

                if($connect->connect_error) 
                {
                    $wiadomosc = "Błąd połączenia z bazą danych";
                } 
                $sql = "INSERT INTO `users` (`id`, `imie`, `nazwisko`, `email`, `haslo`, `uprawnienia`) VALUES (NULL, '$imie', '$nazwisko', '$email', '$password', '0');";
                if($connect->query($sql) === TRUE)
                {
                    $wiadomosc = "Rejestracja przebiegła pomyślnie.";
                }
                $connect->close();
            } 
            else
            {
                $wiadomosc = "Hasła muszą być identyczne";
            }
        }
        else
        {
            $wiadomosc = "Wypełnij wszystkie pola";
        }
        echo $wiadomosc."</section>";
    }
    ?>
</body>
</html>