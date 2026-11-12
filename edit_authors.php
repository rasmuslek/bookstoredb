<?php
require "database.php";

$bookId = (int) ($_GET['id'] ?? 0);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['remove'])) {
        $stmt = $pdo->prepare('DELETE FROM book_authors WHERE book_id = ? AND author_id = ?');
        $stmt->execute([$bookId, $_POST['author_id']]);
    }

    if (isset($_POST['add'])) {
        $stmt = $pdo->prepare('INSERT INTO book_authors (book_id, author_id) VALUES (?, ?)');
        $stmt->execute([$bookId, $_POST['author_id']]);
    }
}

$stmt = $pdo->prepare(
    'SELECT authors.id, authors.first_name, authors.last_name
     FROM authors
     JOIN book_authors ON authors.id = book_authors.author_id
     WHERE book_authors.book_id = ?
     ORDER BY authors.last_name, authors.first_name'
);
$stmt->execute([$bookId]);
$authors = $stmt->fetchAll();

$stmt = $pdo->prepare(
    'SELECT id, first_name, last_name FROM authors
     WHERE id NOT IN (SELECT author_id FROM book_authors WHERE book_id = ?)
     ORDER BY last_name, first_name'
);
$stmt->execute([$bookId]);
$availableAuthors = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit authors</title>
</head>
<body>
    <button><a href="edit.php?id=<?= $bookId ?>">Back to book edit view</a></button>

    <h2>Current authors</h2>
    <?php foreach ($authors as $author) { ?>
        <form method="post">
            <?= $author['first_name'] . ' ' . $author['last_name'] ?>
            <input type="hidden" name="author_id" value="<?= $author['id'] ?>">
            <button type="submit" name="remove">Remove</button>
        </form>
    <?php } ?>

    <h2>Add an author</h2>
    <?php if ($availableAuthors) { ?>
        <form method="post">
            <select name="author_id">
                <?php foreach ($availableAuthors as $author) { ?>
                    <option value="<?= $author['id'] ?>">
                        <?= $author['first_name'] . ' ' . $author['last_name'] ?>
                    </option>
                <?php } ?>
            </select>
            <button type="submit" name="add">Add</button>
        </form>
    <?php } ?>
</body>
</html>
