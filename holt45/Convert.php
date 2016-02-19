<?php
/**
 * Convert.php
 */
namespace w3l\Holt45;

/**
 * Convert and manipulate values.
 */
trait Convert
{
    /**
     * Converts red-green-blue(RGB) to hexadecimal
     *
     * @param array $rgb RGB color
     * @return string Hexadecimal color
     */
    public static function rgbhex(...$rgb)
    {
        // If first value is array, then create array from first value
        if ((array)$rgb[0] === $rgb[0]) {
            $rgb = $rgb[0];
        }
        
        $hex = "";
        foreach ($rgb as $color) {
            $hex .= str_pad(dechex($color), 2, "0", STR_PAD_LEFT);
        }
        return $hex;
    }

    /**
     * Converts hexadecimal to red-green-blue(RGB)
     *
     * @used-by Holt45::rainbowText();
     *
     * @param string $hex Hexadecimal color
     * @return null|int[] RGB color
     */
    public static function hexrgb($hex)
    {
        $hex = preg_replace("/[^0-9A-Fa-f]/", '', $hex);

        $strlenHex = strlen($hex);

        if ($strlenHex >= 3) {
            if ($strlenHex >= 6) {
                if ($strlenHex > 6) {
                    $hex = substr($hex, 0, 6);
                }
                $hexArray = str_split($hex, 2);
            } elseif ($strlenHex < 6) {
                $hexArray = array("$hex[0]$hex[0]", "$hex[1]$hex[1]", "$hex[2]$hex[2]");
            }
            if (isset($hexArray)) {
                return array(hexdec($hexArray[0]), hexdec($hexArray[1]), hexdec($hexArray[2]));
            }
        }

        return null;
    }

    /**
     * Converts hexadecimal to red-green-blue(RGB)
     *
     * @used-by Holt45::rainbowText();
     *
     * @param array $arrayRGB RGB color
     * @param array $arrayRGB2 RGB color
     * @return int[] Blended RGB color
     */
    public static function colorBlend($arrayRGB, $arrayRGB2)
    {
        $arrayBlend = array();

        for ($i = 0, $size = count($arrayRGB); $i < $size; $i++) {
            $arrayBlend[] = round(($arrayRGB[$i]+$arrayRGB2[$i])/2);
        }

        return $arrayBlend;
    }
}
