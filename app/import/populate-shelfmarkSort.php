<?php namespace ProcessWire;

## 2022-07-18 • ErikMH for Anduin 0.7.1
##
## Populates all empty `shelfmarkSort` fields on existing
## Shelfmark and Page pages.
##
## to invoke: `/import/populate-shelfmarkSort.php`


include('../index.php'); // bootstrap PW

$thePages = wire('pages')->find("template=Page|Shelfmark,shelfmarkSort=''");
## $thePages = wire('pages')->find("template=Page|Shelfmark);

foreach ($thePages as $aPage):
	if ($aPage->series != ""):
		$aPage->shelfmarkSort = $aPage->series;
	endif;
	if ($aPage->subseries != ""):
		$aPage->shelfmarkSort .= "." . $aPage->subseries;
	endif;
	if ($aPage->box != ""):
		$aPage->shelfmarkSort .= "." . $aPage->box;
	endif;
	if ($aPage->folder != ""):
		$aPage->shelfmarkSort .= "." . str_pad($aPage->folder, 2, '0', STR_PAD_LEFT);
	endif;
	if ($aPage->folio != ""):
		$aPage->shelfmarkSort .= "." . str_pad($aPage->folio, 3, '0', STR_PAD_LEFT);
	endif;
	if ($aPage->side != ""):
		$aPage->shelfmarkSort .= "." . $aPage->side;
	endif;
	if ($aPage->version != ""):
		$aPage->shelfmarkSort .= "." . $aPage->version;
	endif;
	$aPage->save('shelfmarkSort');
endforeach;
