<?php namespace ProcessWire;
if (str_starts_with($page->template, 'AJAX')):
	$thePage = $pages->get(getPV("currentPage"));
else:
	$thePage = $page;
endif;

$template = $thePage->template;

echo "<div id='Pane1'>";
if ($template == "Page"):
	echo "<region id='mrImage'>";
	echo "<div id='imagePanel' class='imagePanel'>";
	echo $thePage->markupItsLikeness();
	echo "</div></region><!--mrImage-->";
endif;

include_once "includes/shelfmarkCard.php";
include_once "includes/citationCard.php";
include_once "includes/mainFlowCard.php";
include_once "includes/metadataCard.php";
include_once "includes/commentsCard.php";
include_once "includes/legendCard.php";

if ($template == "Shelfmark" || $template == "Draft" || $template == "Chapter"):
	include_once "includes/pagesCard.php"; ## Pages
endif;

echo "</div>";
