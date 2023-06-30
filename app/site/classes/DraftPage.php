<?php namespace ProcessWire;
class DraftPage extends tcPage {

/* PARENTAGE

A draft’s OOP parent is tcPage, as noted above:
- site/classes/tcPage.php

A draft’s parent in ProcessWire is the “Chapter” template:
- site/templates/Chapter.php

And that *parent’s* OOP class is:
- site/classes/ChapterPage.php

*/

public function citationBreadcrumbs() {
	$html = $this->parent->citationBreadCrumbs();
	if ($this != wire('pages')->get(getPV("currentPage"))):
		return $html . "<td class='draft'><a href='" .$this->url . "'>" . $this->title . "</a></td>\n";
	else:
		return $html . "<td class='draft'>" . $this->title . "</td>\n";
	endif;
}

public function citationDropdowns() {
	$html = $this->parent()->citationDropdowns() . "<td><div class='ddNavMenu'><button class='ddNavBtn'>";
	if ($this->pageRef->count == 0):
		$html .= "[No pages]</button></div>";
	else:
		$html .= "page</button><div class='ddNavContent'><dl class='midAlign'>";
		$idx = 1;
		foreach ($this->pageRef as $child):
			$child->of(false);
			$html .= "<a href='" . $child->url . "'><dt>" . $idx . "</dt><dd>" . $child->title . "</dd></a>";
			$idx = $idx + 1;
		endforeach;
		$html .= "</dl></div></div></td>\n";
	endif;
	return $html;
}

public function dataType() {
	return "<span class='cit'>Draft</span>";
}

public function easyName() {
	return $this->title . " of “" . $this->parent->title . "”";
}

public function mfLatNav() {
	$this->of(false);
	$seq = $this->seq;
	if ($seq == ""):
		return "";
	endif;
	$html = "<span class='right mf'>";
	$prev = wire('pages')->find("template='Draft', seq<$seq, sort=-seq")->first;
	if (isset($prev) && $prev != false):
		$prev->of(false);
		$html .= "<a class='prev' href='" . $prev->url . "'><span class='sc'>" . $prev->recursiveCitation() . "</span></a>";
	else:
		$html .= "<span class='prev sc disabled'>| </span>";
	endif;
	$html .= "<span class='small'>draft</span> <span class='heavy sc'>" . $this->recursiveCitation() . "</span>";
	$next = wire('pages')->find("template='Draft', seq>$seq, sort=seq")->first;
	if (isset($next) && $next != false):
		$next->of(false);
		$html .= "<a class='next' href='" . $next->url . "'><span class='sc'>" . $next->recursiveCitation() . "</span></a>";
	else:
		$html .= "<span class='next sc disabled'> |</span>";
	endif;
	$html .= "</span>";
	return $html;
}

public function recursiveCitation() {
	$this->of(false);
##	$parent = $this->parent();
	if (method_exists ($this->parent, 'recursiveCitation')):
		return $this->parent->recursiveCitation() . "-" . $this->titleShort;
	else:
		return $this->titleShort;
	endif;
}

public function shelfmarkBreadCrumbs() {
	if (method_exists ($this->parent, 'shelfmarkBreadCrumbs')):
		return $this->parent->shelfmarkBreadCrumbs() . "\n";
	else:
		return "\n";
	endif;
}

public function shortNameTextThemed() {
	return "<span class='cit'>" . $this->parent()->recursiveShortNameText() . "-" . strip_tags($this->get('titleShort')) . "</span>";
}

public function slug() {
	return "<span class='cit'>" . $this->parent->parent->parent->titleShort . ", " . $this->parent->parent->titleLong . ", chapter " . $this->parent->titleShortTrim() . ", “" . $this->parent->title . ",” " . $this->title . "</span>";
}

public function slugThemed() {
	return "<span class='cit'>" . $this->slug() . "</span>";
}

public function theme() {
	return "cit";
}

}
