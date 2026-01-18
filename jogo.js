let palavraSecreta;

// Recebe a lista de palavras do banco de dados
async function getListaPalavras(){
    let lista = await $.get('selecionar_palavras.php');
    return lista;
}

// Sorteia a palavra secreta
async function sortearPalavra(){
    let listaPalavras = await getListaPalavras();
    let num = Math.floor(Math.random() * listaPalavras.length) + 0;
    let palavraSorteada = listaPalavras[num].palavra;
    return palavraSorteada;
}

async function executarJogo(){
    palavraSecreta = await sortearPalavra();
    // let elementoPalavra = document.getElementById("palavra-sorteada");
    let numLetras = palavraSecreta.length;
    let guessContainer = document.getElementById("guess-container");
    let emoji = document.getElementById("emoji");
    let limiteTentativas = 10;
    let erros = 0;
    let acertos = 0;
    let pontuacao = 10;

    function quebraDeLinha(container){
        let inputs = container.querySelectorAll(".guess-input");

        if(inputs.length > 20){
            container.style.flexWrap = "wrap";
        }
        else{
            container.style.flexWrap = "nowrap";
        }
    }

    function alterarEmoji(erros, inputs){
        if(inputs == 0){
            emoji.innerHTML = "&#x1F604"; //Sobrevivente
            return;
        }

        if(erros >= limiteTentativas){
            emoji.innerHTML = "&#x1F480"; //Enforcado
        }
        else if(erros >= 5){
            emoji.innerHTML = "&#x1F628"; //Assustado
        }
        else if(erros > 0){
            emoji.innerHTML = "&#x1F626"; //Preocupado
        }
        else{
            emoji.innerHTML = "&#x1F610"; //Neutro
        }
    }

    // Altera a exibição do número tentativas erradas
    function exibirErros(value){
        let placarErros = document.getElementById("placar-forca");
        placarErros.innerHTML = `${erros}/${limiteTentativas}`;
        return placarErros;
    }

    // Adiciona as letras erradas a lista da forca
    function addForca(guess){
        let letraErrada = document.createElement("li");
        letraErrada.className = "letra-errada";
        letraErrada.innerHTML = guess;

        let listaForca = document.getElementsByClassName("lista-erros")[0];
        listaForca.appendChild(letraErrada);
    }

    // Transforma a caixa de entrada na letra correta
    function mostrarAcertos(guess){
        let revelarLetra = document.createElement("span");
        revelarLetra.className = "correct-letter"
        revelarLetra.innerHTML = guess;

        return revelarLetra;
    }

    // Calcula a pontuação final
    function calcularPontuacao(pontuacao_inicial){
        return pontuacao_inicial -= erros;
    }

    // Envia a pontuação da partida com AJAX
    function enviarPontuacao(pontuacao_final){
        // Função para formatar a data e hora da partida
        let datahora = new Date().toLocaleString('sv-SE');

        $.post("salvar_pontuacao.php",{
            pontos_partida: pontuacao_final,
            data_hora: datahora
        })
        .done(function(res){
            console.log("RETORNO DO PHP:", res);
        })
        .fail(function(err){
            console.error("Erro AJAX:", err);
        });
    }

    // Envia dados sobre a partida com AJAX
    function enviarPartida(resultado, pontos) {
    $.post("salvar_partida.php", {
        resultado: resultado,
        pontos: pontos,
        palavra_sorteada: palavraSecreta,
        erros: erros,
        acertos: acertos
    })
    .done(function(res) {
        console.log("Retorno do PHP:", res); 
    })
    .fail(function(err) {
        console.error("ERRO AJAX:", err);
    });
}

    // Cria a caixa de entrada para as tentativas do usuário
    function createInputBox(value){
        let guessBox = document.createElement("input");
        guessBox.type = "text";
        guessBox.name = "user-guess";
        guessBox.value = "";
        guessBox.className = "guess-input";
        guessBox.maxLength = 1;

        guessBox.addEventListener("input", function(){
            // Extrai a tentativa do usuário
            let guess = this.value;
            guess = guess.toUpperCase();

            // Verifica se a digitada letra foi a correta
            if(!palavraSecreta.includes(guess)){
                addForca(guess);

                erros++;
                exibirErros();
                alterarEmoji(erros, 1);
                this.value = "";

                // Caso o usuário atinja o limite de tentativas, ele exibe uma mensagem e muda para a próxima palavra
                if (erros == limiteTentativas){
                    alterarEmoji(erros, 1);

                    setTimeout(() => {
                        pontuacao = calcularPontuacao(pontuacao);
                        alert(`Enforcado!\n Pontuação: ${pontuacao}`);

                        // Encerra a partida
                        enviarPontuacao(pontuacao);
                        enviarPartida("derrota", pontuacao);
                        window.location.reload();
                    }, 100);
                }
            }
            else{
                // Mostra as letras acertadas nas posições corretas
                for (let i = 0; i < numLetras; i++){
                    if(palavraSecreta[i] === guess && guessContainer.children[i].tagName === "INPUT"){
                        let letraAcertada = mostrarAcertos(guess);
                        // Substitui o caixa de entrada pela letra acertada
                        guessContainer.replaceChild(letraAcertada, guessContainer.children[i]);
                        acertos ++;
                    }
                }

                // Verifica se todas as letras foram acertadas
                let inputsRestantes = document.querySelectorAll('#guess-container input').length
                if(inputsRestantes == 0){
                    alterarEmoji(erros, inputsRestantes);

                    setTimeout(() =>{
                        pontuacao = calcularPontuacao(pontuacao);
                        alert(`Você adivinhou!\n Pontuação: ${pontuacao}`);

                        // Encerra a partida
                        enviarPontuacao(pontuacao);
                        enviarPartida("vitoria", pontuacao);
                        window.location.reload();
                        }, 100);
                    }
            }
            this.value = "";
        });

        return guessBox;
    }

    // Gera o número de caixas de entrada igual ao número de letras da palavra secreta
    for (let i = 0; i < numLetras; i++){
        guessContainer.appendChild(createInputBox());
    }

    quebraDeLinha();
}

executarJogo();