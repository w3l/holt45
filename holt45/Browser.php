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
        if (getenv('HTTP_USER_AGENT')) {
            $userAgent = getenv('HTTP_USER_AGENT');

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
     * Get client browser
     *
     * NOTICE: HTTP_USER_AGENT is easily spoofed. Don't trust this data.
     *
     * @return null|string User browser(Internet Explorer|Camino|Firefox|Safari|Chrome|Konqueror|Opera)
     */
    public static function getClientBrowser()
    {
        if (getenv('HTTP_USER_AGENT')) {
            
            $userAgent = getenv('HTTP_USER_AGENT');
            
            if ((
                preg_match('/MSIE/i', $userAgent) ||
                preg_match('/Trident/i', $userAgent)
                ) &&
                !preg_match('/Opera/i', $userAgent)) {
                return 'Internet Explorer';
            } elseif (preg_match('/Camino/i', $userAgent)) {
                return "Camino";
            } elseif (preg_match('/Firefox/i', $userAgent)) {
                return "Firefox";
            } elseif (preg_match('/Safari/i', $userAgent)) {
                return "Safari";
            } elseif (preg_match('/Chrome/i', $userAgent)) {
                return "Chrome";
            } elseif (preg_match('/Konqueror/i', $userAgent)) {
                return "Konqueror";
            } elseif (preg_match('/Opera/i', $userAgent)) {
                return "Opera";
            }
        }
        
        return null;
    }
}
