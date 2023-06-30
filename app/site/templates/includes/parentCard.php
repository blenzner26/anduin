<?php namespace ProcessWire; 
echo "<!-- parentCard -->";
if ($page->template != "AJAX"):
	$thePage = $page;
else:
	$thePage = $pages->get(getPV("currentPage"));
endif;
$thePage->of(false);
$template = $thePage->template;
$shown = !getPV("hideParentDetailFlg");
$detail = "";

if ($template == "Page"):	## Then everything is different: collect all possible DRAFTs
	$typo = $modules->get('TextformatterTypographer');
	$drafts = $pages->find("template='Draft', pageRef={$thePage}");
	$draftCt = ($drafts ? $drafts->count : 0);
	if ($draftCt > 0):
		$idx = 1;
		foreach ($drafts as $draft):
			$detail .= "<div class='card parent {$shown}'><h2 class='parent'>";
			if ($draftCt > 1):
				$typoText = ordinal($idx) . " of " . $draftCt . " parent drafts for this page";
				$typoText = $typo->formatString($typoText);
				$detail .= $typoText . "</h2>";
			else:
				$detail .= "parent draft for this page</h2>";
			endif;
			if (!getPV("hideParentDetailFlg")):
				$detail = "<h3>" . $parent->recursiveShortName() . " ⟡ <a class='sc' href='" . $parent->url . "'>" . $parent->title . "</a></h3><ul>";
				$ct = $draft->children("template=Comment")->count;
				$detail .= "<li>" . $ct . " " . ngettext("comment", "comments", $ct) . "</li>";
				$ct = $draft->pageRef->count() ?? 0;
				$detail .= "<li>" . $ct . " " . ngettext("page", "pages", $ct) . "</li>";
				$ct = $draft->children("template=Passage")->count;
				$detail .= "<li>" . $ct . " " . ngettext("passage", "passages", $ct) . "</li>";
				$detail .= "</ul>";
			endif;
			$detail .= "</div>";
			$idx = $idx + 1;
		endforeach;
	else:
		$detail = "<div class='card parent {$shown}' hx-put='/verso/parentCard' hx-swap='outerHTML'><h2 class='parent'>";
		$detail .= "no parent draft for this page</h2></div>";
	endif;
	if (!getPV("hideParentDetailFlg")):
		echo $detail;
	endif;
else:						## Then things are normal
	$parent = $thePage->parent();
	switch ($template):
		case "Shelfmark":		## parent = Shelfmark
			$detail = "<h3>" . $parent->recursiveShortName() . " ⟡ <a class='sc' href='" . $parent->url . "'>" . $parent->title . "</a></h3><ul>";
			$ct = $parent->children("template=Comment")->count();
			$detail .= "<li>" . $ct . " " . ngettext("comment", "comments", $ct) . "</li>";
			$ct = $parent->children("template=Shelfmark")->count();
			$type = $thePage->getUnformatted("type");
			switch ($type):
				case "folder":
					$detail .= "<li>" . $ct . " " . ngettext("folder", "folders", $ct) . "</li>";
					break;
				case "box":
					$detail .= "<li>" . $ct . " " . ngettext("box", "boxes", $ct) . "</li>";
					break;
				case "subseries":
					$detail .= "<li>" . $ct . " subseries</li>";
					break;
			endswitch;
			$detail .= "</ul>";
			break;
	endswitch;
	$html = "<div class='card parent";
	if (!$detail):
		$html .= " disabled";
	endif;
	$html .= " {$shown}' hx-put='/verso/parentCard' hx-swap='outerHTML'><h2 class='parent'>";
	echo $html . "parent " . strtolower($parent->template) . " for this " . strtolower($thePage->template) . "</h2>";
	if (!getPV("hideParentDetailFlg")):
		echo $detail;
	endif;
	echo "</div>";
endif;
