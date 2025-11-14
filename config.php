<?php
/**
 * Configurações do Sistema de Quiz
 */

// Caminho do arquivo JSON
define('QUIZ_FILE', __DIR__ . '/data/questions.json');

// Configurações de sessão
ini_set('session.cookie_httponly', 1);
session_start();

// Timezone
date_default_timezone_set('America/Sao_Paulo');

// Função helper para redirecionamento
function redirect($url) {
    header("Location: $url");
    exit;
}

// Função helper para mensagens flash
function setFlash($type, $message) {
    $_SESSION['flash'][$type] = $message;
}

function getFlash($type) {
    if (isset($_SESSION['flash'][$type])) {
        $message = $_SESSION['flash'][$type];
        unset($_SESSION['flash'][$type]);
        return $message;
    }
    return null;
}

// Função para carregar questões do JSON
function loadQuestions() {
    if (!file_exists(QUIZ_FILE)) {
        return [];
    }
    $content = file_get_contents(QUIZ_FILE);
    return json_decode($content, true) ?: [];
}

// Função para salvar questões no JSON
function saveQuestions($questions) {
    $dir = dirname(QUIZ_FILE);
    if (!is_dir($dir)) {
        mkdir($dir, 0755, true);
    }
    file_put_contents(QUIZ_FILE, json_encode($questions, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
}
