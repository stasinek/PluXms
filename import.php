<?php 
#---------------------------------------------------------------------------
if (!isset($root)) $root = str_replace('\\','/',dirname(dirname(dirname(__DIR__))));
#Settings & Login (GET & POST), 
#Required files imported: STK Framework, PluXml Utils, Lather & Error handler etc. 
require_once("import-common.php");
if ($allcorrect!==true) die;
#---------------------------------------------------------------------------
# 12-12-31-23-59-59_Test,_importu.txt -> 201212312359
function fileName2FileDate($filename) {
	$base = basename($filename);
	$pattern = '/^(\d{2})?\d{2}\-\d{2}\-\d{2}-\d{2}\-\d{2}\-\d{2}\.*/';
	if (preg_match($pattern, $base, $matches)) {
		$date  = (count($matches)>1) ? "" : "20";
		$date .= str_replace("-",'',substr($matches[0],0,strlen($matches[0])-1-2));
		return $date;
	}
	else return date('omdHi',filemtime($filename));
}
#---------------------------------------------------------------------------
# 12-12-31-23-59-59_Test,_importu.txt -> "Test, importu"
function fileName2Title($filename) {
	$base = ucwords(basename($filename));
	$subst = array(".txt"=>"","_"=>" ","  "=>" ");
	foreach ($subst as $key => $value) {
		 $base = str_replace($key,$value,$base);
	}
	$pattern = '/^(\d{2})?\d{2}\-\d{2}\-\d{2}-\d{2}\-\d{2}\-\d{2}/';
	if (preg_match($pattern, $base, $matches)) {
		 $base = str_replace($matches[0],"",$base);
	}
	return trim($base,".-_ ");
}
#---------------------------------------------------------------------------
# 12-12-31-23-59-59_Test,_importu.txt -> "test-importu"
function fileName2ArtName($filename) {
	$filename =  basename($filename);
	$subst = array(".txt"=>""," "=>"-",
		"!"=>"-","@"=>"-","#"=>"-","%"=>"-","&"=>"-","."=>"-",","=>"-",";"=>"-","["=>"-","]"=>"-",")"=>"-","("=>"-","{"=>"-","}"=>"-","_"=>"-",
		"ą"=>"a","ę"=>"e","ć"=>"c","ł"=>"l","ó"=>"o","ś"=>"s","ń"=>"n","ź"=>"z","ż"=>"z");
	$result = strtolower(fileName2Title($filename));
# Remove french characters and characters not PlXml friendly
	$result = plxUtils::title2filename($result);
	foreach ($subst as $key => $value) {
		 $result = str_replace($key,$value,$result);
	}
	# remove --
	 while (strpos($result,"--")!==false) 
		 $result = str_replace("--","-",$result);
	return trim($result,"-");
}
#---------------------------------------------------------------------------
function str2Utf8($str) { 
    if (mb_detect_encoding($str, 'UTF-8', true)===false) { 
		$str = utf8_encode($str); 
    }
    return $str;
}
function convert2Html($content) {
  return replaceBBQuotes($content);	
}
#---------------------------------------------------------------------------
function replaceBBQuotes($content) {
# TODO: /[quote*][quote]text1[/quote] between [quote]text2[/quote][/quote]/ -> <blockquote><blockquote>text1</blockquote> between <blockquote>text2</blockquote></blockquote> 
# Until then simple will work for simple [quote][/quote] but would not work for nested ones!
# To do such thing: Need to search fo opening [quuote] tags, untill last one found, push it to array, use simple replacer for last one, pop changes back to context
# Find last opening tag again, use simple replacer, pop back changes and so on and so forth.. 
# Until then just use.. 
  return replaceBBSimple($content);
}
#---------------------------------------------------------------------------
# Regex - specials cannot be nested! Doesn't support [quote] at this moment.
function replaceBBSimple($content) {
	$content = "<p>".$content."</p>";
	$simple_subst = array("\n\r\n\r"=>"</p><br><p>","\n\r"=>"</p><p>","\n"=>"</p><p>","\t"=>"&nbsp&nbsp&nbsp&nbsp");
	foreach ($simple_subst as $key => $value) {
		 $content = str_replace($key,$value,$content);
	}
	$pattern_array = array(
		"/\[b\](.*?)\[\/b\]/i"=>
		'<b>${1}</b>',
		'/\[i\](.*?)\[\/i\]/i'=>
		'<i>${1}</i>',
		'/\[u\](.*?)\[\/u\]/i'=>
		'<u>${1}</u>',
		'/\[s\](.*?)\[\/s\]/i'=>
		'<strike>${1}</strike>',
		'/\[url[\s]*=[\\\'\"\s]*(.*(jpg|jpeg|gif|png|bmp))[\\\'\"\s]*\][\s]*\[img\](.*?)\[\/img\][\s]*\[\/url\]/i'=> 
		'<a href="${1}"><img src="${2}" alt="${2}"></img></a>',
		'/\[url[\s]*=[\\\'\"\s]*(?<link>[A-Za-z]*:\/\/[\w\.\_\~\:\/\?\#\[\]\@\!\$\&\'\(\)\*\+\,\;\=\-]*?)[\\\'\"\s]*\][\s]*\(.*?)[\s]*\[\/url\]/i'=> 
		'<a href="${1}">${2}</a>',
		'/\[url[\s]*\](?<link>[A-Za-z]*:\/\/[\w\.\_\~\:\/\?\#\[\]\@\!\$\&\'\(\)\*\+\,\;\=\-]*?)\[\/url\]/i'=>
		'<a href="${1}">${1}</a>',
		'/\[img[\s]*\](?<link>[A-Za-z]*:\/\/[\w\.\_\~\:\/\?\#\[\]\@\!\$\&\'\(\)\*\+\,\;\=\-]*?)\[\/img\]/i'=>
		'<img src="${1}" alt="${1}"></img>',
		'/[\s]+(?<link>[A-Za-z]*:\/\/[\w\.\_\~\:\/\?\#\[\]\@\!\$\&\'\(\)\*\+\,\;\=\-]*?)[\s]+/i'=>
		'&nbsp<a href="${1}">${1}</a>&nbsp',
		'/(?<link>[A-Za-z]*:\/\/[\w\.\_\~\:\/\?\#\[\]\@\!\$\&\'\(\)\*\+\,\;\=\-]*?)[\s]+/i'=>
		'<a href="${1}">${1}</a>&nbsp',
		'/[\s]+(?<link>[A-Za-z]*:\/\/[\w\.\_\~\:\/\?\#\[\]\@\!\$\&\'\(\)\*\+\,\;\=\-]*)/i'=>
		'&nbsp<a href="${1}">${1}</a>',
		'/\[quote[\s]*\](?<text>.*?)\[\/quote\]/i'=>
		'<blockquote>${1}</blockquote>',
		'/\[quote[\s]+name=[\\\'\"\s]*(?<name>.*?)[\\\'"\s]*date=[\\\'\"\s]*(?<date>.*?)[\\\'\"\s]*post=[\\\'\"\s]*(?<post>.*?)[\\\'\"\s]*\](?<text>.*?)\[\/quote\]/i'=>
		'<blockquote>${4}<footer>-&nbsp<q>${1}</q>&nbsp@&nbsp<q>${2}</q>&nbsp/&nbsp<q>${3}</q></footer></blockquote>',
		'/\[quote[\s]+name=[\\\'\"\s]*(?<name>.*?)[\\\'"\s]*date=[\\\'\"\s]*(?<date>.*?)[\\\'\"\s]*\](?<text>.*?)\[\/quote\]/i'=>
		'<blockquote>${3}<footer>-&nbsp<q>${1}</q>&nbsp@&nbsp<q>${2}</q></footer></blockquote>',
		'/\[quote[\s]+name=[\\\'\"\s]*(?<name>.*?)[\\\'\"\s]*\](?<text>.*?)\[\/quote\]/i'=>
		'<blockquote>${2}<footer>-&nbsp<q>${1}</q></footer></blockquote>',
		'/\[code\](.*?)\[\/code\]/i'=>
		'<code>${1}</code>',
		"/<[\s]*script[^>]*>(.*?)<[\s]*\/[\s]*script[^>]*>/i"=>
		'<code>${0}</code>',
		"/<[\s]*iframe[^>]*>(.*?)<[\s]*\/[\s]*iframe[^>]*>/i"=>
		'<code>${0}</code>'
		);
	foreach ($pattern_array as $pattern => $replacement) {
		$result = preg_replace($pattern,$replacement,$content);
		if ($result!==null) $content = $result;		
	}
	echo $content;
	return $content;
}
//convert2Html('ftp://galeria.e-kei.pl [b]test[/b] [i]test[/i][u]test[/u][s]test[/s]<script>test</script> Proste: [quote name="SunTzu" date=\'2018.04.16 21:04\' post=\'1138856\']quote test2[/quote] zagnieżdzone (nie zadziała):[quote][quote]testk[/quote][/quote] nienazwany w tagu url [url]"http://test.pl/"[/url] [url="http://test.pl/"]nazwany url[/url] http://google.pl');
//include_once($root.'/public_html/start/common/server-console.php');
//die;

