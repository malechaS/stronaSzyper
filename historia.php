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
        if($_SESSION["uprawnienia"] == 0)
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
                <h2>Historia transakcji</h2>
            ZALOGOWANY;
        }
        else
        {
            echo <<<NAWIGACJA
                <div class="username">
                    <h4>Konto serwisowe</h4>
                    <a href="logowanie.php"><span class="material-symbols-outlined">logout</span></a>
                    <a href=""><span class="material-symbols-outlined">settings</span></a>
                </div>
            </header>
            <nav>
                <a href="index.php">Strona główna</a>
                <a href="uzytkownicy.php">Użytkownicy</a>
                <a href="historia.php">Transakcje</a>
            </nav>
            <section>
                <h2>Historia transakcji</h2>
            NAWIGACJA;
        }
        
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
            <p>Nie masz dostępu do tej strony. <a href="logowanie.php">Zaloguj się</a></p>
        </section>
        NIEZALOGOWANY;
    }
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
    if($_SESSION["uprawnienia"] == 0)
    {
        $email = $_SESSION["email"];
        $nadawcaID = $_SESSION["id"];

        $sql = "SELECT `email`, `transactions`.`kwota`, `transactions`.`data` FROM `transactions` 
        INNER JOIN `users` ON `users`.`id` = `transactions`.`idOdbiorcy` 
        WHERE `transactions`.`idNadawcy` = '$nadawcaID';";
        $result = $connect->query($sql);
        if($result->num_rows > 0)
        {
            echo <<<HEREDOC
            <table>
                    <tr>
                        <th>Odbiorca</th>
                        <th>Kwota</th>
                        <th>Data</th>
                    </tr>
            HEREDOC;
            while($row = $result->fetch_assoc())
            {
                $email = $row["email"];
                $kwota = $row["kwota"];
                $data = $row["data"];
                echo <<<HEREDOC
                    <tr>
                        <td>$email</td>
                        <td>$kwota zł</td>
                        <td>$data</td>
                    </tr>
                HEREDOC;
            }
            echo "</table>";
        }
        else
        {
            $wiadomosc = "Brak historii.";
        }
    }
    else
    {
        $sql = "SELECT `idTransakcji`, `idNadawcy`, `idOdbiorcy`, `kwota`, `data` FROM `transactions`;";
        $result = $connect->query($sql);
        if($result->num_rows > 0)
        {
            echo <<<HEREDOC
            <table>
                    <tr>
                        <th>ID Transakcji</th>
                        <th>Nadawca</th>
                        <th>Odbiorca</th>
                        <th>Kwota</th>
                        <th>Data</th>
                    </tr>
            HEREDOC;
            while($row = $result->fetch_assoc())
            {
                $idTransakcji = $row["idTransakcji"];
                $idNadawcy = $row["idNadawcy"];
                $idOdbiorcy = $row["idOdbiorcy"];
                $kwota = $row["kwota"];
                $data = $row["data"];
                echo <<<HEREDOC
                    <tr>
                        <td>$idTransakcji</td>
                        <td>$idNadawcy</td>
                        <td>$idOdbiorcy</td>
                        <td>$kwota zł</td>
                        <td>$data</td>
                    </tr>
                HEREDOC;
            }
            echo "</table></section>";
        }
        else
        {
            $wiadomosc = "Brak historii.";
        }
    }
    $connect->close();
    ?>
</body>
</html>