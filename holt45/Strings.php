<?php
/**
 * Strings.php
 */
namespace w3l\Holt45;

/**
 * Handle strings(convert, encode, replace, etc).
 */
trait Strings
{
    /**
     * Obfuscate string (url-safe and somewhat hard to guess).
     *
     * @param string $input The text that should be obfuscated
     * @return string Obfuscated string
     */
    public static function obfuscateString($input)
    {
        return bin2hex(base64_encode(strrev($input)));
    }

    /**
     * Deobfuscate string
     *
     * @param string $input Obfuscated string
     * @return string Deobfuscated string
     */
    public static function deobfuscateString($input)
    {
        return strrev(base64_decode(hex2bin($input)));
    }

    /**
     * Convert <textarea> to [textarea].
     *
     * @param string $html
     * @return string
     */
    public static function textareaEncode($html)
    {
        return preg_replace("/<textarea(.*?)>(.*?)<\/textarea>/is", "[textarea$1]$2[/textarea]", $html);
    }

    /**
     * Convert [textarea] to <textarea>.
     *
     * @param string $html
     * @return string
     */
    public static function textareaDecode($html)
    {
        return preg_replace("/\[textarea(.*?)\](.*?)\[\/textarea\]/is", "<textarea$1>$2</textarea>", $html);
    }

    /**
     * To replace "Hallo [@var] world" with $value.
     *
     * Example:
     * ```php
     * replace_string($string, array("val1" => "foo", "val2" => "bar"))
     * ```
     *
     * @param string $langString String containing placeholder.
     * @param array $dynamicContent key->value array.
     * @return string String with placeholder replaced.
     */
    public static function replaceString($langString, $dynamicContent = array())
    {
        foreach ($dynamicContent as $k => $v) {
            $langString = str_replace("[@".$k."]", $v, $langString);
        }
        return $langString;
    }

    /**
     * Creates rainbow-colored text.
     *
     * @uses Holt45::colorBlend()
     * @uses Holt45::rgbhex()
     *
     * @param string $text Text wanted coloured.
     * @return string String with span-tags with color.
     */
    public static function rainbowText($text)
    {
        $colorsBase = array(
        array(255, 0, 0),
        array(255, 102, 0),
        array(255, 238, 0),
        array(0, 255, 0),
        array(0, 153, 255),
        array(68, 0, 255),
        array(153, 0, 255)
        );

        $colorsBuild = array();

        $strlenText = strlen($text);

        if ($strlenText > 7) {
            while (count($colorsBuild) < $strlenText) {
                for ($i = 0, $size = count($colorsBase); $i < $size; $i++) {

                    $colorsBuild[] = $colorsBase[$i];

                    if (count($colorsBuild) >= $strlenText) {
                        continue 2;
                    }

                    if ($i < count($colorsBase)-1) {

                        $colorsBuild[] = self::colorBlend($colorsBase[$i], $colorsBase[$i+1]);

                        if (count($colorsBuild) >= $strlenText) {
                            continue 2;
                        }
                    }
                }
                $colorsBase = $colorsBuild;
                $colorsBuild = array();
            }
        } elseif ($strlenText <= 7) {
            $colorsBuild = $colorsBase;
        }

        $arrayText = str_split($text);
        $returnText = "";
        for ($i = 0, $size = count($arrayText); $i < $size; $i++) {
            $returnText .= '<span style="color: #'.self::rgbhex($colorsBuild[$i]).';">'.$arrayText[$i].'</span>';
        }
        return $returnText;
    }
}
