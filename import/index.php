<?php
chdir("..");
if (!isset($root)) $root = str_replace('\\','/',dirname(dirname(dirname(dirname(__DIR__)))));
require_once($root.'/public_html/start/notes/import.php');
chdir($root.'/public_html/start/notes');
?>
