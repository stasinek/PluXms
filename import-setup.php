<?php
require_once("import-common.php");

	echo str_replace($root.'/nextcloud/test',$_SERVER['HTTP_HOST'].'/nextcloud/test','/nextcloud/test').'</b><br>'.PHP_EOL;
	echo '<ul>'.PHP_EOL;
	// UPPER DIRECTORY - LINK
	if (isset($_GET['path']) ? dirname($_GET['path'])!='.' : false)
		{
		echo ' <li><a href="'.$page_url.'/?path='.dirname($_GET['path']).'"><b>'.dirname($_GET['path']).'</b></li>';
		}
	else 
		{
		echo ' <li><a href="'.$page_url.'"><b>nextcloud/test</b></li>';
		}
	$lista = glob($root.'/nextcloud/test'.'/*');
	$maska = array("*.txt","*.html","*.htm");
	$maska_match = false;
	for($i = 0; $i < count($lista); $i++)
		{ 
		$filename = $lista[$i];
		$relative_name = str_replace($root.'/nextcloud/test/',"",$filename);
		if(is_dir($filename)==true)
			{ 
			$subdir = glob($filename.'/*', GLOB_NOSORT);
			for ($x = 0; $x < count($subdir); $x++) array_push($lista, $subdir[$x]);
			if (count($subdir)>0)
				{
				echo ' <li><a href="'.$page_url.'/?path='.$relative_name.'"><b>'.$relative_name.'</b></li>';
				}
			}
		else	
			{
			$maska_match = false;
			for($m = 0; $m < count($maska); $m++)
				{
				if (fnmatch($maska[$m],$relative_name,FNM_CASEFOLD)==true) $maska_match = true;
				else  continue;
				}				
			if ($maska_match) 
				{
				echo ' <li style="margin-left:2em;"><input type="checkbox" name="file[]" checked value="'.$relative_name.'"></input>&nbsp<a class="file" href="'.$page_url.'/?file='.$relative_name.'">'.$relative_name.'</li>';
				}
			}
		}
	echo '</ul>'.PHP_EOL;	
?>