<?php namespace ProcessWire; 
if ($page->template != "AJAX"):
	$thePage = $page;
else:
	$thePage = $pages->get(getPV("currentPage"));
endif;

$shown = getPV("hidePassagesDetailFlg") ? "hidden" : "shown";
$ct = 0;

echo "\n<region id='mrPassagesCard'>";

if ($thePage->template == "Draft"):
	$passages = $thePage->children("template=Passage");
	$ct = $passages->count();
	$detail = "";
	if ($ct > 0):
		$detail .= "<div class='alignedList'><dl class='midAlign pass'>";
		foreach ($passages as $passage):
			$detail .= "<dt class='sc'><a href='" . $passage->url . "'>" . $passage->id . "</a></dt><dd>" . $passage->startWords;
			if ($passage->endWords != ""):
				$detail .= " … " . $passage->endWords;
			endif;
			$detail .= "</dd>";
		endforeach;
		$detail .= "</dl></div>";
	else:
		$detail .= "<span class='note'>[<em>No passages have yet been assigned to any pages in this draft.</em>]</span>";
 	endif;
elseif ($thePage->template == "Page"):
	$passages = new PageArray();
	$detail = "";
	$drafts = $pages->find("template=Draft, pageRef={$thePage}");
	foreach ($drafts as $draft):
		$passages = $draft->children("template=Passage, pageWithinDraftRef={$thePage}");
			$detail .= "<h3 class='pass'>" . $draft->recursiveShortName() . "</h3><div class='alignedList'><dl class='midAlign pass'>";
		if ($passages->count() > 0):
			foreach ($passages as $passage):
				$ct += 1;
				$detail .= "<dt class='sc'><a href='" . $passage->url . "'>" . $passage->id . "</a></dt><dd>" . $passage->startWords;
				if ($passage->endWords != ""):
					$detail .= " … " . $passage->endWords;
				endif;
				$detail .= "</dd>";
			endforeach;
		else:
			$detail .= "<span class='note'>[<em>No passages have yet been assigned to this page within this draft.</em>]</span>";
		endif;
		$detail .= "</dl></div>";
	endforeach;
endif;

echo "<div id='tcPassages' class='card pass {$shown}'><h2 class='pass'><span class='htmx' hx-put='/verso/PassagesCard' hx-swap='outerHTML' hx-target='#tcPassages'><span class='sc'>" . $ct . "</span>" . ngettext(" passage</h2>", " passages</h2>", $ct);
if (!getPV("hidePassagesDetailFlg")):
	echo $detail;
endif;
echo "</div>";
echo "</region><!--#mrPassagesCard-->\n";
