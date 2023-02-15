<?php
require __DIR__ . './../vendor/autoload.php';
require_once __DIR__ . './../includes/_header.php';
if(isset($_POST['InputEmail'], $_POST['InputPassword']))
{
    try {
        $ret = \App\User\User::login($_POST['InputEmail'], $_POST['InputPassword'], new \App\Database\Database());
    } catch (\Throwable $t) {
        echo "<p>{$t->getMessage()}</p>";
    }
}



require_once __DIR__ . './../includes/_signin.php';
require_once __DIR__ . './../includes/_footer.php';