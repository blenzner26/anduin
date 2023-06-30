<?php namespace ProcessWire;

## invoke this by navigating to https://anduin.marquette.edu/import/import-passages-from-lrc-02.php

include('../index.php'); // bootstrap PW

echo "Starting up!<br>";
$i = 0;

if (($handle = fopen("lrc-b.csv", "r")) !== FALSE):  // open file read-only
	$new = 0;
	$mod = 0;
    while (($row = fgetcsv($handle, 0, ",", '"')) !== FALSE):
		$Section = $row[0];
		$Chapter = $row[1];
		$StartWords = $row[3];
		$EndWords = $row[4];
		$Text = $row[5];
		$Notes = $row[6];

		$parent = $pages->findOne("template=Draft, parent.parent.titleShort=$Section, parent.titleShort=$Chapter, sort=-titleShort");
		if ($parent->id != 0):
			$page = $pages->add('Passage', $parent);
			$page->title = $page->id;
			$page->name = $page->id;
			$page->startWords = $StartWords;
			$page->endWords = $EndWords;
			$page->contentPublic = $Text;
			$page->notes = $Notes;
			$page->save();
			$new++;
		endif;
	endwhile;
	fclose($handle);
endif;
echo "<br>Added: " . $new . "<br>";
