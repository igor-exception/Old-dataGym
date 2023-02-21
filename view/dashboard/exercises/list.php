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
    <h1 class="mt-4">Exercícios</h1>
    <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item active">Exercícios</li>
        </ol>
    <div class="row">
        <table class="table table-hover">
            <thead>
                <tr>
                <th scope="col">#</th>
                <th scope="col">Exercício</th>
                <th scope="col">Descrição</th>
                <th scope="col">Ações</th>
                </tr>
            </thead>

            <tbody>
                <?php if(count($exercises) < 1) { ?>
                    <tr>
                        <td>-</td>
                        <td>-</td>
                        <td>-</td>
                        <td>-</td>
                    </tr>
                <?php } else { ?>
                    <?php foreach($exercises as $idx=>$exercise) { ?>
                        <tr>
                            <td><?= $idx + 1 ?></td>
                            <td><?= $exercise['name'] ?></td>
                            <td><span class="d-inline-block text-truncate" style="max-width: 300px;"><?= $exercise['description'] ?></span></td>
                            <td>
                                <a href='<?= "/view/dashboard/exercises/show.php?id={$exercise['id']}"?>'><button type="button" class="btn btn-secondary btn-sm">Ver</button></a>
                                <a href='<?= "/view/dashboard/exercises/edit.php?id={$exercise['id']}"?>'><button type="button" class="btn btn-warning btn-sm">Editar</button></a>
                                <a href='<?= "/view/dashboard/exercises/delete.php?id={$exercise['id']}"?>' onclick="return confirm('Tem certeza que deseja remover este item?');"><button type="button" class="btn btn-danger btn-sm">Remover</button></a>
                            </td>
                        </tr>
                    <?php } ?>
                <?php } ?>
            </tbody>
        </table>
        <a href='<?= "/view/dashboard/exercises/create.php"?>'><button type="button" class="btn btn-primary btn-lg">Adicionar</button></a>
    </div>
</div>
<?php
require_once './../includes/_footer.php';
?>