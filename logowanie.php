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
        ZALOGOWANY;
        unset($_SESSION["email"]);
        echo "Nastąpiło wylogowanie<br>Za 5 sekund nastąpi przekierowanie na stronę główną.";
        header("Refresh: 5; index.php");
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
            <form action="logowanie.php" method="post">
                <label for="email">E-mail</label>
                <input type="text" name="email" id="">
                <label for="password">Hasło</label>
                <input type="password" name="password" id="">
                <input type="submit" value="Zaloguj" id="button">
            </form>
        
    NIEZALOGOWANY;
    }
    if($_SERVER["REQUEST_METHOD"] == "POST")
        {
            if(!empty($_POST["email"]) and !empty($_POST["password"]))
            {
                $email = $_POST["email"];
                $password = $_POST["password"];
    
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
                $sql = "SELECT `id`, `haslo`, `imie`, `stanKonta`, `uprawnienia` FROM `users` WHERE `email` = '$email';";
                $result = $connect->query($sql);
                if ($result->num_rows > 0) 
                {
                    $row = $result->fetch_assoc();
                    if(password_verify($password, $row["haslo"]))
                    {
                        $_SESSION["email"] = $email;
                        $_SESSION["id"] = $row["id"];
                        $_SESSION["imie"] = $row["imie"];
                        $_SESSION["saldo"] = $row["stanKonta"];
                        $_SESSION["uprawnienia"] = $row["uprawnienia"];
                        $wiadomosc = "Zalogowano <br>Za 5 sekund nastąpi przekierowanie na stronę główną.";
                        header("Refresh: 5; index.php");
                    }
                    else
                    {
                        $wiadomosc = "Niepoprawne hasło";
                    }
                } 
                else 
                {
                    $wiadomosc = "Nie istnieje takie konto";
                }
                $connect->close();
            }
            else
            {
                $wiadomosc = "Wypełnij wszystkie pola";
            }
        }
        echo $wiadomosc."</section>";
    ?>
</body>
</html>