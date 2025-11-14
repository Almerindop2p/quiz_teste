# 🎯 Sistema de Quiz - Laravel 11

Sistema completo de Quiz desenvolvido com PHP e Laravel 11, utilizando armazenamento em arquivo JSON. Interface moderna, responsiva e intuitiva.

## 📋 Índice

- [Funcionalidades](#-funcionalidades)
- [Requisitos](#-requisitos)
- [Instalação](#-instalação)
- [Configuração](#-configuração)
- [Como Usar](#-como-usar)
- [Estrutura do Projeto](#-estrutura-do-projeto)
- [Formato do JSON](#-formato-do-json)
- [Rotas da Aplicação](#-rotas-da-aplicação)
- [Tecnologias](#-tecnologias)
- [Solução de Problemas](#-solução-de-problemas)
- [Desenvolvimento](#-desenvolvimento)

---

## ✨ Funcionalidades

### 🎮 Modo Quiz (Jogador)
- ✅ Tela inicial com configurações personalizáveis
- ✅ Seleção de quantidade de questões (1-50)
- ✅ Filtros por categoria e nível (opcional)
- ✅ Interface interativa com barra de progresso
- ✅ Uma pergunta por vez com animações suaves
- ✅ Exibição de resultados com pontuação
- ✅ Gabarito completo com respostas corretas/incorretas
- ✅ Botão para refazer quiz

### 📝 Gerenciamento de Questões
- ✅ Cadastro de questões com 4 alternativas (A, B, C, D)
- ✅ Categorização personalizada
- ✅ Níveis de dificuldade (fácil, médio, difícil)
- ✅ Listagem com filtros avançados:
  - Busca por palavra-chave
  - Filtro por categoria
  - Filtro por nível
- ✅ Edição de questões existentes
- ✅ Exclusão com confirmação
- ✅ Visualização clara de todas as questões

### 🎨 Interface
- ✅ Design moderno com Tailwind CSS
- ✅ Totalmente responsivo (mobile, tablet, desktop)
- ✅ Ícones Font Awesome
- ✅ Animações e transições suaves
- ✅ Feedback visual em todas as ações
- ✅ Cores intuitivas por nível de dificuldade

---

## 🔧 Requisitos

### Obrigatórios
- **PHP:** 8.2 ou superior
- **Composer:** Versão mais recente
- **Servidor Web:** Apache/Nginx ou PHP Built-in Server

### Recomendados
- **Extensões PHP:**
  - `json` (geralmente já incluída)
  - `mbstring`
  - `openssl`
  - `pdo`
  - `tokenizer`
  - `xml`

---

## 🚀 Instalação

### Passo 1: Clonar/Baixar o Projeto

Se você já tem o projeto, pule para o Passo 2.

```bash
# Se estiver usando Git
git clone <url-do-repositorio> quiz_teste
cd quiz_teste
```

### Passo 2: Instalar Dependências

```bash
composer install
```

Este comando irá:
- Baixar o Laravel Framework 11
- Instalar todas as dependências necessárias
- Criar o diretório `vendor/` com os pacotes
- Configurar o autoloader do Composer

### Passo 3: Criar Diretórios Necessários

**Windows (PowerShell):**
```powershell
New-Item -ItemType Directory -Force -Path storage\app
New-Item -ItemType Directory -Force -Path storage\framework\sessions
New-Item -ItemType Directory -Force -Path storage\framework\views
```

**Linux/Mac:**
```bash
mkdir -p storage/app storage/framework/sessions storage/framework/views
```

### Passo 4: (Opcional) Adicionar Questões de Exemplo

Se quiser começar com algumas questões de exemplo:

**Windows (PowerShell):**
```powershell
Copy-Item storage\app\quiz.json.example storage\app\quiz.json
```

**Linux/Mac:**
```bash
cp storage/app/quiz.json.example storage/app/quiz.json
```

**Ou deixe vazio** - o sistema criará automaticamente um arquivo vazio `[]` na primeira execução.

### Passo 5: Verificar Permissões (Linux/Mac)

```bash
chmod -R 775 storage
chmod -R 775 bootstrap/cache
```

---

## ⚙️ Configuração

### Configurar Servidor

#### Opção 1: PHP Built-in Server (Recomendado para Desenvolvimento)

```bash
php -S localhost:8000 -t public
```

#### Opção 2: Laravel Artisan Serve

```bash
php artisan serve
```

#### Opção 3: Servidor Web (Apache/Nginx)

Configure seu servidor web para apontar o **DocumentRoot** para o diretório `public/`.

**Exemplo Apache (.htaccess já configurado):**
```apache
<VirtualHost *:80>
    ServerName quiz.local
    DocumentRoot "C:/caminho/para/quiz_teste/public"
    
    <Directory "C:/caminho/para/quiz_teste/public">
        AllowOverride All
        Require all granted
    </Directory>
</VirtualHost>
```

### Acessar a Aplicação

Após iniciar o servidor, acesse no navegador:

- **Página Inicial (Quiz):** http://localhost:8000
- **Gerenciar Questões:** http://localhost:8000/questions
- **Criar Nova Questão:** http://localhost:8000/questions/create

---

## 🎮 Como Usar

### Gerenciar Questões

1. **Acessar a Listagem:**
   - Vá para `/questions` ou clique em "Questões" no menu

2. **Criar Nova Questão:**
   - Clique em "Nova Questão" no menu ou na listagem
   - Preencha todos os campos:
     - **Pergunta:** Texto da questão (mínimo 10 caracteres)
     - **Alternativas A, B, C, D:** Todas obrigatórias
     - **Resposta Correta:** Selecione A, B, C ou D
     - **Categoria:** Ex: Geografia, História, Matemática
     - **Nível:** Fácil, Médio ou Difícil
   - Clique em "Salvar Questão"

3. **Filtrar Questões:**
   - Use a barra de busca para encontrar por palavra-chave
   - Selecione uma categoria no dropdown
   - Escolha um nível de dificuldade
   - Clique em "Filtrar"

4. **Editar Questão:**
   - Clique no ícone de edição (lápis) na questão desejada
   - Modifique os campos necessários
   - Clique em "Atualizar Questão"

5. **Deletar Questão:**
   - Clique no ícone de lixeira na questão desejada
   - Confirme a exclusão

### Jogar Quiz

1. **Acessar a Página Inicial:**
   - Vá para `/` ou clique em "Jogar" no menu

2. **Configurar o Quiz:**
   - **Quantidade:** Escolha quantas questões deseja (1-50)
   - **Categoria:** (Opcional) Filtre por categoria específica
   - **Nível:** (Opcional) Filtre por nível de dificuldade
   - Clique em "Iniciar Quiz"

3. **Responder as Questões:**
   - Leia a pergunta atentamente
   - Selecione uma das alternativas (A, B, C ou D)
   - Clique em "Próxima Questão" ou "Finalizar Quiz"
   - A barra de progresso mostra seu avanço

4. **Ver Resultados:**
   - Após responder todas as questões, você verá:
     - **Pontuação:** Quantidade de acertos e percentual
     - **Gabarito Completo:**
       - Respostas corretas destacadas em verde
       - Respostas incorretas destacadas em vermelho
       - Sua resposta vs resposta correta
   - Opções disponíveis:
     - **Refazer Quiz:** Iniciar um novo quiz
     - **Ver Questões:** Ir para a listagem de questões

---

## 📁 Estrutura do Projeto

```
quiz_teste/
├── app/
│   ├── Http/
│   │   └── Controllers/
│   │       ├── Controller.php          # Controller base
│   │       ├── QuizController.php      # Controlador do quiz
│   │       └── QuestionController.php # Controlador de questões
│   ├── Providers/
│   │   └── AppServiceProvider.php      # Service Provider
│   └── Services/
│       └── QuizService.php             # Serviço para manipular JSON
├── bootstrap/
│   ├── app.php                         # Configuração do Laravel 11
│   └── providers.php                   # Service Providers
├── config/
│   ├── app.php                         # Configuração da aplicação
│   ├── filesystems.php                 # Sistema de arquivos
│   ├── session.php                     # Configuração de sessão
│   └── view.php                        # Configuração de views
├── public/
│   ├── index.php                       # Entry point
│   └── .htaccess                       # Configuração Apache
├── resources/
│   └── views/
│       ├── layouts/
│       │   └── app.blade.php           # Layout base
│       ├── quiz/
│       │   ├── index.blade.php         # Tela inicial do quiz
│       │   ├── play.blade.php          # Jogar quiz
│       │   └── results.blade.php       # Resultados
│       └── questions/
│           ├── index.blade.php         # Listagem de questões
│           ├── create.blade.php        # Criar questão
│           └── edit.blade.php          # Editar questão
├── routes/
│   ├── web.php                         # Rotas da aplicação
│   └── console.php                     # Comandos console
├── storage/
│   ├── app/
│   │   ├── quiz.json                   # Arquivo JSON (criado automaticamente)
│   │   └── quiz.json.example           # Exemplo de questões
│   └── framework/
│       ├── sessions/                   # Sessões
│       └── views/                     # Views compiladas
├── composer.json                       # Dependências do projeto
└── README.md                           # Este arquivo
```

---

## 📝 Formato do JSON

As questões são armazenadas em `storage/app/quiz.json` no seguinte formato:

```json
[
  {
    "id": 1,
    "pergunta": "Qual é a capital da França?",
    "alternativas": {
      "a": "Paris",
      "b": "Lyon",
      "c": "Marselha",
      "d": "Toulouse"
    },
    "correta": "a",
    "categoria": "Geografia",
    "nivel": "fácil"
  },
  {
    "id": 2,
    "pergunta": "Quem pintou a Mona Lisa?",
    "alternativas": {
      "a": "Vincent van Gogh",
      "b": "Leonardo da Vinci",
      "c": "Pablo Picasso",
      "d": "Michelangelo"
    },
    "correta": "b",
    "categoria": "Arte",
    "nivel": "fácil"
  }
]
```

### Campos Obrigatórios:
- **id:** Número único (gerado automaticamente)
- **pergunta:** Texto da questão
- **alternativas:** Objeto com chaves `a`, `b`, `c`, `d`
- **correta:** Letra da resposta correta (`a`, `b`, `c` ou `d`)
- **categoria:** Nome da categoria
- **nivel:** `fácil`, `médio` ou `difícil`

---

## 🛣️ Rotas da Aplicação

### Rotas do Quiz
| Método | Rota | Descrição |
|--------|------|-----------|
| GET | `/` | Página inicial do quiz |
| POST | `/quiz/start` | Iniciar quiz |
| GET | `/quiz/play` | Jogar quiz (pergunta atual) |
| POST | `/quiz/answer` | Processar resposta |
| GET | `/quiz/results` | Exibir resultados |

### Rotas de Questões
| Método | Rota | Descrição |
|--------|------|-----------|
| GET | `/questions` | Listar questões |
| GET | `/questions/create` | Formulário de criação |
| POST | `/questions` | Salvar nova questão |
| GET | `/questions/{id}/edit` | Formulário de edição |
| PUT | `/questions/{id}` | Atualizar questão |
| DELETE | `/questions/{id}` | Deletar questão |

---

## 🛠️ Tecnologias

- **Backend:**
  - PHP 8.2+
  - Laravel 11
  - JSON (armazenamento)

- **Frontend:**
  - Tailwind CSS (via CDN)
  - Font Awesome 6.4.0 (via CDN)
  - Blade Templates

- **Ferramentas:**
  - Composer (gerenciamento de dependências)

---

## 🔧 Solução de Problemas

### Erro: "composer: command not found"

**Solução:**
Instale o Composer:
- **Windows:** Baixe de https://getcomposer.org/download/
- **Linux:** `sudo apt install composer` ou `sudo yum install composer`
- **Mac:** `brew install composer`

### Erro: "PHP version not supported"

**Solução:**
Verifique sua versão do PHP:
```bash
php -v
```
Requer PHP 8.2 ou superior. Atualize o PHP se necessário.

### Erro: "Storage directory not writable"

**Solução:**

**Linux/Mac:**
```bash
chmod -R 775 storage
chmod -R 775 bootstrap/cache
```

**Windows:**
Verifique as permissões da pasta no Explorer (clique com botão direito > Propriedades > Segurança)

### Erro: "Class not found"

**Solução:**
Recrie o autoloader:
```bash
composer dump-autoload
```

### Erro: "Session not working"

**Solução:**
1. Verifique se o diretório `storage/framework/sessions` existe
2. Verifique as permissões de escrita
3. Limpe o cache:
```bash
php artisan config:clear
php artisan cache:clear
```

### Erro: "File quiz.json not found"

**Solução:**
O arquivo é criado automaticamente na primeira execução. Se não for criado:
1. Verifique se `storage/app` existe e tem permissões de escrita
2. Crie manualmente: `storage/app/quiz.json` com conteúdo `[]`

### Página em branco / Erro 500

**Solução:**
1. Verifique os logs em `storage/logs/laravel.log`
2. Limpe o cache:
```bash
php artisan config:clear
php artisan cache:clear
php artisan view:clear
```
3. Verifique as permissões dos diretórios
4. Verifique se todas as dependências foram instaladas: `composer install`

### Rotas não funcionam (404)

**Solução:**
1. Verifique se está acessando via `public/` ou configurou o DocumentRoot corretamente
2. Verifique se o `.htaccess` está presente em `public/`
3. Se usar Nginx, configure as regras de rewrite corretamente

---

## 💻 Desenvolvimento

### Estrutura de Código

- **MVC Pattern:** Controllers, Views e Services separados
- **Service Layer:** `QuizService` para lógica de negócio
- **Validação:** Validação de dados no Controller
- **Sessão:** Armazenamento temporário durante o quiz

### Adicionar Novas Funcionalidades

1. **Novo Controller:**
   - Criar em `app/Http/Controllers/`
   - Registrar rotas em `routes/web.php`

2. **Nova View:**
   - Criar em `resources/views/`
   - Estender `layouts/app.blade.php`

3. **Novo Service:**
   - Criar em `app/Services/`
   - Injetar via construtor no Controller

### Comandos Úteis

```bash
# Limpar cache
php artisan config:clear
php artisan cache:clear
php artisan view:clear

# Recriar autoloader
composer dump-autoload

# Verificar rotas
php artisan route:list

# Verificar versão do Laravel
php artisan --version
```

---

## 📄 Licença

MIT License - Sinta-se livre para usar, modificar e distribuir.

---

## 🤝 Contribuindo

1. Faça um fork do projeto
2. Crie uma branch para sua feature (`git checkout -b feature/AmazingFeature`)
3. Commit suas mudanças (`git commit -m 'Add some AmazingFeature'`)
4. Push para a branch (`git push origin feature/AmazingFeature`)
5. Abra um Pull Request

---

## 📞 Suporte

Se encontrar problemas ou tiver dúvidas:
1. Verifique a seção [Solução de Problemas](#-solução-de-problemas)
2. Consulte a documentação do Laravel: https://laravel.com/docs
3. Verifique os logs em `storage/logs/laravel.log`

---

**Desenvolvido com ❤️ usando Laravel 11**
