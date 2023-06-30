<?php namespace ProcessWire;

include_once 'includes/_func.php';
if (str_starts_with($page->template, 'AJAX')):
	$thePage = $pages->get(getPV("currentPage"));
else:
	$thePage = $page;
	SetPV("currentPage", $page->id);
endif;

wire('session')->fns = array(); // initialize feetnote array
