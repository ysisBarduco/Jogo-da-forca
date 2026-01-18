
Universidade Federal do Paraná - UFPR

Setor de Educação Profissional e Tecnológica - SEPT

**Curso:** Tecnologia em Análise e Desenvolvimento de Sistemas

**Disciplina:** DS123 - Desenvolvimento Web I

**Professor:**  Alexander Robert Kutzke

**Ano:** 2025  

**Autores:**
* Ariane de Oliveira Neves
* Ysis Barduco Straub de Lima 

---

# Trabalho prático: Jogo da forca
Para o trabalho, desenvolvemos uma aplicação web que implementa um jogo da forca, com sistema de cadastro, pontuação e ranking. 
O usuário deve se cadastrar em uma conta e pode jogar individualmente ou participar de ligas, competindo entre um grupo.
Além disso, o usuário pode acessar:
* O ranking geral, com as pontuações de todos os usuários e suas posições;
* A pontuação semanal, com a soma dos pontos adquiridos, em uma liga ou não, durante a semana;
* O histórico de partidas, com data e hora, os pontos adquiridos, palavra secreta, resultado e liga;
* A página de criação de liga, onde o usuário pode criar uma liga e adicionar outros usuários;
* O ranking de liga, com as pontuações dos membros da liga e suas posições;
* O histórico da liga, com informações sobre a liga e o histórico de partidas dos membros da liga.

## Jogo
A cada partida, o programa sorteia uma das palavras do banco de dados e o usuário deve adivinhar a palavra secreta letra a letra.
Caso o usuário erre, o programa decrementa a pontuação e exibe a letra errada na tabela "forca". Ao atingir o limite de 10 tentativas erradas, o usuário perde e o programa inicia uma nova partida.
Caso o usuário acerte a letra, o programa exibe as posições correspondentes na palavra secreta. Ao adivinhar todas as letras que compõem a palavra secreta, o usuário vence.
Ao final de cada partida, o programa calcula a pontuação com base no número de tentativas erradas e envia ao banco de dados.

## Ferramentas
- Visual Studio Code (VS Code) para desenvolvimento;
- Servidor Apache (XAMPP) para hospedagem da aplicação;
- MySQL para criação e controle do banco de dados;
- Git e GitLab para versionamento e armazenamento do código.


