<?php namespace ProcessWire;
class PagePage extends tcPage {

/* PARENTAGE

A pages’s OOP parent is tcPage, as noted above:
- site/classes/tcPage.php

A page’s parent in ProcessWire is the “Shelfmark” template:
- site/templates/Shelfmark.php

And that *parent’s* OOP class is:
- site/classes/ShelfmarkPage.php

It may also be assigned to 0 to N *drafts*, but those are by reference, not parentage:
- site/classes/DraftPage.php
- site/templates/Draft.php

*/

public function citationBreadcrumbs() {
	if (func_num_args()):
		$draft = func_get_arg(0);
	else:
		$draft = wire('pages')->findOne("template='Draft', pageRef={$this}");
	endif;
	$html = "";
	$idx = 1;
	$pageRefs = $draft->pageRef;
	if (!is_null($pageRefs) && $pageRefs->count > 0):
/*		foreach ($pageRefs as $ref):
			if ($ref->id == $this->id):
				break;
			endif;
			$idx = $idx + 1;
			if ($idx > $pageRefs->count):
				$idx = 0;
				break;
			endif;
		endforeach;
*/		$html .= $draft->citationBreadcrumbs();
		$html .= "<td class='page'>";
/*		if ($idx > 0):
			$html .= $idx . ". ";
		endif;
*/		$html .= $this->title . "</td>";
	endif;
	if ($html == ""):
		$html = $this->parent->citationBreadcrumbs();
	endif;
	return $html . "\n";
}

public function citationDropdowns() {
	if (func_num_args()):
		$draft = func_get_arg(0);
	else:
		$draft = wire('pages')->findOne("template='Draft', pageRef={$this}");
	endif;
	return $draft->citationDropdowns() . "\n";
}

public function citationLateral() {
	if (func_num_args()):
		$draft = func_get_arg(0);
	else:
		$draft = wire('pages')->findOne("template='Draft', pageRef={$this}");
	endif;
	$idx = 1;
	$pageRefs = $draft->pageRef;
	if (!is_null($pageRefs) && $pageRefs->count > 0):
		foreach ($pageRefs as $ref):
			if ($ref->id == $this->id):
				break;
			endif;
			$idx = $idx + 1;
			if ($idx > $pageRefs->count):
				$idx = 0;
				break;
			endif;
		endforeach;
		if ($idx > 1):
			$prev = $pageRefs($idx - 2);
			$html = "<a class='prev' href='" . $prev->url . "'><span class=sc'>" . $idx - 1 . "</span></a>";
		else:
			$html = "<span class='prev sc disabled'>| </span>";
		endif;
		if ($idx > 0):
			$page = $pageRefs($idx - 1);
			$html .= "<span class='small'>page <span class='heavy sc'>" . $idx . "</span></span>";
		endif;
		$next = $pageRefs($idx);
		if (!is_null($next)):
			$html .= "<a class='next' href='" . $next->url . "'><span class='sc'>" . $idx + 1 . "</span></a>";
		else:
			$html .= "<span class='next sc disabled'> |</span>";
		endif;
		return "<span class='right cit'>" . $html . "</span>";
	else:
		return "";
	endif;
}

public function dataType() {
	return "<span class='hybrid'>page</span>";
}

public function recursiveShortName() {
		return $this->parent()->recursiveShortName();
}

public function recursiveShortNameText() {
	return strip_tags($this->get('title'));
}

public function shelfmarkBreadCrumbs() {
	if (method_exists ($this->parent, 'shelfmarkBreadCrumbs')):
		$html = $this->parent->shelfmarkBreadCrumbs();
	else:
		$html = "";
	endif;
	$this->of(false);
	return $html . "<td class='page'>" /* . $this->folio . $this->side . ". " */ . $this->title . "</td>\n";
}

public function shelfmarkLateral() {
	$this->of(false);
	$prev = $this->prev;
	$prev->of(false);
	$next = $this->next;
	$next->of(false);
	$html = "";
	if ($prev->id > 0):
		$html .= "<a class='prev' href='" . $prev->url . "'><span class='sc'>" . $prev->folio . $prev->side . "</span></a>";
	else:
		$html .= "<span class='prev sc disabled'>| </span>";
	endif;
	$html .= "<span class='small'>folio <span class='heavy sc'>" . $this->folio . $this->side . "</span></span>";
	if ($next->id > 0):
		$html .= "<a class='next' href='" . $next->url . "'><span class='sc'>" . $next->folio . $next->side . "</span></a>";
	else:
		$html .= "<span class='next sc disabled'> |</span>";
	endif;
	return "<span class='right sm'>" . $html . "</span>";
}

public function shortNameTextThemed() {
	return "<span class='hybrid'>" . $this->slug() . "</span>";
}

public function slug() {
// title and shelfmark are easy, but draft info is hard....

	$drafts = wire('pages')->find("template='Draft', pageRef={$this}, sort=parent, sort=titleShort");
	$draftLit = "";
	$ct = $drafts->count();
	$i = 1;
	if ($ct > 0):
		foreach ($drafts as $draft):
			$j = 0;
			foreach ($draft->pageRef as $draftPage):
				$j = $j + 1;
				if ($draftPage == $this):
					break;
				endif;
			endforeach;
			if ($i == $ct):
				$punc = "";
			else:
				$punc = Star("cit");
			endif;
			$draftLit .= $draft->recursiveShortNameText() . ".p" . $j . $punc;
			$i = $i + 1;
		endforeach;
	endif;
	return	"<span class='hybrid'>" .
			$this->title .
			"</span>" .
			Star("hybrid") .
			"<span class='sm'>MS. Tolkien, " . $this->titleLong() .
			"</span>" .
			Star("hybrid") .
			"<span class='cit'>" . $draftLit . "</span>";
}

public function theme() {
	return "hybrid";
}

}
