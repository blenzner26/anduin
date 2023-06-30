<?php namespace ProcessWire;

echo "<div id='Pane2'>";

/*
$p2 = (GetPV("pane2TemplatePriorities"));
if ($p2 == ""):
	$p2 = (GetPV("pane2Priorities"));
	if ($p2 == ""):
		$p2 = $config->pane2Priorities;
	endif;
endif;
$p2Priorities = explode("|", $p2);
foreach ($p2Priorities as $panel):
	switch ($panel):
		case ($config->navPlusPanel):
			if ($navPlusPanelValid):
				$pane = "navPlusPanel";
				break 2; # breaks out of switch-case and foreach
			endif;
		case ($config->searchPanel):
			if ($searchPanelValid):
				$pane = "searchPanel";
				break 2; # breaks out of switch-case and foreach
			endif;
		case ($config->listingsPanel):
			if ($listingsPanelValid):
				$pane = "listingsPanel";
				break 2; # breaks out of switch-case and foreach
			endif;
		case ($config->imagePanel):
			if ($imagePanelValid):
				$pane = "imagePanel";
				break 2; # breaks out of switch-case and foreach
			endif;
	endswitch;
endforeach;
echo "<region id='" . $pane . "'>";
include_once "includes/" . $pane . ".php";
echo "</region><!--#" . $pane . "-->";
*/

if ($page->template == "Page"):
	echo "<region id='imagePanel'>";
	include_once "includes/imagePanel.php";
	echo "</region><!--#imagePanel-->";
endif;

// echo "<region id='listingsPanel'>";
// include_once "includes/listingsPanel.php";
// echo "</region><!--#listingsPanel-->";

echo "</div>";
