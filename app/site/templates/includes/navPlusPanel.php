<?php namespace ProcessWire;
if ($page->template != "AJAX"):
	$thePage = $page;
else:
	$thePage = $pages->get(getPV("currentPage"));
endif;
?>
<div class='navPlusPanel'>
<region id='mrShelfmarkCard'><?php include_once "includes/shelfmarkCard.php" ?></region><!--#mrShelfmarkCard-->
<region id='mrCitationCard'><?php include_once "includes/citationCard.php" ?></region><!--#mrCitationCard-->
<region id='mrMainFlowCard'><?php include_once "includes/mainFlowCard.php" ?></region><!--#mrMainFlowCard-->
<region id='mrMetadataCard'><?php include_once "includes/metadataCard.php" ?></region><!--#mrMetadataCard-->
<region id='mrCommentsCard'><?php include_once "includes/commentsCard.php" ?></region><!--#mrCommentsCard-->
<!--
<region id='mrLegendCard'><? include_once "includes/legendCard.php" ?></region><!--#mrLegendCard-->
</div>