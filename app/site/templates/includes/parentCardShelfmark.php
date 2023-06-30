<?php namespace ProcessWire; 
if ($page->template != "AJAX"):
	$thePage = $page;
else:
	$thePage = $pages->get(getPV("currentPage"));
endif;

$template = $thePage->template;
$shown = !getPV("hideParentDetailFlg");
$detail = "";

$parent = $thePage->parent();

$detail = "<h3>" . $parent->recursiveShortName() . " ⟡ <a class='sc' href='" . $parent->url . "'>" . $parent->title . "</a></h3><ul>";
$ct = $parent->children("template=Comment")->count();
$detail .= "<li>" . $ct . " " . ngettext("comment", "comments", $ct) . "</li>";

$ct = $parent->children("template=Shelfmark")->count();
$type = $thePage->getUnformatted("type");
switch ($type):
	case "folder":
		$detail .= "<li>" . $ct . " " . ngettext("folder", "folders", $ct) . "</li>";
		$header  = "parent box for this folder";
		break;
	case "box":
		$detail .= "<li>" . $ct . " " . ngettext("box", "boxes", $ct) . "</li>";
		$header  = "parent subseries for this box";
		break;
	case "subseries":
		$detail .= "<li>" . $ct . " subseries</li>";
		$header  = "parent work for this subseries";
		break;
endswitch;
$detail .= "</ul>";

$html = "<div class='card parent {$shown}' hx-put='/verso/parentCard' hx-swap='outerHTML'><h2 class='parent'>";
echo $html . $header . "</h2>";
if (!getPV("hideParentDetailFlg")):
	echo $detail;
endif;
echo "</div>";
