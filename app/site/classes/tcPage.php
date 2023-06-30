<?php namespace ProcessWire;
class tcPage extends Page {

/* PARENTPAGE

A tcPage’s OOP parent is a ProcessWire Page, as noted above:
- wire/core/Page.php

tcPage has no corresponding concept within ProcessWire — it is merely a subclass of Page

*/

public function citationBreadCrumbs() {
	return "";
}

public function citationDropdowns() {
	if (method_exists ($this->parent(), 'citationDropdowns')):
		$html = $this->parent()->citationDropdowns();
	else:
		$html = "";
	endif;
	return $html . "<td></td>\n";
}

public function citationLateral() {
	$this->of(false);
	$type = $this->type;
	$prev = $this->prev;
	$prev->of(false);
	$next = $this->next;
	$next->of(false);
	$html = "<span class='right cit'>";
	if ($prev->id > 0):
		$html .= "<a class='prev' href='" . $prev->url . "'><span class='sc'>" . $prev->recursiveCitation() . "</span></a>";
	else:
		$html .= "<span class='prev sc disabled'>| </span>";
	endif;
	$html .= "<span class='small'>" . strtolower($this->template) . "</span> <span class='heavy sc'>" . $this->recursiveCitation() . "</span>";
	$next = $this->next;
	if ($next->id > 0):
		$html .= "<a class='next' href='" . $next->url . "'><span class='sc'>" . $next->recursiveCitation() . "</span></a>";
	else:
		$html .= "<span class='next sc disabled'> |</span>";
	endif;
	return $html . "</span>";
}

public function dataType() {
	return "";
}

public function feetnote($fn) {
	$fns = wire('session')->fns;
	$fns[] = $fn;
	wire('session')->fns = $fns;
	return "<sup> [" . wire('pages')->get("template=Feetnote, title={$fn}")->seq . "]</sup>";
}

public function likenessSrc() {
	if (UserCanViewImages()):
		$server = trim(file_get_contents('../assets/addresses/image-server.txt'));
		return "https://" . $server . "/3/" . $this->title . ".png";
	else:
		return "";
	endif;
}

public function markupItsLikeness() {
	if (UserCanViewImages()):
		$server = trim(file_get_contents('../assets/addresses/image-server.txt'));
		$imgPath = "https://" . $server . "/3/" . $this->title . ".png";
		$thumbPath = "https://" . $server . "/3/jpg/" . $this->title . ".jpg";
	else:
		$rootpage = $this->wire('pages')->findOne("id=1");
		$imgPath = $rootpage->likenesses->first()->url;
		$thumbPath = $rootpage->likenesses->first()->url;
	endif;
	return
##		"<div id='theScan'><img src='https://" . $server . "/3/" . $this->title . ".png' alt='a photograph of this document' class='scan " . $mix . "'></div>";
		"<div id='theScan'><script>setImage('" . $imgPath . "');</script><img src='" . $thumbPath . "' alt='a photograph of this document' class='scan' onclick='openImageModal()'><div class='modal fade' id='imageModal' tabindex='-1' aria-labelledby='imageModalLabel' aria-hidden='true'><div class='modal-dialog'><div class='modal-content'><div class='modal-body' id='manuscript-container'><img class='modal-close-btn' id='closeBtn' src='/site/templates/scripts/openseadragon/images/close-btn.png' alt='close image viewer' onclick='closeModal()'></div></div></div></div></div>";
}

public function mfLatNav() {
	return "";
}

public function recursiveCitation() {
	return "";
}

public function recursiveShortName() {
	if ($this != wire('pages')->get(getPV("currentPage"))):
		if (method_exists($this->parent(), 'recursiveShortName')):
			return $this->parent()->recursiveShortName() . ".<a href='" . $this->url . "'>" . $this->titleShort . "</a>";
		else:
			return ".<a href='" . $this->url . "'>" . $this->titleShort . "</a>";
		endif;
	else:
		if (method_exists($this->parent(), 'recursiveShortName')):
			return $this->parent()->recursiveShortName() . $this->titleShort;
		else:
			return $this->titleShort;
		endif;
	endif;
}

public function recursiveShortNameText() {
	if (method_exists($this->parent(), 'recursiveShortNameText')):
		return $this->parent()->recursiveShortNameText() . "." . strip_tags($this->titleShort);
	else:
		return strip_tags($this->titleShort);
	endif;
}

public function shelfmarkBreadCrumbs() {
	return "";
}

public function shelfmarkLateral() {
	return "";
}

public function shelfmarkNavBar() {
	$html = $this->parent->shelfmarkNavBar();
	return  $html . "<td></td>\n";
}

public function shortNameTextThemed() {
	return "";
}

public function slug() {
	return $this->title;
}

public function slugThemed() {
	return "";
}

public function theme() {
	return "default";
}

public function work() {
	return "";
}

}
