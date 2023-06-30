<?php namespace ProcessWire; 
if ($page->template != "AJAX"):
	$thePage = $page;
else:
	$thePage = $pages->get(getPV("currentPage"));
endif;

$template = $thePage->template;
$detail = "";

$parent = $thePage->parent();
$shown = !getPV("hideParentDetailFlg");
$detail = "<ul>";

$ct = $parent->children("template=Comment")->count();
$detail .= "<li>" . $ct . " " . ngettext("comment", "comments", $ct) . "</li>";

$ct = $parent->children("template=Work,author=jrrt")->count();
$detail .= "<li>" . $ct . " " . ngettext("work", "works", $ct) . "</li>";
$detail .= "</ul>";

$html = "<div class='card parent {$shown}' hx-put='/verso/parentCard' hx-swap='outerHTML'><h2 class='parent'>";
echo $html . "Anduin itself</h2>";
if (!getPV("hideParentDetailFlg")):
	echo $detail;
endif;
echo "</div>";
