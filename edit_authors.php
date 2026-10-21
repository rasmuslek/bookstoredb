<?php

require "connection.php";

$id = $_GET['id'] ?? 0;


$stmt = $pdo->prepare('SELECT id FROM books WHERE id = ?');
$stmt->execute([$id]);
$book = $stmt->fetch();
$stmt = $pdo->prepare(
    'SELECT authors.first_name, authors.last_name
     FROM authors
     JOIN book_authors ON authors.id = book_authors.author_id
     WHERE book_authors.book_id = ?'
);
$stmt->execute([$id]);
$authors = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <button><a href="edit_book.php?id=<?= $book['id'] ?>">Back to book edit view</a></button><br>

    <h2>Current authors:</h2><ol>
        <?php foreach ($authors as $author) { ?>
            <li><?=($author['first_name'] . ' ' . $author['last_name']) ?></li>
        <?php } ?>

    </ol>

</body>
</html>