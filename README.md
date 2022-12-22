# dataGym
Projeto pessoal para consolidar alguns conhecimentos em programação e testes.

Ideia principal do projeto:
Ao fazer um exercicio de musculação, poderei usar esta aplicação para registrar a evolução de carga nos exercícios.
Por exemplo:
* Usuário: John Doe
* Exercício: Supino
* Ações:
  * Repetições: 10
  * **Peso: 20kg**
  * Descanso: 3min
  * Data: 01/12/2022
----
* Usuário: John Doe
* Exercício: Supino
* Ações:
  * Repetições: 10
  * **Peso: 22kg**
  * Descanso: 3min
  * Data: 04/12/2022
----
* Usuário: John Doe
* Exercício: Supino
* Ações:
  * Repetições: 10
  * **Peso: 24kg**
  * Descanso: 3min
  * Data: 08/12/2022

Posteriormente poderei apresentar gráficos mostrando evolução/involução.
Conforme obtvermos mais dados, o app apresentará resumos com estatísticas usando alguma lib ainda não definida.

## Rodar o projeto
Uma opção para rodar o projeto, é usando docker:
* $ docker pull igor972/php-study
* Na pasta do projeto: $ docker compose up -d
* Acessar localhost:50001

