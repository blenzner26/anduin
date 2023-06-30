<?php namespace ProcessWire;

## 2022-08-09 • ErikMH for Anduin 0.7.4
##
## Corrects LR Hanna Code hyperlinks from `[LRxxxxx]` format to
## `[[lr lr=xxxxx]]` format.
##
## to invoke: `/import/correct-hanna-lr-links.php`

include('../index.php'); // bootstrap PW

$thePages = wire('pages')->find("template=Comment");

$patterns = "~\[LR(\d\d\d\d\d)\]~";
$replace = " [[lr lr=$1]]";

foreach ($thePages as $aPage):
	if ($aPage->contentPublic != ""):
		$aPage->contentPublic = preg_replace($patterns, $replace, $aPage->contentPublic);
	endif;
	$aPage->save('contentPublic');
endforeach;
