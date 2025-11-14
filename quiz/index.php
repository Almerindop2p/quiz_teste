<?php
require_once '../config.php';

$questions = loadQuestions();
$categories = array_unique(array_column($questions, 'categoria'));
$levels = ['fácil', 'médio', 'difícil'];
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar Quiz - Sistema de Quiz</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary shadow-sm">
        <div class="container">
            <a class="navbar-brand fw-bold" href="../index.php">
                <i class="bi bi-arrow-left me-2"></i>Voltar
            </a>
            <span class="navbar-text text-white">Configurar Quiz</span>
        </div>
    </nav>

    <div class="container my-5">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="card shadow-lg border-0 animate-fade-in">
                    <div class="card-body p-5">
                        <h2 class="fw-bold mb-4 text-center">⚙️ Configurações do Quiz</h2>
                        
                        <?php if (empty($questions)): ?>
                            <div class="alert alert-warning text-center">
                                <i class="bi bi-exclamation-triangle me-2"></i>
                                Nenhuma questão disponível. Cadastre questões no painel admin primeiro.
                            </div>
                            <div class="text-center mt-4">
                                <a href="../admin/index.php" class="btn btn-primary">Ir para Admin</a>
                            </div>
                        <?php else: ?>
                            <form id="quizForm" action="play.php" method="GET">
                                <div class="mb-4">
                                    <label for="categoria" class="form-label fw-semibold">
                                        <i class="bi bi-tags me-2"></i>Categoria
                                    </label>
                                    <select class="form-select form-select-lg" id="categoria" name="categoria">
                                        <option value="">Todas as categorias</option>
                                        <?php foreach ($categories as $cat): ?>
                                            <option value="<?= htmlspecialchars($cat) ?>"><?= htmlspecialchars($cat) ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>

                                <div class="mb-4">
                                    <label for="nivel" class="form-label fw-semibold">
                                        <i class="bi bi-bar-chart me-2"></i>Nível
                                    </label>
                                    <select class="form-select form-select-lg" id="nivel" name="nivel">
                                        <option value="">Todos os níveis</option>
                                        <?php foreach ($levels as $level): ?>
                                            <option value="<?= htmlspecialchars($level) ?>"><?= ucfirst(htmlspecialchars($level)) ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>

                                <div class="mb-4">
                                    <label for="quantidade" class="form-label fw-semibold">
                                        <i class="bi bi-list-ol me-2"></i>Quantidade de Perguntas
                                    </label>
                                    <input type="number" class="form-control form-control-lg" id="quantidade" name="quantidade" 
                                           min="1" max="<?= count($questions) ?>" value="<?= min(10, count($questions)) ?>" required>
                                    <small class="text-muted">Máximo: <?= count($questions) ?> questões disponíveis</small>
                                </div>

                                <div class="d-grid mt-5">
                                    <button type="submit" class="btn btn-primary btn-lg py-3 shadow-sm hover-lift">
                                        <i class="bi bi-play-fill me-2"></i>Iniciar Quiz
                                    </button>
                                </div>
                            </form>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

