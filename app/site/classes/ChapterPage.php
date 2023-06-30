<?php namespace ProcessWire;
class ChapterPage extends tcPage {

/* PARENTAGE

A chapter’s OOP parent is tcPage, as noted above:
- site/classes/tcPage.php

A chapter’s parent in ProcessWire is the “Section” template:
- site/templates/Section.php

And that *parent’s* OOP class is:
- site/classes/SectionPage.php

*/

public function citationBreadcrumbs() {
	$html = $this->parent->citationBreadCrumbs();
	if ($this != wire('pages')->get(getPV("currentPage"))):
		return $html . "<td class='chapter'><a href='" .$this->url . "'>" . $this->title . "</a></td>\n";
	else:
		return $html . "<td class='chapter'>" . $this->title . "</td>\n";
	endif;
}

public function citationDropdowns() {
	$html = $this->parent()->citationDropdowns() . "<td><div class='ddNavMenu'><button class='ddNavBtn'>";
	if ($this->numChildren("template='Draft'") == 0):
		$html .= "[No drafts]</button></div>";
	else:
		$html .= "draft</button><div class='ddNavContent'><dl class='midAlign'>";
		foreach ($this->children("template='Draft'") as $child):
			$child->of(false);
			$html .= "<a href='" . $child->url . "'><dt>" . $child->titleShort . "</dt><dd>" . $child->title . "</dd></a>";
		endforeach;
		$html .= "</dl></div></div></td>\n";
	endif;
	return $html;
}

public function dataType() {
	return "<span class='cit'>Chapter</span>";
}

public function easyName() {
	return $this->parent->title . ", chapter " . $this->titleShort . ", “" . $this->title . "”";
}

public function recursiveCitation() {
	$this->of(false);
	if (method_exists ($this->parent, 'recursiveCitation')):
		return $this->parent->recursiveCitation() . "." . $this->titleShort;
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

public function shelfmarkNavBar() {
	if (method_exists ($this->parent, 'shelfmarkNavBar')):
		return $this->parent->shelfmarkNavBar() . "\n";
	else:
		return "\n";
	endif;
}

public function shortNameTextThemed() {
	return "<span class='cit'>" . $this->parent()->recursiveShortNameText() . "." . strip_tags($this->get('titleShort')) . "</span>";
}

public function slug() {
	return "<span class='cit'>" . $this->parent->parent->titleShort . ", " . $this->parent->titleLong . ", chapter " . $this->titleShortTrim() . ", “" . $this->title . "”</span>";
}

public function slugThemed() {
	return "<span class='cit'>" . $this->slug() . "</span>";
}

public function theme() {
	return "cit";
}

public function titleShortTrim() {
	return ltrim($this->titleShort, "0");
}

}
