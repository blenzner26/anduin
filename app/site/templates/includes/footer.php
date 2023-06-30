<?php namespace ProcessWire;
## 2022-07-06 • ErikMH for Anduin 0.7.1
## Added Saul Zaentz trademark info; adjusted `main.css` to accommodate.
?>

<region id='mrFooter'><div id='Boot'><hr class='footer'><div class='left'><p class='fullLeft'><em>Anduin</em> is a trademark owned by <a href="https://www.zaentz.com/middle-earth-enterprises.html">The Saul Zaentz Company</a> and is under license by <a href="https://www.marquette.edu/">Marquette University</a>.</p><p class='fullLeft'>Copyright © 2021–<?=date('y')?>, <a href="https://vermontsoftworks.com/">Vermont Softworks, <span class="sc">LLC</span></a>, for <a href="https://www.marquette.edu/library/archives/">Raynor Memorial Libraries Special Collections and University Archives</a>, <a href="https://www.marquette.edu/">Marquette University</a>.</p></div> <div class="right">
<?php
	echo "<p class='fullRight'><em>Anduin</em> v " . $config->AnduinVersion . " on " . $config->server . " at " . date("Y-m-d H:i:s") . " <span class='sc'>UTC</span></p>";
	echo "<p class='fullRight'>for " . $session->getIP() . "  ⟡  ";
	if ($user->isLoggedin()):
		echo "<a href='/verso/login/logout/'>" . $user->titleLong . "</a>  ⟡  <a href='/verso/login/logout/'>";
	else:
		echo "<a href='/verso/?loggedout=1'>";
	endif;
	echo $user->name . "</a></p>";
?>
</div></div></region><!--#mrFooter-->
