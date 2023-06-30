<?php namespace ProcessWire;
## This file defines the layout of all pages in Anduin. It’s included once, immediately after the relevant
## Template.php file. See https://processwire.com/docs/front-end/output/markup-regions/#main.php.

echo "<!DOCTYPE html>\n<html lang='en'>\n";
echo "<head>\n";

include_once "includes/head.php";	## favicon, robots, meta, auto-forward
include_once "includes/tail.php";	## scripts
include_once "includes/title.php";	## page title

echo "</head><body>";

include_once "includes/header.php";
include_once "includes/pane1.php";
include_once "includes/footer.php";

echo "</body></html>";
