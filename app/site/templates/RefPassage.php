<?php namespace ProcessWire; ?>
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
