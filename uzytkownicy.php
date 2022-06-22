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
    if(isset($_SESSION["email"]) and $_SESSION["uprawnienia"] >= 1)
    {
        echo <<<NAWIGACJA
            <div class="username">
                <h4>Konto serwisowe</h4>
                <a href="logowanie.php"><span class="material-symbols-outlined">logout</span></a>
            </div>
        </header>
        <nav>
            <a href="index.php">Strona główna</a>
            <a href="uzytkownicy.php">Użytkownicy</a>
            <a href="historia.php">Transakcje</a>
        </nav>
        <section>
            <h2>Użytkownicy</h2>
        NAWIGACJA;
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
        echo "Błąd";
    } 
    if($_SESSION["uprawnienia"] >= 1)
    {
        $sql = "SELECT `id`, `imie`, `nazwisko`, `email`, `haslo`, `uprawnienia`, `stanKonta` FROM `users`;";
        $result = $connect->query($sql);
        if($result->num_rows > 0)
        {
            echo <<<HEREDOC
            <table>
                    <tr>
                        <th>ID Użytkownika</th>
                        <th>Imię</th>
                        <th>Nazwisko</th>
                        <th>Email</th>
                        <th>Stan Konta</th>
                    </tr>
            HEREDOC;
            while($row = $result->fetch_assoc())
            {
                $idUzytkownika = $row["id"];
                $imie = $row["imie"];
                $nazwisko = $row["nazwisko"];
                $email = $row["email"];
                $stanKonta = $row["stanKonta"];
                echo <<<HEREDOC
                    <tr>
                        <td>$idUzytkownika</td>
                        <td>$imie</td>
                        <td>$nazwisko</td>
                        <td>$email</td>
                        <td>$stanKonta</td>
                    </tr>
                HEREDOC;
            }
            echo "</table>";
            if($_SESSION["uprawnienia"] == 2)
            {
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
                            $wiadomosc = "Dodawanie przebiegło pomyślnie.";
                            header("Refresh: uzytkownicy.php");
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
                }
                echo <<<HEREDOC
                <form action="uzytkownicy.php" method="post">
                    <label for="imie">Imię</label>
                    <input type="text" name="imie">
                    <label for="nazwisko">Nazwisko</label>
                    <input type="text" name="nazwisko">
                    <label for="email">E-mail</label>
                    <input type="text" name="email" id="">
                    <label for="password">Hasło</label>
                    <input type="password" name="passwordFirst">
                    <label for="password">Powtórz hasło</label>
                    <input type="password" name="passwordSecond">
                    <input type="submit" value="Dodaj użytkownika" id="button">
                </form>
                HEREDOC;
            }
            echo $wiadomosc."</section>";
        }
        else
        {
            echo "Brak użytkowników.";
        }
    }
    ?>
</body>
</html>