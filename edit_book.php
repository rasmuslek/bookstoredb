<?php

require "connection.php";

$id = $_GET['id'] ?? 0;



if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $changes = [];
    $values = [];

    foreach (['title', 'summary', 'price', 'pages', 'release_date', 'language'] as $temp) {
        $value = trim($_POST[$temp] ?? '');
        if ($value !== '') {
            $changes[] = "$temp = ?";
            $values[] = $value;
        }
    }

    if ($changes) {
        $values[] = $id;
        $stmt = $pdo->prepare(
            'UPDATE books SET ' . implode(', ', $changes) . ' WHERE id = ?'
        );
        $stmt->execute($values);
    }

}

$stmt = $pdo->prepare('SELECT id, title, summary, price, pages, release_date, language FROM books WHERE id = ?');
$stmt->execute([$id]);
$book = $stmt->fetch();
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>

    <button><a href="book.php?id=<?= $book['id'] ?>">Back to book view</a></button><br>

    <form method="post" action="edit_book.php?id=<?= $id ?>">

        <label for="title"><strong>Title:</strong></label><br>
        <input type="text" name="title" id="title"><br>
        <p><?= ($book['title']) ?></p>

        <label for="release_date"><strong>Release Date:</strong></label><br>
        <input type="number" name="release_date" id="release_date" min="1000" max="3000" step="1"><br>
        <p><?= ($book['release_date']) ?></p>

        <label for="price"><strong>Price:</strong></label><br>
        <input type="number" step="0.01" name="price" id="price">
        <p><?=round($book['price'], 2) ?>$</p>

        <label for="summary"><strong>Summary:</strong></label><br>
        <textarea name="summary" id="summary" ></textarea>
        <p><?= ($book['summary']) ?></p>

        <label for="language"><strong>Language:</strong></label><br>
        <input type="text" name="language" id="language"><br>
        <p><?= ($book['language']) ?></p>

        <label for="pages"><strong>Pages:</strong></label><br>
        <input type="number" name="pages" id="pages">
        <p><?= ($book['pages']) ?></p>

        <button type="submit">Save Changes</button>
    </form>
</body>
</html>
