<?php
require_once '../config.php';

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['error' => 'Method not allowed']);
    exit;
}

$input = json_decode(file_get_contents('php://input'), true);
$_SESSION['quiz_answers'] = $input['answers'] ?? [];
$_SESSION['quiz_time'] = $input['time'] ?? 0;

echo json_encode(['success' => true]);

