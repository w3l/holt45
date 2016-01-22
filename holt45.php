<?php
define('HOLT45_DIR', dirname(__FILE__) . '/holt45');

require_once HOLT45_DIR . '/Get.php';
require_once HOLT45_DIR . '/Post.php';
require_once HOLT45_DIR . '/Session.php';
require_once HOLT45_DIR . '/Time.php';
require_once HOLT45_DIR . '/Misc.php';

class holt45 {

	const DATA_URI_TRANSPARENT_GIF = 'data:image/gif;base64,R0lGODlhAQABAIAAAAAAAP///yH5BAEAAAAALAAAAAABAAEAAAIBRAA7';
	const DATA_URI_TRANSPARENT_PNG = 'data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAEAAAABCAQAAAC1HAwCAAAAC0lEQVQYV2NgYAAAAAMAAWgmWQ0AAAAASUVORK5CYII=';
	
	use \Holt45\Get;
	use \Holt45\Post;
	use \Holt45\Session;
	use \Holt45\Time;
	use \Holt45\Misc;
}