#---------------------------------------------------------------------------
# HTML BODY
echo("<html><head></head><body><h2>PluXml .txt files importer - \"$path\" v0.1a 2018.07</h2><hr>");
#---------------------------------------------------------------------------
# Template + template keys list
$article_keys = json_decode(file_get_contents("import-keys.json"));
$article_template = new Template("import.tmpl");
$article_exist = array();
$article_last_num = 0;
#---------------------------------------------------------------------------
# Get list of existing articles
$lista_xml = glob(__DIR__.'/data/articles/*.xml');
echo "Articles found:".PHP_EOL;
for($i = 0; $i < count($lista_xml); $i++)
	{ 
		$article_exist[] = $lista_xml[$i];
		$num = strtok(str_replace((__DIR__).'/data/articles/','',$lista_xml[$i]),".");
		echo ($i==0 ? ' ' : ',')."$num";
		if ($num > $article_last_num) $article_last_num = $num; 
	}
echo "<br>Total bumber of articles: $article_last_num".PHP_EOL;
#---------------------------------------------------------------------------
# Get source files list
$lista = glob(__DIR__.'/'.$path.'/*.txt');
echo "<hr>Files found in \"$path\": ".count($lista)."<hr>".PHP_EOL;
$article_imported = 0;
for($i = 0; $i < count($lista); $i++)
	{ 
	$template = clone($article_template);
	$filename = $lista[$i];
	$relative_name = str_replace($root.'/'.(__DIR__).'/',"",$filename);
	if ($i==0) $num = $article_last_num + 1;
	else $num = $num + 1;
		echo ($i==0 ? '' : '<br>')."$num: ".str_replace($root.'/','',$relative_name).PHP_EOL;
#Open source file
	if (is_readable($filename)) $text = file_get_contents($filename);
	else continue;
#Detect & Convert ANSI -> UTF8, or just remove "UTF8 BOM"	
	$text = str2Utf8($text);
#Replace [img], [url], [quote] tags -> <img>, <a>, <quote> 
	$text = convert2Html($text);
	$filename_xml = sprintf("%s%04d.000.001.%s.%s.xml",(__DIR__).'/data/articles/',$num,fileName2FileDate($filename),fileName2ArtName(basename($filename)));
		echo "<br>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp-> ".str_replace($root.'/','',$filename_xml)."<br>";
#Open destination file
	$file_xml = fopen($filename_xml,"w");
	if (!$file_xml) { echo "^ Error creating file.<br>"; continue; }

	$content = array('template'=>'article.php','title'=>fileName2Title($filename),
	'subtitle'=>'Zaimportowane automatycznie z notatek tekstowych<br>','date_update'=>fileName2FileDate($filename),
	'date_creation'=>fileName2FileDate($filename),
	'content'=>$text,'tags'=>'Komentarze Stanley','meta_keywords'=>'comments news research wiki');
	foreach ($article_keys as $key) {
		 if (isset($content[$key])) $template->set($key,$content[$key]);
			else $template->set($key,'');
		}
	if (!fwrite($file_xml,$template->output())) { echo "^ Error writing file.<br>"; continue; } 
	fclose($file_xml);
		echo "^ Conversion successful!"; $article_imported += 1;
# To remove imported file after successful conversion
	if (unlink($filename)) echo " NOTICE! Source file has been deleted.";
	}
#---------------------------------------------------------------------------
# Finito!
echo " <br>Total number of files imported: $article_imported<br>".PHP_EOL;
echo(" <hr><b>COPYRIGHT <a href='http://sstsoft.pl'>SSTSOFT.PL</a> 2018r</b><hr>");
# Error handler printout
include_once($root.'/public_html/start/common/server-console.php');
echo("</body></html>");
#---------------------------------------------------------------------------
?>