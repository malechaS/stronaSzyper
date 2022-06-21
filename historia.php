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

        $sql = "SELECT `email`, `transactions`.`kwota`, `transactions`.`data` FROM `transactions` 
        INNER JOIN `users` ON `users`.`id` = `transactions`.`idOdbiorcy` 
        WHERE `transactions`.`idNadawcy` = '$id';";
        $result = $connect->query($sql);
        if($result->num_rows > 0)
        {
            echo <<<HEREDOC
            <table>
                    <tr>
                        <th>Email</th>
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
                        <td>$kwota</td>
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