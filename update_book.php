<?php

require 'database.php';

$id = $_POST['id'];

$stmt = $pdo->prepare('UPDATE books
    SET title = :title,
        summary = :summary,
        price = :price,
        pages = :pages,
        release_date = :release_date,
        language = :language
    WHERE id = :id;');
$stmt->execute([
    'id' => $id,
    'title' => $_POST['title'],
    'summary' => $_POST['summary'],
    'price' => $_POST['price'],
    'pages' => $_POST['pages'],
    'release_date' => $_POST['release_date'],
    'language' => $_POST['language']
]);

header("Location: book.php?id={$id}&update=success");
