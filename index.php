<?php

require "connection.php";

$search = $_GET['search'] ?? '';

$stmt = $pdo->prepare(
    'SELECT id, title FROM books
     WHERE is_deleted = 0 AND title LIKE ?'
);
$stmt->execute(["%$search%"]);

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
