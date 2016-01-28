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
    
    /**
     * Get the symbol from a list of keyboard-keys...
     *
     * @used-by Holt45::kbdShortcut()
     *
     * @param string $inputKey Text
     * @param string $inputOperatingSystem default|auto|win|mac|linux
     * @return null|string HTML Entity (decimal)
     */
    public static function kbdSymbol($inputKey, $inputOperatingSystem = "default")
    {
        $inputKey = mb_strtolower($inputKey);
        
        if ($inputOperatingSystem == "auto") {
            
            $inputOperatingSystem = "default";
            
            $getClientOperatingSystem = self::getClientOperatingSystem();
            
            if ($getClientOperatingSystem == "linux" ||
                $getClientOperatingSystem == "mac" ||
                $getClientOperatingSystem == "win") {
                   $inputOperatingSystem = $getClientOperatingSystem;
            }
        }
        
        $arrayConvert = array(
        "return" => "enter",
        "control" => "ctrl",
        "escape" => "esc",
        "caps lock" => "caps-lock",
        "page up" => "page-up",
        "page down" => "page-down",
        "arrow left" => "arrow-left",
        "left" => "arrow-left",
        "arrow up" => "arrow-up",
        "up" => "arrow-up",
        "arrow right" => "arrow-right",
        "right" => "arrow-right",
        "arrow down" => "arrow-down",
        "down" => "arrow-down"
        );
        
        /* Convert input */
        if (array_key_exists($inputKey, $arrayConvert)) {
            $inputKey = $arrayConvert[$inputKey];
        }

        $arrayKeySymbols = array(
        "shift" => array("default" => "&#8679;"),
        "opt" => array("default" => "&#8997;"),
        "enter" => array("default" => "&#9166;", "mac" => "&#8996;"),
        "alt" => array("default" => "&#9095;", "mac" => "&#8997;"),
        "delete" => array("default" => "&#9003;"),
        "ctrl" => array("default" => "&#10034;", "win" => "&#10034;", "linux" => "&#9096;", "mac" => "&#00094;"),
        "esc" => array("default" => "&#9099;"),
        "command" => array("default" => "&#8984;"),
        "tab" => array("default" => "&#8633;", "mac" => "&#8677;"),
        "caps-lock" => array("default" => "&#65;", "mac" => "&#8682;"),
        "page-up" => array("default" => "&#9650;", "mac" => "&#8670;"),
        "page-down" => array("default" => "&#9660;", "mac" => "&#8671;"),
        "arrow-left" => array("default" => "&#8592;"),
        "arrow-up" => array("default" => "&#8593;"),
        "arrow-right" => array("default" => "&#8594;"),
        "arrow-down" => array("default" => "&#8595;"),
        // Sun
        "compose" => array("default" => "&#9092;"),
        "meta" => array("default" => "&#9670")
        );
        
        if (array_key_exists($inputKey, $arrayKeySymbols)) {
            
            return ((array_key_exists($inputOperatingSystem, $arrayKeySymbols[$inputKey])) ?
                                      $arrayKeySymbols[$inputKey][$inputOperatingSystem] :
                                      $arrayKeySymbols[$inputKey]["default"]);
        }
        
        return null;
    }

    /**
     * Show fancy buttons for keyboard-shortcuts.
     *
     * @uses Holt45::kbdSymbol()
     *
     * @param array $inputArrayKeys
     * @param string $inputOperatingSystem
     * @param string $inputKbdClass
     * @param string $inputKbdSymbolClass
     * @param string $inputJoinHtml Glue
     * @return string String of html
     */
    public static function kbdShortcut($inputArrayKeys,
                                       $inputOperatingSystem = "default",
                                       $inputKbdClass = "holt45-kbd",
                                       $inputKbdSymbolClass = "holt45-kbd__symbol",
                                       $inputJoinGlue = " + ")
    {
        $returnArray = array();

        foreach ($inputArrayKeys as $key) {
            
            $kbdSymbol = self::kbdSymbol($key, $inputOperatingSystem);
            
            $kbdSymbolHtml = "";
            
            if ($kbdSymbol !== null) {
                $kbdSymbolHtml = '<span class="'.$inputKbdSymbolClass.'">'.$kbdSymbol.'</span>';
            }
            
            $returnArray[] = '<kbd class="'.$inputKbdClass.'">'.$kbdSymbolHtml.$key.'</kbd>';
            
        }

        return implode($inputJoinGlue, $returnArray);
    }
}
