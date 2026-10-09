<?php

require "connection.php";

$id = $_GET['id'] ?? 0;

$stmt = $pdo->prepare('SELECT id, title, cover_path, summary, price FROM books WHERE id = ?');
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
    <title>Book</title>
</head>
<body>
        <button><a href="index.php">Back to list</a></button>
        <h1><?= ($book['title']) ?></h1>
        <h2>Book ID: <?= $book['id'] ?></h2>
        <p><strong>Authors:</strong>
            <?php foreach ($authors as $author) { ?>
                <?=($author['first_name'] . ' ' . $author['last_name']) ?>
            <?php } ?>
        </p>
        <p><strong>Summary:</strong> <?= ($book['summary']) ?></p>
        <p><strong>Price:</strong> <?= round($book['price'], 2) ?>€</p>
        <img src="<?= $book['cover_path'] ?>" alt="<?= ($book['title']) ?>">
</body>
</html>
