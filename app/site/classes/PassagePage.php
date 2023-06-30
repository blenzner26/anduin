<?php namespace ProcessWire;
class PassagePage extends tcPage {

/* PARENTAGE

A passage’s OOP parent is tcPage, as noted above:
- site/classes/tcPage.php

A passage’s parent in ProcessWire is the “Draft” template:
- site/templates/Draft.php

And that *parent’s* OOP class is:
- site/classes/DraftPage.php

*/

public function dataType() {
	return "<span class='cit'>passage</span>";
}

public function recursiveCitation() {
	$this->of(false);
	$text = $this->parent->recursiveCitation() . ".";
	return $text . $this->title;
}

public function theme() {
	return "pass";
}

}
