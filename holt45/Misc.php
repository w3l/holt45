<?php
namespace w3l\Holt45;
trait Misc {
	
	/**
	 * Convert ISO 3166-1 alpha-2 code to (English) country name.
	 *
	 * @link https://gist.github.com/IngmarBoddington/5909709 Source
	 *
	 * @param string $key ISO 3166-1 alpha-2 code
	 * @return string Country name OR $key if no match.
	 */
	public static function iso3166ToName($key) {
	
		$countries = self::getCountriesList();

		return ((array_key_exists($key, $countries)) ? $countries[$key] : $key);
	}
		
	/**
	* To replace "Hallo [@var] world" with $value.
	*
	* @example replace_string($string, array("val1" => "foo", "val2" => "bar"))
	*
	* @param string $lang_string String containing placeholder.
	* @return string String with placeholder replaced.
	*/
	public static function replaceString($lang_string, $dynamic_content = array()) {

		foreach ($dynamic_content as $k => $v) {
			$lang_string = str_replace("[@".$k."]", $v, $lang_string);
		}
		return $lang_string;
	}
	
	/**
	 * Get client ip-address
	 *
	 * @return string User ip-address
	 */
	public static function getClientIpAddress() {

		if (getenv('HTTP_CLIENT_IP'))
			return getenv('HTTP_CLIENT_IP');
		else if(getenv('HTTP_X_FORWARDED_FOR'))
			return getenv('HTTP_X_FORWARDED_FOR');
		else if(getenv('HTTP_X_FORWARDED'))
			return getenv('HTTP_X_FORWARDED');
		else if(getenv('HTTP_FORWARDED_FOR'))
			return getenv('HTTP_FORWARDED_FOR');
		else if(getenv('HTTP_FORWARDED'))
			return getenv('HTTP_FORWARDED');
		else if(getenv('REMOTE_ADDR'))
			return getenv('REMOTE_ADDR');
		else
			return '127.0.0.1'; // Unknown IP
	}

	/**
	 * Tries to auto-correct parse_url()-output.
	 *
	 * @param string $url
	 * @return array
	 */
	
	private static function autoCorrectParseUrl($url) {
		// multiple /// messes up parse_url, replace 3 or more with 2
		$url = preg_replace('/(\/{2,})/','//',$url);
		
		$parse_url = parse_url($url);
		
		if(empty($parse_url["scheme"])) {
			$parse_url["scheme"] = "http";
		}
		if(empty($parse_url["host"]) && !empty($parse_url["path"])) {
			// Strip slash from the beginning of path
			$parse_url["host"] = ltrim($parse_url["path"], '\/');
			$parse_url["path"] = "";
		}
		return $parse_url;
	}

	/**
	 * parse url, try to correct errors and return valid url + display-url.
	 *
	 * @example http:/wwww.example.com/lorum.html => http://www.example.com/lorum.html
	 * @example gopher:/ww.example.com => gopher://www.example.com
	 * @example http:/www3.example.com/?q=asd&f=#asd =>http://www3.example.com/?q=asd&f=#asd
	 * @example asd://.example.com/folder/folder/ =>http://example.com/folder/folder/
	 * @example .example.com/ => http://example.com/
	 * @example example.com =>http://example.com
	 * @example subdomain.example.com => http://subdomain.example.com
	 *
	 * @param string $url Any somewhat valid url.
	 * @return string[] "url" contains an auto-corrected url. "url_display" host.tld or subdomain.host.tld
	 */
	public static function urlParser($url) {
		
		$parse_url = self::autoCorrectParseUrl($url);

		$url_array = array("url" => "", "url_display" => "");
		
		// Check if scheme is correct
		if(!in_array($parse_url["scheme"], array("http", "https", "gopher"))) {
			$url_array["url"] .= 'http'.'://';
		} else {
			$url_array["url"] .= $parse_url["scheme"].'://';
		}
		
		// Check if the right amount of "www" is set.
		$explode_host = explode(".", $parse_url["host"]);
		
		// Remove empty entries
		$explode_host = array_filter($explode_host);
		// And reassign indexes
		$explode_host = array_values($explode_host);
		
		// Contains subdomain
		if(count($explode_host) > 2) {
			// Check if subdomain only contains the letter w(then not any other subdomain).
			if(substr_count($explode_host[0], 'w') == strlen($explode_host[0])) {
				// Replace with "www" to avoid "ww" or "wwww", etc.
				$explode_host[0] = "www";
				
			}
		}

		$url_array["url"] .= implode(".",$explode_host);
		$url_array["url_display"] = trim(implode(".",$explode_host), '\/'); // Removes trailing slash
		
		if(!empty($parse_url["port"])) {
			$url_array["url"] .= ":".$parse_url["port"];
		}
		if(!empty($parse_url["path"])) {
			$url_array["url"] .= $parse_url["path"];
		}
		if(!empty($parse_url["query"])) {
			$url_array["url"] .= '?'.$parse_url["query"];
		}
		if(!empty($parse_url["fragment"])) {
			$url_array["url"] .= '#'.$parse_url["fragment"];
		}

		
		return $url_array;
	}
	
