<?php

require "database.php";

$search = $_GET['search'] ?? '';

$stmt = $pdo->prepare(
    'SELECT id, title FROM books
     WHERE is_deleted = 0 AND title LIKE ?'
);
$stmt->execute(["%$search%"]);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {    
    $stmt = $pdo->prepare('INSERT INTO authors (first_name, last_name) VALUES (?, ?)');
    $stmt->execute([$_POST['first_name'], $_POST['last_name']]);
    header('Location: index.php');
    exit;
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




    <form method="get">
        <input name="search" placeholder="Search titles"
            value="<?= $search ?>">
        <button>Search</button>
        <button><a href="index.php">Clear</a></button>
    </form>

    <ol>
        <?php while ($book = $stmt->fetch()) { ?>
            <li><a href="book.php?id=<?= $book['id'] ?>"><?= ($book['title']) ?></a></li>
            <?php } ?>
    </ol>

</body>
</html>
