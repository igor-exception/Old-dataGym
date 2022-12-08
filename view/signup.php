<?php
require __DIR__ . './../vendor/autoload.php';

if(isset($_POST['InputName'] , $_POST['InputEmail'], $_POST['InputPassword'], $_POST['InputPasswordConfirmation']))
{
    $user = new \App\User\User();
    $user->createUser($_POST['InputName'] , $_POST['InputEmail'], $_POST['InputPassword'], $_POST['InputPasswordConfirmation']);

    if($user->thereIsError()){
        foreach($user->getErrorMessages() as $message) {
            echo "<p>{$message}</p>";
        }
    }else{
        echo "<p>Cadastro realizado com sucesso!</p>";
    }
}



require_once __DIR__ . './../includes/_header.php';
require_once __DIR__ . './../includes/_signup.php';
require_once __DIR__ . './../includes/_footer.php';