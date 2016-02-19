<?php
/**
 * Get.php
 */
namespace w3l\Holt45;

/**
 * Check/assign from superglobal $_GET
 */
trait Get
{
    /**
     * Check $_GET
     *
     * Example:
     * ```php
     * if(chkGet("s") == "a") instead of if(isset($_GET["s"]) && $_GET["s"] == "a")
     * ```
     *
     * @param string $key Get-key.
     * @return bool|string
     */
    public static function chkGet($key)
    {
        return filter_input(INPUT_GET, $key);
    }

    /**
     * Assign value from $_GET
     *
     * Example:
     * ```php
     * $var = assignFromGet("a") instead of $var = ((!empty($_GET["s"])) ? $_GET["s"] : "");
     * ```
     *
     * @param string $key Get-key.
     * @return string
     */
    public static function assignFromGet($key)
    {
        return (string)filter_input(INPUT_GET, $key);
    }

    /**
     * Check if multiple $_GET-keys are not empty
     *
     * Example:
     * ```php
     * if(chkGetAll(array("a","b"))) instead of if(!empty($_GET["a"]) && !empty($_GET["b"]))
     * ```
     *
     * @param array $keys Get-keys.
     * @return bool
     */
    public static function chkGetAll(...$keys)
    {
        // If first value is array, then create array from first value
        if ((array)$keys[0] === $keys[0]) {
            $keys = $keys[0];
        }

        foreach ($keys as $key) {

            $val = filter_input(INPUT_GET, $key);
            if (empty($val)) {
                return false;
            }
        }
        return true;
    }
}
