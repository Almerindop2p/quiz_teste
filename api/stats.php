<?php
require_once '../config.php';

header('Content-Type: application/json');

$questions = loadQuestions();
$categories = array_unique(array_column($questions, 'categoria'));

echo json_encode([
    'totalQuestions' => count($questions),
    'totalCategories' => count($categories)
]);
