<?php 
require_once("import-common.php");

echo "<html><head></head>";

if (!isset($_GET['path'])) 
	       $_GET['path'] = '/demo';
echo "<body><h2>PluXml .txt files importer - ".$_GET['path']." v0.1a 2018.07</h2><hr>";

$article_keys = json_decode(file_get_contents("import_keys.json"));
$article_template = new Template("import.tmpl");
echo 'Hello World'.PHP_EOL;
//$file = fopen($_GET['path'].$filename,"w");

print("<hr><br><b>COPYRIGHT <a href='http://sstsoft.pl'>SSTSOFT.PL</a> 2018r</b><br>");
echo "</body></html>";
?>