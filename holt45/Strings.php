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

}
