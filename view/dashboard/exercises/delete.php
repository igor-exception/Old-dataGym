<?php
require __DIR__ . '/../../../vendor/autoload.php';
if(isset($_GET['id'])) {
    try {
        $ret = \App\Exercise\Exercise::deleteExercise($_GET['id'], new \App\Database\Database());
        header("Location: /view/dashboard/exercises/list.php");
        exit();
    } catch(\Throwable $t) {
        echo "<p>{$t->getMessage()}</p>";
    }
}


