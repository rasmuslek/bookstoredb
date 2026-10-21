<?php

require "connection.php";

$id = $_GET['id'] ?? 0;

if (isset($_POST['soft_delete'])) {
    $stmt = $pdo->prepare('UPDATE books SET is_deleted = 1 WHERE id = ?');
    $stmt->execute([$id]);

    header('Location: index.php');
    exit;
}

$stmt = $pdo->prepare('SELECT id, title, cover_path, summary, price, language, is_deleted, release_date, pages FROM books WHERE id = ?');
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
        <h2>
            <?php foreach ($authors as $index => $author) { 
                if ($index > 0) {
                    echo ', ';
                }
                echo $author['first_name'] . ' ' . $author['last_name'];
            } ?>
        </h2>
        <h3>Released: <?= $book['release_date'] ?></h3>
        <p><strong>Price:</strong> <?= round($book['price'], 2) ?>€</p>
        <p><strong>Summary:</strong> <?= ($book['summary']) ?></p>
        <p><strong>Language:</strong> <?= ($book['language']) ?></p>
        <p><strong>Pages:</strong> <?= ($book['pages']) ?></p>



        <img src="<?= $book['cover_path'] ?>" alt="<?= ($book['title']) ?>"><br>
        <button><a href="edit_book.php?id=<?= $book['id'] ?>">Edit book</a></button>
        <?php if (!$book['is_deleted']) { ?>
            <form method="post">    
                <button type="submit" name="soft_delete" value="1">Remove from list</button>
            </form>
        <?php } ?>

</body>
</html>
