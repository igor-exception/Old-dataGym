<?php
require __DIR__ . '/../../../vendor/autoload.php';
require_once '../includes/_header.php';

$exercises = \App\Exercise\Exercise::getExercises(new \App\Database\Database());

if(isset($_POST['name'], $_POST['description'])) {
    if(isset($_POST['name'], $_POST['description'])) {
        try {
            $exercise = new \App\Exercise\Exercise($_POST['name'], $_POST['description'], new \App\Database\Database());
            header('Location: ./index.php');
            exit();
        }catch (\Throwable $t) {
            echo "<p>{$t->getMessage()}</p>";
        }
    }
}
?>

<div class="container-fluid px-4">
    <h1 class="mt-4">Treinos</h1>
    <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item active">Treinos</li>
        </ol>
    <div class="row">

        <a href='<?= "/view/dashboard/actions/create.php"?>'><button type="button" class="btn btn-primary btn-lg">Adicionar treino</button></a>
    </div>
</div>
<?php
require_once './../includes/_footer.php';
?>