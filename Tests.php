<?php
/**
 * Tests.php
 * @ignore
 */
namespace w3l\Holt45\Tests;

require_once dirname(__FILE__) . '/holt45.php';

class Tests extends \Holt45
{
    public function allTests()
    {
        /* $_GET */
        if (self::chkGet("q")) {
            echo '$_GET["q"] is set';
        }

        echo self::assignFromGet("q"); // "" or $_GET["q"]

        if (self::chkGetAll("q", "search")) {
            echo '$_GET["q"] and $_GET["search"] is set';
        }

        /* $_POST */
        if (self::chkPost("q")) {
            echo '$_POST["q"] is set';
        }

        echo self::assignFromPost("q"); // "" or $_POST["q"]

        if (self::chkPostAll("q", "search")) {
            echo '$_POST["q"] and $_POST["search"] is set';
        }

        /* Sessions */
        self::sessionSet("example_session_name", "content of session", 86400);

        if (self::sessionIsset("example_session_name")) {
            echo 'Session example_session_name is set and not expired';
        }

        echo self::sessionRead("example_session_name"); // content of session

        self::sessionDelete("example_session_name"); // Deletes session

        /* Time */
        echo self::timestampToHttpDate("1980-01-01 17:15:00"); // Tue, 01 Jan 1980 16:15:00 GMT

        echo self::timeElapsed("1980-01-01 17:15:00"); // 13173 days

        /* Browser */
        echo self::getClientIpAddress(); // 127.0.0.1
        
        echo self::getClientOperatingSystem(); // linux
        
        echo self::getClientBrowser(); // Firefox
        
        if (self::isClientBrowserGoogleChrome()) {
            echo 'Looks like Google Chrome';
        }
        
        if ($results = self::getBrowserAccessKeyModifiers("1")) {
            $results[0]; // array([0] => "Alt", [1] => "Shift", [2] => "1");
        }
        
        /* Convert */
        echo self::rgbhex(255, 0, 0); // ff0000

        $arr = self::hexrgb("#FF0000"); // Array([0] => 255, [1] => 0, [2] => 0)
        print "R: $arr[0] G: $arr[1] B: $arr[2]";
        
        $arr = self::colorBlend(array(0, 0, 0), array(255, 255, 255)); // Array ( [0] => 128 [1] => 128 [2] => 128 )
        print "R: $arr[0] G: $arr[1] B: $arr[2]";
        
        /* Strings */
        try {
            echo self::encrypt("some text", "pazz11!!klb"); // vZp3TdnGAY6/NPgM9sz3qUW24nTbthX+mHdqG7BWCDJVnmqWcz6IMEAs9sqcaVD0Efv4iXSIulUmlrp+E6Z0/w==
        } catch (\w3l\Holt45\Holt45Exception $e) {
            echo 'Caught exception: ',  $e->getMessage();
        }

        echo self::decrypt("vZp3TdnGAY6/NPgM9sz3qUW24nTbthX+mHdqG7BWCDJVnmqWcz6IMEAs9sqcaVD0Efv4iXSIulUmlrp+E6Z0/w==", "pazz11!!klb"); // some text
        
        echo self::textareaEncode('<textarea id="tex1"></textarea> <p> asdasd </p>'); // [textarea id="tex1"][/textarea] <p> asdasd </p>

        echo self::textareaDecode('[textarea id="tex1"][/textarea] <p> asdasd </p>'); // <textarea id="tex1"></textarea> <p> asdasd </p>

        echo self::obfuscateString("Hi, I'm a ninja!"); // 49574671626d6c75494745676253644a4943787053413d3d

        echo self::deobfuscateString("49574671626d6c75494745676253644a4943787053413d3d"); // Hi, I'm a ninja!

        echo self::replaceString("Hi my name is [@foo] and i like [@bar]", array("foo" => "sven", "bar" => "beer")); // Hi my name is sven and i like beer

        echo self::rainbowText("Hallo world"); // <span style="color: #ff0000;">H</span><span style="color: #ff3300;">a</span>...
        
        echo self::kbdSymbol("enter"); // &#9166;

        echo self::kbdShortcut(array("Ctrl", "Alt", "Delete"), "auto"); // <kbd class="holt45-kbd"><span class="holt45-kbd__symbol">&#10034;</span>Ctrl</kbd> + <kbd class="holt45-kbd"><span class="holt45-kbd__symbol">&#9095;</span>Alt</kbd> + <kbd class="holt45-kbd"><span class="holt45-kbd__symbol">&#9003;</span>Delete</kbd>

        echo self::cssOneLineText("hallo world!", "h1", 80, 320);

        /* Math */
        $arr = self::generatePaginationRange(106, 15, 7); // Array([0] => 1, [1] => 13, [2] => 14, [3] => 15, [4] => 16, [5] => 17, [6] => 106)
        echo $arr[0];
        
        /* Misc */
        $arr = self::urlParser("htt://w.google..com/"); // Array([url] => http://www.google.com/, [url_display] => www.google.com)
        echo $arr["url"];
        echo $arr["url_display"];
        
        echo self::generatePassword(10); // 2k%=cbot:w

        echo self::generatePassword(10, "simple"); // m9b7gfkmhc

        echo self::iso3166ToName("SE"); // SWEDEN

        /* constants */
        echo self::DATA_URI_TRANSPARENT_GIF; // data:image/gif;base64,R0lGODlhAQABAIAAAAAAAP///yH5BAEAAAAALAAAAAABAAEAAAIBRAA7

        echo self::DATA_URI_TRANSPARENT_PNG; // data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAEAAAABCAQAAAC1HAwCAAAAC0lEQVQYV2NgYAAAAAMAAWgmWQ0AAAAASUVORK5CYII=
        
        /* global constants */
        echo date(DATE_DATETIME);
    }
}
