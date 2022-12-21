<?php
require __DIR__ . './../vendor/autoload.php';
require_once __DIR__ . './../includes/_header.php';


if(isset($_POST['InputName'] , $_POST['InputEmail'], $_POST['InputPassword'], $_POST['InputPasswordConfirmation']))
{
    $user = new \App\User\User($_POST['InputName'] , $_POST['InputEmail'], $_POST['InputPassword'], $_POST['InputPasswordConfirmation']);

    if($user->thereIsErrors()){
        foreach($user->getErrorMessages() as $error ){
            echo "<p>{$error}</p>";
        }
    }

    header('Location: ../index.php?msg=success');
    exit;

}

require_once __DIR__ . './../includes/_signup.php';
require_once __DIR__ . './../includes/_footer.php';