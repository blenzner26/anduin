<?php namespace ProcessWire;

include('../../index.php'); // bootstrap PW

if (($handle = fopen("folders-02.csv", "r")) !== FALSE):  // open file read-only
    while (($data = fgetcsv($handle, 0, ",", '"')) !== FALSE):
        $shelfmark = $data[0];
           $series = $data[1];
        $subseries = $data[2];
              $box = $data[3];
           $folder = $data[4];
             $form = $data[5];
         $contents = $data[6];
       $titleShort = $data[7];

		if ($series == ""):
			$series = "0";
		endif;
		if ($subseries == ""):
			$subseries = "0";
		endif;
		if ($box == ""):
			$box = "0";
		endif;
		if ($folder == ""):
			$folder = "0";
		endif;

// Series
        $page = $pages->findOne("template=Shelfmark, series=$series, subseries='', box='', folder=''");
		if ($page instanceof NullPage):
        	$page = $pages->add('Shelfmark', "/", [
        		'series' => $series,
        		'name' => $series,
        		'type' => "series",
        		'title' => "The Lord of the Rings"
        	]);
        endif;

// Subseries
        $page = $pages->findOne("template=Shelfmark, series=$series, subseries=$subseries, box='', folder=''");
		if ($page instanceof NullPage):
			if ($subseries == "0"):
				$title = "Series 3";
			else:
				$title = "MSS-" . $subseries;
			endif;
        	$page = $pages->add('Shelfmark', "/" . $series . "/", [
        		'series' => $series,
        		'subseries' => $subseries,
        		'type' => "subseries",
        		'name' => $subseries,
        		'title' => $title
        	]);
        endif;

// Box
        $page = $pages->findOne("template=Shelfmark, series=$series, subseries=$subseries, box=$box, folder=''");
		if ($page instanceof NullPage):
        	if ($subseries == "0"):
        		$title = $series . "/" . $box;
        	else:
        		$title = "MSS-" . $subseries . "/" . $box;
        	endif;
        	$page = $pages->add('Shelfmark', "/" . $series . "/" . $subseries . "/", [
        		'series' => $series,
        		'subseries' => $subseries,
        		'box' => $box,
        		'type' => "box",
        		'name' => $box,
        		'title' => $title
        	]);
        endif;

// Folder
        $page = $pages->findOne("template=Shelfmark, series=$series, subseries=$subseries, box=$box, folder=$folder");
		if ($page instanceof NullPage):
        	if ($subseries == "0"):
        		$title = $series . "/" . $box . "/" . $folder;
        	else:
        		$title = "MSS-" . $subseries . "/" . $box . "/" . $folder;
        	endif;
        	$page = $pages->add('Shelfmark', "/" . $series . "/" . $subseries . "/" . $box . "/", [
        		'series' => $series,
        		'subseries' => $subseries,
        		'box' => $box,
        		'folder' => $folder,
        		'name' => $folder,
        		'type' => "folder",
        		'title' => $title,
        		'contentPublic' => $contents,
        		'form' => $form,
        		'titleShort' => $titleShort
        	]);
        endif;
    endwhile;
    fclose($handle);
endif;
