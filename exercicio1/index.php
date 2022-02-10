<?php
require_once("../class/Configurations.php");
$name = filter_input(INPUT_POST, "name", FILTER_SANITIZE_STRING);
$userName = filter_input(INPUT_POST, "userName", FILTER_SANITIZE_STRING);
$zipCode = filter_input(INPUT_POST, "zipCode", FILTER_SANITIZE_NUMBER_INT);
$email = filter_input(INPUT_POST, "email", FILTER_VALIDATE_EMAIL);
$password = filter_input(INPUT_POST, "password", FILTER_SANITIZE_STRING);

if (count($_POST) > 0) {
    if (!$name) {
        echo "<p>Preencha o campo 'Nome completo'!</p>";
    }
    if (!$userName) {
        echo "<p>Preencha o campo 'Nome de login'!</p>";
    }
    if (!$zipCode) {
        echo "<p>Preencha o campo 'CEP'!</p>";
    } else if (strlen($zipCode) != 8) {
        echo "<p>Informe um cep válido! Ex.: 29665000</p>";
    }
    if ($email === "") {
        echo "<p>Preencha o campo 'Email'!</p>";
    } else if ($email === false) {
        echo "<p>Informe um email válido! Ex.: usuario@host.com</p>";
    }
    if (!$password) {
        echo "<p>Preencha o campo 'Senha'!</p>";
    } else if (!preg_match('/^(?=.*[a-z,A-Z])(?=.*[0-9])[\w\W]{8,}$/', $password)) {
        echo "<p>Informe uma senha de 8 caracteres ou mais, possuindo pelo menos 1 letra e 1 número!</p>";
    }

    if (Users::ReturnUser($email)->GetResult()) {
        echo "<p>Já existe um usuário cadastrado com o email <strong>$email</strong>!</p>";
    } else {
        $user = new Users($name, $userName, $zipCode, $email, $password);
        $user->Insert();
        if ($user->GetResult()) {
            echo "<p>Usuário cadastrado com suceso!</p>";
        } else if ($user->GetError()) {
            echo "<p>Ocorreu um erro ao cadastrar o usuário!<br><strong>{$user->GetError()}</strong></p>";
        } else {
            echo "<p>Não foi possível cadastrar o usuário!</p>";
        }
    }
}

?>

<form method="post">
    <div>
        <label for="name">Nome completo:</label>
        <input type="text" id="name" name="name" value="<?= $name ? $name : "" ?>">
    </div>
    <div>
        <label for="userName">Nome de login:</label>
        <input type="text" id="userName" name="userName" value="<?= $userName ? $userName : "" ?>">
    </div>
    <div>
        <label for="zipCode">CEP</label>
        <input type="text" id="zipCode" name="zipCode" value="<?= $zipCode ? $zipCode : "" ?>">
    </div>
    <div>
        <label for="email">Email:</label>
        <input type="text" id="email" name="email" value="<?= $email ? $email : "" ?>">
    </div>
    <div>
        <label for="password">Senha (8 caracteres mínimo, contendo pelo menos 1 letra
            e 1 número):</label>
        <input type="password" id="password" name="password" value="<?= $password ? $password : "" ?>">
    </div>
    <input type="submit" value="Cadastrar">
    <input type="reset" value="Limpar Campos">
</form>

<?php
$users = Users::ReturnUsers();
if ($users->GetResult()) {
?>
    <h5>RESULTADO</h5>
    <table>
        <thead>
            <tr>
                <th>Nome</th>
                <th>Login</th>
                <th>Cep</th>
                <th>Email</th>
            </tr>
        </thead>
        <tbody>
            <?php
            foreach ($users->GetResult() as $value) {
            ?>
                <tr>
                    <td><?= $value['name'] ?></td>
                    <td><?= $value['userName'] ?></td>
                    <td><?= $value['zipCode'] ?></td>
                    <td><?= $value['email'] ?></td>
                </tr>
            <?php
            }
            ?>
        </tbody>
    </table>
    <style>
        table {
            border-collapse: collapse;
            margin-bottom: 30px;
        }

        table tr td,
        table tr th {
            border: 1px solid #cecece;
            padding: 5px;
        }
    </style>
<?php
} else if ($users->GetError()) {
    echo "<p>Ocorreu um erro ao buscar os usuários cadastrados!<br><strong>{$users->GetError()}</strong></p>";
} else {
    echo "<p>Nenhum usuário cadastrado!</p>";
}
?>