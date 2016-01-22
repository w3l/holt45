<?php
namespace w3l\Holt45;
trait Session {

	/**
	 * Handle sessions - set session
	 *
	 * @param string $name Session name
	 * @param string $content Session content
	 * @param int $expires How many seconds before the session should expire.
	 */
	public static function sessionSet($name, $content, $expires = 86400) {
		$_SESSION[$name] = (time() + $expires).'-'.$content;
	}

	/**
	 * Handle sessions - check if session is set and not expired.
	 *
	 * @param string $name Session name
	 * @return bool Session status
	 */
	public static function sessionIsset($name) {
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
	public static function sessionRead($name) {
		return substr(strstr($_SESSION[$name], '-'),1);
	}

	/**
	 * Handle sessions - Delete session
	 *
	 * @param string $name Session name
	 * @return void
	 */
	public static function sessionDelete($name) {
		unset($_SESSION[$name]);
	}

}