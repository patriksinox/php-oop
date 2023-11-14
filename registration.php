

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <?php require "../php-oop/components/header.php" ?>
    <h1>Registrácia</h1>
    <form action="admin/after-registration.php" method="POST">

    <input type="text" name="first_name" placeholder="first_name"> <br>
    <input type="text" name="second_name" placeholder="second_name"> <br>
    <input type="email" name="email" placeholder="email"> <br>
    <input type="password" name="password" placeholder="password"> <br>
    <input type="password" name="password-again" placeholder="password-again"> <br>
    <input type="submit" value="Registrovať">

    </form>


</body>
</html>