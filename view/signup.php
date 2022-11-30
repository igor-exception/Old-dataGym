<?php
require __DIR__ . './../vendor/autoload.php';

if(isset($_POST['InputName'] , $_POST['InputEmail'], $_POST['InputPassword'], $_POST['InputPasswordConfirmation']))
{
    var_dump($_POST);
}



require_once __DIR__ . './../includes/_header.php';
require_once __DIR__ . './../includes/_signup.php';
require_once __DIR__ . './../includes/_footer.php';