<?php
namespace w3l\Holt45;
trait Convert {

	/**
	 * Converts red-green-blue(RGB) to hexadecimal
	 *
	 * @param array $rgb RGB color
	 * @return string Hexadecimal color
	 */
	public static function rgbhex($rgb) {
		$hex = "";
		foreach($rgb AS $color) {
			$hex .= str_pad(dechex($color), 2, "0", STR_PAD_LEFT);
		}
		return $hex;
	}

	/**
	 * Converts hexadecimal to red-green-blue(RGB)
	 *
	 * @param string $hex Hexadecimal color
	 * @return array RGB color
	 */
	function hexrgb($hex) {
		$hex = preg_replace("/[^0-9A-Fa-f]/", '', $hex);

		$strlenHex = strlen($hex);

		if($strlenHex >= 3) {
			if($strlenHex >= 6) {
				if($strlenHex > 6) {
					$hex = substr($hex,0,6);
				}
				$hexArray = str_split($hex,2);
			} elseif($strlenHex < 6) {
				$hexArray = array("$hex[0]$hex[0]", "$hex[1]$hex[1]", "$hex[2]$hex[2]");
			}
			return array(hexdec($hexArray[0]), hexdec($hexArray[1]), hexdec($hexArray[2]));
		}

		return NULL;
	}
	/**
	 * Converts hexadecimal to red-green-blue(RGB)
	 *
	 * @param array $arrayRGB RGB color
	 * @param array $arrayRGB2 RGB color
	 * @return array Blended RGB color
	 */
	function colorBlend($arrayRGB,$arrayRGB2) {

		$arrayBlend = array();

		for($i = 0; $i < count($arrayRGB); $i++) {
			$arrayBlend[] = round(($arrayRGB[$i]+$arrayRGB2[$i])/2);
		}

		return $arrayBlend;
	}

}
