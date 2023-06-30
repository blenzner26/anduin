<?php namespace ProcessWire;

echo "<title>";
echo ($config->server == "Aragorn" ? "Anduin" : $config->server);
echo Star("none") . $page->recursiveShortNameText();
echo "</title>";
