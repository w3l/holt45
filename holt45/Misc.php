<?php
namespace w3l\Holt45;

trait Misc {

    /**
     * Convert ISO 3166-1 alpha-2 code to (English) country name.
     *
     * @link https://gist.github.com/IngmarBoddington/5909709 Source
     *
     * @param string $key ISO 3166-1 alpha-2 code
     * @return string Country name OR $key if no match.
     */
    public static function iso3166ToName($key)
    {
        $countries = self::getCountriesList();

        return ((array_key_exists($key, $countries)) ? $countries[$key] : $key);
    }

    /**
     * Get client ip-address
     *
     * @return string User ip-address
     */
    public static function getClientIpAddress()
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
        return '127.0.0.1'; // Unknown IP
    }

    /**
     * Tries to auto-correct parse_url()-output.
     *
     * @param string $url
     * @return string[]|false
     */
    private static function autoCorrectParseUrl($url)
    {
        // multiple /// messes up parse_url, replace 3 or more with 2
        $url = preg_replace('/(\/{2,})/', '//', $url);

        $parseUrl = parse_url($url);

        if (empty($parseUrl["scheme"])) {
            $parseUrl["scheme"] = "http";
        }
        if (empty($parseUrl["host"]) && !empty($parseUrl["path"])) {
            // Strip slash from the beginning of path
            $parseUrl["host"] = ltrim($parseUrl["path"], '\/');
            $parseUrl["path"] = "";
        }
        return $parseUrl;
    }

    /**
     * parse url, try to correct errors and return valid url + display-url.
     *
     * @example http:/wwww.example.com/lorum.html => http://www.example.com/lorum.html
     * @example gopher:/ww.example.com => gopher://www.example.com
     * @example http:/www3.example.com/?q=asd&f=#asd =>http://www3.example.com/?q=asd&f=#asd
     * @example asd://.example.com/folder/folder/ =>http://example.com/folder/folder/
     * @example .example.com/ => http://example.com/
     * @example example.com =>http://example.com
     * @example subdomain.example.com => http://subdomain.example.com
     *
     * @param string $url Any somewhat valid url.
     * @return string[] "url" contains an auto-corrected url. "url_display" host.tld or subdomain.host.tld
     */
    public static function urlParser($url)
    {

        $parseUrl = self::autoCorrectParseUrl($url);

        // malformed URL, parse_url() returns false. Returns urls "as is".
        if ($parseUrl === false) {
            return array("url" => $url, "url_display" => $url);
        }

        $urlArray = array("url" => "", "url_display" => "");

        // Check if scheme is correct
        if (!in_array($parseUrl["scheme"], array("http", "https", "gopher"))) {
            $urlArray["url"] .= 'http'.'://';
        } else {
            $urlArray["url"] .= $parseUrl["scheme"].'://';
        }

        // Check if the right amount of "www" is set.
        $explodeHost = explode(".", $parseUrl["host"]);

        // Remove empty entries
        $explodeHost = array_filter($explodeHost);
        // And reassign indexes
        $explodeHost = array_values($explodeHost);

        // Contains subdomain
        if (count($explodeHost) > 2) {
            // Check if subdomain only contains the letter w(then not any other subdomain).
            if (substr_count($explodeHost[0], 'w') == strlen($explodeHost[0])) {
                // Replace with "www" to avoid "ww" or "wwww", etc.
                $explodeHost[0] = "www";

            }
        }

        $urlArray["url"] .= implode(".", $explodeHost);
        $urlArray["url_display"] = trim(implode(".", $explodeHost), '\/'); // Removes trailing slash

        if (!empty($parseUrl["port"])) {
            $urlArray["url"] .= ":".$parseUrl["port"];
        }
        if (!empty($parseUrl["path"])) {
            $urlArray["url"] .= $parseUrl["path"];
        }
        if (!empty($parseUrl["query"])) {
            $urlArray["url"] .= '?'.$parseUrl["query"];
        }
        if (!empty($parseUrl["fragment"])) {
            $urlArray["url"] .= '#'.$parseUrl["fragment"];
        }

        return $urlArray;
    }

    /**
    * Generate a password-suggestion.
    *
    * @param int $length Length of password
    * @param string $passwordType "simple" limit character-set to first 33 characters. "long" uses 64 characters.
    * @return string
    */
    public static function generatePassword($length = 8, $passwordType = "long")
    {
        $characterSet = "23456789abcdefghijkmnopqrstuvwxyzABCDEFGHJKLMNPRSTUVWXYZ!#%+:=?@";
        $characterSetLenght = (($passwordType == "simple") ? 33 : 64);

        $counter = 0;
        $suggestedPassword = "";

        while ($counter < 10) {

            $suggestedPassword = "";

            for ($i = 0; $i < $length; $i++) {
                $suggestedPassword .= $characterSet[rand(0, ($characterSetLenght-1))];
            }

            if (strlen(count_chars($suggestedPassword, 3)) > ($length-2)) {
                break;
            }

            $counter++;
        }

        return $suggestedPassword;
    }

}
