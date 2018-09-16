<?php
if (preg_match_all('/\[img\]["]*(?<link>[A-Za-z]*:\/\/[\w\.\_\~\:\/\?\#\[\]\@\!\$\&\'\(\)\*\+\,\;\=\-]*).*\[\/img\]/','[url]http://digiworthy.com/2017/06/22/intel-skylake-x-vs-threadripper-die-size/[/url]',$matches))
{foreach($matches as $match) {print_r($match); echo '<br>';}}
else print("Dupa!");
print_r($matches);

?>
class Patterns {

	$pattern_array = array(
		array("/<[\s]*script[^>]*>(.*)/i",
		"/<[\s]*script[^>]*>/i",
		'<code>${0}</code>'),
		array("/<[\s]*iframe[^>]*>(.*)/i",
		"/<[\s]*iframe[^>]*>/i",
		'<code>${0}</code>'),
		array("/\[b\](.*?)/i",
		"/\[\/b\]/i",
		'<b>${1}</b>'),
		array('/\[i\](.*?)/i',
		'/\[\/i\]/i',
		'<i>${1}</i>'),
		array('/\[u\](.*?)/i',
		'/\[\/u\]/i',
		'<u>${1}</u>'),
		array('/\[s\](.*?)/i',
		'/\[\/s\]/i',
		'<strike>${1}</strike>'),
		array('/\[code\](.*?)/i',
		'/\[\/code\]/i',
		'<code>${1}</code>'),
		array('/\[quote\](?<text>.*?)/i',
		'/\[\/quote\]/i',
		'<blockquote>${1}</blockquote>'),
		array('/\[quote[\s]+name=[\"\s]*(?<name>.*?)[\"\s]*\](?<text>.*)/i',
		'/\[\/quote\]/i',
		'<blockquote>${2}<footer>-&nbsp<q>${1}</q></footer></blockquote>'),
		array('/\[quote[\s]+name=[\"\s]*(?<name>.*?)["\s]*date=[\"\s]*(?<date>.*?)[\"\s]*\](?<text>.*)/i',
		'/\[\/quote\]/i',
		'<blockquote>${3}<footer>-&nbsp<q>${1}</q>&nbsp@&nbsp<q>${2}</q></footer></blockquote>'),
		array('/\[quote[\s]+name=[\"\s]*(?<name>.*?)["\s]*date=[\"\s]*(?<date>.*?)[\"\s]*post=[\"\s]*(?<post>.*?)[\"\s]*\](?<text>.*?)/i',
		'/\[\/quote\]/i',
		'<blockquote>${4}<footer>-&nbsp<q>${1}</q>&nbsp@&nbsp<q>${2}</q>&nbspPOST:&nbsp<q>${3}</q></footer></blockquote>'),
		array('/\[img\][\"\s]*(?<link>[A-Za-z]*:\/\/[\w\.\_\~\:\/\?\#\[\]\@\!\$\&\'\(\)\*\+\,\;\=\-]*?)[\"\s]*/i',
		'/\[\/img\]/i',
		'<img src="${1}" alt="${1}"></img>'),
		array('/\[url\][\"\s]*(?<link>[A-Za-z]*:\/\/[\w\.\_\~\:\/\?\#\[\]\@\!\$\&\'\(\)\*\+\,\;\=\-]*?)[\"\s]*/i',
		'/\[\/url\]/i',
		'<a href="${1}">${1}</a>'),
		array('/\[url[\s]*=[\"\s]*(.*(jpg|jpeg|gif|png|bmp))[\"\s]*\][\s]*\[img\](.*?)\[\/img\][\"\s]*/i',
		'/\[\/url\]/i',
		'<a href="${1}">${1}3</a>'),
		array('/^(?<link>[A-Za-z]*:\/\/[\w\.\_\~\:\/\?\#\[\]\@\!\$\&\'\(\)\*\+\,\;\=\-]*?)[\s]+/i',
		'/[\s]+/',
		'<a href="${1}"><img src="${2}" alt="${2}"></img></a>'),
		array('/[\s]+(?<link>[A-Za-z]*:\/\/[\w\.\_\~\:\/\?\#\[\]\@\!\$\&\'\(\)\*\+\,\;\=\-]*?)[\s]+/i',
		'/[\s]+/',
		'<a href="${1}"><img src="${2}" alt="${2}"></img></a>'),
		array('/[\s]+(?<link>[A-Za-z]*:\/\/[\w\.\_\~\:\/\?\#\[\]\@\!\$\&\'\(\)\*\+\,\;\=\-]*?)$/i',
		'/[\s]+/',
		'<a href="${1}"><img src="${2}" alt="${2}"></img></a>')
		);

