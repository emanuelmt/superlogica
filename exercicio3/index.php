<?php
require_once("../class/Configurations.php");

$select = new Select();
$insert = new Insert();

// Processo de criação das tabelas - DDL
$sql = "CREATE TABLE IF NOT EXISTS `usuario` (
            `Id` INT(11) NOT NULL,
            `cpf` VARCHAR(11) NOT NULL,
            `nome` VARCHAR(150) NOT NULL
        );
        CREATE TABLE IF NOT EXISTS `info` (
            `Id` INT(11) NOT NULL,
            `cpf` VARCHAR(11) NOT NULL,
            `genero` CHAR(1) NOT NULL,
            `ano_nascimento` INT(11) NOT NULL
        );";
$select->Exec($sql);
if ($select->GetError()) {
    echo "<p>Não foi possível criar as tabelas!</p>";
    echo "<p><strong>{$select->GetError()}</strong></p>";
    exit();
}
// Processo de população das tabelas criadas - DML
$userData = [
    ["Id" => 1, "cpf" => "16798125050", "nome" => "Luke Skywalker"],
    ["Id" => 2, "cpf" => "59875804045", "nome" => "Bruce Wayne"],
    ["Id" => 3, "cpf" => "04707649025", "nome" => "Diane Prince"],
    ["Id" => 4, "cpf" => "21142450040", "nome" => "Bruce Banner"],
    ["Id" => 5, "cpf" => "83257946074", "nome" => "Harley Quinn"],
    ["Id" => 6, "cpf" => "07583509025", "nome" => "Peter Parke"]
];
$sql = "SELECT * FROM usuario WHERE cpf = :cpf";
foreach ($userData as $user) {
    if ($select->Exec($sql, [":cpf" => $user["cpf"]])->GetResult()) {
        echo "<p>O usuário {$user["nome"]} - {$user["cpf"]} já foi inserido!</p>";
    } else if ($insert->Exec("usuario", $user)->GetResult()) {
        echo "<p>O usuário {$user["nome"]} - {$user["cpf"]} foi inserido com sucesso!</p>";
    } else if ($insert->GetError()) {
        echo "<p>Ocorreu um erro ao inserir o usuário!<br><strong>{$insert->GetError()}</strong></p>";
    } else {
        echo "<p>Não foi possível inserir o usuário {$user["nome"]} - {$user["cpf"]}!</p>";
    }
}

$infoData = [
    ["Id" => 1, "cpf" => "16798125050", "genero" => "M", "ano_nascimento" => 1976],
    ["Id" => 2, "cpf" => "59875804045", "genero" => "M", "ano_nascimento" => 1960],
    ["Id" => 3, "cpf" => "04707649025", "genero" => "F", "ano_nascimento" => 1988],
    ["Id" => 4, "cpf" => "21142450040", "genero" => "M", "ano_nascimento" => 1954],
    ["Id" => 5, "cpf" => "83257946074", "genero" => "F", "ano_nascimento" => 1970],
    ["Id" => 6, "cpf" => "07583509025", "genero" => "M", "ano_nascimento" => 1972]
];
$sql = "SELECT * FROM info WHERE cpf = :cpf";
foreach ($infoData as $info) {
    if ($select->Exec($sql, [":cpf" => $info["cpf"]])->GetResult()) {
        echo "<p>As informações para o cpf {$info["cpf"]} já foi inserido!</p>";
    } else if ($insert->Exec("info", $info)->GetResult()) {
        echo "<p>As informações para o cpf {$info["cpf"]} foram inseridas com sucesso!</p>";
    } else if ($insert->GetError()) {
        echo "<p>Ocorreu um erro ao inserir as informações para o cpf {$info["cpf"]}!<br><strong>{$insert->GetError()}</strong></p>";
    } else {
        echo "<p>Não foi possível inserir as informações para o cpf {$info["cpf"]}!</p>";
    }
}

// Processo de consulta de dados - DML
$sql = "SELECT 
            CONCAT(u.nome, ' - ', i.genero) AS usuario, 
            IF((YEAR(CURDATE()) - i.ano_nascimento) > 50, 'SIM', 'NÃO') AS maior_50_anos
        FROM usuario u
        INNER JOIN info i ON (i.cpf = u.cpf)
        WHERE
            i.genero = :GENERO
        ORDER BY
            maior_50_anos ASC, u.Id desc
        LIMIT :LIMIT";
$select->Exec($sql, [":GENERO" => "M", ":LIMIT" => 3]);
$result = $select->GetResult();
?>
<h5>RESULTADO</h5>
<?php
if ($result) {
?>
    <table>
        <thead>
            <tr>
                <th>usuario</th>
                <th>maior_50_anos</th>
            </tr>
        </thead>
        <tbody>
            <?php
            foreach ($result as $value) {
            ?>
                <tr>
                    <td><?= $value['usuario'] ?></td>
                    <td><?= $value['maior_50_anos'] ?></td>
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
} else {
    echo "<p>Nenhum resultado encontrado no banco de dados!</p>";
}
