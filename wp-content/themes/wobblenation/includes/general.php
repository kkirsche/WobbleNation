<?php
/**
 * General use functions
 * Exclusive to the WobbleNation theme
 * 
 * @package WordPress
 * @subpackage WobbleNation
**/


/**
 * Parse the content between two strings
 *
 * Exammple: 
 * get_string_between('hello [b]world[/b]', '[b]', [/b])
 * returns 'world' 
**/
function get_string_between($string, $start, $end){
	$string = " ".$string;
	$ini = strpos($string,$start);
	if ($ini == 0) return "";
	$ini += strlen($start);
	$len = strpos($string,$end,$ini) - $ini;
	return substr($string,$ini,$len);
}


/**
 * Finds a key inside a multi-level array
 * It works only for the form: [key][child]
**/
function array_deep_exists($array, $key)
{
    $keys = preg_split("/\\]|\\[/", $key, NULL, PREG_SPLIT_NO_EMPTY);
    
    foreach ($keys as $key)
    {
        if ( ! array_key_exists($key, $array))
        {
            return false;
        }
        $array = $array[$key];
    }
    return $array;
}


/**
 * Cut a string to the specified number of words
**/
function split_by_words($words, $string, $divider = ' ') {
	$array = explode($divider, $string);
	$newarray = array();
	for($i = 0; $i < $words; $i++) {
		array_push($newarray, $array[$i]);
	}
	return implode(' ', $newarray);
}



/**
 * Cut a string in the middle and sets a different style for the first half
**/
function cut_in_the_middle($string) {
	
	$p1 = array();
	$p2 = array();
	
	$words = explode(' ', $string);
	
	if(count($words) % 2 == 0) {
		$half = count($words) / 2;
	}
	else {
		$mid = floor(count($words) / 2);
		$half = strlen($words[$mid]) > strlen($words[$mid + 1]) ? $mid : $mid + 1;
	}
	
	$i = 0;
	while($i < count($words)) {
		if($i < $half)
			array_push($p1, $words[$i]);
		else
			array_push($p2, $words[$i]);	
			
		$i++;
	}
	
	echo '<span class="altcolor">' . implode(' ', $p1) . '</span> ';
	echo implode(' ', $p2);
	
}


/**
 * Converts a timestamp into a "XX time ago" string 
**/
function timeago($timestamp){
   $difference = time() - strtotime($timestamp);
   $periods = array("second", "minute", "hour", "day", "week", "month", "years", "decade");
   $lengths = array("60","60","24","7","4.35","12","10");
   for($j = 0; $difference >= $lengths[$j]; $j++)
   $difference /= $lengths[$j];
   $difference = round($difference);
   if($difference != 1) $periods[$j].= "s";
   $text = "$difference $periods[$j] ago";
   return $text;
}


?>