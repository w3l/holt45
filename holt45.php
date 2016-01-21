<?php
class holt45 {
	
	const DATA_URI_TRANSPARENT_GIF = 'data:image/gif;base64,R0lGODlhAQABAIAAAAAAAP///yH5BAEAAAAALAAAAAABAAEAAAIBRAA7';
	const DATA_URI_TRANSPARENT_PNG = 'data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAEAAAABCAQAAAC1HAwCAAAAC0lEQVQYV2NgYAAAAAMAAWgmWQ0AAAAASUVORK5CYII=';
	
	
	/**
	 * Check $_GET
	 *
	 * @example if(chk_get("s") == "a") instead of if(isset($_GET["s"]) && $_GET["s"] == "a")
	 *
	 * @param string $key Get-key...
	 * @return bool
	 */
	function chk_get($key) {
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
	function chk_post($key) {
		if (!isset($_POST[$key])) {
			return false;
		}
		return $_POST[$key];
	}

	/**
	 * Check multiple $_GET-keys
	 *
	 * @example if(chk_get_all(array("a","b"))) instead of if(!empty($_GET["a"]) && !empty($_GET["b"]))
	 */
	function chk_get_all($keys) {
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
	 */
	function chk_post_all($keys) {
		$s = true;

		foreach($keys AS $key) {
		
			if (empty($_POST[$key])) {
				$s = false;
			}
		}
		return $s;
	}

	/**
	 * Convert timestamp to HTTP-date (RFC2616)
	 *
	 * For use in "Last-Modified" headers.
	 */
	function timestamp_to_http_date($timestamp) {
		if($timestamp == NULL) { return NULL; }
		return gmdate("D, d M Y H:i:s T", strtotime($timestamp));
	}

	/**
	 * Get client ip-address
	 *
	 * @return string User ip-address
	 */
	function get_client_ip_address() {

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
	function url_parser($url) {
		
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
}