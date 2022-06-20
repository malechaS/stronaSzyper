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
            $sql = "INSERT INTO `users` (`id`, `Imię`, `Nazwisko`, `Email`, `Hasło`, `Uprawnienia`) VALUES (NULL, '$imie', '$nazwisko', '$email', '$password', '0');";
            if($connect->query($sql) === TRUE)
            {
                echo "Sukces";
            }
            $connect->close();
        }
    ?>
</body>
</html>