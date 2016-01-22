<?php
namespace w3l\Holt45;
trait Get {
	
	/**
	 * Check $_GET
	 *
	 * @example if(chk_get("s") == "a") instead of if(isset($_GET["s"]) && $_GET["s"] == "a")
	 *
	 * @param string $key Get-key.
	 * @return bool|string
	 */
	public static function chkGet($key) {
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
	 * @param string $key Get-key.
	 * @return string
	 */
	public static function assignFromGet($key) {
		return ((!isset($_GET[$key])) ? "" : $_GET[$key]);
	}
	
	/**
	 * Check multiple $_GET-keys
	 *
	 * @example if(chk_get_all(array("a","b"))) instead of if(!empty($_GET["a"]) && !empty($_GET["b"]))
	 *
	 * @param array $keys Get-keys.
	 * @return bool
	 */
	public static function chkGetAll($keys) {
		$keys_set = true;

		foreach($keys AS $key) {
		
			if (empty($_GET[$key])) {
				$keys_set = false;
			}
		}
		return $keys_set;
	}
}