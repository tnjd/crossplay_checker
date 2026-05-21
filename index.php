<?php
require_once('db.php');

$result = null;
$searched_word = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $searched_unsafe = trim($_POST['word'] ?? '');
    $searched = htmlspecialchars($searched_unsafe);

    if ($searched_unsafe !== '') {
        $words_db = setup_db();
        $dbresult = query_word($words_db, $searched_unsafe);
        if (count($dbresult) === 0) {
            $result = false;
        } else {
            $result = $dbresult[0];
            $definition = $result[0];
            $partOfSpeech = $result[1];
            $pronunciation = $result[2];
        }
    }
}

?>


<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<link rel="stylesheet" href="main.css"></link>
</head>
<body>

<h1 class="entry-title">
Crossplay Word Checker
</h1>

<form method="POST" action="">
    <input type="text" name="word" value="<?= htmlspecialchars($searched) ?>">
    <button type="submit">Check</button>
</form>

<?php if ($result === false): ?>
    <p> <strong><?= $searched ?></strong> is not a valid word.</p>
<?php elseif (is_array($result)): ?>
    <p> <strong><?= $searched ?></strong> is a valid word.</p>
    <p> <?= $definition ?> </p>
    <p> <?= $partOfSpeech ?> </p>
    <p> <?= $pronunciation ?> </p>
<?php endif; ?>


</body>
</html>
