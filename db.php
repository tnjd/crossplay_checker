<?php

function setup_db() {
    return new PDO('sqlite:words.sqlite');
}

function query_word($words_db, $word) {
    $stmt = $words_db->prepare('select definition, partOfSpeech, pronunciation from word where word == ? collate nocase');
    $stmt->execute([$word]);
    return $stmt->fetchAll();
}

?>
