<?php
require_once '../config.php';

$questions = loadQuestions();
$message = getFlash('success');
$error = getFlash('error');
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Painel Admin - Sistema de Quiz</title>
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
            <span class="navbar-text text-white">Painel Administrativo</span>
        </div>
    </nav>

    <div class="container my-5">
        <?php if ($message): ?>
            <div class="alert alert-success alert-dismissible fade show animate-fade-in" role="alert">
                <i class="bi bi-check-circle me-2"></i><?= htmlspecialchars($message) ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        <?php endif; ?>

        <?php if ($error): ?>
            <div class="alert alert-danger alert-dismissible fade show animate-fade-in" role="alert">
                <i class="bi bi-exclamation-triangle me-2"></i><?= htmlspecialchars($error) ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        <?php endif; ?>

        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="fw-bold">Gerenciar Questões</h2>
            <button class="btn btn-primary btn-lg hover-lift" data-bs-toggle="modal" data-bs-target="#questionModal" onclick="openModal()">
                <i class="bi bi-plus-circle me-2"></i>Nova Questão
            </button>
        </div>

        <div class="card shadow-sm border-0">
            <div class="card-body">
                <?php if (empty($questions)): ?>
                    <div class="text-center py-5">
                        <i class="bi bi-inbox display-1 text-muted"></i>
                        <p class="text-muted mt-3">Nenhuma questão cadastrada ainda.</p>
                    </div>
                <?php else: ?>
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead class="table-light">
                                <tr>
                                    <th>ID</th>
                                    <th>Pergunta</th>
                                    <th>Categoria</th>
                                    <th>Nível</th>
                                    <th class="text-end">Ações</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($questions as $question): ?>
                                    <tr class="animate-fade-in">
                                        <td><?= $question['id'] ?></td>
                                        <td><?= htmlspecialchars(substr($question['pergunta'], 0, 60)) ?><?= strlen($question['pergunta']) > 60 ? '...' : '' ?></td>
                                        <td>
                                            <span class="badge bg-info"><?= htmlspecialchars($question['categoria']) ?></span>
                                        </td>
                                        <td>
                                            <?php
                                            $badgeClass = match($question['nivel']) {
                                                'fácil' => 'bg-success',
                                                'médio' => 'bg-warning',
                                                'difícil' => 'bg-danger',
                                                default => 'bg-secondary'
                                            };
                                            ?>
                                            <span class="badge <?= $badgeClass ?>"><?= htmlspecialchars($question['nivel']) ?></span>
                                        </td>
                                        <td class="text-end">
                                            <button class="btn btn-sm btn-outline-primary hover-lift" onclick="editQuestion(<?= htmlspecialchars(json_encode($question)) ?>)">
                                                <i class="bi bi-pencil"></i> Editar
                                            </button>
                                            <button class="btn btn-sm btn-outline-danger hover-lift" onclick="deleteQuestion(<?= $question['id'] ?>)">
                                                <i class="bi bi-trash"></i> Deletar
                                            </button>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <!-- Modal para Criar/Editar Questão -->
    <div class="modal fade" id="questionModal" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalTitle">Nova Questão</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form id="questionForm" action="save.php" method="POST">
                    <input type="hidden" name="id" id="questionId">
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="pergunta" class="form-label">Pergunta *</label>
                            <textarea class="form-control" id="pergunta" name="pergunta" rows="3" required></textarea>
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label">Alternativas *</label>
                            <?php for ($i = 0; $i < 4; $i++): ?>
                                <div class="input-group mb-2">
                                    <span class="input-group-text"><?= $i + 1 ?></span>
                                    <input type="text" class="form-control" name="alternativas[]" required>
                                    <div class="input-group-text">
                                        <input type="radio" class="form-check-input" name="correta" value="<?= $i ?>" required>
                                    </div>
                                </div>
                            <?php endfor; ?>
                            <small class="text-muted">Marque a alternativa correta</small>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="categoria" class="form-label">Categoria *</label>
                                <input type="text" class="form-control" id="categoria" name="categoria" list="categorias" required>
                                <datalist id="categorias">
                                    <option value="PHP">
                                    <option value="JavaScript">
                                    <option value="HTML">
                                    <option value="CSS">
                                    <option value="Lógica">
                                    <option value="Segurança">
                                    <option value="Banco de Dados">
                                </datalist>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="nivel" class="form-label">Nível *</label>
                                <select class="form-select" id="nivel" name="nivel" required>
                                    <option value="">Selecione...</option>
                                    <option value="fácil">Fácil</option>
                                    <option value="médio">Médio</option>
                                    <option value="difícil">Difícil</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-primary">Salvar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function openModal() {
            document.getElementById('questionForm').reset();
            document.getElementById('questionId').value = '';
            document.getElementById('modalTitle').textContent = 'Nova Questão';
        }

        function editQuestion(question) {
            document.getElementById('questionId').value = question.id;
            document.getElementById('pergunta').value = question.pergunta;
            document.getElementById('categoria').value = question.categoria;
            document.getElementById('nivel').value = question.nivel;
            
            const alternativas = document.querySelectorAll('input[name="alternativas[]"]');
            question.alternativas.forEach((alt, index) => {
                if (alternativas[index]) {
                    alternativas[index].value = alt;
                }
            });
            
            const radios = document.querySelectorAll('input[name="correta"]');
            if (radios[question.correta]) {
                radios[question.correta].checked = true;
            }
            
            document.getElementById('modalTitle').textContent = 'Editar Questão';
            new bootstrap.Modal(document.getElementById('questionModal')).show();
        }

        function deleteQuestion(id) {
            if (confirm('Tem certeza que deseja deletar esta questão?')) {
                const form = document.createElement('form');
                form.method = 'POST';
                form.action = 'delete.php';
                
                const input = document.createElement('input');
                input.type = 'hidden';
                input.name = 'id';
                input.value = id;
                form.appendChild(input);
                
                document.body.appendChild(form);
                form.submit();
            }
        }
    </script>
</body>
</html>
