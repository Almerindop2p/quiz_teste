<?php
require_once '../config.php';

$answers = $_SESSION['quiz_answers'] ?? [];
$time = $_SESSION['quiz_time'] ?? 0;
$questions = $_SESSION['quiz_questions'] ?? [];

if (empty($answers)) {
    redirect('index.php');
}

$correct = 0;
$wrong = 0;

foreach ($answers as $answer) {
    if ($answer['isCorrect']) {
        $correct++;
    } else {
        $wrong++;
    }
}

$total = count($answers);
$percentage = $total > 0 ? round(($correct / $total) * 100, 1) : 0;

$minutes = floor($time / 60);
$seconds = $time % 60;
$timeFormatted = sprintf('%02d:%02d', $minutes, $seconds);

// Limpar sessão do quiz
unset($_SESSION['quiz_questions']);
unset($_SESSION['quiz_answers']);
unset($_SESSION['quiz_time']);
unset($_SESSION['quiz_start_time']);
unset($_SESSION['quiz_current']);
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Resultados - Sistema de Quiz</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>
    <div class="container my-5">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="card shadow-lg border-0 animate-fade-in">
                    <div class="card-body p-5 text-center">
                        <div class="mb-4">
                            <div class="display-1 mb-3">
                                <?php if ($percentage >= 70): ?>
                                    🏆
                                <?php elseif ($percentage >= 50): ?>
                                    👍
                                <?php else: ?>
                                    📚
                                <?php endif; ?>
                            </div>
                            <h1 class="fw-bold mb-3">Quiz Finalizado!</h1>
                            <p class="lead text-muted">Confira seus resultados abaixo</p>
                        </div>

                        <div class="row g-4 my-5">
                            <div class="col-md-4">
                                <div class="stat-card bg-success text-white p-4 rounded-4 shadow-sm">
                                    <div class="display-4 fw-bold mb-2"><?= $correct ?></div>
                                    <div class="h5">Acertos</div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="stat-card bg-danger text-white p-4 rounded-4 shadow-sm">
                                    <div class="display-4 fw-bold mb-2"><?= $wrong ?></div>
                                    <div class="h5">Erros</div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="stat-card bg-primary text-white p-4 rounded-4 shadow-sm">
                                    <div class="display-4 fw-bold mb-2"><?= $percentage ?>%</div>
                                    <div class="h5">Porcentagem</div>
                                </div>
                            </div>
                        </div>

                        <div class="card bg-light border-0 p-4 mb-4">
                            <div class="row text-center">
                                <div class="col-md-6 mb-3 mb-md-0">
                                    <div class="h5 text-muted mb-2">Total de Questões</div>
                                    <div class="h3 fw-bold"><?= $total ?></div>
                                </div>
                                <div class="col-md-6">
                                    <div class="h5 text-muted mb-2">Tempo Total</div>
                                    <div class="h3 fw-bold"><?= $timeFormatted ?></div>
                                </div>
                            </div>
                        </div>

                        <div class="mt-5">
                            <a href="index.php" class="btn btn-primary btn-lg me-3 hover-lift">
                                <i class="bi bi-arrow-clockwise me-2"></i>Fazer Outro Quiz
                            </a>
                            <a href="../index.php" class="btn btn-outline-secondary btn-lg hover-lift">
                                <i class="bi bi-house me-2"></i>Voltar ao Início
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

