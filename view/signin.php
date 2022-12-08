<?php
require __DIR__ . './../vendor/autoload.php';

if(isset($_POST['InputEmail'], $_POST['InputPassword']))
{
    var_dump($_POST);
}


require_once __DIR__ . './../includes/_header.php';
require_once __DIR__ . './../includes/_signin.php';
require_once __DIR__ . './../includes/_footer.php';