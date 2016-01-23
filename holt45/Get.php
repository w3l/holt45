<?php
namespace w3l\Holt45;
trait Get {
	
	/**
	 * Check $_GET
	 *
	 * @example if(chkGet("s") == "a") instead of if(isset($_GET["s"]) && $_GET["s"] == "a")
	 *
	 * @param string $key Get-key.
	 * @return bool|string
	 */
	public static function chkGet($key) {
		return filter_input(INPUT_GET, $key);
	}
	
	/**
	 * Assign value from $_GET
	 *
	 * @example $var = assignFromGet("a") instead of $var = ((!empty($_GET["s"])) ? $_GET["s"] : "");
	 *
	 * @param string $key Get-key.
	 * @return string
	 */
	public static function assignFromGet($key) {
		return (string)filter_input(INPUT_GET, $key);
	}
	
	/**
	 * Check multiple $_GET-keys
	 *
	 * @example if(chkGetAll(array("a","b"))) instead of if(!empty($_GET["a"]) && !empty($_GET["b"]))
	 *
	 * @param array $keys Get-keys.
	 * @return bool
	 */
	public static function chkGetAll($keys) {
		$keys_set = true;

		foreach($keys AS $key) {
			
			$val = filter_input(INPUT_GET, $key);
			if (empty($val)) {
				$keys_set = false;
			}
		}
		return $keys_set;
	}
}
