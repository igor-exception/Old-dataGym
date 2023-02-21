<?php
require __DIR__ . '/../../../vendor/autoload.php';
require_once '../includes/_header.php';

if(isset($_GET['id'])) {
    try {
        $exercise = \App\Exercise\Exercise::getExercise($_GET['id'], new \App\Database\Database());
?>

        <div class="container-fluid px-4">
        <h1 class="mt-4">Exercícios</h1>
        <ol class="breadcrumb mb-4">
                <li class="breadcrumb-item"><a href="/view/dashboard/exercises/list.php">Exercícios</a></li>
                <li class="breadcrumb-item active">Visualizar</li>
            </ol>
        <div class="row">
            <div class="col-lg-6 col-sm-12">
                <form method="POST" action="./exercises.php">
                    <div class="form-floating mb-3">
                        <input class="form-control" id="name" name="name" type="text" placeholder="Supino reto" value="<?= $exercise['name']?>" readonly/>
                        <label for="inputEmail">Nome do exercício</label>
                    </div>
                    <div class="form-floating mb-3">
                        <textarea class="form-control" id="description" name="description" style="height: 100px" readonly><?= $exercise['description']?></textarea>
                        <label for="description">Comentário</label>
                    </div>
                    <div class="d-flex align-items-center justify-content-between mt-4 mb-0">
                        <a href='<?= "/view/dashboard/exercises/edit.php?id={$exercise['id']}"?>'><button type="button" class="btn btn-warning">Editar</button></a>
                    </div>
                </form>
            </div>
        </div>
    </div>

<?php
    }catch (\Throwable $t) {
        echo "<p>{$t->getMessage()}</p>";
    }
}

require_once './../includes/_footer.php';
?>