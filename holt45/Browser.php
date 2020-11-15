<?php
/**
 * Browser.php
 */
namespace w3l\Holt45;

/**
 * Get data from the browser/user.
 */
trait Browser
{
    /**
     * Get client ip-address
     *
     * @return null|string User ip-address
     */
    public static function getClientIpAddress($fallbackReturn = null)
    {
        if (getenv('HTTP_CLIENT_IP')) {
            return getenv('HTTP_CLIENT_IP');
        } elseif (getenv('HTTP_X_FORWARDED_FOR')) {
            return getenv('HTTP_X_FORWARDED_FOR');
        } elseif (getenv('HTTP_X_FORWARDED')) {
            return getenv('HTTP_X_FORWARDED');
        } elseif (getenv('HTTP_FORWARDED_FOR')) {
            return getenv('HTTP_FORWARDED_FOR');
        } elseif (getenv('HTTP_FORWARDED')) {
            return getenv('HTTP_FORWARDED');
        } elseif (getenv('REMOTE_ADDR')) {
            return getenv('REMOTE_ADDR');
        }
        /* Unknown IP */
        return $fallbackReturn;
    }

    /**
     * Get client operating system
     *
     * NOTICE: HTTP_USER_AGENT is easily spoofed. Don't trust this data.
     *
     * @used-by: Holt45::kbdSymbol()
     *
     * @return null|string User operating system(win|mac|linux)
     */
    public static function getClientOperatingSystem()
    {
        if ($userAgent = getenv('HTTP_USER_AGENT')) {

            if (preg_match('/linux/i', $userAgent)) {
                return 'linux';
            } elseif (preg_match('/macintosh|mac os x/i', $userAgent)) {
                return'mac';
            } elseif (preg_match('/windows|win32/i', $userAgent)) {
                return 'windows';
            }
        }
        
        return null;
    }

    /**
     * Convert UA to browser name
     *
     * @param Useragent-string
     * return null|string Browser name
     */
    public static function getBrowserNameFromUA($userAgent)
    {
        if (preg_match('/(MSIE|Trident)/i', $userAgent)) {
            return 'msie';
        } elseif (preg_match('/^((?!Mozilla).*?)\//i', $userAgent, $match)) {
            return mb_strtolower($match[1]);
        } elseif (preg_match('/(Chrome)/i', $userAgent) &&
                  preg_match('/(Safari)/i', $userAgent)) {
            return 'chrome';
        } elseif (preg_match('/([^\s]+)$/i', $userAgent, $match)) {
            return mb_strtolower(current(explode("/", $match[1])));
        }
        
        return null;
    }
    
    /**
     * Get client browser
     *
     * NOTICE: HTTP_USER_AGENT is easily spoofed. Don't trust this data.
     *
     * @return null|string User browser
     */
    public static function getClientBrowser()
    {
        if ($userAgent = getenv('HTTP_USER_AGENT')) {
            return self::getBrowserNameFromUA($userAgent);            
        }
        return null;
    }

    /**
     * Check if browser is Google Chrome and not one of the browsers derived from Google Chrome.
     *
     * NOTICE: HTTP_USER_AGENT is easily spoofed. Don't trust this data.
     *
     * @return bool
     */
    public static function isClientBrowserGoogleChrome()
    {
        if ($userAgent = getenv('HTTP_USER_AGENT')) {
            
            if (preg_match('/(Chrome|CriOS)\//i', $userAgent) &&
                !preg_match('/(Aviator|brave|ChromePlus|coc_|Dragon|Edge|Flock|Iron|Kinza|Maxthon|MxNitro|Nichrome|OPR|Perk|Rockmelt|Seznam|Sleipnir|Spark|UBrowser|Vivaldi|WebExplorer|YaBrowser)/i', $userAgent)) {
                return true;
            }
        }
        return false;
    }
    
    /**
     * Get access key modifiers
     *
     * NOTICE: HTTP_USER_AGENT is easily spoofed. Don't trust this data.
     *
     * @link https://en.wikipedia.org/wiki/Access_key Source
     *
     * @used-by: Holt45::kbdSymbol()
     *
     * @param string|null $accessKey
     * @param string $getClientBrowser
     * @param string $getClientOS
     * @return array|null
     */
    public static function getBrowserAccessKeyModifiers(
        $accessKey = null,
        $getClientBrowser = "auto",
        $getClientOS = "auto"
    ) {
        if ($getClientBrowser == "auto") {
            $getClientBrowser = self::getClientBrowser();
        }
        
        if ($getClientOS == "auto") {
            $getClientOS = self::getClientOperatingSystem();
        }
        
        $accessKeyModifiers = array(
            "windows" => array(
                "firefox" => array("Alt", "Shift"),
                "palemoon" => array("Alt", "Shift"),
                "chrome" => array("Alt"),
                "msie" => array("Alt")
            ),
            "mac" => array(
                "safari" => array("Ctrl", "Opt"),
                "chrome" => array("Ctrl", "Opt"),
                "firefox" => array("Ctrl", "Opt"),
                "camino" => array("Ctrl")
            ),
            "linux" => array(
                "konqueror" => array("Ctrl"),
                "firefox" => array("Alt", "Shift"),
                "chrome" => array("Alt")
            )
        );
        
        if ($keys = $accessKeyModifiers[$getClientOS][$getClientBrowser]) {
            return array_merge($keys, (array)$accessKey);
        }
        return null;
    }
}
