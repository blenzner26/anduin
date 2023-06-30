<?php namespace ProcessWire;

/**
 * Admin template just loads the admin application controller, 
 * and admin is just an application built on top of ProcessWire. 
 *
 * This demonstrates how you can use ProcessWire as a front-end 
 * to another application. 
 *
 * Feel free to hook admin-specific functionality from this file, 
 * but remember to leave the require() statement below at the end.
 * 
 */

## 2022-05-26 · ErikMH for Anduin
##
## Hook for invoking passage cloning from Draft record on verso

$wire->addHookBefore('Pages::saveReady', function($event){
	$page = $event->arguments(0);
# find an excuse not to run:
	if (!$page->template == "Draft") return;
	if (!$page->hasField("executePHP")) return;
	if (!$page->executePHP) return;
# run!
$pages = $this->wire('pages');
$sourceDraft = $page;
$targetDraft = $sourceDraft->prev;
if ($targetDraft->id > 0):
	if ($targetDraft->numChildren == 0):
		foreach ($page->children as $sourcePassage):
			$targetPassage = $pages->add("Passage", $targetDraft);
			$targetPassage->title = $targetPassage->id;
			$targetPassage->name = $targetPassage->id;
			$targetPassage->startWords = $sourcePassage->startWords;
			$targetPassage->endWords = $sourcePassage->endWords;
			$targetPassage->notes = $targetPassage->notes;
			$targetPassage->passageRef = $sourcePassage;
			$targetPassage->save();
			usleep (100000);  # 0.1 second delay works around bug where cloned passages often were added slightly out of order
		endforeach;
	endif;
endif;
$page->executePHP = 0;
});

## 2022-07-19 • ErikMH for Anduin 0.7.1
##
## Hook for auto-populating latest `LR` number on a newly created Page page.

$this->addHookBefore('Pages::added', function(HookEvent $event) {
  // Get the object the event occurred on, if needed
  $pages = $event->object;

  // Get values of arguments sent to hook (and optionally modify them)
  $page = $event->arguments(0);

	if ($page->template != "Page") return;
	
	$lastPage = $pages->findOne("template='Page',sort='-title'");
	$newTitle = $lastPage->title;
	$newTitle++;
	$page->title = $newTitle;
	$page->name = $newTitle;
	$page->save();

  // Populate back arguments (if you have modified them)
  $event->arguments(0, $page);
});

## 2022-07-19 • ErikMH for Anduin 0.7.1
##
## Hook for auto-populating a Page page’s (or a Shelfmark page’s) discrete
## Shelfmark atoms based on its parent’s shelfmark.

$this->addHookAfter('Pages::added', function(HookEvent $event) {
  // Get the object the event occurred on, if needed
  $pages = $event->object;

  // Get values of arguments sent to hook (and optionally modify them)
  $page = $event->arguments(0);

	if ($page->template != "Page" && $page->template != "Shelfmark") return;

	$parent = $page->parent;
	if ($page->series == ""):
		$page->series = $parent->series;
	endif;
	if ($page->subseries == ""):
		$page->subseries = $parent->subseries;
	endif;
	if ($page->box == ""):
		$page->box = $parent->box;
	endif;
	if ($page->folder == ""):
		$page->folder = $parent->folder;
	endif;
	if ($page->side == ""):
		$page->side = "a";
	endif;
	$page->save();

  // Populate back arguments (if you have modified them)
  $event->arguments(0, $page);
});

## 2022-07-19 • ErikMH for Anduin 0.7.1
##
## Hook for auto-updating `titleLong` (shelfmark) and `shelfmarkSort` (in each
## case, only if it is empty) on a *saved* Page page or Shelfmark page.
## Also populates `type` on saved Shelfmark pages.

$this->addHookAfter('Pages::saveReady', function(HookEvent $event) {
  // Get the object the event occurred on, if needed
  $pages = $event->object;

  // Get values of arguments sent to hook (and optionally modify them)
  $page = $event->arguments(0);

	if ($page->template != "Page") return;
##	if ($page->template != "Page" && $page->template != "Shelfmark") return;
	if (!$page->id) return; ## initial page creation
	
	$shelfmark = "";
	if ($page->series != ""):
		if ($page->subseries == "0"):
			$shelfmark = $page->series;
		else:
			$shelfmark = "MSS-";
		endif;
		$page->shelfmarkSort = $page->series;
	endif;
	if ($page->subseries != ""):
		if ($page->subseries != "0"):
			$shelfmark .= $page->subseries;
		endif;
		$page->shelfmarkSort .= "." . $page->subseries;
	endif;
	if ($page->box != ""):
		$shelfmark .= "/" . $page->box;
		$page->shelfmarkSort .= "." . $page->box;
	endif;
	if ($page->folder != ""):
		$shelfmark .= "/" . $page->folder;
		$page->shelfmarkSort .= "." . str_pad($page->folder, 2, '0', STR_PAD_LEFT);
	endif;
	if ($page->template == "Page"):
		if ($page->folio != ""):
			$shelfmark .= "/" . $page->folio;
			$page->shelfmarkSort .= "." . str_pad($page->folio, 3, '0', STR_PAD_LEFT);
		endif;
		if ($page->side != ""):
			$shelfmark .= $page->side;
			$page->shelfmarkSort .= "." . $page->side;
		endif;
		if ($page->version != ""):
			$shelfmark .= " (" . $page->version . ")";
			$page->shelfmarkSort .= "." . $page->version;
		endif;
	else:
		switch ($page->parent->type):
			case "box":
				$type = "folder";
				break;
			case "subseries":
				$type = "box";
				break;
			case "series":
				$type = "subseries";
				break;
			default:
				$type = "series";
		endswitch;
	endif;
	if ($shelfmark != ""):
		if ($page->template == "Page"):
			$page->titleLong = $shelfmark;
			$page->save('titleLong');
		elseif ($page->template == "Shelfmark"):
			$page->title = $shelfmark;
			$page->save('title');
			if ($page->name != $page->$type):
				$page->name = $page->$type;
				$page->save('name');
			endif;
		endif;
	endif;
	if ($page->shelfmarkSort != ""):
		$page->save('shelfmarkSort');
	endif;
/*
	if ($type != ""):
		$page->type = $type;
		$page->save('type');
	endif;
*/
  // Populate back arguments (if you have modified them)
  $event->arguments(0, $page);
});

/** @var Config $config */
require($config->paths->core . "admin.php"); 
