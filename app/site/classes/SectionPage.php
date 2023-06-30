<?php namespace ProcessWire;
class SectionPage extends tcPage {

/* PARENTAGE

A section’s OOP parent is tcPage, as noted above:
- site/classes/tcPage.php

A section’s parent in ProcessWire is the “Work” template:
- site/templates/Work.php

And that *parent’s* OOP class is:
- site/classes/WorkPage.php

*/

public function citationBreadcrumbs() {
##	$parent = $this->parent();
##	if (method_exists ($parent, 'citationBreadCrumbs')):
		$html = $this->parent->citationBreadCrumbs();
##	else:
##		$html = "";
##	endif;
	if ($this != wire('pages')->get(getPV("currentPage"))):
		return $html . "<td class='section'><a href='" .$this->url . "'>" . $this->title . "</a></td>\n";
	else:
		return $html . "<td class='section'>" . $this->title . "</td>\n";
	endif;
}

public function citationDropdowns() {
	$html = $this->parent()->citationDropdowns() . "<td><div class='ddNavMenu'><button class='ddNavBtn'>";
	if ($this->numChildren("template='Chapter'") == 0):
		$html .= "[No chapters]</button></div>";
	else:
		$html .= "chapter</button><div class='ddNavContent'><dl class='midAlign'>";
		foreach ($this->children("template='Chapter'") as $child):
			$child->of(false);
			$html .= "<a href='" . $child->url . "'><dt>" . $child->titleShort . "</dt><dd>" . $child->title . "</dd></a>";
		endforeach;
		$html .= "</dl></div></div></td>\n";
	endif;
	return $html;
}

public function dataType() {
	return "<span class='cit'>Section</span>";
}

public function easyName() {
	return $this->title . " of <em>" . $this->parent->title . "</em>";
}

public function recursiveCitation() {
	return $this->titleShort;
}

public function recursiveShortName() {
	if ($this != wire('pages')->get(getPV("currentPage"))):
		return $this->parent()->recursiveShortName() . " <a href='" . $this->url . "'>" . $this->titleShort . "</a>";
	else:
		return $this->parent()->recursiveShortName() . $this->titleShort;
	endif;
}

public function recursiveShortNameText() {
	return $this->parent()->recursiveShortNameText() . " " . strip_tags($this->titleShort);
}

public function shelfmarkBreadCrumbs() {
##	$parent = $this->parent();
	if (method_exists ($this->parent, 'shelfmarkBreadCrumbs')):
		return $this->parent->shelfmarkBreadCrumbs() . "\n";
	else:
		return "\n";
	endif;
}

public function shelfmarkNavBar() {
##	$parent = $this->parent();
	if (method_exists ($this->parent, 'shelfmarkNavBar')):
		return $this->parent->shelfmarkNavBar() . "\n";
	else:
		return "\n";
	endif;
}

public function shortNameTextThemed() {
	return "<span class='cit'>" . $this->parent()->recursiveShortNameText() . " " . strip_tags($this->get('titleShort')) . "</span>";
}

public function slug() {
	return "<span class='cit'>" . $this->parent->titleShort . ", " . $this->titleLong . "</span>";
}

public function slugThemed() {
	return "<span class='cit'>" . $this->slug() . "</span>";
}

public function theme() {
	return "cit";
}

}