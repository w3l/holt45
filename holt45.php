<?php
define('HOLT45_DIR', dirname(__FILE__) . '/holt45');

require_once HOLT45_DIR . '/Constants.php';

class holt45 {
	use Holt45Constants;

	
	/**
	 * Check $_GET
	 *
	 * @example if(chk_get("s") == "a") instead of if(isset($_GET["s"]) && $_GET["s"] == "a")
	 *
	 * @param string $key Get-key...
	 * @return bool
	 */
	public static function chk_get($key) {
		if (!isset($_GET[$key])) {
			return false;
		}
		return $_GET[$key];
	}

	/**
	 * Check $_POST
	 *
	 * @example if(chk_post("s") == "a") instead of if(isset($_POST["s"]) && $_POST["s"] == "a")
	 *
	 * @param string $key Post-key...
	 * @return bool
	 */
	public static function chk_post($key) {
		if (!isset($_POST[$key])) {
			return false;
		}
		return $_POST[$key];
	}
	
	/**
	 * Assign value from $_GET
	 *
	 * @example $var = assign_from_get("a") instead of $var = ((!empty($_GET["s"])) ? $_GET["s"] : "");
	 *
	 * @param string $key
	 * @return string
	 */
	public static function assign_from_get($key) {
		return ((!isset($_GET[$key])) ? "" : $_GET[$key]);
	}

	/**
	 * Assign value from $_POST
	 *
	 * @example $var = assign_from_post("a") instead of $var = ((!empty($_POST["s"])) ? $_POST["s"] : "");
	 *
	 * @param string $key
	 * @return string
	 */
	public static function assign_from_post($key) {
		return ((!isset($_POST[$key])) ? "" : $_POST[$key]);
	}

	/**
	 * Check multiple $_GET-keys
	 *
	 * @example if(chk_get_all(array("a","b"))) instead of if(!empty($_GET["a"]) && !empty($_GET["b"]))
	 *
	 * @param array $keys
	 * @return bool
	 */
	public static function chk_get_all($keys) {
		$s = true;

		foreach($keys AS $key) {
		
			if (empty($_GET[$key])) {
				$s = false;
			}
		}
		return $s;
	}

	/**
	 * Check multiple $_POST-keys
	 *
	 * @example if(chk_post_all(array("a","b"))) instead of if(!empty($_POST["a"]) && !empty($_POST["b"]))
	 *
	 * @param array $keys
	 * @return bool
	 */
	public static function chk_post_all($keys) {
		$s = true;

		foreach($keys AS $key) {
		
			if (empty($_POST[$key])) {
				$s = false;
			}
		}
		return $s;
	}

	/**
	 * Handle sessions - set session
	 *
	 * @param string $name Session name
	 * @param string $content Session content
	 * @param int $expires How many seconds before the session should expire.
	 */
	public static function session_set($name, $content, $expires = 86400) {
		$_SESSION[$name] = (time() + $expires).'-'.$content;
	}

	/**
	 * Handle sessions - check if session is set and not expired.
	 *
	 * @param string $name Session name
	 * @return bool Session status
	 */
	public static function session_isset($name) {
		if(isset($_SESSION[$name])) {
			$expires = current(explode("-",$_SESSION[$name]));
			if(ctype_digit($expires) && $expires > time()) {
				return true;
				
			} else {
				unset($_SESSION[$name]);
				return false;
			}
		} else {
			return false;
		}
	}

	/**
	 * Handle sessions - Get session content
	 *
	 * @param string $name Session name
	 * @return string Session content
	 */
	public static function session_read($name) {
		return substr(strstr($_SESSION[$name], '-'),1);
	}

	/**
	 * Handle sessions - Delete session
	 *
	 * @param string $name Session name
	 * @return void
	 */
	public static function session_delete($name) {
		unset($_SESSION[$name]);
	}
	
	/**
	 * Convert timestamp to HTTP-date (RFC2616)
	 *
	 * For use in "Last-Modified" headers.
	 *
	 * @param string $timestamp
	 * @return string
	 */
	public static function timestamp_to_http_date($timestamp) {
		if($timestamp == NULL) { return NULL; }
		return gmdate("D, d M Y H:i:s T", strtotime($timestamp));
	}

	/**
	 * Get client ip-address
	 *
	 * @return string User ip-address
	 */
	public static function get_client_ip_address() {

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
	public static function url_parser($url) {
		
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
	 * @param bool $simple Limit character-set to first 33 characters.
	 * @return string
	 */
	public static function generate_password($length = 8, $simple = false) {
		$character_set = "23456789abcdefghijkmnopqrstuvwxyzABCDEFGHJKLMNPRSTUVWXYZ!#%+:=?@";
		$character_set_lenght = (($simple) ? 33 : 64);
		
		$i = 0;
		
		while($i < 10) {
		
			$suggested_password = "";
			
			for($i = 0; $i < $length; $i++) {
				$suggested_password .= $character_set[rand(0,($character_set_lenght-1))];
			}

			if(strlen(count_chars($suggested_password, 3)) > ($length-2)) {
				break;
			}
		}
		
		return $suggested_password;
		
	}
	
	/**
	 * Convert <textarea> to [textarea].
	 *
	 * @param string $html
	 * @return string
	 */
	public static function textarea_encode($html) {
		return preg_replace("/<textarea(.*?)>(.*?)<\/textarea>/is", "[textarea$1]$2[/textarea]", $html);
	}
	
	/**
	 * Convert [textarea] to <textarea>.
	 *
	 * @param string $html
	 * @return string
	 */
	public static function textarea_decode($html) {
		return preg_replace("/\[textarea(.*?)\](.*?)\[\/textarea\]/is", "<textarea$1>$2</textarea>", $html);
	}

	/**
	 * Convert timestamp to "x unit"
	 *
	 * @param string $timestamp
	 * @return string
	 */
	public static function time_elapsed($timestamp) {
		$seconds = max((time() - strtotime($timestamp)),0);
		
		if($seconds < 60) {
			$number = $seconds;
			$text = "second";
		} elseif($seconds < (60 * 60)) {
			$number = $seconds / 60;
			$text = "minute";
		} elseif($seconds < (60 * 60 * 24)) {
			$number = $seconds / (60 * 60);
			$text = "hour";
		} else {
			$number = $seconds / (60 * 60 * 24);
			$text = "day";
		}

		$number = floor($number);
		
		if($number > 1) {
		$text.="s";
		}
		
		return "$number $text";
	}
}