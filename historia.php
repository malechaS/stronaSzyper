<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Strona</title>
    <link rel="stylesheet" href="style.css">
    <style>
        table, tr, td, th {
            border: solid 1px black;
        }
    </style>
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
                <h2>Historia transakcji</h2>
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
            echo "Błąd";
        } 
        $id = $_SESSION["id"];

        $sql = "SELECT `email`, `transactions`.`kwota`, `transactions`.`data` FROM `transactions` 
        INNER JOIN `users` ON `users`.`id` = `transactions`.`idOdbiorcy` 
        WHERE `transactions`.`idNadawcy` = '$id';";
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
            echo "Brak historii.";
        }
        
        $connect->close();

    ?>
</body>
</html>