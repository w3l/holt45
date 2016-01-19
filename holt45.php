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