<?php namespace ProcessWire;

if(!defined("PROCESSWIRE")) die();

## handle LR permalinks
$wire->addHook('/([Ll][Rr][0-9]+/?)', function($event) {
  $id = $event->arguments(1);
  $id = str_replace("/", "", $id);
  $id = strtoupper($id);
  $entry = $event->pages->findOne("title=$id");
  if ($entry->viewable()):
	$event->session->redirect($entry->httpUrl);
  endif;
});

/** @var Wire $wire */

/**
 * ProcessWire Bootstrap Initialization
 * ====================================
 * This init.php file is called during ProcessWire bootstrap initialization process.
 * This occurs after all autoload modules have been initialized, but before the current page
 * has been determined. This is a good place to attach hooks. You may place whatever you'd
 * like in this file. For example:
 *
 * $wire->addHookAfter('Page::render', function($event) {
 *   $event->return = str_replace("</body>", "<p>Hello World</p></body>", $event->return);
 * });
 *
 */