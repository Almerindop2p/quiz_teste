# 🎯 Sistema de Quiz

Sistema completo de quiz desenvolvido em PHP puro, com interface moderna e responsiva, utilizando armazenamento em arquivo JSON.

## 📋 Características

- ✅ **Painel Administrativo** completo para gerenciar questões
- ✅ **Sistema de Quiz** interativo com filtros avançados
- ✅ **Feedback imediato** ao responder questões
- ✅ **Estatísticas detalhadas** ao final do quiz
- ✅ **Design moderno** com animações e transições suaves
- ✅ **Totalmente responsivo** para desktop e mobile
- ✅ **Armazenamento em JSON** (sem necessidade de banco de dados)

## 🚀 Tecnologias Utilizadas

- **PHP** - Backend e lógica de negócio
- **HTML5** - Estrutura das páginas
- **CSS3** - Estilização e animações
- **JavaScript** - Interatividade e lógica do frontend
- **Bootstrap 5** - Framework CSS para layout responsivo

## 📁 Estrutura do Projeto

```
quiz_teste/
│
├── index.php              # Tela inicial do sistema
├── config.php             # Configurações e funções auxiliares
├── README.md              # Este arquivo
│
├── admin/                 # Painel administrativo
│   ├── index.php          # Listagem e gerenciamento de questões
│   ├── save.php           # Salvar/atualizar questões
│   └── delete.php         # Deletar questões
│
├── quiz/                  # Sistema de quiz
│   ├── index.php          # Configuração do quiz (filtros)
│   ├── play.php           # Tela de jogo do quiz
│   ├── save_answers.php   # Salvar respostas na sessão
│   └── results.php        # Tela de resultados
│
├── api/                   # Endpoints da API
│   └── stats.php          # Estatísticas do sistema
│
├── assets/                # Arquivos estáticos
│   └── css/
│       └── style.css      # Estilos personalizados
│
└── data/                  # Armazenamento de dados
    └── questions.json     # Arquivo JSON com as questões
```

## 🛠️ Instalação

1. **Clone ou baixe o projeto**
   ```bash
   git clone [url-do-repositorio]
   cd quiz_teste
   ```

2. **Configure um servidor web local**
   - Use XAMPP, WAMP, Laragon ou qualquer servidor PHP
   - Configure o DocumentRoot para apontar para a pasta do projeto

3. **Verifique permissões**
   - A pasta `data/` precisa ter permissão de escrita
   - O arquivo `data/questions.json` será criado automaticamente se não existir

4. **Acesse o sistema**
   - Abra no navegador: `http://localhost/quiz_teste/`

## 📖 Como Usar

### 1. Painel Administrativo

Acesse **Painel Admin** na tela inicial para gerenciar questões:

- **Criar Questão**: Clique em "Nova Questão"
  - Preencha a pergunta
  - Adicione 4 alternativas
  - Marque a alternativa correta
  - Selecione categoria e nível

- **Editar Questão**: Clique no botão "Editar" na listagem
  - Modifique os campos desejados
  - Salve as alterações

- **Deletar Questão**: Clique no botão "Deletar" e confirme

### 2. Jogar Quiz

1. Acesse **Iniciar Quiz** na tela inicial
2. Configure os filtros:
   - **Categoria**: Filtre por categoria específica ou todas
   - **Nível**: Escolha entre fácil, médio ou difícil
   - **Quantidade**: Selecione quantas questões deseja responder
3. Clique em **Iniciar Quiz**
4. Responda as questões clicando nas alternativas
5. Veja o feedback imediato (acerto/erro)
6. Ao final, visualize suas estatísticas

### 3. Resultados

Após completar o quiz, você verá:
- ✅ Total de acertos
- ❌ Total de erros
- 📊 Porcentagem de acerto
- ⏱️ Tempo total gasto
- 🔄 Opção para fazer outro quiz

## 📝 Estrutura do JSON

O arquivo `data/questions.json` segue esta estrutura:

```json
[
  {
    "id": 1,
    "pergunta": "Qual é a função do isset() no PHP?",
    "alternativas": [
      "Verifica se existe",
      "Compara valores",
      "Cria variáveis",
      "Remove itens"
    ],
    "correta": 0,
    "categoria": "PHP",
    "nivel": "fácil"
  }
]
```

### Campos:
- **id**: Identificador único (gerado automaticamente)
- **pergunta**: Texto da pergunta
- **alternativas**: Array com 4 alternativas
- **correta**: Índice da alternativa correta (0-3)
- **categoria**: Categoria da questão (ex: PHP, JavaScript, HTML, etc)
- **nivel**: Nível de dificuldade (fácil, médio, difícil)

## 🎨 Personalização

### Cores e Estilos

Edite o arquivo `assets/css/style.css` para personalizar:
- Cores do tema (variáveis CSS no início do arquivo)
- Animações e transições
- Layout e espaçamentos

### Categorias Padrão

As categorias sugeridas no formulário podem ser editadas em `admin/index.php`:
- PHP
- JavaScript
- HTML
- CSS
- Lógica
- Segurança
- Banco de Dados

## 🔒 Segurança

- Validação de dados nos formulários
- Sanitização de inputs com `htmlspecialchars()`
- Sessões seguras configuradas
- Validação de métodos HTTP (POST/GET)

## 📱 Responsividade

O sistema é totalmente responsivo e funciona em:
- 💻 Desktop
- 📱 Tablets
- 📱 Smartphones

## 🐛 Solução de Problemas

### Erro ao salvar questões
- Verifique se a pasta `data/` tem permissão de escrita
- Certifique-se de que o PHP tem permissão para criar arquivos

### Questões não aparecem
- Verifique se o arquivo `data/questions.json` existe
- Confirme que o JSON está no formato correto

### Estatísticas não carregam
- Verifique se o arquivo `api/stats.php` está acessível
- Confirme que o JavaScript está habilitado no navegador

## 📄 Licença

Este projeto é de código aberto e está disponível para uso livre.

## 👨‍💻 Desenvolvimento

### Requisitos
- PHP 7.4 ou superior
- Servidor web (Apache, Nginx, etc)
- Navegador moderno com JavaScript habilitado

### Melhorias Futuras
- [ ] Sistema de ranking de pontuações
- [ ] Exportação de resultados em PDF
- [ ] Modo escuro/claro
- [ ] Mais tipos de questões (múltipla escolha, verdadeiro/falso)
- [ ] Sistema de comentários nas questões

## 📞 Suporte

Para dúvidas ou problemas, verifique:
1. A estrutura de pastas está correta
2. As permissões de arquivo estão configuradas
3. O servidor PHP está funcionando corretamente

---

**Desenvolvido com ❤️ usando PHP, HTML, CSS e JavaScript**

