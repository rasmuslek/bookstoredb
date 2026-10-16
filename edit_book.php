<?php

require "connection.php";

$id = $_GET['id'] ?? 0;



if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $stmt = $pdo->prepare(
        'UPDATE books SET title = ?, summary = ?, price = ? WHERE id = ?'
    );

    $stmt->execute([
        $_POST['title'],
        $_POST['summary'],
        $_POST['price'],
        $id
    ]);

}

$stmt = $pdo->prepare('SELECT id, title, summary, price FROM books WHERE id = ?');
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
        <label for="title">Title:</label>
        <input type="text" name="title" id="title"><br>
        <p><?= ($book['title']) ?></p>

        <label for="summary">Summary:</label>
        <textarea name="summary" id="summary" ></textarea><br>
        <p><?= ($book['summary']) ?></p>

        <label for="price">Price:</label>
        <input type="number" step="0.01" name="price" id="price"  ><br>
        <p><?=round($book['price'], 2) ?>$</p>

        <button type="submit">Save Changes</button>

</body>
</html>