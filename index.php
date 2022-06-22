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
            ZALOGOWANY;

            $saldo = $_SESSION["saldo"];
            $imie = $_SESSION["imie"];
            echo <<<HEREDOC
            <section>
                Witaj $imie! <br>
                Twoje saldo wynosi: $saldo zł<br>
            </section>
            HEREDOC;

            echo "";
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
            NAWIGACJA;

            echo <<<WIADOMOSC
            <section>
                <p>To jest konto serwisowe</p>
            </section>
            WIADOMOSC;
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
            <h2>To jest bank</h2>
            <p>Lorem, ipsum dolor sit amet consectetur adipisicing elit. Dolores aliquid commodi similique, at optio harum porro ipsum reprehenderit perspiciatis! Voluptas illo quaerat similique ut optio quia perspiciatis cupiditate doloremque facilis.</p>
        </section>
        NIEZALOGOWANY;
    }
    ?>
</body>
</html>