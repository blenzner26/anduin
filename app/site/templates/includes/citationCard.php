<?php namespace ProcessWire;

echo "\n<div id='tcCitation' class='cit'>";
if (getPV("hideCitationDetailFlg")):
	if ($thePage->template == 'Page'):
		$drafts = $pages->find("template='Draft', pageRef={$thePage}, sort=parent, sort=titleShort");
		if ($drafts->count() > 0):
			foreach ($drafts as $draft):
				$shortName = $draft->recursiveShortName();
				$j = 0;
				foreach ($draft->pageRef as $draftPage):
					$j = $j + 1;
					if ($draftPage == $thePage):
						break;
					endif;
				endforeach;
				echo "<div class='card cit hidden'><h2 class='cit'><span class='htmx' hx-put='/verso/citationCard' hx-swap='outerHTML' hx-target='#tcCitation'><span class='uni'>" . $shortName . ".p" . $j . "</span></span>" . $thePage->citationLateral($draft) . "</h2></div>";
			endforeach;
		endif;
	else:
		if (in_array($thePage->template, array("Work", "Section", "Chapter", "Draft"))):
			echo "<div class='card cit hidden'><h2 class='cit'><span class='htmx' hx-put='/verso/citationCard' hx-swap='outerHTML' hx-target='#tcCitation'><span class='uni'>" . $thePage->recursiveShortName() . "</span></span>";
 			echo $thePage->citationLateral();
		else:
			echo "<div class='card cit hidden'><h2 class='cit'><span class='htmx' hx-put='/verso/citationCard' hx-swap='outerHTML' hx-target='#tcCitation'><span class='uni'>Citation</span></span>";
		endif;
		echo "</h2></div>";
	endif;
else:
	if ($thePage->template == 'Page'):
		$drafts = $pages->find("template='Draft', pageRef={$thePage}, sort=parent, sort=titleShort");
		if ($drafts->count() > 0):
			$also = " ";
			foreach ($drafts as $draft):
				$shortName = $draft->recursiveShortName();
				$j = 0;
				foreach ($draft->pageRef as $draftPage):
					$j = $j + 1;
					if ($draftPage == $thePage):
						break;
					endif;
				endforeach;

				$detail = "<div class='card cit shown'><h2 class='cit'><span class='htmx' hx-put='/verso/citationCard' hx-swap='outerHTML' hx-target='#tcCitation'><span class='uni'>" . $shortName . ".p" . $j . "</span></span>" . $thePage->citationLateral($draft) . "</h2>";
				$pageCt = $draft->pageRef(false, "pageRef")->count - 1;
				$pageLit = ngettext("page", "pages", $pageCt);
				$commentCt = $draft->children("template=Comment")->count();
				$commentLit = ngettext("comment", "comments", $commentCt);
				$passageCt = $draft->children("template=Passage")->count();
				$passageLit = ngettext("passage", "passages", $passageCt);
				if ($passageCt == 0):
					$passageLit = $passageLit . "<sup>{$thePage->feetnote(1)}</sup>";
				endif;
				$title = $thePage->title;

				$detail .= "<nav class='cit'><table class='nav'><tr>" . $thePage->citationDropdowns($draft) . "</tr><tr class='breadCrumb'>" . $thePage->citationBreadcrumbs($draft) . "</tr></table></nav>";
				$detail .= "<p class='note'><em>" . $also . "<span class='num semibold'>" . $title . "</span> is page <span class='num'>" . $j . "</span> of the " . $draft->title . " of “" . $draft->parent->title . ",” which includes <span class='num'>" . $pageCt . "</span> other " . $pageLit . ", <span class='num'>" . $commentCt . "</span> " . $commentLit . ", and <span class='num'>" . $passageCt . "</span> " . $passageLit . " altogether. In this context, <span class='num semibold'>" . $title . "</span> may also be cited as <span class='num semibold'>" . $shortName . ".p" . $j . "</span>." . $thePage->feetnote(3) . "</em></p>";

				switch ($also):
					case " ":
						$also = "Also, ";
						break;
					case "Also, ":
						$also = "In addition, ";
						break;
					case "In addition, ":
						$also = "Furthermore, ";
						break;
					default:
						$also = "Also, ";
						break;
				endswitch;

				$passages = $draft->children("template=Passage, pageWithinDraftRef={$thePage}");
				$passageCt = $passages->count();
				$passageLit = ngettext("passage on this draft page", "passages on this draft page", $passageCt);
				if ($passageCt == 0):
					$passageLit = $passageLit . "<sup class='note'>{$thePage->feetnote(2)}</sup>";
				endif;
				$detail .= "<h3 class='semibold'>{$passageCt} {$passageLit}</h3>";

				if ($passageCt > 0):
					$detail .= "<div class='alignedList'><dl class='midAlign pass'>";
					$i = 0;
					foreach ($passages as $passage):
						$i += 1;
						$detail .= "<dt class='sc'><a href='" . $passage->url . "'>" . $passage->id . "</a></dt><dd>" . $passage->startWords;
						if ($passage->endWords != ""):
							$detail .= " … " . $passage->endWords;
						endif;
						$detail .= "</dd>";
					endforeach;
					$detail .= "</dl></div>";
				endif;
				echo $detail . "</div>";
			endforeach;
		endif;
	else:
		if (in_array($thePage->template, array("Work", "Section", "Chapter", "Draft"))):
			echo "<div class='card cit shown'><h2 class='cit'><span class='htmx' hx-put='/verso/citationCard' hx-swap='outerHTML' hx-target='#tcCitation'><span class='uni'>" . $thePage->recursiveShortName() . "</span></span>";
 			echo $thePage->citationLateral();
 		else:
			echo "<div class='card cit shown'><h2 class='cit'><span class='htmx' hx-put='/verso/citationCard' hx-swap='outerHTML' hx-target='#tcCitation'><span class='uni'>Citation</span></span>";
		endif;
		echo "</h2><nav class='cit'><table class='nav'><tr>" . $thePage->citationDropdowns() . "</tr><tr class='breadCrumb'>" . $thePage->citationBreadcrumbs() . "</tr></table></nav></div>";
	endif;
endif;
echo "</div>\n";
