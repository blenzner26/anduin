<?php namespace ProcessWire;
if ($page->template != "AJAX"):
	$thePage = $page;
else:
	$thePage = $pages->get(getPV("currentPage"));
endif;

$template = $page->template;
echo "<div class='listingsPanel'>";

## Pages
if ($template == "Shelfmark" || $template == "Draft" || $template == "Chapter"):
	echo "<region id='mrPagesCard'>";
	include_once "includes/pagesCard.php";
	echo "</region><!--#mrPagesCard-->";
endif;

## Passages
if ($template == "Page" || $template == "Draft"):
	echo "<region id='mrPassagesCard'>";
	include_once "includes/passagesCard.php";
	echo "</region><!--#mrPassagesCard-->";
endif;

echo "</div>";

