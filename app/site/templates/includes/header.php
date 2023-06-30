<?php namespace ProcessWire;

echo "<div id='vsHeader' class='header'>";
echo "<h1 class='header'>";
echo "<a href='/'><img class='logo left' src='{$config->urls->assets}Anduin_Red.png' alt='Anduin logo'></a>";
// echo Star("hybrid");
// echo "<img class='diamond left' src='{$config->urls->assets}Anduin_diamond_blue.png' alt='⟡'>";
echo "    <span class='headerText'>";
echo $thePage->dataType() . " ";
echo $thePage->slug() . "</span>";
echo "</h1><hr class='header'></div>";
