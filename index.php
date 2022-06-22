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
        
        $sql = "SELECT `stanKonta`, `imie` FROM `users` WHERE `id` = '$id';";
        
        $result = $connect->query($sql);
        $row = $result->fetch_assoc();
        $_SESSION["saldo"] = $row["stanKonta"];

        $saldo = $row["stanKonta"];
        $imie = $row["imie"];
        echo <<<HEREDOC
        Witaj $imie! <br>
        Twoje saldo wynosi: $saldo zł<br>
        <a href="przelew.php">Przelew</a><br>
        <a href="historia.php">Pełna historia</a>
        HEREDOC;
        $connect->close();
        echo "</section>";
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
            <h2>To jest bank</h2>
            <p>Lorem, ipsum dolor sit amet consectetur adipisicing elit. Dolores aliquid commodi similique, at optio harum porro ipsum reprehenderit perspiciatis! Voluptas illo quaerat similique ut optio quia perspiciatis cupiditate doloremque facilis.</p>
        </section>
        NIEZALOGOWANY;
    }
    ?>
</body>
</html>