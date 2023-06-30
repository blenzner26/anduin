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

$ct = $parent->pageRef->count();
$detail .= "<li>" . $ct . " unassigned " . ngettext("page", "pages", $ct) . "</li>";

$ct = $parent->children("template=Draft")->count();
$detail .= "<li>" . $ct . " " . ngettext("draft", "drafts", $ct) . "</li>";
$detail .= "</ul>";

$html = "<div class='card parent {$shown}' hx-put='/verso/parentCard' hx-swap='outerHTML'><h2 class='parent'>";
echo $html . "parent chapter for this draft</h2>";
if (!getPV("hideParentDetailFlg")):
	echo $detail;
endif;
echo "</div>";
