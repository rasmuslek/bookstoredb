<?php

require 'database.php';

$id = $_GET['id'];

if (isset($_POST['soft_delete'])) {
    $stmt = $pdo->prepare('UPDATE books SET is_deleted = 1 WHERE id = ?');
    $stmt->execute([$id]);

    header('Location: index.php');
    exit;
}

$bookStmt = $pdo->prepare('SELECT * FROM books WHERE id = :id;');
$bookStmt->execute(['id' => $id]);
$book = $bookStmt->fetch();

$authorsStmt = $pdo->prepare('SELECT authors.first_name, authors.last_name
    FROM book_authors
    LEFT JOIN authors ON book_authors.author_id = authors.id
    WHERE book_authors.book_id = :book_id;');
$authorsStmt->execute(['book_id' => $id]);
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
        <?php if ($isSuccess == 'success') { ?>
            <span style="display: flex; justify-content: center; color: forestgreen; font-weight: bold; font-size: larger;">Muudatused salvestatud!</span>
        <?php } ?>
        <h1><?= ($book['title']) ?></h1>
            <?php while ($author = $authorsStmt->fetch()) { ?>
                <h2><?= $author['first_name'] ?> <?= $author['last_name'] ?></h2>
            <?php } ?>
        <h3>Released: <?= $book['release_date'] ?></h3>
        <p><strong>Price:</strong> <?= round($book['price'], 2) ?>€</p>
        <p><strong>Summary:</strong> <?= ($book['summary']) ?></p>
        <p><strong>Language:</strong> <?= ($book['language']) ?></p>
        <p><strong>Pages:</strong> <?= ($book['pages']) ?></p>



        <img src="<?= $book['cover_path'] ?>" alt="<?= ($book['title']) ?>"><br>
        <button><a href="edit.php?id=<?= $book['id'] ?>">Edit book</a></button>
        <?php if (!$book['is_deleted']) { ?>
            <form method="post">    
                <button type="submit" name="soft_delete" value="1">Remove from list</button>
            </form>
        <?php } ?>

</body>
</html>
