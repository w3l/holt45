<?php
namespace w3l\Holt45;
trait Time {
	
	/**
	 * Convert timestamp to HTTP-date (RFC2616)
	 *
	 * For use in "Last-Modified" headers.
	 *
	 * @param string $timestamp
	 * @return string
	 */
	public static function timestampToHttpDate($timestamp) {
		if($timestamp == NULL) { return NULL; }
		return gmdate("D, d M Y H:i:s T", strtotime($timestamp));
	}
	
	/**
	 * Convert timestamp to x unit(plural), like "6 minutes" or "1 day".
	 *
	 * @param string $timestamp
	 * @param int $limit Limit in seconds when to return nothing
	 * @return string Formated time: "x unit(s)" or empty string
	 */
	public static function timeElapsed($timestamp) {
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
