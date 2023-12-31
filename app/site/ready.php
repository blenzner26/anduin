<?php namespace ProcessWire;

if(!defined("PROCESSWIRE")) die();

/** @var Wire $wire */

/**
 * ProcessWire Bootstrap API Ready
 * ===============================
 * This ready.php file is called during ProcessWire bootstrap initialization process.
 * This occurs after the current page has been determined and the API is fully ready
 * to use, but before the current page has started rendering. This file receives a
 * copy of all ProcessWire API variables.
 *
 */

// if htmx request, DO NOT use _main.php
if (array_key_exists('HTTP_HX_REQUEST', $_SERVER)):
  $config->appendTemplateFile = '';
  $config->htmxRequest = true;
endif;
