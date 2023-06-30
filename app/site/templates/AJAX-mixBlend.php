<?php namespace ProcessWire;

include_once "includes/_func.php";

SetPV("mixBlendMode", $page->titleShort);
## echo $pages->get(getPV("currentPage"))->markupItsLikeness();
include_once "includes/imagePanel.php";
