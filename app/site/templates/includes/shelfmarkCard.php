<?php namespace ProcessWire;
if ($page->template != "AJAX"):
	$thePage = $page;
else:
	$thePage = $pages->get(getPV("currentPage"));
endif;

echo "\n<region id='mrShelfmarkCard'>";

if (!getPV("hideShelfmarkDetailFlg")):
	$shown = "shown";
	$detail = "<nav class='sm'><table class='nav'><tr>" . $thePage->shelfmarkNavBar() . "</tr><tr class='breadCrumb'>" . $thePage->shelfmarkBreadCrumbs() . "</tr></table></nav>";
	$parent = $thePage->parent;

	switch ($thePage->template):
		case 'Shelfmark':
			$type = $thePage->getUnformatted("type");
			break;
		case 'Page':
			$type = "folio";
			break;
		case 'Work':
			$type = "work";
			break;
		default:
			$type = "";
	endswitch;

	if ($type):
		$detail .= "<p class='sm note'><em>";
		$d2 = "";
		switch ($type):
			case 'folio':
				$sibCt = $parent->children("template=Page")->count() - 1;
				$sibLit = ngettext("folio", "folios", $sibCt);
				$folio = $thePage->getUnformatted("folio") . $thePage->getUnformatted("side");
				$cit = $parent->title . "/" . $folio;
				$detail .= "<span class='num semibold'>" . $thePage->title . "</span> is folio <span class='num'>" . $folio . "</span> of folder <span class='num'>" . $parent->title . "</span>, which includes <span class='num'>" . $sibCt . "</span> other " . $sibLit;
				$d2 = "In this context, <span class='num semibold'>" . $thePage->recursiveShortName() . "</span> may also be cited as <span class='num semibold'>MS. Tolkien, " . $cit . "</span>." . $thePage->feetnote(6);
				break;
			case 'folder':
				$sibCt = $parent->children("template=Shelfmark")->count() - 1;
				$sibLit = ngettext("folder", "folders", $sibCt);
				$cit = $thePage->title;
				$detail .= "Folder <span class='num'>" . $thePage->title . "</span> is in box <span class='num'>" . $parent->title . "</span>, which includes <span class='num'>" . $sibCt . "</span> other " . $sibLit;
				$d2 = "The folder as a whole may be cited as <span class='num semibold'>MS. Tolkien, " . $cit . "</span>.";
				break;
			case 'box':
				$sibCt = $parent->children("template=Shelfmark")->count() - 1;
				$sibLit = ngettext("box", "boxes", $sibCt);
				$cit = $thePage->title;
				$detail .= "Box <span class='num'>" . $thePage->title . "</span> is in <span class='num'>" . $parent->title . "</span>, which includes <span class='num'>" . $sibCt . "</span> other " . $sibLit;
				$d2 = "The box as a whole may be cited as <span class='num semibold'>MS. Tolkien, " . $cit . "</span>.";
				break;
			case 'subseries':
				$sibCt = $parent->children("template=Shelfmark")->count() - 1;
				$cit = $thePage->title;
				$detail .= "<span class='num'>" . $thePage->title . "</span> is in <span class='num'>" . $parent->title . "</span>, which includes " . $sibCt . " other series";
				$d2 = "The series as a whole may be cited as <span class='num semibold'>MS. Tolkien, " . $cit . "</span>.";
				break;
			default: // work / series
				$sibCt = $parent->children("template=Work,author=JRRT")->count() - 1;
				$cit = $thePage->title;
				$detail .= "<span class='num'>" . $thePage->title . "</span> is in <span class='num'>" . $parent->title . "</span>, which includes <span class='num'>" . $sibCt . "</span> other works";
				$d2 = "The work as a whole may be cited as <span class='num semibold'>MS. Tolkien, " . $cit . "</span>.";
				break;
		endswitch;
	
		$commentCt = $parent->children("template=Comment")->count();
		$commentLit = ngettext(" comment", " comments", $commentCt);

		$detail .= " and " . $commentCt . $commentLit . ". " . $d2 . "</em></p>";
	else:
		$cit = "";
	endif;
else:
	$shown = "hidden";
	$detail = "";
	if ($thePage->template == 'Page'):
		$cit = $thePage->parent->title . "/" . $thePage->getUnformatted("folio") . $thePage->getUnformatted("side");
	else:
		$cit = $thePage->title;
	endif;
endif;

if (ctype_space($cit) || $cit == ''):
	$cit = "Marquette shelfmark";
else:
	$cit = "MS. Tolkien, " . $cit;
endif;

echo "<div id='tcShelfmark' class='card shelfmark {$shown}'><h2 class='sm'><span class='htmx sc' hx-put='/verso/shelfmarkCard' hx-swap='outerHTML' hx-target='#tcShelfmark'>" . $cit . "</span>" . $thePage->shelfmarkLateral() . "</h2>" . $detail . "</div>";
echo "</region><!--#mrShelfmarkCard-->\n";
