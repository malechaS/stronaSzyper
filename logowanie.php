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
        ZALOGOWANY;
        unset($_SESSION["email"]);
        echo "Nastąpiło wylogowanie<br>Za 5 sekund nastąpi przekierowanie na stronę główną.";
        header("Refresh: 5; index.php");
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
            # TODO Dodać walidację pól
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
                echo "Błąd";
            } 
            $sql = "SELECT `id`, `haslo` FROM `users` WHERE `email` = '$email';";
            $result = $connect->query($sql);
            if ($result->num_rows > 0) 
            {
                $row = $result->fetch_assoc();
                if($row["haslo"] == $password)
                {
                    $_SESSION["email"] = $email;
                    $_SESSION["id"] = $row["id"];
                    echo "Zalogowano <br>Za 5 sekund nastąpi przekierowanie na stronę główną.";
                    header("Refresh: 5; index.php");
                }
                else
                {
                    echo "Niepoprawne hasło";
                }
            } 
            else 
            {
                echo "Nie istnieje takie konto";
            }
            $connect->close();
            echo "</section>";
        }
    ?>
</body>
</html>