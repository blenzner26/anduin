<?php namespace ProcessWire; 
if ($page->template != "AJAX"):
	$thePage = $page;
else:
	$thePage = $pages->get(getPV("currentPage"));
endif;

$thePage->of(true);
$shownFlg = getPV("hideMetadataDetailFlg") ? FALSE : TRUE;
$contentsFlg = FALSE;

echo "\n<region id='mrMetadataCard'>";
if ($thePage->contentPublic):
	if ($shownFlg):
		$contents = "<h3 class='md'>Description</h3><div class='indent'>" . $thePage->contentPublic . "</div>";
	else:
		$contentsFlg = TRUE;
	endif;
else:
	$contents = "";
endif;

$alts = "";
if (($thePage->titleAlt) && $thePage->titleAlt->count > 0):
##			Assemble the “constituent parts” of draft or “alternate titles” of chapter
	foreach ($thePage->titleAlt as $alt):
		$alts .= "  ⟡  " . $alt;
	endforeach;
	if ($alts != ""):
		if ($shownFlg):
##			If there’s any content, wrap it in paragraph tags and remove the spurious opening delimiter
			$alts = "<p class='indent'>   " . substr($alts, 7) . "</p>";
			if ($thePage->template == "Draft"):
				$alts = "<h3 class='md'>Constituent parts</h3>" . $alts;
			else:
				$alts = "<h3 class='md'>Alternate titles</h3>" . $alts;
			endif;
		else:
			$contentsFlg = TRUE;
		endif;
	endif;
endif;

if (($thePage->pdfs) && $thePage->pdfs->count > 0):
	$ct = $thePage->pdfs->count;
	if ($shownFlg):
		$pdfs = "<h3 class='md'>" . ngettext("PDF", "PDFs", $ct) . "</h3><ul class='content'>";
		foreach ($thePage->pdfs as $pdf):
			switch ($pdf->author):
			case "CT":
				setPV("legendCTflg", 1);
				$classStr = "ct";
				break;
			case "JRRT":
				setPV("legendJRRTflg", 1);
				$classStr = "jrrt";
				break;
			endswitch;
			$pdfs .= "<li class='{$classStr}'><a href='{$pdf->url}'>" . $pdf->author . ": <em>" . $pdf->description . "</em></a>";
		endforeach;
		$pdfs .= "</ul>";
	else:
		$contentsFlg = TRUE;
	endif;
else:
	$pdfs = "";
endif;

if (($thePage->labels) && $thePage->labels->count > 0):
	if ($shownFlg):
		$labels = "<h3 class='md'>Labels</h3><table class='labels'><tr><th>Author</th><th>Context</th><th>Content</th></tr>";
		foreach ($thePage->labels as $label):
			$classStr = " class='content ";
			switch ($label->author):
			case "CT":
				setPV("legendCTflg", 1);
				$classStr .= "ct'";
				$fn = 4;
				break;
			case "JRRT":
				setPV("legendJRRTflg", 1);
				$classStr .= "jrrt'";
				$fn = 5;
				break;
			endswitch;
			$theContext = str_replace(",", " <span class='md'>⟡</span> ", $label->context);
			$labels .= "<tr><td>" . $label->author . "</td><td>" . $theContext . "</td><td" . $classStr . ">" . $label->getUnformatted("contentPublic") . "<span class='md'>" . $thePage->feetnote($fn) ."</span></td></tr>";
		endforeach;
		$labels .= "</table>";
	else:
		$contentsFlg = TRUE;
	endif;
else:
	$labels = "";
endif;

$flags = "";
if ($thePage->template == "Page"):
	if ($thePage->CTNoteWithOrigsFolderFlg):
		if ($shownFlg):
			$flags .= "<li>CT note with originals folder";
		else:
			$contentsFlg = TRUE;
		endif;
	endif;
	if ($thePage->CTLetterWithCopiesFolderFlg):
		if ($shownFlg):
			$flags .= "<li>CT letter with copies folder";
		else:
			$contentsFlg = TRUE;
		endif;
	endif;
	if ($thePage->versoIsBlankFlg):
		if ($shownFlg):
			$flags .= "<li>Verso is blank";
		else:
			$contentsFlg = TRUE;
		endif;
	endif;
	if ($thePage->studentEssayFlg):
		if ($shownFlg):
			$flags .= "<li>Not <em>LotR</em> material";
		else:
			$contentsFlg = TRUE;
		endif;
	endif;
	if ($thePage->photocopyInOrigsFolderFlg):
		if ($shownFlg):
			$flags .= "<li>Photocopy in originals folder";
		else:
			$contentsFlg = TRUE;
		endif;
	endif;
	if ($flags):
		if ($shownFlg):
			$flags = "<h3 class='md'>More info</h3><ul class='md'>" . $flags . "</ul>";
		else:
			$contentsFlg = TRUE;
		endif;
	endif;
endif;

if ($shownFlg):
	$detail = $contents . $alts . $labels . $pdfs . $flags;
	$shown = "shown";
else:
	$detail = "";
	$shown = "hidden";
endif;

if ($detail || $contentsFlg):
	echo "<div id='tcMetadata' class='card md {$shown}'><h2 class='md'><span class='htmx' hx-put='/verso/metadataCard' hx-swap='outerHTML' hx-target='#tcMetadata'>";
	echo "metadata</span></h2>" . $detail . "</div>";
endif;

echo "</region><!--#mrMetadataCard-->\n";
