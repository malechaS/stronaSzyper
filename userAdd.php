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
            $imie = $_POST["imie"];
            $nazwisko = $_POST["nazwisko"];
            $email = $_POST["email"];
            $passwordFirst = $_POST["passwordFirst"];
            $passwordSecond = $_POST["passwordSecond"];
            
        }
    ?>
</body>
</html>