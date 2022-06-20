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
    <?php
        session_start();
        # baza danych
        $serverName = "127.0.0.1";
        $userName = "root";
        $userPassword = "";
        $databaseName = "sklep";

        $connect = new mysqli($serverName, $userName, $userPassword, $databaseName);

        if($connect->connect_error) 
        {
            echo "Błąd";
        } 
        $id = $_SESSION["id"];

        $sql = "SELECT `Stan_konta`, `Imię` FROM `users` WHERE `id` = '$id';";
        $result = $connect->query($sql);
        $row = $result->fetch_assoc();
        $saldo = $row["Stan_konta"];
        $imie = $row["Imię"];
        echo <<<HEREDOC
        Witaj $imie! <br>
        Twoje saldo wynosi: $saldo<br>
        <a href="przelew.php">Przelew</a>
        <a href="historia.php">Pełna historia</a>
        HEREDOC;
        $connect->close();

    ?>
    
</body>
</html>