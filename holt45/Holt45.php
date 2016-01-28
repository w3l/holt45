<?php
/**
 * Holt45.php
 */
 
/**
 * Main-class loading defining constants and loading traits.
 */
class Holt45
{
    /**
     * Data URI: 1x1 transparent GIF
     */
    const DATA_URI_TRANSPARENT_GIF = 'data:image/gif;base64,R0lGODlhAQABAIAAAAAAAP///yH5BAEAAAAALAAAAAABAAEAAAIBRAA7';
    
    /**
     * Data URI: 1x1 transparent PNG
     */
    const DATA_URI_TRANSPARENT_PNG = <<<EOD
data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAEAAAABCAQAAAC1HAwCAAAAC0lEQVQYV2NgYAAAAAMAAWgmWQ0AAAAASUVORK5CYII=
EOD;

    use \w3l\Holt45\Get;
    use \w3l\Holt45\Post;
    use \w3l\Holt45\Session;
    use \w3l\Holt45\Time;
    use \w3l\Holt45\Browser;
    use \w3l\Holt45\Convert;
    use \w3l\Holt45\Strings;
    use \w3l\Holt45\Math;
    use \w3l\Holt45\MiscData;
    use \w3l\Holt45\Misc;
}
