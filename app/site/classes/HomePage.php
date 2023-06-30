<?php namespace ProcessWire;
class HomePage extends tcPage {

/* PARENTAGE

A Home’s OOP parent is tcPage, as noted above:
- site/classes/tcPage.php

Home does not have a ProcessWire parent — it is “root,” essentially

*/

public function citationBreadcrumbs() {
	return "";
}

public function citationDropdowns() {
##	$html = $this->parent->citationDropdowns();
	$html = "<td><div class='ddNavMenu'><button class='ddNavBtn'>";
	if ($this->numChildren("template='Work',author='JRRT'") == 0):
		$html .= "[No works]</button></div>";
	else:
		$html .= "work</button><div class='ddNavContent'>";
		foreach ($this->children("template='Work' author='JRRT'") as $child):
			$html .= "<a href='" . $child->url . "'>" . $child->title . "</a>";
		endforeach;
		$html .= "</div></div></td>\n";
	endif;
	return $html;
}

public function dataType() {
//	return "<span class='default'>Home</span>";
	return "";
}

public function recursiveShortName() {
	return "";
}

public function shelfmarkBreadCrumbs() {
	return "";
}

public function shelfmarkNavBar() {
	$html = "<td>";
	if ($this->numChildren("template='Work',author='JRRT'") == 0):
		$html .= "<div class='ddNavMenu'><button class='ddNavBtn'>[Nothing here]</button></div>";
	else:
		$html .= "<div class='ddNavMenu'><button class='ddNavBtn'>work </button><div class='ddNavContent'>";
		foreach ($this->children("template='Work',author='JRRT'") as $child):
			$html .= "<a href='" . $child->url . "'>" . $child->title . "</a>";
		endforeach;
		$html .= "</div></div>";
	endif;
	return $html . "</td>\n";
}

public function theme() {
	return "default";
}

}
