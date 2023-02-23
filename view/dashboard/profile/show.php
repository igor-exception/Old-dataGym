<?php
require __DIR__ . '/../../../vendor/autoload.php';
require_once '../includes/_header.php';
    if(isset($_SESSION['id'])) {
        try {
            $user = \App\User\User::getUserById($_SESSION['id'], new \App\Database\Database());
?>
            <div class="container-fluid px-4">
                <h1 class="mt-4">Perfil</h1>
                <ol class="breadcrumb mb-4">
                    <li class="breadcrumb-item active">Perfil</li>
                </ol>
        
                <div class="row">
                    <div class="col-lg-6 col-sm-12">
                        <form method="POST" action="/view/dashboard/profile/edit.php">
                        <input class="form-control" id="id" name="id" type="hidden" value="<?= $user['id']?>" />
                            <div class="form-floating mb-3">
                                <input class="form-control" id="name" name="name" type="text" value="<?= $user['name']?>" readonly/>
                                <label for="inputEmail">Nome</label>
                            </div>
                            <div class="form-floating mb-3">
                                <input class="form-control" id="email" name="email" type="text" value="<?= $user['email']?>" readonly/>
                                <label for="inputEmail">Email</label>
                            </div>
                            <div class="form-floating mb-3">
                                <input class="form-control" id="password" name="password" type="password" value="*******" readonly/>
                                <label for="inputEmail">Senha</label>
                            </div>
        
                            <div class="d-flex align-items-center justify-content-between mt-4 mb-0">
                                <input type="submit" class="btn btn-warning" class="btn btn-warning" value="Editar"/>
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