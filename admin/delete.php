<?php
require_once '../config.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    redirect('index.php');
}

$id = isset($_POST['id']) ? (int)$_POST['id'] : 0;

if ($id <= 0) {
    setFlash('error', 'ID inválido!');
    redirect('index.php');
}

$questions = loadQuestions();
$questions = array_filter($questions, function($question) use ($id) {
    return $question['id'] != $id;
});

// Reindexar array
$questions = array_values($questions);

saveQuestions($questions);
setFlash('success', 'Questão deletada com sucesso!');
redirect('index.php');
