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
<meta name="viewport"
      content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0"/>
<link rel="stylesheet" href="main.css">
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&family=Manrope:wght@200..800&family=Noto+Emoji:wght@300..700&display=swap" rel="stylesheet">
<title>Crossplay Word Checker</title>
</head>
<body>

<div class="bg">
<div class="checker">
    <h1 class="entry-title">
    Crossplay Word Checker
    </h1>

    <form method="POST">
        <input type="text" name="word" value="<?= htmlspecialchars($searched) ?>"><button type="submit">🔍</button>
    </form>

    <div class="result">
        <?php if ($result === false): ?>
            <p> <strong><?= $searched ?></strong> is not a valid word</p>
        <?php elseif (is_array($result)): ?>
            <p class='word-result'> <strong><?= $searched ?></strong></p>
            <p class='definition'> <?= $definition ?> <?php if ($partOfSpeech): ?>[<?= $partOfSpeech ?>]<?php endif; ?></p>
            <?php if ($partOfSpeech): ?>
                <p class='pronunciation'> /<?= $pronunciation ?>/ </p>
            <?php endif; ?>
        <?php endif; ?>
    </div>
</div>
</div>
</body>
</html>