	function replace($context,$index)
	{
		$last_opening_match = $context; 
		$last_opening_match_offset = 0;
		if (preg_match($this->pattern_array[$index][0],$last_opening_match,$opening_matches,PREG_OFFSET_CAPTURE) {
			$last_opening_match = $opening_matches[0][0];
			$last_opening_match_offset = $opening_matches[0][1];
			
		}	


	$context = $last_opening_match;
			$last_opening_match[] = $opening_matches[0][0];
			$last_opening_match_offset[] = $opening_matches[0][1];
		}
		$last_closing_match = $last_opening_match; 
		$last_closing_match_offset = $last_opening_match_offset + strlen($last_opening_match);
		
		if (preg_match($this->pattern_array[$index][1],$last_opening_match,$closing_matches,PREG_OFFSET_CAPTURE,0)) {
			if (preg_match($this->pattern_array[$index][1],$opening_matches,$closing_matches,PREG_OFFSET_CAPTURE)) {
			
			}
		if (preg_match($this->pattern_array[$index][1],$result,$closing_matches,PREG_OFFSET_CAPTURE)) {
		
		}			
			$result = replace($opening_matches[0],$index);
			if ($result[1]==false)
			$result = preg_replace($this->pattern_array[$index][0],$this->pattern_array[$index][3],$context);
		}
		
		return array(false,$context);
	}
		if (preg_match($this->pattern_array[$index][1],$result,$closing_matches,PREG_OFFSET_CAPTURE)) {
			$result = substr($opening_matches[0],0,$closing_matches[0][1]);
			$result = preg_replace($this->pattern_array[$index][0],$this->pattern_array[$index][3],$context);
		}
		return $result;
	}

		
	$stos_opening = array(array($content));
	$result = "";
	
	while (preg_match($pattern,$stos_opening[$i],$matches),PREG_OFFSET_CAPTURE) {
		$stos_opening[] = $matches;		
	}
	while (preg_match($pattern,$stos_closing[$i],$matches),PREG_OFFSET_CAPTURE) {
		$stos_closing[] = $matches;		
	}
		'/\[quote\](?<text>.*?)\[\/quote\]/i'=>
		'<blockquote>${1}</blockquote>',
		'/\[quote[\s]+name=[\"\s]*(?<name>.*?)[\"\s]*\](?<text>.*?)\[\/quote\]/i'=>
		'<blockquote>${2}<footer>-&nbsp<q>${1}</q></footer></blockquote>',
		'/\[quote[\s]+name=[\"\s]*(?<name>.*?)["\s]*date=[\"\s]*(?<date>.*?)[\"\s]*\](?<text>.*?)\[\/quote\]/i'=>
		'<blockquote>${3}<footer>-&nbsp<q>${1}</q>&nbsp@&nbsp<q>${2}</q></footer></blockquote>',
		'/\[quote[\s]+name=[\"\s]*(?<name>.*?)["\s]*date=[\"\s]*(?<date>.*?)[\"\s]*post=[\"\s]*(?<post>.*?)[\"\s]*\](?<text>.*?)\[\/quote\]/i'=>
		'<blockquote>${4}<footer>-&nbsp<q>${1}</q>&nbsp@&nbsp<q>${2}</q>&nbspPOST:&nbsp<q>${3}</q></footer></blockquote>',

}*/

# metoda zwraca priorytet operatora
function int priorytet(String operator) {
  // dla + i - zwracamy 1
  if(operator.equals("+") || operator.equals("-")) return 1;
  // dla * i / zwracamy 2
  else if(operator.equals("*") || operator.equals("/")) return 2;
  // dla pozostałych 0
  else return 0;
}