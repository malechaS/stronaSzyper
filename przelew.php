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
    <header></header>
    <nav></nav>
    <section>
        <form action="przelew.php" method="post">
            <label for="nadawca">E-mail odbiorcy</label>
            <input type="text" name="email" id="">
            <label for="kwota">Kwota</label>
            <input type="number" step="0.01" name="kwota" id="">
            <input type="submit" value="Wyślij" id="button">
        </form>
        <?php
        session_start();
        if($_SERVER["REQUEST_METHOD"] == "POST")
        {
            date_default_timezone_set("Europe/Warsaw");

            $odbiorca = $_POST["email"];
            $kwota = $_POST["kwota"];
            $nadawca = $_SESSION["id"];
            $currentDATATIME = date("Y-m-d h:i:s");
            $saldo = $_SESSION["saldo"] + $_POST["kwota"];

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
            $sql = "SELECT `id` FROM `users` WHERE `Email` = '$odbiorca';";
            $result = $connect->query($sql);
            $row = $result->fetch_assoc();
            $odbiorcaID = $row["id"];

            $sql = "INSERT INTO `transactions`(`nadawca`, `odbiorca`, `kwota`, `data`) VALUES ('$nadawca','$odbiorcaID','$kwota','$currentDATATIME');";
            $sql .= "UPDATE `users` SET `Stan_konta`='$saldoOdbiorcy' WHERE `id` = '$odbiorcaID';";
            $sql .= "UPDATE `users` SET `Stan_konta`='$saldoNadawcy' WHERE `id` = '$nadawcaID';";
            if($connect->multi_query($sql) === TRUE)
            {
                echo "Przelew został wykonany";
            }
            $connect->close();
        }
        ?>
    </section>
</body>
</html>