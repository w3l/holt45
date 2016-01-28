# holt45 - A library with a mix of functions...

[![License](https://poser.pugx.org/w3l/holt45/license)](https://packagist.org/packages/w3l/holt45)
[![Build Status](https://img.shields.io/travis/w3l/holt45.svg)](https://travis-ci.org/w3l/holt45)
[![Latest Version](https://img.shields.io/packagist/v/w3l/holt45.svg)](https://packagist.org/packages/w3l/holt45)
[![Dependency Status](https://img.shields.io/versioneye/d/w3l/holt45.svg)](https://www.versioneye.com/user/projects/569e23172025a6002e00014e)
[![Badges](https://img.shields.io/badge/badges-shields.io-ff69b4.svg)](http://shields.io/)

[![Scrutinizer Code Quality](https://img.shields.io/scrutinizer/g/w3l/holt45.svg)](https://scrutinizer-ci.com/g/w3l/holt45/?branch=master)
[![SensioLabs Insight](https://img.shields.io/sensiolabs/i/43b42ce6-800c-42c8-8562-06ed841d8272.svg?label=SensioLabs)](https://insight.sensiolabs.com/projects/43b42ce6-800c-42c8-8562-06ed841d8272)
[![Code Climate](https://img.shields.io/codeclimate/github/w3l/holt45.svg)](https://codeclimate.com/github/w3l/holt45)
[![Codacy Badge](https://img.shields.io/codacy/a3955affc5dc4e57b48ae2a6a8eb5b2f.svg?label=codacy)](https://www.codacy.com/app/support_7/holt45)


## Class Features
 - @todo: Write something awesome here.
 

## Installation

### Composer
```sh
composer require w3l/holt45
```

Holt45 at [packagist](https://packagist.org/packages/w3l/holt45)

### Manually
```php
include_once("folder/holt45.php");
```

### Usage
```php
holt45::getClientIpAddress()
```

## Documentation

Generated API documentation is found [here](http://holt45.pw/docs)

* $_GET
  * chkGet()
  * assignFromGet()
  * chkGetAll()
* $_POST
  * chkPost()
  * assignFromPost()
  * chkPostAll()
* Sessions
  * sessionSet()
  * sessionIsset()
  * sessionRead()
  * sessionDelete()
* Time
  * timestampToHttpDate()
  * timeElapsed()
* Browser
  * getClientIpAddress()
  * getClientOperatingSystem()
  * getClientBrowser()
* Convert
  * rgbhex()
  * hexrgb()
* Strings
  * textareaEncode()
  * textareaDecode()
  * obfuscateString()
  * deobfuscateString()
  * replaceString()
  * rainbowText()
  * kbdSymbol()
  * kbdShortcut()
* Math
  * generatePaginationRange()
* Misc
  * getClientIpAddress()
  * urlParser()
  * generatePassword()
  * iso3166ToName()
* constants
  * DATA_URI_TRANSPARENT_GIF
  * DATA_URI_TRANSPARENT_PNG

### Example code:
```php
<?php
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

/* Browser */
echo holt45::getClientIpAddress(); // 127.0.0.1

echo holt45::getClientOperatingSystem(); // linux

echo holt45::getClientBrowser(); // Firefox
        
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

echo holt45::kbdSymbol("enter"); // &#9166;

echo holt45::kbdShortcut(array("Ctrl", "Alt", "Delete"), "auto"); // <kbd class="holt45-kbd"><span class="holt45-kbd__symbol">&#10034;</span>Ctrl</kbd> + <kbd class="holt45-kbd"><span class="holt45-kbd__symbol">&#9095;</span>Alt</kbd> + <kbd class="holt45-kbd"><span class="holt45-kbd__symbol">&#9003;</span>Delete</kbd>

/* Math */
print_r(holt45::generatePaginationRange(106, 15, 7)); // Array([0] => 1, [1] => 13, [2] => 14, [3] => 15, [4] => 16, [5] => 17, [6] => 106)

/* Misc */
print_r(holt45::urlParser("htt://w.google..com/")); // Array([url] => http://www.google.com/, [url_display] => www.google.com)

echo holt45::generatePassword(10); // 2k%=cbot:w

echo holt45::generatePassword(10, "simple"); // m9b7gfkmhc

echo holt45::iso3166ToName("SE"); // SWEDEN

/* constants */
echo holt45::DATA_URI_TRANSPARENT_GIF; // data:image/gif;base64,R0lGODlhAQABAIAAAAAAAP///yH5BAEAAAAALAAAAAABAAEAAAIBRAA7

echo holt45::DATA_URI_TRANSPARENT_PNG; // data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAEAAAABCAQAAAC1HAwCAAAAC0lEQVQYV2NgYAAAAAMAAWgmWQ0AAAAASUVORK5CYII=

```

## License

Holt45 is [unlicense](http://unlicense.org/) licensed. **TL;DR?** Do what you want with the code.

