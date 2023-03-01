<?php
require __DIR__ . '/../../../vendor/autoload.php';
require_once '../includes/_header.php';


if(isset($_POST['exercise'], $_POST['weight'], $_POST['repetitions'])) {
        
}
?>
        <div class="container-fluid px-4">
        <h1 class="mt-4">Treino</h1>
        <ol class="breadcrumb mb-4">
                <li class="breadcrumb-item"><a href="/view/dashboard/actions/list.php">Treinos</a></li>
                <li class="breadcrumb-item active">Adicionar</li>
            </ol>
        
            <div class="row">
                <form method="POST" action="/view/dashboard/actions/create.php">
                    <div class="row">
                        <div class="col-lg-6 col-md-6 col-sm-12">  <!-- coluna esquerda -->
                            <div class="mb-3">
                                <select class="form-select" aria-label="Default select example" name="exercise"> <!-- carregar exercicios -->
                                    <option selected>Escolher exercício</option>


                                    <option value="1">Supino</option>
                                    <option value="2">Biceps Barra W</option>
                                    <option value="3">Terra</option>

                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="weight" class="form-label">Peso</label>
                                <input type="number" class="form-control" id="weight" name="weight" aria-describedby="weightHelp">
                                <div id="weightHelp" class="form-text">Kilos</div>
                            </div>
                            <div class="mb-3">
                                <label for="repetitions" class="form-label">Repetições</label>
                                <input type="number" class="form-control" id="repetitions" name="repetitions">
                            </div>
                            <div class="mb-3">
                                <label for="rest" class="form-label">Descanso</label>
                                <input type="number" class="form-control" id="rest" name="rest" aria-describedby="restHelp">
                                <div id="restHelp" class="form-text">segundos</div>
                            </div>
                            <div class="mb-3">
                                <label for="rest" class="form-label">Data</label>
                                <input type="date" class="form-control" id="date" name="date" value="<?= date("Y-m-d"); ?>">
                            </div>
                        </div>

                        <div class="col-lg-6 col-md-6 col-sm-12">  <!-- coluna direita -->
                            <div class="form-floating mb-3">
                                <textarea class="form-control" id="description" name="description" style="height: 300px"></textarea>
                                <label for="description">Comentário</label>
                            </div>
                        </div>

                        <div class="d-flex align-items-center justify-content-between mt-4 mb-0">
                            <button class="btn btn-primary" type="submit">Adicionar</button>
                        </div>
                    </div>
                </form>
            </div>
        
    </div>

<?php
require_once './../includes/_footer.php';
?>