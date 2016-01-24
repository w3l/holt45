<?php
namespace w3l\Holt45;
trait Strings {

	/**
	 * Obfuscate string (url-safe and somewhat hard to guess).
	 *
	 * @param string $input The text that should be obfuscated
	 * @return string Obfuscated string
	 */
	public static function obfuscateString($input) {
		return bin2hex(base64_encode(strrev($input)));
	}

	/**
	 * Deobfuscate string
	 *
	 * @param string $input Obfuscated string
	 * @return string Deobfuscated string
	 */
	public static function deobfuscateString($input) {
		return strrev(base64_decode(hex2bin($input)));
	}
	
	/**
	 * Convert <textarea> to [textarea].
	 *
	 * @param string $html
	 * @return string
	 */
	public static function textareaEncode($html) {
		return preg_replace("/<textarea(.*?)>(.*?)<\/textarea>/is", "[textarea$1]$2[/textarea]", $html);
	}
	
	/**
	 * Convert [textarea] to <textarea>.
	 *
	 * @param string $html
	 * @return string
	 */
	public static function textareaDecode($html) {
		return preg_replace("/\[textarea(.*?)\](.*?)\[\/textarea\]/is", "<textarea$1>$2</textarea>", $html);
	}

	/**
	* To replace "Hallo [@var] world" with $value.
	*
	* @example replace_string($string, array("val1" => "foo", "val2" => "bar"))
	*
	* @param string $langString String containing placeholder.
	* @param array $dynamicContent key->value array.
	* @return string String with placeholder replaced.
	*/
	public static function replaceString($langString, $dynamicContent = array()) {

		foreach ($dynamicContent as $k => $v) {
			$langString = str_replace("[@".$k."]", $v, $langString);
		}
		return $langString;
	}

	/**
	* Creates rainbow-colored text.
	*
	* @param string $text Text wanted coloured.
	* @return string String with span-tags with color.
	*/
	function rainbowText($text) {
		$colors_base = array(
		array(255, 0, 0),
		array(255, 102, 0),
		array(255, 238, 0),
		array(0, 255, 0),
		array(0, 153, 255),
		array(68, 0, 255),
		array(153, 0, 255)
		);

		$colors_build = array();

		$strlenText = strlen($text);

		if($strlenText > 7) {
			while(count($colors_build) < $strlenText) {
				for($i = 0; $i < count($colors_base); $i++) {

					$colors_build[] = $colors_base[$i];
					if(count($colors_build) >= $strlenText) { continue 2; }
					
					if($i < count($colors_base)-1) {
						$colors_build[] = holt45::colorBlend($colors_base[$i], $colors_base[$i+1]);
						if(count($colors_build) >= $strlenText) { continue 2; }
					}
				}
				$colors_base = $colors_build;
				$colors_build = array();
			}
		} elseif($strlenText <= 7) {
			$colors_build = $colors_base;
		}

		$arrayText = str_split($text);
		$returnText = "";
		for($i = 0; $i < count($arrayText); $i++) {
			$returnText .= '<span style="color: #'.holt45::rgbhex($colors_build[$i]).';">'.$arrayText[$i].'</span>';
		}
		return $returnText;

	}

}
