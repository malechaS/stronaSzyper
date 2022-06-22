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
                <h2>Formularz przelewu</h2>
                <form action="przelew.php" method="post">
                    <label for="nadawca">E-mail odbiorcy</label>
                    <input type="text" name="email" id="">
                    <label for="kwota">Kwota</label>
                    <input type="number" step="0.01" name="kwota" id="">
                    <input type="submit" value="Wyślij" id="button">
                </form>
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
                <p>Nie masz dostępu do tej strony. <a href="logowanie.php">Zaloguj się</a></p>
            </section>
            NIEZALOGOWANY;
        }
        if($_SERVER["REQUEST_METHOD"] == "POST")
        {
            date_default_timezone_set("Europe/Warsaw");

            $odbiorca = $_POST["email"];
            $kwota = $_POST["kwota"];
            $nadawcaID = $_SESSION["id"];
            $currentDATATIME = date("Y-m-d h:i:s");

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
            $saldoNadawcy = $_SESSION["saldo"] - $_POST["kwota"];

            if($saldoNadawcy >= 0)
            {
                $sql = "SELECT `id`, `stanKonta` FROM `users` WHERE `email` = '$odbiorca';";
                $result = $connect->query($sql);
                $row = $result->fetch_assoc();
                $odbiorcaID = $row["id"];
                $saldoOdbiorcy = $row["stanKonta"] + $_POST["kwota"];

                $sql = "INSERT INTO `transactions`(`idNadawcy`, `idOdbiorcy`, `kwota`, `data`) VALUES ('$nadawcaID','$odbiorcaID','$kwota','$currentDATATIME');";
                $sql .= "UPDATE `users` SET `stanKonta`='$saldoOdbiorcy' WHERE `id` = '$odbiorcaID';";
                $sql .= "UPDATE `users` SET `stanKonta`='$saldoNadawcy' WHERE `id` = '$nadawcaID';";
                if($connect->multi_query($sql) === TRUE)
                {
                    $wiadomosc = "Przelew został wykonany";
                }
            }
            else
            {
                $wiadomosc = "Brak środków na koncie.";
            }
            $connect->close();
            echo $wiadomosc."</section>";
        }
        ?>
    </section>
</body>
</html>