<h2>Cadastrar conta</h2>
<form method="POST">
    <div class="form-group">
        <label for="InputName">Nome</label>
        <input type="text" class="form-control" name="InputName"placeholder="insira seu nome" value="John Doe">
    </div>
    <div class="form-group">
        <label for="InputEmail">Email</label>
        <input type="email" class="form-control" name="InputEmail" aria-describedby="emailHelp" placeholder="Insira seu email" value="john.doe@gmail.com">
    </div>
    <div class="form-group">
        <label for="InputPassword">Senha</label>
        <input type="password" class="form-control" name="InputPassword" placeholder="Insira sua senha" value="123123123">
    </div>
    <div class="form-group">
        <label for="InputPasswordConfirmation">Confirmação de senha</label>
        <input type="password" class="form-control" name="InputPasswordConfirmation" placeholder="Confirme sua senha" value="123123123">
    </div>
    <button type="submit" class="btn btn-primary">Enviar</button>
</form>