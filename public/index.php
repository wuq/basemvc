<?php

header("Content-Type: text/html; charset=UTF-8");
date_default_timezone_set('Asia/Shanghai');


define("DS", DIRECTORY_SEPARATOR);
define("APP_PATH",  dirname(__FILE__).DS.'..'.DS);
define("ROOT_PATH",  dirname(__FILE__));


include APP_PATH . DS . 'app/Bootstrap.php';


try {

    Bootstrap::cef966ab4274d37ef65d724218073a79();
} catch (\Exception $e) {
    echo "Exception: ", $e->getMessage();
}