<?
function chk_get($key) {
    if (!isset($_GET[$key])) {
        return false;
    }
    return $_GET[$key];
}

function chk_post($key) {
    if (!isset($_POST[$key])) {
        return false;
    }
    return $_POST[$key];
}

function chk_get_all($keys) {
	$s = true;

	foreach($keys AS $key) {
	
		if (empty($_GET[$key])) {
			$s = false;
		}
	}
	return $s;
}

function chk_post_all($keys) {
	$s = true;

	foreach($keys AS $key) {
	
		if (empty($_POST[$key])) {
			$s = false;
		}
	}
	return $s;
}