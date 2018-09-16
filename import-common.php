<?php if (!isset($root)) exit(0);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
include $root.'/common/include/stk-utils.php';
include $root.'/common/include/stk-stack.php';
include $root."/common/include/stk-make-xml.php";
include $root.'/common/include/lather/templater.php';
#@title2filename
#Convert filename to PluXml friendly filename / url friendly
define('PLX_CHARSET', 'UTF-8');
require_once("core/lib/class.plx.utils.php");
if (isset($_GET['group'])) $group = $_GET['group'];
else $group = 0;
#Setting the import folder, 
if (isset($_GET['path'])) $path = $_GET['path'];
else $path = "import-data";
#for security reasons "\" "/" or "." as any part of PluXml directory is forbiden
$path_blacklist = array("\\","/",".","data","core","plugins","themes","common","sauvegarde","update",".git");
for ($i = 0; $i < count($path_blacklist); $i++) {
	 if (strstr($path_blacklist[$i],$path)) exit(0);
	 else continue;
	}
$allcorrect = true; 
?>
