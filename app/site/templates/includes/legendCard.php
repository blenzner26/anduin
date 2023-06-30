<?php namespace ProcessWire; 
if ($page->template != "AJAX"):
	$thePage = $page;
else:
	$thePage = $pages->get(getPV("currentPage"));
endif;

$fns = array_unique(wire('session')->fns);
$fnsCt = count($fns);
if ($fnsCt > 0):
	echo "\n<region id='mrLegendCard'>";
	$detail = "";
	if (getPV("hideLegendDetailFlg")):
		echo "<div id='tcLegend' class='card legend hidden'><h2><span class='htmx' hx-put='/verso/legendCard' hx-swap='outerHTML' hx-target='#tcLegend'>legend: {$fnsCt} notes</span></h2></div>";
	else:
		echo "<div id='tcLegend' class='card legend shown'><h2><span class='htmx' hx-put='/verso/legendCard' hx-swap='outerHTML' hx-target='#tcLegend'>legend</span></h2><dl>";
		foreach ($fns as $fn):
			if (in_array($fn, $fns, true)):
				$notePage = $pages->get("template=Feetnote, title={$fn}");
				echo "<dt class='note'>[{$notePage->seq}]</dt><dd class='note'>{$notePage->contentPublicSinglePara}</dt>";
			endif;
		endforeach;
		echo "</dl></div>";
	endif;
	wire('session')->fns = "";
	echo "</region><!--#mrLegendCard-->\n";
endif;
