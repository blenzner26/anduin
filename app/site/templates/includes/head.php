<?php namespace ProcessWire; ?>
	<meta http-equiv='content-type' content='text/html; charset=utf-8'>
<?php	## auto-forward
	##  if there’s only one child, we’ll forward to it immediately rather than making the user do it
if ($page->numChildren("!template='Comment'") == 1):
	echo " <meta http-equiv='Refresh' content='0; url=" . $page->child("!template='Comment'")->url . "' />";
elseif ($page->id == 1):
	echo " <meta http-equiv='Refresh' content='0; url=3/' />";
endif;

## robots
if ($config->server == "Aragorn"):
	echo " <meta name='robots' content='index,follow'>";
else:
	echo " <meta name='robots' content='noindex,nofollow'>";		## presumably Gandalf or Celeborn
endif;

## stylesheets
echo " <link rel='stylesheet' type='text/css' href='" . $config->urls->styles . "main.css'>";
echo " <link rel='stylesheet' type='text/css' href='" . $config->urls->styles . "bootstrap/bootstrap.min.css'>";

## favicons ?>
<link rel="apple-touch-icon" sizes="180x180" href="/apple-touch-icon.png">
<link rel="icon" type="image/png" sizes="32x32" href="/favicon-32x32.png">
<link rel="icon" type="image/png" sizes="16x16" href="/favicon-16x16.png">
<link rel="mask-icon" href="/safari-pinned-tab.svg" color="#5bbad5">
<meta name="msapplication-TileColor" content="#af2227">
<meta name="theme-color" content="#ff0000">
<link rel="manifest" href="/site.webmanifest">

