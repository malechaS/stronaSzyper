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
        if($_SERVER["REQUEST_METHOD"] == "POST")
        {
            # TODO Dodać walidację pól
            $email = $_POST["email"];
            $password = $_POST["password"];

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
            $sql = "SELECT `id`, `hasło` FROM `users` WHERE `email` = '$email';";
            $result = $connect->query($sql);
            if ($result->num_rows > 0) 
            {
                $row = $result->fetch_assoc();
                $id = $row["id"];
                echo $row["hasło"];
                if($row["hasło"] == $password)
                {
                    echo "zalogowano";
                    $_SESSION["id"] = $id;
                    header("Location: index.php");
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
            echo $_SESSION["id"];
        }
    ?>
</body>
</html>