<?php
/**
 * Time.php
 */
namespace w3l\Holt45;

/**
 * Convert/display time
 */
trait Time
{
    /**
     * Convert timestamp to HTTP-date (RFC2616)
     *
     * For use in "Last-Modified" headers.
     *
     * @param string $timestamp
     * @return string|null
     */
    public static function timestampToHttpDate($timestamp)
    {
        if ($timestamp === null) {
            return null;
        }
        return gmdate("D, d M Y H:i:s T", strtotime($timestamp));
    }

    /**
     * Convert timestamp to x unit(plural), like "6 minutes" or "1 day".
     *
     * @param string $timestamp
     * @param string $lang Language
     * @return string Formated time: "x unit(s)" or empty string
     */
    public static function timeElapsed($timestamp, $lang = "en")
    {
        $arrayLanguages = array(
        "sv" => array("s" => ["sekund", "sekunder"], "m" => ["minut", "minuter"], "h" => ["timme", "timmar"], "d" => ["dag", "dagar"]),
        "en" => array("s" => ["second", "seconds"], "m" => ["minute", "minutes"], "h" => ["hour", "hours"], "d" => ["day", "days"])
        );
        
        $seconds = max((time() - strtotime($timestamp)), 0);

        if ($seconds < 60) {
            $number = $seconds;
            $key = "s";
        } elseif ($seconds < (60 * 60)) {
            $number = $seconds / 60;
            $key = "m";
        } elseif ($seconds < (60 * 60 * 24)) {
            $number = $seconds / (60 * 60);
            $key = "h";
        } else {
            $number = $seconds / (60 * 60 * 24);
            $key = "d";
        }

        $number = floor($number);

        $text = $arrayLanguages[$lang][$key][(($number > 1) ? 1 : 0)];

        return "$number $text";
    }
}
