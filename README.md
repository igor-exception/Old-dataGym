# dataGym

personal project to consolidate some knowledge in programming and testing.

Main idea of the project: When doing a bodybuilding exercise, I will be able to use this application to register the load evolution in the exercises. For example:

* User: John Doe
* Exercise: bench press
* Actions:
  * Reps: 10
  * Weight: 20kg
  * Rest: 3min
  * Date: 01/12/2022
---
* User: John Doe
* Exercise: bench press
* Actions:
  * Reps: 10
  * Weight: 22kg
  * Rest: 3min
  * Date: 04/12/2022
---
* User: John Doe
* Exercise: bench press
* Actions:
  * Reps: 10
  * Weight: 24kg
  * Rest: 3min
  * Date: 08/12/2022

later I will be able to present graphs showing evolution/involution. As we get more data, the app will present summaries with statistics using some lib not yet defined.

run the project
One option to run the project is to use docker:

$ docker pull igor972/php-study

In the project folder: $ docker compose up -d

Access localhost:50001
