<?php
require_once 'config.php';
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistema de Quiz</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
    <div class="container-fluid min-vh-100 d-flex align-items-center justify-content-center bg-gradient">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-8 col-md-10">
                    <div class="card shadow-lg border-0 animate-fade-in">
                        <div class="card-body p-5 text-center">
                            <div class="mb-4">
                                <h1 class="display-4 fw-bold text-primary mb-3">🎯 Sistema de Quiz</h1>
                                <p class="lead text-muted">Teste seus conhecimentos de forma divertida e interativa</p>
                            </div>
                            
                            <div class="d-grid gap-3 mt-5">
                                <a href="quiz/index.php" class="btn btn-primary btn-lg py-3 shadow-sm hover-lift">
                                    <i class="bi bi-play-circle me-2"></i>
                                    Iniciar Quiz
                                </a>
                                <a href="admin/index.php" class="btn btn-outline-secondary btn-lg py-3 shadow-sm hover-lift">
                                    <i class="bi bi-gear me-2"></i>
                                    Painel Admin
                                </a>
                            </div>
                            
                            <div class="mt-5 pt-4 border-top">
                                <div class="row text-center">
                                    <div class="col-md-4 mb-3">
                                        <div class="stat-box">
                                            <h3 class="text-primary mb-1" id="total-questions">0</h3>
                                            <p class="text-muted mb-0">Questões</p>
                                        </div>
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <div class="stat-box">
                                            <h3 class="text-success mb-1" id="total-categories">0</h3>
                                            <p class="text-muted mb-0">Categorias</p>
                                        </div>
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <div class="stat-box">
                                            <h3 class="text-info mb-1" id="total-levels">3</h3>
                                            <p class="text-muted mb-0">Níveis</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Carregar estatísticas
        fetch('api/stats.php')
            .then(response => response.json())
            .then(data => {
                document.getElementById('total-questions').textContent = data.totalQuestions || 0;
                document.getElementById('total-categories').textContent = data.totalCategories || 0;
            })
            .catch(error => console.error('Erro ao carregar estatísticas:', error));
    </script>
</body>
</html>
