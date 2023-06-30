<?php namespace ProcessWire;
class ShelfmarkPage extends tcPage {

/* PARENTAGE

A shelfmark’s OOP parent is tcPage, as noted above:
- site/classes/tcPage.php

A shelfmark’s parent in ProcessWire is either another “Shelfmark” template
(true for folders, boxes, and subseries):
- site/templates/Shelfmark.php

Or a “Work” template (true for series):
- site/templates/Work.php

And that *parent’s* OOP class is either:
- site/classes/ShelfmarkPage.php or
- site/classes/WorkPage.php or

*/

public function citationBreadcrumbs() {
	$parent = $this->parent();
	if (method_exists ($parent, 'citationBreadcrumbs')):
		$html = $parent->citationBreadcrumbs();
	else:
		$html = "";
	endif;
	return $html . "\n";
}

public function dataType() {
	$type = $this->type;
	switch ($type):
		case "folder":
			return "<span class='sm'>folder</span>";
			break;
		case "box":
			return "<span class='sm'>box</span>";
			break;
		case "subseries":
			return "<span class='sm'>series</span>";
			break;
		case "series":
			return "<span class='sm'>work</span>";
			break;
	endswitch;
}

public function easyName() {
	$type = $this->getUnformatted('type');
	switch ($type):
		case ("subseries"):
			return $this->title;
		case ("box"):
			return $this->parent->title . ", box " . $this->box;
		case "folder":
			return $this->title;
		case "folio":
			return $this->title;
	endswitch;
}

public function recursiveShortName() {
	$this->of(false);
	$html = $this->parent->recursiveShortName() . ", ";
	$type = $this->getUnformatted('type');
	if ($this == wire('pages')->get(getPV("currentPage"))):
		switch ($type):
//			case "folio":
//				$html .=  " folio " . $this->folio;
//				break;
			case "folder":
				$html .=  " folder " . $this->folder;
				break;
			case ("box"):
				$html .=  " box " . $this->box;
				break;
			case ("subseries"):
				$html .=  " " . strtolower($this->title);
				break;
		endswitch;
	else:
		switch ($type):
//			case "folio":
//				$html .=  " <a class='page' href='" . $this->url . "'>folio " . $this->folio . "</a>";
//				break;
			case "folder":
				$html .=  " <a class='folder' href='" . $this->url . "'>folder " . $this->folder . "</a>";
				break;
			case ("box"):
				$html .=  " <a class='box' href='" . $this->url . "'>box " . $this->box . "</a>";
				break;
			case ("subseries"):
				$html .=  " <a class='ss' href='" . $this->url . "'>" . strtolower($this->title) . "</a>";
				break;
		endswitch;
	endif;
	return $html;
}

public function recursiveShortNameText() {
	return $this->work() . " " . strip_tags($this->get('title'));
}

public function shelfmarkBreadCrumbs() {
	$parent = $this->parent();
	if (method_exists ($parent, 'shelfmarkBreadCrumbs')):
		$html = $parent->shelfmarkBreadCrumbs();
	else:
		$html = "";
	endif;
	$type = $this->getUnformatted('type');
	switch ($type):
		case ("series"):
			$class = "series";
			break;
		case ("subseries"):
			$class = "ss";
			break;
		case ("box"):
			$class = "box";
			break;
		case "folder":
			$class = "folder";
			break;
		case "folio":
			$class = "page";
			break;
	endswitch;

	if ($this != wire('pages')->get(getPV("currentPage"))):
		return $html . "<td class='{$class}'><a href='" . $this->url . "'>" . $this->title . "</a></td>\n";
	else:
		return $html . "<td class='{$class}'>" . $this->title . "</td>\n";
	endif;
}

public function shelfmarkLateral() {
	$this->of(false);
	$type = strtolower($this->type);
	$prev = $this->prev;
	$prev->of(false);
	$next = $this->next;
	$next->of(false);
	$html = "<span class='right sm'>";
	switch ($type):
		case "folder":
			$prevNick = $prev->folder;
			$thisNick = $this->title;
			$nextNick = $next->folder;
			break;
		case "box":
			$prevNick = $prev->box;
			$thisNick = $this->title;
			$nextNick = $next->box;
			break;
		case "subseries":
			$prevNick = $prev->title;
			$thisNick = $this->title;
			$nextNick = $next->title;
			break;
		case "series":
			$prevNick = $prev->series;
			$thisNick = $this->title;
			$nextNick = $next->series;
			break;
	endswitch;
	if ($prev->id > 0):
		$html .= "<a class='prev' href='" . $prev->url . "'><span class='sc small'> " . $prevNick . "</span></a>";
	else:
		$html .= "<span class='prev disabled'>| </span>";
	endif;
	$html .= "<span class='small sc heavy'> " . $thisNick . " </span>";
	$next = $this->next;
	if ($next->id > 0):
		$html .= "<a class='next' href='" . $next->url . "'><span class='sc small'>" . $nextNick . " </span></a>";
	else:
		$html .= "<span class='next sc disabled'> |</span>";
	endif;
	$html .= "</span>";
	return $html;
}

public function shelfmarkNavBar() {
	$parent = $this->parent();
	if (method_exists ($parent, 'shelfmarkNavBar')):
		$html = $parent->shelfmarkNavBar();
	else:
		$html = "";
	endif;
	$html .= "<td>";
	if ($this->numChildren("!template='Comment'") == 0):
		$html .= "<div class='ddNavMenu'><button class='ddNavBtn'>[Nothing here]</button></div>";
	else:
		$html .= "<div class='ddNavMenu'>";
		$type = $this->child->type;
		if ($type == ""):
			$type = "folio";
		endif;
		$html .= "<button class='ddNavBtn'>" . $type . "</button><div class='ddNavContent'>";
		if ($type == "folio"):
			$html .= "<dl class='midAlign'>";
			foreach ($this->children("!template='Comment'") as $child):
			$child->of(false);
				$html .= "<a href='" . $child->url . "'><dt>" . $child->folio . $child->side . "</dt>" . "<dd>" . $child->title . "</dd></a>";
			endforeach;
			$html .= "</dl>";
		else:
			foreach ($this->children("!template='Comment'") as $child):
				$html .= "<a href='" . $child->url . "'>" . $child->title . "</a>";
			endforeach;
		endif;
		$html .= "</div></div>";
	endif;
	return $html . "</td>\n";
}

public function slug() {
	return "MS. Tolkien, " . $this->title;
}

public function theme() {
	return "sm";
}

public function work() {
	$this->of(false);
	$parent = $this->parent();
	if (method_exists ($parent, 'work')):
		return $parent->work();
	else:
		return "";
	endif;
}

}
