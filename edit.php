<?php

require 'database.php';

$id = $_GET['id'] ?? 0;
$stmt = $pdo->prepare('SELECT id, title, summary, price, pages, release_date, language FROM books WHERE id = ?');
$stmt->execute([$id]);
$book = $stmt->fetch();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit book</title>
</head>
<body>
    <button><a href="book.php?id=<?= $book['id'] ?>">Back to book view</a></button><br>

    <form method="post" action="update_book.php">
        <input type="hidden" name="id" value="<?= $book['id'] ?>">
        <label for="title"><strong>Title:</strong></label><br>
        <input type="text" name="title" id="title" value="<?= $book['title'] ?>"><br>
    
        <label for="release_date"><strong>Release Date:</strong></label><br>
        <input type="number" name="release_date" id="release_date" min="1000" max="3000" step="1" value="<?= $book['release_date'] ?>"><br>

        <label for="price"><strong>Price:</strong></label><br>
        <input type="number" step="0.01" name="price" id="price" value="<?= $book['price'] ?>"><br>

        <label for="summary"><strong>Summary:</strong></label><br>
        <textarea name="summary" id="summary"><?= $book['summary'] ?></textarea><br>

        <label for="language"><strong>Language:</strong></label><br>
        <input type="text" name="language" id="language" value="<?= $book['language'] ?>"><br>

        <label for="pages"><strong>Pages:</strong></label><br>
        <input type="number" name="pages" id="pages" value="<?= $book['pages'] ?>"><br>

        <button type="submit">Save Changes</button>
    </form>

    <button><a href="edit_authors.php?id=<?= $book['id'] ?>">Edit authors</a></button><br>
</body>
</html>
