<?php

function autoload($classe){
//    echo $classe . ' - ';
    $name = explode("\\", $classe);
    if(count($name) == 2){
        $path = DIR . $name[0] . '/' . $name[1] . '.php';
    }else{
        $path = DIR . 'system/' . $classe . '.php';
    }
    
//    echo $path . '<br />';
    require_once($path);
}
spl_autoload_register("autoload");