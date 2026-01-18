# Relatório de Uso de Inteligência Artificial Generativa

Este documento registra todas as interações significativas com ferramentas de IA generativa (como Gemini, ChatGPT, Copilot, etc.) durante o desenvolvimento deste projeto. O objetivo é promover o uso ético e transparente da IA como ferramenta de apoio, e não como substituta para a compreensão dos conceitos fundamentais.

## Política de Uso
O uso de IA foi permitido para as seguintes finalidades:
- Geração de ideias e brainstorming de algoritmos.
- Explicação de conceitos complexos.
- Geração de código boilerplate (ex: estrutura de classes, leitura de arquivos).
- Sugestões de refatoração e otimização de código.
- Debugging e identificação de causas de erros.
- Geração de casos de teste.

É proibido submeter código gerado por IA sem compreendê-lo completamente e sem adaptá-lo ao projeto. Todo trecho de código influenciado pela IA deve ser referenciado neste log.

---

## Registro de Interações

### Interação 1

- **Etapa do Projeto:** Estilização da página do jogo
- **Ferramenta de IA Utilizada:** ChatGPT
- **Objetivo da Consulta:** Adquirir ideias para a estilização da caixa de inputs
- **Prompt(s) Utilizado(s):** 
1. Olá chat! Como poderia fazer para que a caixa de input pareça mais com a de um jogo da forca, sem perder a característica da digitação?

- **Resumo da Resposta da IA:**
1. Primeira sugestão: Estilo de “letra única”: caixa pequena, centralizada e marcada
    ```css
    .input-forca {
        width: 60px;               /* pequena, como um slot */
        height: 40px;
        font-size: 24px;           /* letra maior */
        text-align: center;        /* letra no meio */
        border: 3px solid #000;    /* borda forte */
        border-radius: 6px;        /* mais suave */
        outline: none;             /* remove brilho padrão */
    }
    ```
    Segunda sugestão: Estilo “underline”, imitando tracinhos do jogo da forca
    ```css
    .input-forca {
        width: 80px;
        font-size: 28px;
        text-align: center;
        border: none;
        border-bottom: 4px solid #000; /* traço estilo forca */
        background: transparent;
        outline: none;
        padding: 5px;
    }
    ```
    Terceira sugestão: Estilo de “slot destacado” com sombra
    ```css
    .input-forca {
        width: 70px;
        height: 45px;
        font-size: 26px;
        text-align: center;
        border: 2px solid #000;
        border-radius: 8px;
        box-shadow: 0 4px 0 #000; /* sombra estilo cartoon */
        background-color: #fff;
        outline: none;
    }
    ```

- **Análise e Aplicação:** Após analizar as sugestões que a IA levantou, escolhi a primeira opção e apliquei algumas alterações. A sugestão da IA também permitiu ter a ideia de gerar automáticamente as caixas de input através do Javascript.
- **Referência no Código:** A sugestão da IA sofreu algumas alterações e foi aplicada a classe .guess-input no arquivo estilo.css.

---

### Interação 2

- **Etapa do Projeto:** Implementação das funcionalidades da página de jogo
- **Ferramenta de IA Utilizada:** ChatGPT
- **Objetivo da Consulta:** Compreender o funcionamento do método POST com AJAX e metodos para enviar a data e a hora que a partida foi finalizada.
- **Prompt(s) Utilizado(s):** 
1. Olá chat! Me explique como funciona o POST em javascript com AJAX (jQuery)
2. Se eu quiser enviar a data e hora da partida para salvar em um campo datetime. Como ficaria no javascript? Como eu pego esse valor automaticamente ao fim da partida?
3. Não existe nenhuma função javaScript que faça tudo isso automaticamente?

- **Resumo da Resposta da IA:** 
1. $.post() é uma forma simplificada de fazer uma requisição AJAX usando o método POST.
Ele envia dados para o servidor sem recarregar a página, e o PHP recebe via $_POST.

    Sintaxe básica:

```javascript
$.post("arquivo.php", { chave: valor }, function(resposta){
    console.log(resposta);
}); 
```

2. Criar new Date(), extrair ano, mês, dia, horas, minutos, segundos e montar o formato MySQL

3. new Date().toLocaleString('sv-SE')

- **Análise e Aplicação:** Através da explicação da IA compreendi que o método $.post() seria o mais adequado para enviar os dados ao banco de dados do servidor.

- **Referência no Código:** As sugestões da IA foram utilizadas na função enviarPontuacao() na linha 87 do arquivo jogo.js. 

---

### Interação 3

- **Etapa do Projeto:** Implementação das funcionalidades do jogo
- **Ferramenta de IA Utilizada:** ChatGPT
- **Objetivo da Consulta:** Compreender como funcionam prepared statements, a partir de um código de exemplo.
- **Prompt(s) Utilizado(s):**
1. Olá chat!
    Poderia me explicar esse código aqui?

    ```php
    <?php
    $servername = "localhost";
    $username = "username";
    $password = "password";
    $dbname = "myDB";

    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Check connection
    if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
    }

    // prepare and bind
    $stmt = $conn->prepare("INSERT INTO MyGuests (firstname, lastname, email) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $firstname, $lastname, $email);

    // set parameters and execute
    $firstname = "John";
    $lastname = "Doe";
    $email = "john@example.com";
    $stmt->execute();

    $firstname = "Mary";
    $lastname = "Moe";
    $email = "mary@example.com";
    $stmt->execute();

    $firstname = "Julie";
    $lastname = "Dooley";
    $email = "julie@example.com";
    $stmt->execute();

    echo "New records created successfully";

    $stmt->close();
    $conn->close();
    ?>
    ```

- **Resumo da Resposta da IA:** 
1. Você enviou um código que insere registros no banco usando mysqli e prepare().
Eu expliquei cada parte: Configuração da conexão (servername, username, etc.), criação da conexão com new mysqli, checagem de erro,uso de prepare() com placeholders ?, bind_param("sss", ...) para vincular variáveis, execução repetida usando execute(), fechamento do statement e conexão

- **Análise e Aplicação:** Com a explicação da IA conclui que o método prepared statement poderia ser utilizado para que as varaiveis, que no caso do jogo armazenavam os dados recebidos com método POST, pudessem preencher os valores da sql query para inserção de dados no banco de dados. 

- **Referência no Código:** A aplicação do método foi utilizado nas linhas 25 a 29 no arquivo salvar_pontuacao.php

---

