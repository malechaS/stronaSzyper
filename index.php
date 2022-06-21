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
    <nav>
        <a href="rejestracja.html">rejestracja</a>
        <a href="logowanie.html">logowanie</a>
        <a href="index.php">index</a>
        <a href="przelew.html">przelew</a>
        <a href="historia.php">historia</a>
    </nav>
    <?php
        session_start();
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
        Twoje saldo wynosi: $saldo PLN<br>
        <a href="przelew.html">Przelew</a><br>
        <a href="historia.php">Pełna historia</a>
        HEREDOC;
        $connect->close();

    ?>
    
</body>
</html>