<?php
require __DIR__ . './../vendor/autoload.php';
require_once __DIR__ . './../includes/_header.php';

if(isset($_POST['InputEmail'], $_POST['InputPassword']))
{
    try {
        $ret = \App\Login\Login::login($_POST['InputEmail'], $_POST['InputPassword'], new \App\Database\Database());
        $_SESSION['id']     = $ret['id'];
        $_SESSION['name']   = $ret['name'];
        $_SESSION['email']  = $ret['email'];

        header('Location: ./dashboard/index.php');
        exit();
    } catch (\Throwable $t) {
        echo "<p>{$t->getMessage()}</p>";
    }
}

require_once __DIR__ . './../includes/_signin.php';
require_once __DIR__ . './../includes/_footer.php';