<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
if (!isset($root)) $root = str_replace('\\','/',dirname(dirname(__DIR__)));
include $root.'/common/include/utils.php';
include $root.'/common/include/stack.php';
include $root.'/common/include/lather/templater.php';
include $root."/common/include/make-xml.php";

?>
