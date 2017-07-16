<?php
/**
 * Created by PhpStorm.
 * User: victor
 * Date: 16/07/17
 * Time: 13:36
 */

function retornaArquivosDir($diretorio){
    if (is_dir($diretorio)){
        $dir = dir($diretorio);
        try {
            while(($arquivo = $dir->read()) !== false) {
                yield $arquivo;
            }
        } finally {
            $dir->close();
        }
    } else {
        throw new Exception('Diretório inválido');
    }
}

function autolooad($diretorios = []){
    foreach ($diretorios as $diretorio) {
        foreach (retornaArquivosDir($diretorio) as $item) {
            $file = $diretorio . $item;
            if(file_exists($file) && strlen($item) > 2){
                require_once $file;
            }
        }
    }
}