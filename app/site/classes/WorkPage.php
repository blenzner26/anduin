<?php namespace ProcessWire;
class WorkPage extends tcPage {

/* PARENTAGE

A work’s OOP parent is tcPage, as noted above:
- site/classes/tcPage.php

A work’s parent in ProcessWire is the “Home” template:
- site/templates/home.php

And that *parent’s* OOP class is:
- site/classes/HomePage.php

*/

public function citationBreadcrumbs() {
	if ($this != wire('pages')->get(getPV("currentPage"))):
		return "<td><a class='work' href='" .$this->url . "'>" . $this->titleShort . "</a></td>\n";
	else:
		return "<td>" . $this->titleShort . "</td>\n";
	endif;
}

public function citationDropdowns() {
	$html = $this->parent()->citationDropdowns() . "<td><div class='ddNavMenu'><button class='ddNavBtn'>";
	if ($this->numChildren("template='Section'") == 0):
		$html .= "[No sections]</button></div>";
	else:
		$html .= "section</button><div class='ddNavContent'><dl class='midAlign'>";
		foreach ($this->children("template='Section'") as $child):
			$child->of(false);
			$html .= "<a href='" . $child->url . "'><dt>" . $child->titleShort . "</dt><dd>" . $child->title . "</dd></a>";
		endforeach;
		$html .= "</dl></div></div></td>\n";
	endif;
	return $html;
}

public function citationLateral() {
	return "";
}

public function dataType() {
	return "<span class='hybrid'>work</span>";
}

public function easyName() {
	return "<em>" . $this->title . "</em>";
}

public function recursiveCitation() {
	return "";
}

public function recursiveShortName() {
	if ($this != wire('pages')->get(getPV("currentPage"))):
		return "<a class='series' href='" . $this->url . "'>" . $this->titleShort . "</a>";
	else:
		return $this->titleShort;
	endif;
}

public function recursiveShortNameText() {
	return strip_tags($this->titleShort);
}

public function shelfmarkBreadCrumbs() {
	if ($this != wire('pages')->get(getPV("currentPage"))):
		return "<td><a class='series' href='" .$this->url . "'>" . $this->titleShort . "</a></td>\n";
	else:
		return "<td>" . $this->titleShort . "</td>\n";
	endif;
}

public function shelfmarkNavBar() {
	$html = $this->parent->shelfmarkNavBar();
	$html .= "<td>";
	if ($this->numChildren("template='Shelfmark'") == 0):
		$html .= "<div class='ddNavMenu'><button class='ddNavBtn'>[Nothing here]</button></div>";
	else:
		$html .= "<div class='ddNavMenu'><button class='ddNavBtn'>series</button><div class='ddNavContent'>";
		foreach ($this->children("template='Shelfmark'") as $child):
			$html .= "<a href='" . $child->url . "'>" . $child->title . "</a>";
		endforeach;
		$html .= "</div></div>";
	endif;
	return $html . "</td>\n";
}

public function shortNameTextThemed() {
	return "<span class='cit'>" . $this->get('titleShort') . "</span>";
}

public function slug() {
	return	"<span class='hybrid'>" . $this->title . "</span>";
}

public function slugThemed() {
	return "<span class='hybrid'>" . $this->slug() . "</span>";
}

public function theme() {
	return "cit";
}

public function work() {
	return strip_tags($this->get('titleShort'));
}

}
