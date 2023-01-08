<?php
require __DIR__ . './../vendor/autoload.php';
require_once __DIR__ . './../includes/_header.php';


if (isset(
    $_POST['InputName'],
    $_POST['InputEmail'],
    $_POST['InputPassword'],
    $_POST['InputPasswordConfirmation']
)) {
    try {
        $user = new \App\User\User(
            $_POST['InputName'],
            $_POST['InputEmail'],
            $_POST['InputPassword'],
            $_POST['InputPasswordConfirmation']
        );
        header('Location: ../index.php?msg=success');
        exit();
    } catch (\Throwable $t) {
        echo "<p>{$t->getMessage()}</p>";
    }

}

require_once __DIR__ . './../includes/_signup.php';
require_once __DIR__ . './../includes/_footer.php';