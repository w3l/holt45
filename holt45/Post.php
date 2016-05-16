<?php
/**
 * Post.php
 */
namespace w3l\Holt45;

/**
 * Check/assign from superglobal $_POST
 */
trait Post
{
    /**
     * Check $_POST
     *
     * Example:
     * ```php
     * if(chkPost("s") == "a") instead of if(isset($_POST["s"]) && $_POST["s"] == "a")
     * ```
     *
     * @param string $postKey Post-key.
     * @return bool|string
     */
    public static function chkPost($postKey)
    {
        return filter_input(INPUT_POST, $postKey);
    }

    /**
     * Assign value from $_POST
     *
     * Example:
     * ```php
     * $var = assignFromPost("a") instead of $var = ((!empty($_POST["s"])) ? $_POST["s"] : "");
     * ```
     *
     * @param string $postKey Post-key.
     * @return string
     */
    public static function assignFromPost($postKey)
    {
        return (string)filter_input(INPUT_POST, $postKey);
    }

    /**
     * Check if multiple $_POST-keys are not empty
     *
     * Example:
     * ```php
     * if(chkPostAll(array("a","b"))) instead of if(!empty($_POST["a"]) && !empty($_POST["b"]))
     * ```
     *
     * @param array $keys Post-keys.
     * @return bool
     */
    public static function chkPostAll(...$keys)
    {
        // If first value is array, then create array from first value
        if ((array)$keys[0] === $keys[0]) {
            $keys = $keys[0];
        }

        foreach ($keys as $key) {
            $val = filter_input(INPUT_POST, $key);
            if (empty($val)) {
                return false;
            }
        }
        return true;
    }
}
