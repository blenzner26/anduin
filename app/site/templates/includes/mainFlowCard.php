<?php namespace ProcessWire;

if ($thePage->seq != ""):
	echo "\n<region id='mrMainFlowCard'><div class='card mf stat'>";
	echo "<h2 class='mf'>navigate by main draft flow" . $page->mfLatNav() . "</h2>";
	echo "</div></region><!--#mrMainFlowCard-->\n";
endif;
