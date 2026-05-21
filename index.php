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
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&family=Manrope:wght@200..800&family=Noto+Emoji:wght@300..700&display=swap" rel="stylesheet">
</head>
<body>

<div class="bg">
<div class="checker">
    <h1 class="entry-title">
    Crossplay Word Checker
    </h1>

    <form method="POST" action="">
        <input type="text" name="word" value="<?= htmlspecialchars($searched) ?>"><button type="submit">🔍</button>
    </form>

    <div class="result">
        <?php if ($result === false): ?>
            <p> <strong><?= $searched ?></strong> is not a valid word.</p>
        <?php elseif (is_array($result)): ?>
            <p class='word-result'> <strong><?= $searched ?></strong></p>
            <p class='definition'> <?= $definition ?> [<?= $partOfSpeech ?>]</p>
            <p class='pronunciation'> <?= $pronunciation ?> </p>
        <?php endif; ?>
    </div>
</div>
</div>
</body>
</html>
