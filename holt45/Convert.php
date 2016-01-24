<?php
namespace w3l\Holt45;
trait Convert {

	/**
	 * Converts red-green-blue(RGB) to hexadecimal
	 *
	 * @param array $rgb RGB color
	 * @return string Hexadecimal color
	 */
	function rgbhex($rgb) {
		$hex = "";
		foreach($rgb AS $color) {
			$hex .= str_pad(dechex($color), 2, "0", STR_PAD_LEFT);
		}
		return $hex;
	}

}
