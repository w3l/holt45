<?php
/**
 * holt45 - a library with a mix of functions...
 *
 * @link https://github.com/w3l/holt45 Code
 * @link http://holt45.pw/ Documentation
 * @copyright Unlicense
 * @version 0.4.5
 */

require_once dirname(__FILE__) . '/holt45/Get.php';
require_once dirname(__FILE__) . '/holt45/Post.php';
require_once dirname(__FILE__) . '/holt45/Session.php';
require_once dirname(__FILE__) . '/holt45/Time.php';
require_once dirname(__FILE__) . '/holt45/Convert.php';
require_once dirname(__FILE__) . '/holt45/Strings.php';
require_once dirname(__FILE__) . '/holt45/Math.php';
require_once dirname(__FILE__) . '/holt45/Misc.data.inc';
require_once dirname(__FILE__) . '/holt45/Misc.php';

/**
 * Main-class loading defining constants and loading traits.
 */
class Holt45 {

    /**
     * Data URI: 1x1 transparent gif 
     */
    const DATA_URI_TRANSPARENT_GIF = 'data:image/gif;base64,R0lGODlhAQABAIAAAAAAAP///yH5BAEAAAAALAAAAAABAAEAAAIBRAA7';
    
    /**
     * Data URI: 1x1 transparent png 
     */
    const DATA_URI_TRANSPARENT_PNG = <<<EOD
data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAEAAAABCAQAAAC1HAwCAAAAC0lEQVQYV2NgYAAAAAMAAWgmWQ0AAAAASUVORK5CYII=
EOD;

    use \w3l\Holt45\Get;
    use \w3l\Holt45\Post;
    use \w3l\Holt45\Session;
    use \w3l\Holt45\Time;
    use \w3l\Holt45\Convert;
    use \w3l\Holt45\Strings;
    use \w3l\Holt45\Math;
    use \w3l\Holt45\MiscData;
    use \w3l\Holt45\Misc;
}
