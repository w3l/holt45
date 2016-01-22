<?php
namespace w3l\Holt45;
trait Post {
	
	/**
	 * Check $_POST
	 *
	 * @example if(chk_post("s") == "a") instead of if(isset($_POST["s"]) && $_POST["s"] == "a")
	 *
	 * @param string $key Post-key.
	 * @return bool|string
	 */
	public static function chkPost($key) {
		if (!isset($_POST[$key])) {
			return false;
		}
		return $_POST[$key];
	}

	/**
	 * Assign value from $_POST
	 *
	 * @example $var = assign_from_post("a") instead of $var = ((!empty($_POST["s"])) ? $_POST["s"] : "");
	 *
	 * @param string $key Post-key.
	 * @return string
	 */
	public static function assignFromPost($key) {
		return ((!isset($_POST[$key])) ? "" : $_POST[$key]);
	}

	/**
	 * Check multiple $_POST-keys
	 *
	 * @example if(chk_post_all(array("a","b"))) instead of if(!empty($_POST["a"]) && !empty($_POST["b"]))
	 *
	 * @param array $keys Post-keys.
	 * @return bool
	 */
	public static function chkPostAll($keys) {
		$keysSet = true;

		foreach($keys AS $key) {
		
			if (empty($_POST[$key])) {
				$keysSet = false;
			}
		}
		return $keysSet;
	}
}
