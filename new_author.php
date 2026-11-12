<?php

require "database.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $stmt = $pdo->prepare('INSERT INTO authors (first_name, last_name) VALUES (?, ?)');
    $stmt->execute([$_POST['first_name'], $_POST['last_name']]);

}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
        <form method="post" >
            <input name="first_name" placeholder="First name" required>
            <input name="last_name" placeholder="Last name" required>
            <button type="submit" name="new_author">Create new author</button>
        </form>

        <button><a href="index.php">Back to list</a></button>
</body>
</html>