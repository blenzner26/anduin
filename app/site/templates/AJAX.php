<?php namespace ProcessWire;

include_once "includes/_func.php";

switch ($page->id):
case (141936):
	TogglePV("hideShelfmarkDetailFlg");
	include_once "includes/shelfmarkCard.php";
	break;
case (142127):
	TogglePV("hideCitationDetailFlg");
	include_once "includes/citationCard.php";
	break;
case (145421):
	TogglePV("hideCommentsDetailFlg");
	include_once "includes/commentsCard.php";
	break;
case (145422):
	TogglePV("hideMetadataDetailFlg");
	include_once "includes/metadataCard.php";
	break;
case (145423):
	TogglePV("hideLegendDetailFlg");
	include_once "includes/legendCard.php";
	break;
case (145560):
	TogglePV("hidePagesDetailFlg");
	include_once "includes/pagesCard.php";
	break;
case (145558):
	TogglePV("hidePassagesDetailFlg");
	include_once "includes/passagesCard.php";
	break;
case (145563):
	include_once "includes/setScanMixBlendNormal.php";
	break;
case (145564):
	include_once "includes/setScanMixBlendColorBurn.php";
	break;
case (145565):
	include_once "includes/setScanMixBlendDifference.php";
	break;
case (145566):
	include_once "includes/setScanMixBlendDarken.php";
	break;
case (145567):
	include_once "includes/setScanMixBlendExclusion.php";
	break;
case (145568):
	include_once "includes/setScanMixBlendHardLight.php";
	break;
case (145569):
	include_once "includes/setScanMixBlendLuminosity.php";
	break;
case (145570):
	include_once "includes/setScanMixBlendMultiply.php";
	break;
case (145571):
	include_once "includes/setScanMixBlendOverlay.php";
	break;
case (145572):
	include_once "includes/setScanMixBlendPlusDarker.php";
	break;
endswitch;
