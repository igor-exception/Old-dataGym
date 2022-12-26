<?php

require __DIR__ . '/vendor/autoload.php';

require_once __DIR__ . '/includes/_header.php';

if(isset($_GET['msg'])){
    if ($_GET['msg'] == 'success') {
        echo "<p>Cadastro realizado com sucesso!</p>";
    }
}
?>

<div class="row">
    <div class="col">
    <div class="col">
        <div class="card" style="width: 18rem;">
            <div class="card-body">
                <h5 class="card-title">Sobre</h5>
                <p class="card-text">DataGym tem como objetivo registrar progresso de cargas e repetições nos exercícios.</p>
            </div>
        </div>
    </div>
    </div>
    <div class="col">
        <div class="card" style="width: 18rem;">
            <div class="card-body">
                <h5 class="card-title">Registrar/Logar</h5>
                <p class="card-text">Caso já tenha conta, faça login. Ou, registre-se</p>
                <a href="./view/signin.php" class="card-link">Login</a>
                <a href="./view/signup.php" class="card-link">Nova conta</a>
            </div>
        </div>
    </div>
  </div>

<?php
require_once __DIR__ . '/includes/_footer.php';
?>