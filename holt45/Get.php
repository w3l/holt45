<?php
namespace Holt45;
trait Get {
	
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
}