	/**
	 * Generate a password-suggestion.
	 *
	 * @param int $length Length of password
	 * @param string $password_type "simple" limit character-set to first 33 characters. "long" uses 64 characters.
	 * @return string
	 */
	public static function generatePassword($length = 8, $password_type = "long") {
		$character_set = "23456789abcdefghijkmnopqrstuvwxyzABCDEFGHJKLMNPRSTUVWXYZ!#%+:=?@";
		$character_set_lenght = (($password_type == "simple") ? 33 : 64);
		
		$counter = 0;
		$suggested_password = "";
		
		while($counter < 10) {
		
			$suggested_password = "";
			
			for($i = 0; $i < $length; $i++) {
				$suggested_password .= $character_set[rand(0,($character_set_lenght-1))];
			}

			if(strlen(count_chars($suggested_password, 3)) > ($length-2)) {
				break;
			}
			
			$counter++;
		}
		
		return $suggested_password;
		
	}
	
	/**
	 * Obfuscate string (url-safe and somewhat hard to guess).
	 *
	 * @param string $input The text that should be obfuscated
	 * @return string Obfuscated string
	 */
	public static function obfuscateString($input) {
		return bin2hex(base64_encode(strrev($input)));
	}

	/**
	 * Deobfuscate string
	 *
	 * @param string $input Obfuscated string
	 * @return string Deobfuscated string
	 */
	public static function deobfuscateString($input) {
		return strrev(base64_decode(hex2bin($input)));
	}
	
	/**
	 * Convert <textarea> to [textarea].
	 *
	 * @param string $html
	 * @return string
	 */
	public static function textareaEncode($html) {
		return preg_replace("/<textarea(.*?)>(.*?)<\/textarea>/is", "[textarea$1]$2[/textarea]", $html);
	}
	
	/**
	 * Convert [textarea] to <textarea>.
	 *
	 * @param string $html
	 * @return string
	 */
	public static function textareaDecode($html) {
		return preg_replace("/\[textarea(.*?)\](.*?)\[\/textarea\]/is", "<textarea$1>$2</textarea>", $html);
	}
	
	/**
	 * Create range for pagination
	 *
	 * @param int $total_pages
	 * @param int $selected_page
	 * @param int $number_of_results
	 * @return array Array with all page-numbers limited by $number_of_results
	 */
	public static function generatePaginationRange($total_pages,$selected_page = 1,$number_of_results = 7) {

		// Get the numbers
		$temp_array_range = range(1, $total_pages);
		
		if($total_pages <= $number_of_results) {
			// all
			$array_data = $temp_array_range;
		} elseif($selected_page <= (round(($number_of_results / 2), 0, PHP_ROUND_HALF_UP))) {
			// 1-6+last
			$array_data = array_slice($temp_array_range, 0, ($number_of_results-1));
			$array_data[] = $total_pages;
			
		} elseif($selected_page >= $total_pages-round(($number_of_results / 2), 0, PHP_ROUND_HALF_DOWN)) {
			// first + $total_pages-5 - $total_pages
			$array_data = array_slice($temp_array_range, $total_pages-($number_of_results-1));
			$array_data[] = 1;
		} else {
			// first + $total_pages-2 - $total_pages+2 + last
			$array_data = array_slice($temp_array_range, $selected_page-(round(($number_of_results / 2), 0, PHP_ROUND_HALF_DOWN)), ($number_of_results-2));
			$array_data[] = 1;
			$array_data[] = $total_pages;
			
		}
		
		sort($array_data);
		
		return $array_data;
		
	}

	
}
