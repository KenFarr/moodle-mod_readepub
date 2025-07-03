<?php
require_once(__DIR__ . '/../../../config.php');

// New: Check course enrolment using cmid
$cmid = required_param('cmid', PARAM_INT);
$cm = get_coursemodule_from_id('readepub', $cmid, 0, false, MUST_EXIST);
require_login($cm->course, true, $cm); // This ensures user is logged in and enrolled

// Decide which preset to send
$is_mobile = preg_match('/Mobi|Android|iPhone|iPad/i', $_SERVER['HTTP_USER_AGENT']);
$preset    = $is_mobile ? 'mobile.js' : 'desktop.js';
?>
<!DOCTYPE html>
<html id="bibi">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />

    <title>This E-Book is Published with Bibi | EPUB Reader on your website.</title>

    <!-- Bibi Styles -->
    <link id="bibi-style" rel="stylesheet" href="resources/styles/bibi.css" />
    <link id="bibi-dress" rel="stylesheet" href="wardrobe/everyday/bibi.dress.css" />

    <!-- 1??  Load the core first (unchanged order) -->
    <script id="bibi-script" src="resources/scripts/bibi.js"></script>

    <!-- 2??  Then load the device-specific preset -->
    <script id="bibi-preset"
            src="presets/<?php echo $preset; ?>"
            data-bibi-bookshelf="">
    </script>
</head>

<body data-bibi-book="">

    <div id="bibi-info">
        <h1>This E-Book is Published on the Web with Bibi | EPUB Reader on your website.</h1>
        <ul>
            <li><a href="https://bibi.epub.link">Bibi | EPUB Reader (Official Site)</a></li>
            <li><a href="https://github.com/satorumurmur/bibi">Bibi on GitHub</a></li>
        </ul>
    </div>

    <div id="bibi-book-data"
         data-bibi-book-mimetype="application/epub+zip"
         hidden="hidden">
    </div>

</body>
</html>
