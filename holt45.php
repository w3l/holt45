<?
/**
 * Check $_GET
 *
 * @example if(chk_get("s") == "a") instead of if(isset($_GET["s"]) && $_GET["s"] == "a")
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