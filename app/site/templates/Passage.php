<?php namespace ProcessWire;

/* PARENTAGE

A passage object’s functions may be found here:
- site/classes/PassagePage.php

A passage’s OOP parent is tcPage:
- site/classes/tcPage.php

A passage’s parent in ProcessWire is the “Draft” template:
- site/templates/Draft.php

And that *parent’s* OOP class is:
- site/classes/DraftPage.php

*/


// Anything added below will show up at the VERY BOTTOM of all passage pages in Anduin:

?>

	<region id='mrTitle'>
		<title>Anduin | passage <?=$page->title?></title>
	</region><!--#mrTitle-->

	<region id='mrHeader'>
		<div id='tcHeader'>
<?php		$page->of(false);
			$html = "<h1 class='sc right'><span class='light'>" . $page->recursiveCitation() . "</span></h1><br /><div class=' sc right'>";
			$html .= $page->titleLong;
			echo $html . " </div>";
?>		</div>
	</region>

	<region id='mrData'>
		<div id='tcData'>
<?php
		echo $page->startWords;
		if ($page->endWords != ""):
			echo " … " . $page->endWords;
		endif;

	$antecedents = $page->references("field='passageRef'");
	if ($antecedents->count > 0):
		$antecedent = $antecedents[0];
		$anteDraft = $antecedent->parent();
		echo "<h4>Antecedent passages</h4><h5>" . $anteDraft->titleShort . ": " . $anteDraft->title . "</h5><ul>";
		foreach ($antecedents as $antecedent):
			echo "<li class='pass'><span class='sc'>" . $antecedent->id . "</span>: " . $antecedent->startWords;
			if ($antecedent->endWords != ""):
				echo " … " . $antecedent->endWords;
			endif;
			echo "</li>";
		endforeach;
		echo "</ul>";
	endif;

	if ($page->passageRef->count > 0):
		$subsequent = $page->passageRef[0];
		$subsDraft = $subsequent->parent();
		echo "<h4>Subsequent passages</h4><h5>" . $subsDraft->titleShort . ": " . $subsDraft->title . "</h5><ul>";
		foreach ($page->passageRef as $subseq):
			echo "<li class='pass'><span class='sc'>" . $subseq->id . "</span>: " . $subseq->startWords;
			if ($subseq->endWords != ""):
				echo " … " . $subseq->endWords;
			endif;
			echo "</li>";
		endforeach;
		echo "</ul>";
	endif;

?>		</div>
	</region>
