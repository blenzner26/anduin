<?php namespace ProcessWire; 
if ($page->template != "AJAX"):
	$thePage = $page;
else:
	$thePage = $pages->get(getPV("currentPage"));
endif;

$hide = getPV("hidePagesDetailFlg");
$shown = $hide ? "hidden" : "shown";
$ct = 0;
$template = $thePage->template;

echo "\n<region id='mrPagesCard'>";

if ($template == "Draft" || $template == "Chapter"):
	$refPages = $thePage->pageRef;
elseif ($template == "Shelfmark"):
	$refPages = $thePage->children("template=Page");
endif;

$ct = isset($refPages) ? $refPages->count : 0;
$detail = "";
if ($ct > 0):
	if (!$hide):
		$detail .= "<div class='alignedList'><dl class='midAlign page'>";
		foreach ($refPages as $refPage):
			$refPage->of(false);
			$detail .= "<dt class='sc'><a href='" . $refPage->url . "'>" . $refPage->title . "</a></dt><dd class='sc'>" . $refPage->titleLong;
			$detail .= "</dd>";
		endforeach;
		$detail .= "</dl></div>";
	endif;
else:
	switch ($template):
		case "Shelfmark":
			$detail .= "<span class='note'>[<em>No pages have yet been assigned to this shelfmark.</em>]</span>";
			break;
		case "Draft":
			$detail .= "<span class='note'>[<em>No pages have yet been assigned to this draft.</em>]</span>";
			break;
		case "Chapter":
#			do nothing — this means there are no pages binned to this chapter that aren’t assigned to a specific draft.
			break;
	endswitch;
endif;

if ($ct > 0 || $template !== "Chapter"):
	echo "<div id='tcPages' class='card page {$shown}'><h2 class='page'><span class='htmx' hx-put='/verso/pagesCard' hx-swap='outerHTML' hx-target='#tcPages'><span class='sc'>" . $ct . "</span>" . ngettext(" page", " pages", $ct);
	if ($template == "Chapter"):
		echo " not yet assigned to a draft";
	endif;
	echo "</h2>";
	if (!getPV("hidePagesDetailFlg")):
		echo $detail;
	endif;
	echo "</div>";
endif;

echo "</region><!--#mrPagesCard-->\n";
