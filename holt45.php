<?php
/**
 * holt45
 * A small library with some really basic functions...
 *
 * @link https://github.com/w3l/holt45
 * @copyright Unlicense
 * @version 0.3.0
 */

require_once dirname(__FILE__) . '/holt45/Get.php';
require_once dirname(__FILE__) . '/holt45/Post.php';
require_once dirname(__FILE__) . '/holt45/Session.php';
require_once dirname(__FILE__) . '/holt45/Time.php';
require_once dirname(__FILE__) . '/holt45/Misc.data.inc';
require_once dirname(__FILE__) . '/holt45/Misc.php';

class Holt45 {

	const DATA_URI_TRANSPARENT_GIF = 'data:image/gif;base64,R0lGODlhAQABAIAAAAAAAP///yH5BAEAAAAALAAAAAABAAEAAAIBRAA7';
	const DATA_URI_TRANSPARENT_PNG = 'data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAEAAAABCAQAAAC1HAwCAAAAC0lEQVQYV2NgYAAAAAMAAWgmWQ0AAAAASUVORK5CYII=';
	
	use \w3l\Holt45\Get;
	use \w3l\Holt45\Post;
	use \w3l\Holt45\Session;
	use \w3l\Holt45\Time;
	use \w3l\Holt45\Convert;
	use \w3l\Holt45\MiscData;
	use \w3l\Holt45\Misc;
}
