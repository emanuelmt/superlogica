<?php
//Definição das variáveis globais do sistema
$conf = parse_ini_file("conf.ini");
foreach ($conf as $key => $value) {
    define($key, $value);
}

//Configuração da função que fará o autoload das classes
function autoload($Class)
{
    $classDir = ['DataBase', 'Models'];
    $error = true;
    foreach ($classDir as $dirName) {
        $file = implode(DIRECTORY_SEPARATOR, [__DIR__, $dirName, "$Class.php"]);
        if (file_exists($file) && !is_dir($file)) {
            require_once($file);
            $error = false;
            break;
        }
    }
    if ($error) {
        trigger_error("Não foi possível incluir {$Class}.php", E_USER_ERROR);
        die;
    }
}

spl_autoload_register("autoload");
