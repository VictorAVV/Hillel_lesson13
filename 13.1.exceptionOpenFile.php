<?php
/**
 * 1. Создайте обработку исключения открытия несуществующего файла. 
 * При попытке открыть несуществующий файл должно появиться сообщение: 
 * Файл с именем Name не существует, где Name- имя файла.
 */

$fileName = 'some_file.txt';
//$fileName = __FILE__;

try {
    if (!file_exists($fileName)) {
        throw new Exception("ERROR: File '$fileName' not exists!");
    }   
    //Next code will not execute, if the file does not exist
    $file = file_get_contents($fileName);
    highlight_string($file, 0);
    //...
} catch (Exception $err) {
    echo $err->getMessage();
    echo '<br>Line: ' . $err->getLine();
}
