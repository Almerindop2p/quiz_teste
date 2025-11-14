<?php
require_once '../config.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    redirect('index.php');
}

$id = isset($_POST['id']) ? (int)$_POST['id'] : 0;
$pergunta = trim($_POST['pergunta'] ?? '');
$alternativas = $_POST['alternativas'] ?? [];
$correta = isset($_POST['correta']) ? (int)$_POST['correta'] : 0;
$categoria = trim($_POST['categoria'] ?? '');
$nivel = trim($_POST['nivel'] ?? '');

// Validações
if (empty($pergunta) || count($alternativas) !== 4 || empty($categoria) || empty($nivel)) {
    setFlash('error', 'Preencha todos os campos obrigatórios!');
    redirect('index.php');
}

if ($correta < 0 || $correta > 3) {
    setFlash('error', 'Alternativa correta inválida!');
    redirect('index.php');
}

$questions = loadQuestions();

if ($id > 0) {
    // Editar questão existente
    $found = false;
    foreach ($questions as &$question) {
        if ($question['id'] == $id) {
            $question['pergunta'] = $pergunta;
            $question['alternativas'] = array_map('trim', $alternativas);
            $question['correta'] = $correta;
            $question['categoria'] = $categoria;
            $question['nivel'] = $nivel;
            $found = true;
            break;
        }
    }
    
    if (!$found) {
        setFlash('error', 'Questão não encontrada!');
        redirect('index.php');
    }
    
    setFlash('success', 'Questão atualizada com sucesso!');
} else {
    // Criar nova questão
    $newId = 1;
    if (!empty($questions)) {
        $newId = max(array_column($questions, 'id')) + 1;
    }
    
    $questions[] = [
        'id' => $newId,
        'pergunta' => $pergunta,
        'alternativas' => array_map('trim', $alternativas),
        'correta' => $correta,
        'categoria' => $categoria,
        'nivel' => $nivel
    ];
    
    setFlash('success', 'Questão cadastrada com sucesso!');
}

saveQuestions($questions);
redirect('index.php');
