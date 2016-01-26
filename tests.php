<?php
namespace w3l\Holt45\Tests;

require_once dirname(__FILE__) . '/holt45/Holt45.php';

class tests {
    function __construct() {
/* $_GET */
if (holt45::chkGet("q")) { echo '$_GET["q"] is set'; }

echo holt45::assignFromGet("q"); // "" or $_GET["q"]

if (holt45::chkGetAll(array("q", "search"))) { echo '$_GET["q"] and $_GET["search"] is set'; }

/* $_POST */
if (holt45::chkPost("q")) { echo '$_POST["q"] is set'; }

echo holt45::assignFromPost("q"); // "" or $_POST["q"]

if (holt45::chkPostAll(array("q", "search"))) { echo '$_POST["q"] and $_POST["search"] is set'; }

/* Sessions */
holt45::sessionSet("example_session_name", "content of session", 86400);

if (holt45::sessionIsset("example_session_name")) { echo 'Session example_session_name is set and not expired'; }

echo holt45::sessionRead("example_session_name"); // content of session

holt45::sessionDelete("example_session_name"); // Deletes session

/* Time */
echo holt45::timestampToHttpDate("1980-01-01 17:15:00"); // Tue, 01 Jan 1980 16:15:00 GMT

echo holt45::timeElapsed("1980-01-01 17:15:00"); // 13173 days

/* Convert */
echo holt45::rgbhex(array(255, 0, 0)); // ff0000

print_r(holt45::hexrgb("#FF0000")); // Array([0] => 255, [1] => 0, [2] => 0)

/* Strings */
echo holt45::textareaEncode('<textarea id="tex1"></textarea> <p> asdasd </p>'); // [textarea id="tex1"][/textarea] <p> asdasd </p>

echo holt45::textareaDecode('[textarea id="tex1"][/textarea] <p> asdasd </p>'); // <textarea id="tex1"></textarea> <p> asdasd </p>

echo holt45::obfuscateString("Hi, I'm a ninja!"); // 49574671626d6c75494745676253644a4943787053413d3d

echo holt45::deobfuscateString("49574671626d6c75494745676253644a4943787053413d3d"); // Hi, I'm a ninja!

echo holt45::replaceString("Hi my name is [@foo] and i like [@bar]", array("foo" => "sven", "bar" => "beer")); // Hi my name is sven and i like beer

echo holt45::rainbowText("Hallo world"); // <span style="color: #ff0000;">H</span><span style="color: #ff3300;">a</span>...

/* Math */
print_r(holt45::generatePaginationRange(106, 15, 7)); // Array([0] => 1, [1] => 13, [2] => 14, [3] => 15, [4] => 16, [5] => 17, [6] => 106)

/* Misc */
echo holt45::getClientIpAddress(); // 127.0.0.1

print_r(holt45::urlParser("htt://w.google..com/")); // Array([url] => http://www.google.com/, [url_display] => www.google.com)

echo holt45::generatePassword(10); // 2k%=cbot:w

echo holt45::generatePassword(10, "simple"); // m9b7gfkmhc

echo holt45::iso3166ToName("SE"); // SWEDEN

/* constants */
echo holt45::DATA_URI_TRANSPARENT_GIF; // data:image/gif;base64,R0lGODlhAQABAIAAAAAAAP///yH5BAEAAAAALAAAAAABAAEAAAIBRAA7

echo holt45::DATA_URI_TRANSPARENT_PNG; // data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAEAAAABCAQAAAC1HAwCAAAAC0lEQVQYV2NgYAAAAAMAAWgmWQ0AAAAASUVORK5CYII=
    }
}