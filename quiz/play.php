<?php
require_once '../config.php';

$categoria = $_GET['categoria'] ?? '';
$nivel = $_GET['nivel'] ?? '';
$quantidade = isset($_GET['quantidade']) ? (int)$_GET['quantidade'] : 10;

$allQuestions = loadQuestions();

// Filtrar questões
$filteredQuestions = $allQuestions;
if (!empty($categoria)) {
    $filteredQuestions = array_filter($filteredQuestions, function($q) use ($categoria) {
        return $q['categoria'] === $categoria;
    });
}
if (!empty($nivel)) {
    $filteredQuestions = array_filter($filteredQuestions, function($q) use ($nivel) {
        return $q['nivel'] === $nivel;
    });
}

$filteredQuestions = array_values($filteredQuestions);

// Limitar quantidade
$quantidade = min($quantidade, count($filteredQuestions));
$selectedQuestions = array_slice($filteredQuestions, 0, $quantidade);

// Embaralhar questões
shuffle($selectedQuestions);

// Salvar na sessão
$_SESSION['quiz_questions'] = $selectedQuestions;
$_SESSION['quiz_answers'] = [];
$_SESSION['quiz_start_time'] = time();
$_SESSION['quiz_current'] = 0;

if (empty($selectedQuestions)) {
    setFlash('error', 'Nenhuma questão encontrada com os filtros selecionados!');
    redirect('index.php');
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quiz - Sistema de Quiz</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>
    <div class="container my-5">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <!-- Progress Bar -->
                <div class="card shadow-sm border-0 mb-4">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <span class="text-muted">Questão <span id="current-question">1</span> de <span id="total-questions"><?= count($selectedQuestions) ?></span></span>
                            <span class="badge bg-primary" id="timer">00:00</span>
                        </div>
                        <div class="progress" style="height: 8px;">
                            <div class="progress-bar bg-primary" id="progress-bar" role="progressbar" style="width: 0%"></div>
                        </div>
                    </div>
                </div>

                <!-- Question Card -->
                <div class="card shadow-lg border-0 animate-fade-in" id="question-card">
                    <div class="card-body p-5">
                        <div class="mb-4">
                            <span class="badge bg-info mb-3" id="question-category"></span>
                            <span class="badge bg-warning mb-3" id="question-level"></span>
                        </div>
                        
                        <h3 class="fw-bold mb-4" id="question-text"></h3>
                        
                        <div id="alternatives-container" class="d-grid gap-3"></div>
                    </div>
                </div>

                <!-- Feedback Card (hidden initially) -->
                <div class="card shadow-lg border-0 mt-4 d-none" id="feedback-card">
                    <div class="card-body p-5 text-center">
                        <div id="feedback-icon" class="display-1 mb-3"></div>
                        <h4 id="feedback-text" class="mb-3"></h4>
                        <button class="btn btn-primary btn-lg" id="next-button" onclick="nextQuestion()">
                            Próxima Pergunta <i class="bi bi-arrow-right ms-2"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        const questions = <?= json_encode($selectedQuestions) ?>;
        let currentIndex = 0;
        let answers = [];
        let startTime = Date.now();
        let timerInterval;

        function initQuiz() {
            loadQuestion();
            startTimer();
        }

        function startTimer() {
            timerInterval = setInterval(() => {
                const elapsed = Math.floor((Date.now() - startTime) / 1000);
                const minutes = Math.floor(elapsed / 60);
                const seconds = elapsed % 60;
                document.getElementById('timer').textContent = 
                    `${String(minutes).padStart(2, '0')}:${String(seconds).padStart(2, '0')}`;
            }, 1000);
        }

        function loadQuestion() {
            if (currentIndex >= questions.length) {
                finishQuiz();
                return;
            }

            const question = questions[currentIndex];
            document.getElementById('question-text').textContent = question.pergunta;
            document.getElementById('question-category').textContent = question.categoria;
            document.getElementById('question-level').textContent = question.nivel;
            document.getElementById('current-question').textContent = currentIndex + 1;
            document.getElementById('total-questions').textContent = questions.length;
            
            const progress = ((currentIndex + 1) / questions.length) * 100;
            document.getElementById('progress-bar').style.width = progress + '%';

            const container = document.getElementById('alternatives-container');
            container.innerHTML = '';
            
            question.alternativas.forEach((alt, index) => {
                const button = document.createElement('button');
                button.type = 'button';
                button.className = 'btn btn-outline-primary btn-lg text-start hover-lift alternative-btn';
                button.textContent = alt;
                button.onclick = () => selectAnswer(index);
                container.appendChild(button);
            });

            document.getElementById('question-card').classList.remove('d-none');
            document.getElementById('feedback-card').classList.add('d-none');
        }

        function selectAnswer(selectedIndex) {
            const question = questions[currentIndex];
            const isCorrect = selectedIndex === question.correta;
            
            answers.push({
                questionId: question.id,
                selected: selectedIndex,
                correct: question.correta,
                isCorrect: isCorrect
            });

            // Desabilitar botões
            document.querySelectorAll('.alternative-btn').forEach(btn => {
                btn.disabled = true;
            });

            // Mostrar feedback
            const feedbackCard = document.getElementById('feedback-card');
            const feedbackIcon = document.getElementById('feedback-icon');
            const feedbackText = document.getElementById('feedback-text');
            
            if (isCorrect) {
                feedbackIcon.innerHTML = '✅';
                feedbackIcon.className = 'display-1 mb-3 text-success';
                feedbackText.textContent = 'Parabéns! Você acertou!';
                feedbackText.className = 'mb-3 text-success';
            } else {
                feedbackIcon.innerHTML = '❌';
                feedbackIcon.className = 'display-1 mb-3 text-danger';
                feedbackText.textContent = `Resposta incorreta. A resposta correta era: "${question.alternativas[question.correta]}"`;
                feedbackText.className = 'mb-3 text-danger';
            }

            // Destacar resposta correta e selecionada
            const buttons = document.querySelectorAll('.alternative-btn');
            buttons[question.correta].classList.remove('btn-outline-primary');
            buttons[question.correta].classList.add('btn-success');
            
            if (!isCorrect) {
                buttons[selectedIndex].classList.remove('btn-outline-primary');
                buttons[selectedIndex].classList.add('btn-danger');
            }

            document.getElementById('question-card').classList.add('d-none');
            feedbackCard.classList.remove('d-none');
            feedbackCard.classList.add('animate-fade-in');

            // Se for a última pergunta, mudar botão
            if (currentIndex === questions.length - 1) {
                document.getElementById('next-button').innerHTML = 'Ver Resultados <i class="bi bi-trophy ms-2"></i>';
            }
        }

        function nextQuestion() {
            currentIndex++;
            setTimeout(() => {
                loadQuestion();
            }, 300);
        }

        function finishQuiz() {
            clearInterval(timerInterval);
            const elapsed = Math.floor((Date.now() - startTime) / 1000);
            
            // Salvar respostas na sessão
            fetch('save_answers.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({
                    answers: answers,
                    time: elapsed
                })
            }).then(() => {
                window.location.href = 'results.php';
            });
        }

        // Iniciar quiz ao carregar
        initQuiz();
    </script>
</body>
</html>

